<?php 

class ViajeAereo extends Viaje
{
   private $num_vuelo;
   private $nombreAerolinea;
   private $cantidad_escalas;
   private $esPrimeraClase;

   public function __construct($codigo_viaje, $destino, $cant_maxima, $colObjpasajeros,$refResponsable,$esIdaVuelta,$importe,$numVuelo,$nom_aerolinea,$esPrimeraClase,$cant_escalas)
   {
      parent:: __construct($codigo_viaje, $destino, $cant_maxima, $colObjpasajeros,$refResponsable,$esIdaVuelta,$importe);
      $this->num_vuelo=$numVuelo;
      $this->nombreAerolinea=$nom_aerolinea;
      $this->esPrimeraClase=$esPrimeraClase;
      $this->cantidad_escalas=$cant_escalas;

   }
   public function getNumVuelo()
   {
      return $this->num_vuelo;
   }

   public function setNumVuelo($num_vuelo)
   {
      $this->num_vuelo = $num_vuelo;
   }

   public function getNombreAerolinea()
   {
      return $this->nombreAerolinea;
   }

   public function setNombreAerolinea($nombreAerolinea)
   {
      $this->nombreAerolinea = $nombreAerolinea;
   }

   public function getCantidadEscalas()
   {
      return $this->cantidad_escalas;
   }
   public function setCantidadEscalas($cantidad_escalas)
   {
      $this->cantidad_escalas = $cantidad_escalas;

   }
   /**
   * Retorna en forma de cadena de texto los valores de los atributos de la instancia clase ViajeAereo 
   * String cadena
   * @return String
   */
   public function __toString()
   {$cadena="Num. vuelo: ".$this->getNumVuelo()." Nombre Aerolinea: ".$this->getNombreAerolinea()." Cantidad de escalas: ".$this->getCantidadEscalas()."\n";  
     $cadena.=parent::__toString();
     return $cadena;
    }
   public function getEsPrimeraClase()
   {
      return $this->esPrimeraClase;
   }
   public function setEsPrimeraClase($esPrimeraClase)
   {
      $this->esPrimeraClase = $esPrimeraClase;
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
      if($this->getEsPrimeraClase())
     {
       // si el asiento es primera clase y sin escalas -> (importe+40%)
       if($this->getCantidadEscalas()==0)
       {
        $importeTotal=$importeTotal+($importeTotal*0.40);
       }
       // si el asiento es primera clase y con escalas -> (importe+60%)
       if($this->getCantidadEscalas()>0)
       {
         $importeTotal=$importeTotal+($importeTotal*0.60);
       }
     }
      return $importeTotal; 
   }
}
?>