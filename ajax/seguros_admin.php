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

    public static function info($id_usuario){
        $db = self::$instance;
        $db->getDBConexion();
        $sql = "SELECT COUNT(id) as num_clientes FROM clientes";
        $sql2 = "SELECT COUNT(id) as num_usuarios FROM usuarios WHERE rol = '0'";
        $sql3 = "SELECT COUNT(id) as num_admin FROM usuarios WHERE rol = '1'";
        $sql4 = "SELECT SUM(valor) as total_recuado FROM pagos WHERE pago = '1'";

        $result =mysqli_query($db->dbcon,$sql);
        $row = mysqli_fetch_array($result);
        $result2 =mysqli_query($db->dbcon,$sql2);
        $row2 = mysqli_fetch_array($result2);
        $result3 =mysqli_query($db->dbcon,$sql3);
        $row3 = mysqli_fetch_array($result3);
        $result4 =mysqli_query($db->dbcon,$sql4);
        $row4 = mysqli_fetch_array($result4);

        $db->auditoria($id_usuario, 'Esta en el inicio de admin');

        $data = array("num_clientes"=>$row['num_clientes'],
                    "num_usuarios"=>$row2['num_usuarios'],
                    "num_admin"=>$row3['num_admin'],
                    "total_recuado"=>$row4['total_recuado']);

        echo json_encode(array("status"=>1,"data"=>$data));
    }

    public static function solicitudes($id_usuario){
        $db = self::$instance;
        $db->getDBConexion();

        $sql = "SELECT * FROM solicitudes as s LEFT JOIN vida as v ON s.ref_pago = v.ref_pago LEFT JOIN clientes as m ON v.id_beneficiario = m.id";
        $result =mysqli_query($db->dbcon,$sql);
        if ($result) {

            $db->auditoria($id_usuario, 'Solicito las solicitudes de los usuarios');

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

    public static function aprovar($ref_pago, $id_usuario){
        $db = self::$instance;

        $sql="UPDATE pagos SET reclamado='2' WHERE ref_pago = '$ref_pago'";
        $sq2="UPDATE solicitudes SET estado='1' WHERE ref_pago = '$ref_pago'";
        $result =mysqli_query($db->dbcon,$sql);
        $result2 =mysqli_query($db->dbcon,$sq2);

        if($result && $result2){
            $db->auditoria($id_usuario, 'Aprovo el seguro con ref N°: '.$ref_pago);
            echo json_encode(array("status"=>1,"message"=>"El seguro con referencia: ".$ref_pago." ha sido aprovado!"));
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }
    }

    public static function registrar($id,$names,$tipo_documento,$email,$password, $id_usuario){
        $db = self::$instance;
        $sql="SELECT * FROM usuarios WHERE email='$email' OR id='$id'";
        $result =mysqli_query($db->dbcon,$sql);

        if(!$row = mysqli_fetch_array($result)){
            $pass = password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]);
            $query1 = "INSERT INTO usuarios(id, tipo_documento, names, email, password, rol) VALUES ('$id','$tipo_documento','$names','$email','$pass', '1')";
            $result1 =mysqli_query($db->dbcon,$query1);

            if($result1){
                $db->auditoria($id_usuario, 'Registro un nuevo administrador');

                echo json_encode(array("status"=>1,"message"=>"Usuario registrado!"));
            }else{
                echo json_encode(array("status"=>-1,"message"=>"Error al registrar al usuario."));
            }
            
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Ya existe un usuario con estos datos"));
        }
    }

    public static function cargarPlan(){
        $db = self::$instance;
        $db->getDBConexion();
        $sql = "SELECT * FROM `cotizar`";
        $result =mysqli_query($db->dbcon,$sql);
        if ($result) {
            $data = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($data, $row);
            }
            echo json_encode(array("status"=>1,"data"=>$data));
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }
    }

    // terminar de hacer 
    public static function actualizarPlan($id){
        $db = self::$instance;
        $sql="UPDATE cotizar SET basico='basico',estandar='estandar',premiun='premiun' WHERE id = '$id'";
        $result =mysqli_query($db->dbcon,$sql);

        if($result){
            $db->auditoria($id, 'Modifico los precios del plan con id: '.$id);
            echo json_encode(array("status"=>1,"message"=>"El ususario con el id: ".$id.", se ha modificado!"));
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }
    }

}

$obj = Admin::getInstance();

$id_usuario = $_SESSION["id"];

switch ($_GET["opcion"]) {
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

    case 'solicitudes':
        $obj->solicitudes($id_usuario);
    break;

    case 'aprovar':
        $conexion = $obj->getDBConexion();
        $ref_pago=isset($_GET["ref"])? $obj->limpiarCadena($_GET["ref"]):"";

        if(empty($ref_pago)){
            echo json_encode(array("status"=>-1,"message"=>"Error, no se recibio la referencia"));
        }else{
            $obj->aprovar($ref_pago, $id_usuario);
        }
    break;

    case 'save_admin':
        $conexion = $obj->getDBConexion();
        $email=isset($_POST["email"])? $obj->limpiarCadena($_POST["email"]):"";
        $password=isset($_POST["password"])? $obj->limpiarCadena($_POST["password"]):"";
        $tipo_documento=isset($_POST["tipo_documento"])? $obj->limpiarCadena($_POST["tipo_documento"]):"";
        $id=isset($_POST["id"])? $obj->limpiarCadena($_POST["id"]):"";
        $names=isset($_POST["names"])? $obj->limpiarCadena($_POST["names"]):"";
        
        
        if(empty($id) || empty($names) || empty($tipo_documento) || empty($email) || empty($password)){
            echo json_encode(array("status"=>-1,"message"=>"Debe llenar todos los campos!"));
        }else{
            $obj->registrar($id, $names, $tipo_documento, $email, $password, $id_usuario);
        }
    break;

    case 'info':
        $obj->info($id_usuario);
    break;

    case 'cotizar':
        $obj->cargarPlan();
    break;

    case 'modificacionPlan':
        $obj->actualizarPlan($id);
    break;
}
