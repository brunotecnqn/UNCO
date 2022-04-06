<?php
 /*TPE 01 
   Bruno Terrazas FAI-2585*/
class Viaje
{

   private $codigo_viaje;
   private $destino;
   private $cant_maxima;
   private $arre_pasajero = array();

   public function  __construct($codigo_viaje, $destino, $cant_maxima, &$arre_pasajero)
   {
      $this->codigo_viaje = $codigo_viaje;
      $this->destino = $destino;
      $this->cant_maxima = $cant_maxima;
      $this->arre_pasajero = $arre_pasajero;
   }
   public function getCodigo_viaje()
   {
      return $this->codigo_viaje;
   }
   public function getDestino()
   {
      return $this->destino;
   }
   public function getCant_maxima()
   {
      return $this->cant_maxima;
   }
   public function getArre_pasajero()
   {
      return $this->arre_pasajero;
   }
   /*No definimos set para codigo de viaje, deberia ser clave no modificable*/
   public function setDestino($destino)
   {
      $this->destino = $destino;
   }
   public function setCantMaxima($cant_maxima)
   {
      $this->cant_maxima = $cant_maxima;
   }
   public function setArrePasajero($arre_pas)
   {

      $this->arre_pasajero = $arre_pas;
   }

   /*Suponiendo que se pueden modificar todos los datos del pasajero*/

   /**
    * Modifica el Num. de documento de un pasajero, ubicado por su posicion ($key) en el arreglo o lista de pasajeros. 
    * @param Int $key
    * @param String $new_num_documento
    * @return Void
    */
   public function addNumDocumento($key, $new_num_documento)
   {
      $this->arre_pasajero[$key]["num_documento"] = $new_num_documento;
   }
   /**
    * Modifica el Nombre de un pasajero, ubicado por su posicion ($key) en el arreglo o lista de pasajeros. 
    * @param Int $key
    * @param String $new_nombre
    * @return Void
    */
   public function addNombrePasajero($key, $new_nombre)
   {
      $this->arre_pasajero[$key]["nombre"] = $new_nombre;
   }
   /**
    * Modifica el Apellido de un pasajero, ubicado por su posicion ($key) en el arreglo o lista de pasajeros. 
    * @param Int $key
    * @param String $new_apellido
    * @return Void
    */
   public function addApellidoPasajero($key, $new_apellido)
   {
      $this->arre_pasajero[$key]["apellido"] = $new_apellido;
   }
   /**
    * Verifica si hay espacio en el arreglo o lista de pasajeros, si la cantidad de pasajeros
    * es menor  a la cantidad maxima, retorna true, sino false
    * @return Boolean
    */
   public function verificarEspacio()
   {
      return count($this->getArre_pasajero()) < $this->getCant_maxima();
   }
   /**
    * Obtiene los datos del pasajero,, ubicado por su posicion ($key) en el arreglo o lista de pasajeros. 
    * STRING $num_documento,$nombre,$apellido
    * @param Int $key
    * @return String
    */
   public function obtenerPasajero($key)
   {
      $num_documento = $this->getArre_pasajero()[$key]["num_documento"];
      $nombre = $this->getArre_pasajero()[$key]["nombre"];
      $apellido = $this->getArre_pasajero()[$key]["apellido"];

      return "Num. Documento:" . $num_documento . " Nombre:" . $nombre . " Apellido:" . $apellido . "\n";
   }
   /**
    * Agrega un nuevo pasajero a lista o arreglo de pasajeros
    * BOOLEAN $res
    * @param String $num_documento
    * @param String $nombre
    * @param String $apellido
    * @return Boolean
    */
   public function agregarPasajero($nombre, $apellido, $num_documento)
   {
      $res = false;
      if ($this->verificarEspacio()) {
         $arre = $this->getArre_pasajero();
         array_push($arre, ["num_documento" => $num_documento, "nombre" => $nombre, "apellido" => $apellido]);
         $this->setArrePasajero($arre);
         $res = true;
      }

      return $res;
   }
   /**
    * Modifica los datos del Viaje
    * @param String $destino
    * @param Int $cant_maxima
    * @return Void
    */
   public function editarViaje($destino, $cant_maxima)
   {
      $this->setDestino($destino);
      $this->setCantMaxima($cant_maxima);
   }
   /**
    * Actualiza los datos de un pasajero, ubicado por su posicion ($key) en el arreglo o lista de pasajeros. 
    * INT $cant_pasajero
    * BOOLEAN $res
    * @param Int $key
    * @param String $num_documento
    * @param String $nombre
    * @param String $apellido
    * @return Boolean
    */
   public function editarPasajero($key, $num_documento, $nombre, $apellido)
   {
      $res = false;
      $cantPasajero = count($this->getArre_pasajero());
      if ($key >= 0 && $key < $cantPasajero) {
         $this->addNumDocumento($key, $num_documento);
         $this->addNombrePasajero($key, $nombre);
         $this->addApellidoPasajero($key, $apellido);
         $res = true;
      }
      return $res;
   }
   public function __toString()
   {

      $cadena = "CODIGO DE VIAJE: " . ($this->getCodigo_viaje()) . " DESTINO: " . ($this->getDestino()) . " CANTIDAD MAXIMA: " . ($this->getCant_maxima()) . "\n";
      $cadena .= "Lista de pasajeros\n";
      foreach ($this->getArre_pasajero() as $key => $value) {
         $cadena .= "Num.pasajero:" . ($key + 1) . " Documento:" . $value['num_documento'] . " Nombre:" . $value['nombre'] . " Apellido:" . $value['apellido'] . "\n";
      }
      return $cadena;
   }
}
