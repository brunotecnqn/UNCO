<?php
/*TPFinal
   Bruno Terrazas FAI-2585*/
class Viaje
{

   private $idviaje;
   private $vdestino;
   private $vcantmaxpasajeros;
   private $objEmpresa;
   private $objResponsable;
   private $vimporte;
   private $colObjPasajeros = array();
   private $tipoAsiento;
   private $idayvuelta;
   private $mensajeoperacion;


   public function  __construct()
   {
      $this->idviaje = 0;
      $this->vdestino = "";
      $this->vcantmaxpasajeros = 0;
      $this->objEmpresa = new Empresa();
      $this->objResponsable = new Responsable();
      $this->vimporte = 0;
      $this->colObjPasajeros = [];
      $this->tipoAsiento = "";
      $this->idayvuelta = "";
   }
   public function cargar($idviaje,$destino, $cantMax, $objEmpresa, $objResponsable, $importe, $tipoAsiento, $idayvuelta)
   {
      $this->setIdviaje($idviaje);
      $this->setVdestino($destino);
      $this->setVcantmaxpasajeros($cantMax);
      $this->setObjEmpresa($objEmpresa);
      $this->setObjResponsable($objResponsable);
      $this->setVimporte($importe);
      $this->setTipoAsiento($tipoAsiento);
      $this->setIdayvuelta($idayvuelta);
   }
   public function insertar()
   {
      $base = new BaseDatos();
      $resp = false;
      $destino = "'".$this->getVdestino()."'";
     $consultaInsertar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros,idempresa,rnumeroempleado,vimporte,tipoAsiento,idayvuelta) 
				VALUES ($destino,". $this->getVcantmaxpasajeros() . ",". $this->getObjEmpresa()->getIdempresa(). "," . $this->getObjResponsable()->getRnumeroempleado() . ", " . $this->getVimporte().",'" . $this->getTipoAsiento() . "','" . $this->getIdayvuelta() . "')";
      echo "\n---------------";
      echo "\n$consultaInsertar";
      if ($base->Iniciar()) {

         if ($base->Ejecutar($consultaInsertar)) {

            $resp =  true;
         } else {
            $this->setmensajeoperacion($base->getError());
         }
      } else {
         $this->setmensajeoperacion($base->getError());
      }
      return $resp;
   }


   /**
    * Recupera los datos de un Viaje por su Idviaje
    * @param int $idviaje
    * @return true en caso de encontrar los datos, false en caso contrario 
    */
   public function Buscar($idviaje)
   {
      $base = new BaseDatos();
      $consulta = "Select * from viaje where idviaje=" . $idviaje;
      $resp = false;
      if ($base->Iniciar()) {
         if ($base->Ejecutar($consulta)) {
            if ($row2 = $base->Registro()) {
               $this->setIdviaje($row2['idviaje']);
               $this->setVdestino($row2['vdestino']);
               $this->setVcantmaxpasajeros($row2['vcantmaxpasajeros']);
               $objEmpresa = new Empresa();
               $objResponsable = new Responsable();
               $this->setObjEmpresa($objEmpresa->Buscar($row2['idempresa']));
               $this->setObjResponsable($objResponsable->Buscar($row2['rnumeroempleado']));
               $this->setVimporte($row2['vimporte']);
               $this->setTipoAsiento($row2['tipoAsiento']);
               $this->setIdayvuelta($row2['idayvuelta']);

               $resp = true;
            }
         } else {
            $this->setmensajeoperacion($base->getError());
         }
      } else {
         $this->setmensajeoperacion($base->getError());
      }
      return $resp;
   }
   public function getIdviaje()
   {
      return $this->idviaje;
   }


   public function setIdviaje($idviaje)
   {
      $this->idviaje = $idviaje;
   }
   public function getVdestino()
   {
      return $this->vdestino;
   }
   public function getVcantmaxpasajeros()
   {
      return $this->vcantmaxpasajeros;
   }


   public function getObjResponsable()
   {
      return $this->objResponsable;
   }
   public function setObjResponsable($objResponsable)
   {
      $this->objResponsable = $objResponsable;
   }

   public function getObjEmpresa()
   {
      return $this->objEmpresa;
   }
   public function setObjEmpresa($objEmpresa)
   {
      $this->objEmpresa = $objEmpresa;
   }
   public function getVimporte()
   {
      return $this->vimporte;
   }

   public function setVimporte($vimporte)
   {
      $this->vimporte = $vimporte;
   }

   public function getIdayvuelta()
   {
      return $this->idayvuelta;
   }
   public function setIdayvuelta($idayvuelta)
   {
      $this->idayvuelta = $idayvuelta;
   }
   public function getColObjPasajeros()
   {
      return $this->colObjPasajeros;
   }

   public function setVdestino($vdestino)
   {
      $this->vdestino = $vdestino;
   }
   public function setVcantmaxpasajeros($vcantmaxpasajeros)
   {
      $this->vcantmaxpasajeros = $vcantmaxpasajeros;
   }
   public function setColObjPasajeros($arre_pas)
   {

      $this->colObjPasajeros = $arre_pas;
   }


   public function hayPasajesDisponible()
   {
      return count($this->getcolObjPasajeros()) < $this->getvcantmaxpasajeros();
   }

   public function listarPasajeros($condicion=""){
      $arregloPasajeros = null;
      $base=new BaseDatos();
      $consulta="Select * from pasajero";
      if ($condicion!=""){
          $consulta =$consulta .' where '.$condicion;
      }
      $consulta .="";
    
      if($base->Iniciar()){
          if($base->Ejecutar($consulta)){
              //si hay registros creamos un arreglo				
              $arregloPasajeros= array();
              while($row2=$base->Registro()){
                  
                  $documento=$row2['rdocumento'];
                  $nombre=$row2['pnombre'];
                  $apellido=$row2['papellido'];
                  $telefono=$row2['ptelefono'];
                  $idviaje=$row2['idviaje'];
              
                  $emp=new Pasajero();
                  $emp->cargar($documento,$nombre,$apellido,$telefono,$idviaje);
                  array_push($arregloPasajeros,$emp);
  
              }
              
          
           }	else {
                   $this->setmensajeoperacion($base->getError());
               
          }
       }	else {
               $this->setmensajeoperacion($base->getError());
           
       }	
       return $arregloPasajeros;
  }

   /**
    *  Retorna en forma de cadena de texto los valores de los atributos de la instancia clase empleadoV.
    * String cadena
    * @return String
    */

   public function __toString()
   {
      $cadena = "-------------------Viaje-----------------\n";
      $cadena = "IDviaje: " . ($this->getIdviaje()) . " Destino: " . ($this->getvdestino()) . " CANTIDAD MAXIMA: " . ($this->getvcantmaxpasajeros()) . "\n";
      $objResponsable = new Responsable();

      if ($objResponsable->Buscar($objResponsable->getRnumeroempleado()."")) {
         $cadena .= "\nResponsable: " . $objResponsable->__toString() . "\n";
      }
      else{
         echo $this->getMensajeoperacion();
      }


      /*  if($objResponsable->Buscar($this->getrnumeroempleado()))
	{
	   $cadena .= "\nResponsable: ".$objResponsable->__toString()."\n";
   
	}*/
      $cadena .= "\nLista de pasajeros\n";
      $this->setColObjPasajeros($this->listarPasajeros("idviaje=".$this->getIdviaje()));
      foreach ($this->getcolObjPasajeros() as $pasajero) {
         $cadena .= $pasajero->__toString() . "\n";
      }
      return $cadena;
   }
   /*
   public function getObjResponsable()
   {
      return $this->objResponsable;
   }

   public function setObjResponsable($objResponsable)
   {
      $this->objResponsable = $objResponsable;
   }
*/
   public function getMensajeoperacion()
   {
      return $this->mensajeoperacion;
   }
   public function setMensajeoperacion($mensajeoperacion)
   {
      $this->mensajeoperacion = $mensajeoperacion;
   }

   public function getTipoAsiento()
   {
      return $this->tipoAsiento;
   }
   public function setTipoAsiento($tipoAsiento)
   {
      $this->tipoAsiento = $tipoAsiento;
   }
}
