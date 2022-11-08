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

    public static function registrar($id,$names,$tipo_documento,$email,$password){
        $db = self::$instance;
        $sql="SELECT * FROM usuarios WHERE email='$email' OR id='$id'";
        $result =mysqli_query($db->dbcon,$sql);

        if(!$row = mysqli_fetch_array($result)){
            $pass = password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]);
            $query1 = "INSERT INTO usuarios(id, tipo_documento, names, email, password) VALUES ('$id','$tipo_documento','$names','$email','$pass')";
            $result1 =mysqli_query($db->dbcon,$query1);

            if($result1){
                $db->auditoria($id, $email.' se registro en el sistema');

                echo json_encode(array("status"=>1,"message"=>"Usuario registrado!"));
            }else{
                echo json_encode(array("status"=>-1,"message"=>"Error al registrar al usuario."));
            }
            
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Ya existe un usuario con estos datos"));
        }
    }

    public static function diferencia_dias($fecha_ini){
        $ini = new DateTime($fecha_ini);
        $ahora = new DateTime(date("Y-m-d"));
        $diferencia = $ahora->diff($ini);
        return $diferencia->format("%R%a");
    }
    
    public static function diferencia_dias_dos_fechas($fecha_ini , $fecha_fin){
        $ini = new DateTime($fecha_ini);
        $fin = new DateTime($fecha_fin);
        $diferencia = $ini->diff($fin);
        return $diferencia->format("%R%a");
    }

    public static function cotizar($numero, $seguro, $tipo_seguro, $fecha_inicio, $fecha_fin){
        $db = self::$instance;
        $sql="SELECT * FROM cotizar WHERE tipo = '$seguro'";
        $result =mysqli_query($db->dbcon,$sql);

        if($row = mysqli_fetch_array($result)){
            $diferencia_dias = $db->diferencia_dias_dos_fechas($fecha_inicio, $fecha_fin);
            $total = intval($diferencia_dias)*$row["$tipo_seguro"]*$numero;
            echo json_encode(array("status"=>1,"message"=>"Todo bien!", "numero"=>"Número de asegurados: ".$numero, "dias"=>$diferencia_dias." dias (".$fecha_inicio." - ".$fecha_fin.")", "plan" => $tipo_seguro." x ".$numero, "total" => $total));
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
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
        $conexion = $obj->getDBConexion();
        $email=isset($_POST["email"])? $obj->limpiarCadena($_POST["email"]):"";
        $password=isset($_POST["password"])? $obj->limpiarCadena($_POST["password"]):"";
        $tipo_documento=isset($_POST["tipo_documento"])? $obj->limpiarCadena($_POST["tipo_documento"]):"";
        $id=isset($_POST["id"])? $obj->limpiarCadena($_POST["id"]):"";
        $names=isset($_POST["names"])? $obj->limpiarCadena($_POST["names"]):"";
        
        
        if(empty($id) || empty($names) || empty($tipo_documento) || empty($email) || empty($password)){
            echo json_encode(array("status"=>-1,"message"=>"Debe llenar todos los campos!"));
        }else{
            $obj->registrar($id, $names, $tipo_documento, $email, $password);
        }
	break;

	case 'cotizar':
        $conexion = $obj->getDBConexion();
        $numero=isset($_POST["num_personas"])? $obj->limpiarCadena($_POST["num_personas"]):"";
        $seguro=isset($_POST["seguro"])? $obj->limpiarCadena($_POST["seguro"]):"";
        $tipo_seguro=isset($_POST["tipo_seguro"])? $obj->limpiarCadena($_POST["tipo_seguro"]):"";
        $fecha_inicio=isset($_POST["fecha_inicio"])? $obj->limpiarCadena($_POST["fecha_inicio"]):"";
        $fecha_fin=isset($_POST["fecha_fin"])? $obj->limpiarCadena($_POST["fecha_fin"]):"";

        
        if ($obj->diferencia_dias($fecha_inicio) < -1) {
            echo json_encode(array("status"=>-1,"message"=>"La fecha inicial no puede ser menor a la actual")); 
        }else{
            if ($numero < 1) {
                echo json_encode(array("status"=>-1,"message"=>"Debe cotizar por lo menos para 1 persona, vehiculo o vivienda")); 
            }else{
                if($obj->diferencia_dias_dos_fechas($fecha_inicio, $fecha_fin) < 1){
                    echo json_encode(array("status"=>-1,"message"=>"La diferencia de la fecha fin con respecto a la inicio, debe ser de por lo menos un dia."));
                }else{
                    $obj->cotizar($numero, $seguro, $tipo_seguro, $fecha_inicio, $fecha_fin);
                }
            }
        }
	break;
}

?>