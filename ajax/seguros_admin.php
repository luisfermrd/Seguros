<?php
header('Content-type:application/json;charset=utf-8');
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 0) {
    header("Location: login.php");
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

    public static function login($email, $password){
        $db = self::$instance;

        $sql = "SELECT * FROM usuarios WHERE email='$email'";
        $result = mysqli_query($db->dbcon, $sql);

        if ($row = mysqli_fetch_array($result)) {
            if (password_verify($password, $row['password'])) {
                if ($row['active'] == 1) {
                    session_start();
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['tipo_documento'] = $row['tipo_documento'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['names'] = $row['names'];
                    $_SESSION['rol'] = $row['rol'];

                    $db->auditoria($row['id'], $email . ' se logueo en el sistema');

                    if ($row['rol'] == 0) {
                        //Usuario
                        echo json_encode(array("status" => 1, "rol" => 0, "message" => "Acceso conseguido"));
                    } else {
                        //Admin
                        echo json_encode(array("status" => 1, "rol" => 1, "message" => "Acceso conseguido"));
                    }
                } else {
                    echo json_encode(array("status" => -1, "message" => "Usuario desactivado por el administrador, pongase en contacto con nosotros."));
                }
            } else {
                echo json_encode(array("status" => -1, "message" => "Usuario/contraseña incorrectos!"));
            }
        } else {
            echo json_encode(array("status" => -1, "message" => "Usuario/contraseña incorrectos!"));
        }
    }
}

$obj = Admin::getInstance();


switch ($_GET["opcion"]) {
    case 'login':
        $conexion = $obj->getDBConexion();
        $email = isset($_POST["email"]) ? $obj->limpiarCadena($_POST["email"]) : "";
        $password = isset($_POST["password"]) ? $obj->limpiarCadena($_POST["password"]) : "";

        if (empty($email) || empty($password)) {
            echo json_encode(array("status" => -1, "message" => "Debe llenar todos los campos!"));
        } else {
            $obj->login($email, $password);
        }
    break;

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
        $id = $_GET['id'];

        if(empty($id)){
            echo json_encode(array("status"=>-1,"message"=>"Error, no se recibio la referencia"));
        }else{
            $sql="UPDATE usuarios SET active='0' WHERE id = '$id'";
            $result =mysqli_query($conexion,$sql);

            if($result){
                echo json_encode(array("status"=>1,"message"=>"El ususario con el id: ".$id.", se ha desactivado!"));
            }else{
                echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
            }
        }
    break;

    case 'activar_user':
    $conexion = $obj->getDBConexion();
    $id = $_GET['id'];

    if(empty($id)){
        echo json_encode(array("status"=>-1,"message"=>"Error, no se recibio la referencia"));
    }else{
        $sql="UPDATE usuarios SET active='1' WHERE id = '$id'";
        $result =mysqli_query($conexion,$sql);

        if($result){
            echo json_encode(array("status"=>1,"message"=>"El ususario con el id: ".$id.", se ha desactivado!"));
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }
    }
    break;
}
