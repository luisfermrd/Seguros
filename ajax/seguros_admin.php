<?php
header('Content-type:application/json;charset=utf-8');
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 1) {
    header("Location: ../views/login.php");
}

class Admin{
    private static $instance = NULL;
    private $dbcon;
    private $ip;

    private function __construct(){
    }

    public static function getInstance(){
        if (self::$instance == NULL) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public static function getDBConexion(){
        try {
            $db = self::$instance;
            $db->dbcon = mysqli_connect("localhost", "seguros_admin", "seguros_admin123", "seguros");
            $db->ip = $db->get_client_ip();
            return $db->dbcon;
        } catch (Exception $e) {
            echo "error: " . $e->getMessage();
        }
    }

    public static function get_client_ip(){
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function auditoria($id, $mensaje){
        $db = self::$instance;
        $sql = "INSERT INTO auditoria (id_usuario, ip, descripcion) VALUES ('$id', '$db->ip', '$mensaje')";
        $result = mysqli_query($db->dbcon, $sql);
    }

    public static function limpiarCadena($str){
        $db = self::$instance;
        $str = mysqli_real_escape_string($db->dbcon, trim($str));
        return htmlspecialchars($str);
    }

    public static function cargarUsuario($id){
        $db = self::$instance;
        $db->getDBConexion();
        $sql = "SELECT * FROM `usuarios`";
        $result =mysqli_query($db->dbcon,$sql);
        if ($result) {

            $db->auditoria($id, 'Solicito usuarios del sistema');

            $data = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($data, $row);
            }
            echo json_encode(array("status"=>1,"data"=>$data));
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }
    }

    public static function desactivarUsuario($id, $id_usuario){
        $db = self::$instance;
        $sql="UPDATE usuarios SET active='0' WHERE id = '$id'";
        $result =mysqli_query($db->dbcon,$sql);

        if($result){
            $db->auditoria($id_usuario, 'Desactivo al usuario con id: '.$id_usuario);
            echo json_encode(array("status"=>1,"message"=>"El ususario con el id: ".$id.", se ha desactivado!"));
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }
    }

    public static function activarUsuario($id, $id_usuario){
        $db = self::$instance;
        $sql="UPDATE usuarios SET active='1' WHERE id = '$id'";

        $result =mysqli_query($db->dbcon,$sql);
        
        if($result){
            $db->auditoria($id_usuario, 'Activo al usuario con id: '.$id_usuario);
            echo json_encode(array("status"=>1,"message"=>"El ususario con el id: ".$id.", se ha activado!"));
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }
    }

}

$obj = Admin::getInstance();

$id_usuario = $_SESSION["id"];

switch ($_GET["opcion"]) {

    case 'registrar':
        $conexion = $obj->getDBConexion();
        $tipo_documento = $_POST['tipo_documento'];
        $id = $_POST['id'];
        $names = $_POST['names'];
        $email = $_POST['email'];
        $password = $_POST['password'];


        if (empty($id) || empty($names) || empty($tipo_documento) || empty($email) || empty($password)) {
            echo "Debe llenar todos los campos!";
        } else {
            $sql = "SELECT * FROM usuarios WHERE email='$email' OR id='$id'";
            $result = mysqli_query($conexion, $sql);

            if (!$row = mysqli_fetch_array($result)) {
                $pass = password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]);
                $query1 = "INSERT INTO usuarios(id, tipo_documento, names, email, password, rol) VALUES ('$id','$tipo_documento','$names','$email','$pass', '1')";
                $result1 = mysqli_query($conexion, $query1);

                if ($result1) {
                    echo "Usuario registrado!";
                } else {
                    echo "Error al registrar al usuario.";
                }
            } else {
                echo  "Ya existe un usuario con estos datos";
            }
        }
    break;

    case 'aprobar':
        $conexion = $obj->getDBConexion();
        $ref_pago = $_GET['ref'];

        if (empty($ref_pago)) {
            echo json_encode(array("status" => -1, "message" => "Error, no se recibio la referencia"));
        } else {
            $sql = "UPDATE pagos SET reclamado='2' WHERE ref_pago = '$ref_pago'";
            $sq2 = "UPDATE solicitudes SET estado='1' WHERE ref_pago = '$ref_pago'";
            $result = mysqli_query($conexion, $sql);
            $result2 = mysqli_query($conexion, $sq2);

            if ($result && $result2) {
                echo json_encode(array("status" => 1, "message" => "El seguro con referencia: " . $ref_pago . " se ha cancelado!"));
            } else {
                echo json_encode(array("status" => -1, "message" => "Error, algo salio mal"));
            }
        }
    break;

    case 'desactivar_user':
        $conexion = $obj->getDBConexion();
        $id=isset($_GET["id"])? $obj->limpiarCadena($_GET["id"]):"";

        if(empty($id)){
            echo json_encode(array("status"=>-1,"message"=>"Error, no se recibio la referencia"));
        }else{
            $obj->desactivarUsuario($id, $id_usuario);
        }
    break;

    case 'activar_user':
        $conexion = $obj->getDBConexion();
        $id=isset($_GET["id"])? $obj->limpiarCadena($_GET["id"]):"";

        if(empty($id)){
            echo json_encode(array("status"=>-1,"message"=>"Error, no se recibio la referencia"));
        }else{
            $obj->activarUsuario($id, $id_usuario);
        }
    break;

    case 'usuarios':
        $obj->cargarUsuario($id_usuario);
    break;
}
