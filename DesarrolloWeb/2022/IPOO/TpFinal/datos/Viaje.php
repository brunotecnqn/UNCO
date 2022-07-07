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
      $this->tipoAsiento = "";
      $this->idayvuelta = "";
   }

   /** Permite cargar los datos del viaje
    * 
    */
   public function cargar($idviaje, $destino, $cantMax, $objEmpresa, $objResponsable, $importe, $tipoAsiento, $idayvuelta)
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

   /** Permite insertar el viaje en la base de datos
    * @return Boolean
    */
   public function insertar()
   {
      $base = new BaseDatos();
      $resp = false;
      $destino = "'" . $this->getVdestino() . "'";
      $consultaInsertar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros,idempresa,rnumeroempleado,vimporte,tipoAsiento,idayvuelta) 
				VALUES ($destino," . $this->getVcantmaxpasajeros() . "," . $this->getObjEmpresa()->getIdempresa() . "," . $this->getObjResponsable()->getRnumeroempleado() . ", " . $this->getVimporte() . ",'" . $this->getTipoAsiento() . "','" . $this->getIdayvuelta() . "')";

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
   /** Permite modificar el viaje en la base de datos
    * @return Boolean
    */
   public function modificar()
   {
      $resp = false;
      $base = new BaseDatos();
      $consultaModifica = "UPDATE viaje SET vdestino='" . $this->getVdestino() . "', vcantmaxpasajeros=" . $this->getVcantmaxpasajeros() . "
     WHERE idviaje=" . $this->getIdviaje();
      if ($base->Iniciar()) {
         if ($base->Ejecutar($consultaModifica)) {
            $resp =  true;
         } else {
            $this->setmensajeoperacion($base->getError());
         }
      } else {
         $this->setmensajeoperacion($base->getError());
      }
      return $resp;
   }

   /** Permite eliminar el viaje en la base de datos
    * @return Boolean
    */
   public function eliminar()
   {
      $base = new BaseDatos();
      $resp = false;
      if ($base->Iniciar()) {
         $consultaBorra = "DELETE FROM viaje WHERE idviaje=" . $this->getIdviaje();
         if ($base->Ejecutar($consultaBorra)) {
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
   public function Buscar($condicion = "")
   {
      $base = new BaseDatos();
      $consulta = "Select * from viaje ";
      $consulta .= "where " . $condicion;

      $resp = false;
      if ($base->Iniciar()) {
         if ($base->Ejecutar($consulta)) {
            if ($row2 = $base->Registro()) {
               $objEmpresa = new Empresa();
               $objResponsable = new Responsable();
               $objEmpresa->Buscar($row2['idempresa']);
               $objResponsable->Buscar($row2['rnumeroempleado']);
               $this->cargar(
                  $row2['idviaje'],
                  $row2['vdestino'],
                  $row2['vcantmaxpasajeros'],
                  $objEmpresa,
                  $objResponsable,
                  $row2['vimporte'],
                  $row2['tipoAsiento'],
                  $row2['idayvuelta']
               );
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
   /**
    * Retorna un arreglo de objetos de pasajero que pertenecen a este viaje
    * int cantDisponible
    * @return Array
    */
   public function getListaPasajeros()
   {
      $objPasajero = new Pasajero();
      $arregloPasajeros = $objPasajero->listar("idviaje=" . $this->getIdviaje());

      return $arregloPasajeros;
   }

   public function setVdestino($vdestino)
   {
      $this->vdestino = $vdestino;
   }
   public function setVcantmaxpasajeros($vcantmaxpasajeros)
   {
      $this->vcantmaxpasajeros = $vcantmaxpasajeros;
   }
   /**
    * Retorna la cantidad de asientos disponibles en este viaje
    * int cantDisponible
    * @return Int
    */
   public function getCantidadDisponible()
   {
      $cantDisponible = $this->getVcantmaxpasajeros() - count($this->getListaPasajeros());
      return $cantDisponible;
   }
   /**
    * Verifica si hay espacio disponible
    * @return Int
    */
   public function hayPasajesDisponible()
   {
      return count($this->getListaPasajeros()) < $this->getVcantmaxpasajeros();
   }

   /** Retorna una arreglo de objetos la clase Viaje
    * @return Array
    */
   public function listar($condicion = "")
   {
      $arregloViajes = null;
      $base = new BaseDatos();
      $consulta = "Select * from viaje";
      if ($condicion != "") {
         $consulta = $consulta . ' ' . $condicion;
      }
      $consulta .= " order by idviaje DESC";
      if ($base->Iniciar()) {
         if ($base->Ejecutar($consulta)) {
            //si hay registros creamos un arreglo				
            $arregloViajes = array();
            while ($row2 = $base->Registro()) {

               $objViaje = new Viaje();
               $objViaje->Buscar("idviaje=" . $row2['idviaje']);

               array_push($arregloViajes, $objViaje);
            }
         } else {
            $this->setmensajeoperacion($base->getError());
         }
      } else {
         $this->setmensajeoperacion($base->getError());
      }
      return $arregloViajes;
   }
   /**
    *  Retorna en forma de cadena de texto los valores de los atributos de la instancia clase Viaje.
    * String cadena
    * @return String
    */

   public function __toString()
   {
      $cadena = "*************************************************************************************************";


      $cadena .= "\n--------------------------------------------------Viaje------------------------------------------\n";
      $cadena .=  "EMPRESA: " . $this->getObjEmpresa()->getEnombre() . " IDVIAJE: " . ($this->getIdviaje()) . " DESTINO: " . ($this->getvdestino()) . " CANTIDAD MAXIMA: " . ($this->getvcantmaxpasajeros()) . " DISPONIBLES: " . $this->getCantidadDisponible() . "\n";
      $cadena .=  "IMPORTE: " . $this->getVimporte() . " TIPO ASIENTO: " . $this->getTipoAsiento() . " ES IDA Y VUELTA: " . $this->getIdayvuelta();
      $objResponsable = $this->getObjResponsable();
      $cadena .= "\nResponsable: " . $objResponsable->__toString() . "\n";


      $cadena .= "\n¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬\n";
      $cadena .= "| Lista de pasajeros |\n";

      foreach ($this->getListaPasajeros() as $pasajero) {
         $cadena .= $pasajero->__toString() . "\n";
      }
      return $cadena;
   }
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
