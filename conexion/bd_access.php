<?php
ini_set('max_execution_time', 0);

//require 'HandlerError.php';

/**
 * @internal la clase conexion busca centralizar y proteger la conexion a la base de datos
 * @internal este archivo no debe ser reubicado, ni duplicado
 * @internal para hacer uso de queries favor de utilizar el archivo controllerFace.php
 * @since face 5.5 (12 de Junio del 2013)
 */
if(!class_exists("Conexion")){
class Conexion {
    protected $hostname;
    protected $database;
    protected $username;
    protected $password;
    protected $fwk_db;
    protected $rst_e;
	protected $rst_c;
    protected $rows;
    protected $columns;
    protected $estado;
	protected $handler;
	//CHS - MASNEGOCIO - 20140512 SE AGREGA VARIABLE PARA USER PREPARE STATAMENT Y EVITAR XSS
	protected $tipoParam;
	private	  $resulset;
	protected $property;
    /**
	 * @method __construct constructor de la clase conexion
	 * @param hostname
	 * @param database
	 * @param username
	 * @param password
	 * @return Object mysqli retorna una nueva conexion a base de datos con la api mysqli
	 */
    function __construct() {
    	$this->hostname = "127.0.0.1";
		$this->database = "quiniela";
		$this->username = "root";
		$this->password = "alone90.";


        $this->rows    = 0;
        $this->estado  = 0;
        $this->columns = 0;
        $this->rst_c   = 0;
        $this->fwk_db  = new mysqli($this->hostname,
        							$this->username,
        							$this->password,
        							$this->database);
		$this->fwk_db ->set_charset("utf8");
		if(mysqli_connect_errno()) {
            die("Error en la conexion : ".$this->fwk_db->connect_errno.
                                      "-".$this->fwk_db->connect_error);
		}

		$this -> tipoParam = array('integer'	=>	'i'
									,'string'	=>	's'
									,'double'	=>	'd'
									,'blob'		=>	'b');
	}

	/**
	 * @method consultar
	 * @param $query es un string que contiene la consulta a la base de datos
	 * @return array $result retorna un arreglo asociativo con la respuesta en caso de exito
	 * 		   String $msg un mensaje de error en caso de que el query no tenga exito
	 */
    function consultar($query, $banderaResult = true) {
    	$result="";
		try {
    		$this->rows = 0;
			$this->columns = 0;
			mysqli_set_charset($this->fwk_db, "utf8");
			$this->rst_c = mysqli_query($this->fwk_db,$query);
			if($this->fwk_db->errno != 0) {
				throw new Exception($this->fwk_db->error);
			}
			//error_log(print_r($this->rst_c,TRUE));
			if($banderaResult){
				$result=$this->get_data_array();
			}else{
				$result ="exito";
			}

		} catch (Exception $e) {
    		$msg= sprintf("Error: %s \n %s",$e -> getMessage(),$query);

			throw new Exception($msg);
			//$result =$msg;
		}
		return($result);
	}

	function fila($filas){
	$result="";
	error_log("FILAS");
	error_log(print_r($filas,true));
	$result=mysqli_num_rows($filas);
	return ($result);

	}


    function get_rows() {
        return($this->rst_c->num_rows);
	}

    function get_columns() {
        return($this-> fwk_db-> field_count);
	}

    function getConnection() {
        return($this->fwk_db);
	}

	/**
	 * @method get_data_array transforma un #resource resultado de un query a un arreglo asociativo
	 * @return array $vt_aux arreglo asociativo con la respuesta del query
	 * @internal este metodo se emplea unicamente en el metodo consultar($query), no esta diseñado para usarse fuera de esta clase
	 */
	protected function get_data_array() {
        $vt_aux = array();
		while ($fila = mysqli_fetch_assoc($this->rst_c)) {
            array_push($vt_aux, $fila);
		}
		if($this->fwk_db->affected_rows===1) {
			$vt_aux=$vt_aux[0];
		}
        return $vt_aux;
	}

	public function close(){
		$this->fwk_db->close();
	}


	//CHS - MASNEGOCIO - 20140512 - SETTERS Y GETTERS
	public function __get($property) {
		if (property_exists($this, $property)) {
		  return $this->$property;
		} else {
			log_action("Propiedad no existente: ".$this->$property);
		}
	}//fin get

  	public function __set($property, $value) {
    	if (property_exists($this, $property)) {
      		$this->$property = ($value);
    	}else{
    		log_action("Propiedad no existente: ".$this->$property);
    	}

    	return $this;
  	}//fin set
public function fixResultSet($resultset)
	{
		return ($this->get_rows() == 1) ? array($resultset) : $resultset;
	}

	public function startTransaction(){
		try{
			$mysqli = $this->fwk_db;
			$mysqli->query("BEGIN");
		}catch(Exception $e){
			log_action("Error st ".$e->getMessage());
		}
	}

	public function commitTransaction(){
		try{
			$mysqli = $this->fwk_db;
			$mysqli->query("COMMIT");
		}catch(Exception $e){
			log_action("Error ct ".$e->getMessage());
		}
	}

	public function rollbackTransaction(){
		try{
			$mysqli = $this->fwk_db;
			$mysqli->query("ROLLBACK");
		}catch(Exception $e){
			log_action("Error rt ".$e->getMessage());
		}
	}
}
}
?>
