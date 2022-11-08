<?php
header('Content-type:application/json;charset=utf-8');
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 0){
    header("Location: login.php");
}

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
            $db->dbcon = mysqli_connect("localhost", "seguros_usuario", "seguros_usuario123","seguros");
            $db->ip = $db->get_client_ip();
            return $db->dbcon;
        } catch (Exception $e) {
            echo "error: ".$e->getMessage();
        }
    }

    public static function obtener_edad_segun_fecha($fecha_nacimiento){
        $nacimiento = new DateTime($fecha_nacimiento);
        $ahora = new DateTime(date("Y-m-d"));
        $diferencia = $ahora->diff($nacimiento);
        return $diferencia->format("%y");
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

    public static function limpiarCadena($str) {
		$db = self::$instance;
		$str = mysqli_real_escape_string($db->dbcon,trim($str));
		return htmlspecialchars($str);
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

    public static function vida($fecha_inicio, $fecha_fin, $tipo_seguro, $num_documento, $tipo_documento, $nombres, $email, $fecha_nacimiento, $sexo, $estado_civil, $celular, $direccion, $ciudad, $ingreso, $profesion, $medicamento, $cual, $eps_ips, $id_usuario){

        $db = self::$instance;

        $sql="SELECT * FROM cotizar WHERE tipo = 'vida'";
        $result =mysqli_query($db->dbcon,$sql);
        
        if($row = mysqli_fetch_array($result)){
            $diferencia_dias = $db->diferencia_dias_dos_fechas($fecha_inicio, $fecha_fin);
            $total = intval($diferencia_dias)*$row["$tipo_seguro"];
            $ref_pago = random_int(10000000,2147483647);
            $id = $_SESSION['id'];
            
            $consulta="SELECT * FROM clientes WHERE id = '$num_documento'";
            $resultConsulta =mysqli_query($db->dbcon,$consulta);

            if(!$r = mysqli_fetch_array($resultConsulta)){
                $query = "INSERT INTO clientes(id, tipo_documento, names, email) VALUES ('$num_documento','$tipo_documento','$nombres','$email')";
                $result =mysqli_query($db->dbcon,$query);

                $db->auditoria($id_usuario, 'Se registro un nuevo cliente');

            }

            $query2 = "INSERT INTO vida(id_user, id_beneficiario, fecha_nacimineto, sexo, estado_civil, celular, direccion, ciudad, ingresos, profesion, medicamento, cual, eps_ips, fecha_inicio, fecha_fin, ref_pago, tipo, plan) VALUES ('$id','$num_documento','$fecha_nacimiento','$sexo','$estado_civil','$celular','$direccion','$ciudad','$ingreso','$profesion','$medicamento','$cual','$eps_ips','$fecha_inicio','$fecha_fin','$ref_pago', 'Seguro de vida', '$tipo_seguro')";

            $query3 = "INSERT INTO pagos(ref_pago, valor) VALUES ('$ref_pago','$total')";

            $result2 =mysqli_query($db->dbcon,$query2);
            $result3 =mysqli_query($db->dbcon,$query3);

            if ($result2 && $result3) {

                $db->auditoria($id_usuario, 'Lleno formulario de vida con ref N°'.$ref_pago);

                echo json_encode(array("status"=>1,"message"=>"Se realizo el registro! ref de pago: ".$ref_pago." --- valor a pagar: ".$total, "ref_pago"=>$ref_pago));
            }else{
                echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
            }
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }
    }

    public static function getInfoRef($ref_pago){
        $db = self::$instance;

        $sql = "SELECT valor FROM pagos WHERE ref_pago = '$ref_pago'";
        $sql2 = "SELECT tipo, plan FROM vida WHERE ref_pago = '$ref_pago'";

        $result =mysqli_query($db->dbcon,$sql);
        $result2 =mysqli_query($db->dbcon,$sql2);

        if(!$row = mysqli_fetch_array($result)){
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }
        if(!$row2 = mysqli_fetch_array($result2)){
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }

        echo json_encode(array("status"=>1,"tipo"=>$row2['tipo']." (".$row2['plan'].")", "valor"=>$row['valor']));
        
    }

    public static function pagar($ref_pago, $id_usuario){
        $db = self::$instance;
        $sql = "UPDATE pagos SET pago='1',activo='1' WHERE ref_pago = '$ref_pago'";
        $result =mysqli_query($db->dbcon,$sql);

        if ($result) {

            $db->auditoria($id_usuario, 'Realizo el pago del seguro con ref N°'.$ref_pago);

            echo json_encode(array("status"=>1,"message"=>"Pago registrado con exito!"));
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }
    }

    public static function misSeguros($id){
        $db = self::$instance;
        $sql = "SELECT p.cancelado, p.pago, p.ref_pago, p.activo, v.id_beneficiario, c.names, CONCAT(v.tipo,' (',v.plan,')') as tipo, CONCAT(v.fecha_inicio, ' - ',v.fecha_fin) as fecha, p.valor, p.reclamado, p.pago  FROM vida as v LEFT JOIN clientes as c ON v.id_beneficiario = c.id LEFT JOIN pagos as p ON v.ref_pago = p.ref_pago WHERE v.id_user = '$id';";

        $result =mysqli_query($db->dbcon,$sql);
        if ($result) {

            $db->auditoria($id, 'Solicito su registro de seguros');

            $data = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($data, $row);
            }
            echo json_encode(array("status"=>1,"data"=>$data));
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }
    }

    public static function detalles($ref_pago, $id_usuario){
        $db = self::$instance;
        $sql = "SELECT v.id_beneficiario, c.names, c.tipo_documento, v.fecha_nacimineto, v.sexo, v.estado_civil, c.email, v.celular, v.direccion, v.ingresos, v.profesion, v.medicamento, v.cual, v.eps_ips, CONCAT(v.tipo,' (',v.plan,')') as tipo_plan, v.tipo as tipo_seguro, CONCAT(v.fecha_inicio, ' - ',v.fecha_fin) as fecha, TIMESTAMPDIFF(DAY, v.fecha_inicio, v.fecha_fin) as dif_dias, TIMESTAMPDIFF(DAY, NOW(), v.fecha_fin) as dias_restantes  FROM vida as v LEFT JOIN clientes as c ON v.id_beneficiario = c.id WHERE v.ref_pago = '$ref_pago';";

        $result =mysqli_query($db->dbcon,$sql);
        if ($result) {

            $db->auditoria($id_usuario, 'Solicito detalles de su seguro con ref N°'.$ref_pago);

            echo json_encode(array("status"=>1,"data"=>mysqli_fetch_assoc($result)));
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }
    }

    public static function cancelarSeguro($ref_pago, $id_usuario){
        $db = self::$instance;
        $sql="UPDATE pagos SET cancelado='1' WHERE ref_pago = '$ref_pago'";
        $result =mysqli_query($db->dbcon,$sql);

        if($result){
            $db->auditoria($id_usuario, 'Cancelo el seguro con ref N°'.$ref_pago);
            echo json_encode(array("status"=>1,"message"=>"El seguro con referencia: ".$ref_pago." se ha cancelado!"));
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }
    }

    public static function reclamarSeguro($ref_pago, $id_usuario){
        $db = self::$instance;

        $sql = "UPDATE pagos SET reclamado='1' WHERE ref_pago = '$ref_pago'";
        $result =mysqli_query($db->dbcon,$sql);
        $sql2 = "INSERT INTO solicitudes(ref_pago) VALUES ('$ref_pago')";
        $result2 =mysqli_query($db->dbcon,$sql2);

        if ($result && $result2) {
            $db->auditoria($id_usuario, 'Ha solicitado reclamar su seguro con ref N°'.$ref_pago);
            echo json_encode(array("status"=>1,"message"=>"Su solicitud esta siendo procesada! en pocos dias un acesor se contactara con usted"));
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, algo salio mal"));
        }
    }

    public static function salir($id_usuario){
        $db = self::$instance;
        $db->getDBConexion();
        $db->auditoria($id_usuario, 'Salio del sistema');
        //Empezamos la sesión
        session_start();
        //Limpiamos las variables de sesión
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.html");
    }


}

