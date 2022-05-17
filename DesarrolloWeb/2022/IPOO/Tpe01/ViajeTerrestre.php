<?php 

class ViajeTerrestre extends Viaje
{
   private $tipo_asiento;
   public function __construct($codigo_viaje, $destino, $cant_maxima, $colObjpasajeros,$refResponsable,$esIdaVuelta,$importe,$tipo_asiento)
   {
      parent:: __construct($codigo_viaje, $destino, $cant_maxima, $colObjpasajeros,$refResponsable,$esIdaVuelta,$importe);
      $this->tipo_asiento=$tipo_asiento;
   }

   public function getTipoAsiento()
   {
      return $this->tipo_asiento;
   }
   public function setTipoAsiento($tipo_asiento)
   {
      $this->tipo_asiento = $tipo_asiento;
   }
 /**
 *  Retorna el importe total a pagar.
 * Double importeBase
 * @return double
 */
 
   public function calcularImporte()
   { 
       
      //calcula el importe si el pasaje es de ida o vuelta
       $importeTotal=parent::calcularImporte();
      //si el asiento es cama (importe+25%)
       if($this->getTipoAsiento()=="Cama")
       {
         $importeTotal=$importeTotal+($importeTotal*0.25);
       }
      return $importeTotal;
   }
   
   /**
   * Retorna en forma de cadena de texto los valores de los atributos de la instancia clase ViajeTerrestre, incluyendo los atributos de la clase padre. 
   * String cadena
   * @return String
   */
   public function __toString()
   { 
     $cadena=parent::__toString();
     $cadena.="Tipo asiento: ".$this->getTipoAsiento()."\n";  
     return $cadena;
   }
}
?>