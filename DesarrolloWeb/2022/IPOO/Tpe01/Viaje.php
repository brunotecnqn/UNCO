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
   private $esIdaVuelta;
   private $importe;
  
   public function  __construct($codigo_viaje, $destino, $cant_maxima, $colObjpasajeros,$refResponsable,$esIdaVuelta,$importe)
   {
      $this->codigo_viaje = $codigo_viaje;
      $this->destino = $destino;
      $this->cant_maxima = $cant_maxima;
      $this->arre_pasajero = $colObjpasajeros;
      $this->objResponsable=$refResponsable;
      $this->esIdaVuelta=$esIdaVuelta;
      $this->importe=$importe;
       
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
   /**
    * El método retorna el importe del pasaje si se pudo realizar la venta
    ** @return 
   */
  public function venderPasaje($pasajero) 
{ 
   $importe="";
   if($this->hayPasajesDisponible())
  {
   $this->agregarPasajero($pasajero);
   $importe=$this->calcularImporte();
  } 
      
   return $importe;
}
   
   public function hayPasajesDisponible()
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
   public function agregarPasajero($pasajero)
   {
      $res = false;
      
      if ($this-> hayPasajesDisponible()) {
         $arre = $this->getArre_pasajero();
         array_push($arre, $pasajero);
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
      if($this->getEsIdaVuelta())
      {
        $cadena.="Ida y vuelta: ☑";   
      }
      else
        $cadena.="Solo ida: ☑";

      $cadena .= "\nResponsable: ".$this->getObjResponsable()->__toString()."\n";
      $cadena .= "Lista de pasajeros\n";
      foreach ($this->getArre_pasajero() as $pasajero) {
         $cadena .= $pasajero->__toString(). "\n";
      }
      return $cadena;
   }

   public function getEsIdaVuelta()
   {
      return $this->esIdaVuelta;
   }
   public function setEsIdaVuelta($esIdaVuelta)
   {
      $this->esIdaVuelta = $esIdaVuelta;
   }
 /**
 *  Retorna el importe total a pagar.
 * Double importeBase
 * @return double
 */
   public function calcularImporte()
   { 
      $importeBase=$this->getImporte();
      if($this->getEsIdaVuelta())
      {
         $importeBase=$importeBase+$importeBase*0.5;
      }
      
     return $importeBase;
   }
   public function getImporte()
   {
      return $this->importe;
   }

   public function setImporte($importe)
   {
      $this->importe = $importe;
   }
}
