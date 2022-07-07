<?php
/* IMPORTANTE !!!!  Clase para (PHP 5, PHP 7)*/

class BaseDatos {
    private $HOSTNAME;
    private $BASEDATOS;
    private $USUARIO;
    private $CLAVE;
    private $CONEXION;
    private $QUERY;
    private $RESULT;
    private $ERROR;
    /**
     * Constructor de la clase que inicia ls variables instancias de la clase
     * vinculadas a la conexion con el Servidor de BD
     */
    public function __construct(){
        $this->HOSTNAME = "127.0.0.1";
        $this->BASEDATOS = "bdviajes";
        $this->USUARIO = "root";
        $this->CLAVE="";
        $this->RESULT=0;
        $this->QUERY="";
        $this->ERROR="";
    }
    /**
     * Funcion que retorna una cadena
     * con una pequenia descripcion del error si lo hubiera
     *
     * @return string
     */
    public function getError(){
        return "\n".$this->ERROR;
        
    }
    
    /**
     * Inicia la coneccion con el Servidor y la  Base Datos Mysql.
     * Retorna true si la coneccion con el servidor se pudo establecer y false en caso contrario
     *
     * @return boolean
     */
    public  function Iniciar(){
        $resp  = false;
        //establecemos la conexion
        $conexion = mysqli_connect($this->HOSTNAME,$this->USUARIO,$this->CLAVE,$this->BASEDATOS);
        if ($conexion){
             //seleccionamos la base de datos
            if (mysqli_select_db($conexion,$this->BASEDATOS)){
                //guardamos la conexion
                $this->CONEXION = $conexion;
                //y  limpiamos las variables de instancia
                unset($this->QUERY);
                unset($this->ERROR);
                $resp = true;
            }  else {
                //devuelve numero de error y la descripcion del error
                $this->ERROR = mysqli_errno($conexion) . ": " .mysqli_error($conexion);
            }
        }else{
            //sino  se puede establecer la conexion, devuelve numero de error y la descripcion del error 
            $this->ERROR =  mysqli_errno($conexion) . ": " .mysqli_error($conexion);
        }
        return $resp;
    }
    
    /**
     * Ejecuta una consulta en la Base de Datos.
     * Recibe la consulta en una cadena enviada por parametro.
     *
     * @param string $consulta
     * @return boolean
     */
    public function Ejecutar($consulta){
        $resp  = false;
        unset($this->ERROR);
        //guardarmos la consulta en el atributo QUERY
        $this->QUERY = $consulta;
        //le asignamos a la variable RESULT mysql_query que recibe como parametro el canal por el que queremos pasar esa consulta, y la consulta
           if(  $this->RESULT = mysqli_query( $this->CONEXION,$consulta)){
           //Si se pudo ejecutar retorna true
            $resp = true;
        } else {
        //devuelve numero de error y la descripcion del error
            $this->ERROR =mysqli_errno( $this->CONEXION).": ". mysqli_error( $this->CONEXION);
        }
        return $resp;
    }
    
    /**
     * Devuelve un registro retornado por la ejecucion de una consulta
     * el puntero se despleza al siguiente registro de la consulta
     *
     * @return boolean
     */
    //Ejemplo: puede servir para crear una coleccion de muchos objetos, los obtenemos de la BD con este metodo y lo agregamos a la coleccion
    //usando una repetiva para obtener los resultados de una consulta select
    public function Registro() {
        $resp = null;
        //si tenemos un resultado para mostrar
        if ($this->RESULT){
            unset($this->ERROR);
            //mientras queda elementos los retorna, sino devuelve null
            //le asignamos a una variable temporal
            //mysqli_fetch_assoc retorna el valor del registro que esta siendo apuntado,
            //y automaticamente pasa al siguiente registro
            if($temp = mysqli_fetch_assoc($this->RESULT)){
                $resp = $temp;
            }else{
                //sino hay mas registros, liberamos el cursor, que nos permite recorrer el resultado de la consulta
                mysqli_free_result($this->RESULT);
            }
        }else{
            //devuelve numero de error y la descripcion del error
            $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
        }
        return $resp ;
    }
    
    /**
     * Devuelve el id de un campo autoincrement utilizado como clave de una tabla
     * Retorna el id numerico del registro insertado, devuelve null en caso que la ejecucion de la consulta falle
     * Depenede de las caracteristicas 
     * @param string $consulta
     * @return int id de la tupla insertada
     */
    public function devuelveIDInsercion($consulta){
        $resp = null;
        unset($this->ERROR);
        $this->QUERY = $consulta;
        //le asignamos a la variable RESULT mysql_query que recibe como parametro el canal por el que queremos pasar esa consulta, y la consulta
          if ($this->RESULT = mysqli_query($this->CONEXION,$consulta)){
            //devuelve el id de el registro que fue insertado
            $id = mysqli_insert_id();
            $resp =  $id;
        } else {
            $this->ERROR =mysqli_errno( $this->CONEXION) . ": " . mysqli_error( $this->CONEXION);
           
        }
    return $resp;
    }
    
}
?>