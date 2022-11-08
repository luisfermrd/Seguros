<?php
header('Content-type:application/json;charset=utf-8');
class Usuario{

    private static $instance = NULL;
    private $dbcon;
    private $ip;
    private function __construct(){

    }

    public static function getInstance(){
        if (self::$instance == NULL) {
            self::$instance = new Static();
        }
        return self::$instance;
    }

    public static function getDBConexion(){
        try {
            $db = self::$instance;
            $db->dbcon = mysqli_connect("localhost", "seguros_validar", "seguros_validar123","seguros");
            $db->ip = $db->get_client_ip();
            return $db->dbcon;
        } catch (Exception $e) {
            echo "error: ".$e->getMessage();
        }
    }

    public static function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function auditoria($id, $mensaje){
        $db = self::$instance;
        $sql = "INSERT INTO auditoria (id_usuario, ip, descripcion) VALUES ('$id', '$db->ip', '$mensaje')";
        $result =mysqli_query($db->dbcon,$sql);
    }

    public static function limpiarCadena($str) {
		$db = self::$instance;
		$str = mysqli_real_escape_string($db->dbcon,trim($str));
		return htmlspecialchars($str);
	}

    public static function login($email, $password){
        $db = self::$instance;

        $sql="SELECT * FROM usuarios WHERE email='$email'";
        $result =mysqli_query($db->dbcon,$sql);

        if($row = mysqli_fetch_array($result)){
            if (password_verify($password, $row['password'])) {
                if($row['active'] == 1){
                    session_start();
                    $_SESSION['id']=$row['id'];
                    $_SESSION['tipo_documento']=$row['tipo_documento'];
                    $_SESSION['email']=$row['email'];
                    $_SESSION['names']=$row['names'];
                    $_SESSION['rol']=$row['rol'];

                    $db->auditoria($row['id'], $email.' se logueo en el sistema');

                    if($row['rol'] == 0){
                        //Usuario
                        echo json_encode(array("status"=>1,"rol"=>0,"message"=>"Acceso conseguido")); 
                    }else{
                        //Admin
                        echo json_encode(array("status"=>1,"rol"=>1,"message"=>"Acceso conseguido")); 
                    }
                }else{
                    echo json_encode(array("status"=>-1,"message"=>"Usuario desactivado por el administrador, pongase en contacto con nosotros.")); 
                }
                
            }else{
                echo json_encode(array("status"=>-1,"message"=>"Usuario/contraseña incorrectos!"));
            }
            
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Usuario/contraseña incorrectos!")); 
        }
    }


}

$obj = Usuario::getInstance();


switch ($_GET["opcion"]){
	case 'login':
        $conexion = $obj->getDBConexion();
        $email=isset($_POST["email"])? $obj->limpiarCadena($_POST["email"]):"";
        $password=isset($_POST["password"])? $obj->limpiarCadena($_POST["password"]):"";

        if(empty($email) || empty($password)){
            echo json_encode(array("status"=>-1,"message"=>"Debe llenar todos los campos!"));
        }else{
            $obj->login($email, $password);
        }
	break;

	case 'registrar':
		
	break;

	case 'cotizar':
		
	break;
}

?>