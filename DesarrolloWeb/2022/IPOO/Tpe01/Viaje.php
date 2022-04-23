<?php
 /*TPE 01 
   Bruno Terrazas FAI-2585*/
class Viaje
{

   private $codigo_viaje;
   private $destino;
   private $cant_maxima;
   private $objResponsable;
   private $arre_pasajero = array();

   public function  __construct($codigo_viaje, $destino, $cant_maxima, $colObjpasajeros,$refResponsable)
   {
      $this->codigo_viaje = $codigo_viaje;
      $this->destino = $destino;
      $this->cant_maxima = $cant_maxima;
      $this->arre_pasajero = $colObjpasajeros;
      $this->objResponsable=$refResponsable;
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
   public function getObjResponsable()
   {
      return $this->objResponsable;
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
   
 

   public function setObjResponsable($objResponsable)
   {
      $this->objResponsable = $objResponsable;

   }
   public function setArrePasajero($arre_pas)
   {

      $this->arre_pasajero = $arre_pas;
   }

   
   public function verificarEspacio()
   {
      return count($this->getArre_pasajero()) < $this->getCant_maxima();
   }
   function buscarPasajero($num_documento)
   {
      $listaPasajeros=$this->getArre_pasajero();
      $i=0;
      $buscado=null;
      $encontrado=false;
      while($i<count($listaPasajeros)&&(!$encontrado))
      {       
         $encontrado=($listaPasajeros[$i]->verificarPasajero($num_documento));
         if($encontrado)
         {
            $buscado=$listaPasajeros[$i];
         }
         $i++;     
      }
      return $buscado;
     
   }   
   /**
    * Agrega un nuevo pasajero a lista o arreglo de pasajeros
    * BOOLEAN $res
    * @param String $num_documento
    * @param String $nombre
    * @param String $apellido
    * @return Boolean
    */
   public function agregarPasajero($nombre, $apellido, $num_documento,$telefono)
   {
      $res = false;
      $nuevo=new Pasajero($num_documento,$nombre,$apellido,$telefono);
      if ($this->verificarEspacio()) {
         $arre = $this->getArre_pasajero();
         array_push($arre, $nuevo);
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
 *  Retorna en forma de cadena de texto los valores de los atributos de la instancia clase ResponsableV.
 * String cadena
 * @return String
 */

   public function __toString()
   {
      $cadena = "CODIGO DE VIAJE: " . ($this->getCodigo_viaje()) . " DESTINO: " . ($this->getDestino()) . " CANTIDAD MAXIMA: " . ($this->getCant_maxima()) . "\n";
      $cadena .= "Responsable: ".$this->getObjResponsable()->__toString()."\n";
      $cadena .= "Lista de pasajeros\n";
      foreach ($this->getArre_pasajero() as $pasajero) {
         $cadena .= $pasajero->__toString(). "\n";
      }
      return $cadena;
   }

}