$obj = Usuario::getInstance();

$id_usuario = $_SESSION["id"];

switch ($_GET["opcion"]){
	case 'guardar_vida':

        $conexion = $obj->getDBConexion();

        $nombres=isset($_POST["nombres"])? $obj->limpiarCadena($_POST["nombres"]):"";
        $tipo_documento=isset($_POST["tipo_documento"])? $obj->limpiarCadena($_POST["tipo_documento"]):"";
        $num_documento=isset($_POST["num_documento"])? $obj->limpiarCadena($_POST["num_documento"]):"";
        
        if(strlen($num_documento)>10){
            echo json_encode(array("status"=>-1,"message"=>"El numero de documento no puede tener mas de 10 caracteres"));
        }else{

            $fecha_nacimiento=isset($_POST["fecha_nacimiento"])? $obj->limpiarCadena($_POST["fecha_nacimiento"]):"";
            
            if ($obj->obtener_edad_segun_fecha($fecha_nacimiento)<18) {
                echo json_encode(array("status"=>-1,"message"=>"Fecha invalidad, no puedes tener ".$obj->obtener_edad_segun_fecha($fecha_nacimiento)." años"));
            }else{

                $sexo=isset($_POST["sexo"])? $obj->limpiarCadena($_POST["sexo"]):"";
                $estado_civil=isset($_POST["estado_civil"])? $obj->limpiarCadena($_POST["estado_civil"]):"";
                $email=isset($_POST["email"])? $obj->limpiarCadena($_POST["email"]):"";
                $celular=isset($_POST["celular"])? $obj->limpiarCadena($_POST["celular"]):"";
                
                if(strlen($celular)>10){
                    echo json_encode(array("status"=>-1,"message"=>"El numero de celular no puede tener mas de 10 caracteres"));
                }else{
                    
                    $direccion=isset($_POST["direccion"])? $obj->limpiarCadena($_POST["direccion"]):"";
                    $ciudad=isset($_POST["ciudad"])? $obj->limpiarCadena($_POST["ciudad"]):"";
                    $ingreso=isset($_POST["ingreso"])? $obj->limpiarCadena($_POST["ingreso"]):"";
                    $profesion=isset($_POST["profesion"])? $obj->limpiarCadena($_POST["profesion"]):"";
                    $medicamento=isset($_POST["medicamento"])? $obj->limpiarCadena($_POST["medicamento"]):"";
                    
                    if ($medicamento == "Si") {
                        $cual=isset($_POST["cual"])? $obj->limpiarCadena($_POST["cual"]):"";
                    }else{
                        $cual = "No aplica";
                    }
                    
                    $eps_ips=isset($_POST["eps_ips"])? $obj->limpiarCadena($_POST["eps_ips"]):"";
                    $fecha_inicio=isset($_POST["fecha_inicio"])? $obj->limpiarCadena($_POST["fecha_inicio"]):"";
                    
                    if ($obj->diferencia_dias($fecha_inicio) < -1) {
                        echo json_encode(array("status"=>-1,"message"=>"La fecha inicial no puede ser menor a la actual")); 
                    }else{
                        $fecha_fin=isset($_POST["fecha_fin"])? $obj->limpiarCadena($_POST["fecha_fin"]):"";
                        $tipo_seguro=isset($_POST["tipo_seguro"])? $obj->limpiarCadena($_POST["tipo_seguro"]):"";

                        if($obj->diferencia_dias_dos_fechas($fecha_inicio, $fecha_fin) < 1){
                            echo json_encode(array("status"=>-1,"message"=>"La diferencia de la fecha fin con respecto a la inicio, debe ser de por lo menos un dia."));
                        }else{
                            $obj->vida($fecha_inicio, $fecha_fin, $tipo_seguro, $num_documento, $tipo_documento, $nombres, $email, $fecha_nacimiento, $sexo, $estado_civil, $celular, $direccion, $ciudad, $ingreso, $profesion, $medicamento, $cual, $eps_ips, $id_usuario);
                        }
                    }
                }
            }
        
        }
	break;

	case 'info_ref':
        $conexion = $obj->getDBConexion();
        $ref_pago=isset($_POST["ref_pago"])? $obj->limpiarCadena($_POST["ref_pago"]):"";
		$obj->getInfoRef($ref_pago);
	break;

	case 'pagar_seguro':
        $conexion = $obj->getDBConexion();
        
        $patron_nombre= "/^[a-zA-ZÀ-ÿ\s]{3,40}$/";
        $patron_numTarjeta= '/^(?:4\d([\- ])?\d{6}\1\d{5}|(?:4\d{3}|5[1-5]\d{2}|6011 )([\- ])?\d{4}\2\d{4}\2\d{4})$/';
        $patron_fecha= "/^\d{2}\/\d{2}$/";
        $patron_cvv= "/^[0-9]{3}$/";
        $patron_direccion= "/^.{6,40}$/";
        $patron_id= "/^[0-9]{5,10}$/";

        $tarjeta=isset($_POST["tarjeta"])? $obj->limpiarCadena($_POST["tarjeta"]):"";
        $fecha=isset($_POST["fecha"])? $obj->limpiarCadena($_POST["fecha"]):"";
        $cvv=isset($_POST["cvv"])? $obj->limpiarCadena($_POST["cvv"]):"";
        $nombres=isset($_POST["nombres"])? $obj->limpiarCadena($_POST["nombres"]):"";
        $direccion=isset($_POST["direccion"])? $obj->limpiarCadena($_POST["direccion"]):"";
        $identificacion=isset($_POST["identificacion"])? $obj->limpiarCadena($_POST["identificacion"]):"";
        $ref_pago=isset($_POST["ref_pago"])? $obj->limpiarCadena($_POST["ref_pago"]):"";
        

        if (preg_match($patron_numTarjeta, $tarjeta)) {
            if (preg_match($patron_fecha, $fecha)) {
                if (preg_match($patron_cvv, $cvv)) {
                    if (preg_match($patron_nombre, $nombres)) {
                        if (preg_match($patron_direccion, $direccion)) {
                            if (preg_match($patron_id, $identificacion)) {
                                
                                $obj->pagar($ref_pago, $id_usuario);

                            }else{
                                echo json_encode(array("status"=>-1,"message"=>"La Identificacion no es valida.")); 
                            }
                        }else{
                            echo json_encode(array("status"=>-1,"message"=>"La direccion no es valida.")); 
                        }
                    }else{
                        echo json_encode(array("status"=>-1,"message"=>"El nombre de usuario tiene que ser de 3 a 40 dígitos y solo puede contener letras.")); 
                    }
                }else{
                    echo json_encode(array("status"=>-1,"message"=>"Codigo CVV incorrecto.")); 
                }
            }else{
                echo json_encode(array("status"=>-1,"message"=>"La fecha es invalida.")); 
            }
        }else{
            echo json_encode(array("status"=>-1,"message"=>"El numero de tarjeta no es permitido, solo se permiten guiones y numeros.")); 
        }
	break;

    case 'mis_seguros':
        $conexion = $obj->getDBConexion();
        $id=isset($_POST["id"])? $obj->limpiarCadena($_POST["id"]):"";
		$obj->misSeguros($id);
	break;

    case 'detalles':
        $conexion = $obj->getDBConexion();
        $ref_pago=isset($_POST["ref_pago"])? $obj->limpiarCadena($_POST["ref_pago"]):"";
		$obj->detalles($ref_pago, $id_usuario);
	break;

    case 'cancelar_seguro':
        $ref_pago = $_GET['ref'];
        $conexion = $obj->getDBConexion();
        $ref_pago=isset($_GET['ref'])? $obj->limpiarCadena($_GET['ref']):"";

        if(empty($ref_pago)){
            echo json_encode(array("status"=>-1,"message"=>"Error, no se recibio la referencia"));
        }else{
            $obj->cancelarSeguro($ref_pago , $id_usuario);
        }
    break;

    case 'reclamar':
        $conexion = $obj->getDBConexion();
        $ref_pago=isset($_POST['ref_pago'])? $obj->limpiarCadena($_POST['ref_pago']):"";
        $pdfFile = $_FILES['archivo']['name'];
        $tmp_dir = $_FILES['archivo']['tmp_name'];
        $pdfSize = $_FILES['archivo']['size'];
        
        if (!empty($ref_pago) && !empty($pdfFile)) {
            $upload_dir = '../archivos/';
        
            $pdfExt = strtolower(pathinfo($pdfFile,PATHINFO_EXTENSION));
        
            $valid_extensions = array('pdf');
        
            $userpic = $ref_pago.".".$pdfExt;
            if(in_array($pdfExt, $valid_extensions)){
                if($pdfSize < 1000000){
                    move_uploaded_file($tmp_dir,$upload_dir.$userpic);
                    
                    $obj->reclamarSeguro($ref_pago, $id_usuario);

                }else{
                    echo json_encode(array("status"=>-1,"message"=>"Error, su pdf es muy grande"));
                }
            }else{
                echo json_encode(array("status"=>-1,"message"=>"Error, el documento no es un pdf"));
            }
        }else{
            echo json_encode(array("status"=>-1,"message"=>"Error, no se recibio el archivo")); 
        }
    break;

	case 'cerrar_sesion':
		$obj->salir($id_usuario);
	break;

    default:
        header("Location: ../views/principal.php");
    break;
}

?>