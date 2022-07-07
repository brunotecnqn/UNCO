<?php

class Pasajero
{
  private $rdocumento;
  private $pnombre;
  private $papellido;
  private $ptelefono;
  private $objViaje;
  private $mensajeoperacion;
  public function __construct()
  {
    $this->rdocumento = "";
    $this->pnombre = "";
    $this->papellido = "";
    $this->ptelefono = "";
    $this->objViaje = new Viaje();
  }
  /** Permite cargar los datos del viaje
   *
   */
  public function cargar($num_docu, $nom, $ape, $telef, $objViaje)
  {

    $this->setRdocumento($num_docu);
    $this->setPnombre($nom);
    $this->setPapellido($ape);
    $this->setPtelefono($telef);
    $this->setObjViaje($objViaje);
  }
  /** Permite insertar el pasajero en la base de datos
   * @return Boolean
   */
  public function insertar()
  {
    $base = new BaseDatos();
    $resp = false;

    $documento = $this->getRdocumento();
    $consultaInsertar = "INSERT INTO pasajero(rdocumento, pnombre, papellido, ptelefono, idviaje) 
				VALUES ($documento,'" . $this->getPnombre() . "','" . $this->getPapellido() . "'," . $this->getPtelefono() . "," . $this->getObjViaje()->getIdviaje() . ")";

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
  /** Permite modificar el pasajero en la base de datos
   * @return Boolean
   */
  public function modificar()
  {
    $resp = false;
    $base = new BaseDatos();
    $consultaModifica = "UPDATE pasajero SET papellido='" . $this->getPapellido() . "',pnombre='" . $this->getPnombre() . "'
                         ptelefono=" . $this->getPtelefono() . " WHERE rdocumento=" . $this->getRdocumento();
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


  /** Permite eliminar el pasajero en la base de datos
   * @return Boolean
   */
  public function eliminar()
  {
    $base = new BaseDatos();
    $resp = false;
    if ($base->Iniciar()) {
      $consultaBorra = "DELETE FROM pasajero WHERE rdocumento=" . $this->getRdocumento();
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
   * Recupera los datos del pasajero por numero de documento
   * @param int rdocumento
   * @return true en caso de encontrar los datos, false en caso contrario 
   */
  public function Buscar($numDocumento)
  {
    $base = new BaseDatos();
    $consulta = "Select * from pasajero where rdocumento=" . $numDocumento;
    $resp = false;
    if ($base->Iniciar()) {
      if ($base->Ejecutar($consulta)) {
        if ($row2 = $base->Registro()) {
          $this->setRdocumento($row2['rdocumento']);
          $this->setPnombre($row2['pnombre']);
          $this->setPapellido($row2['papellido']);
          $this->setPtelefono($row2['ptelefono']);
          $objViaje = new Viaje();
          $objViaje->Buscar("idviaje=" . $row2['idviaje']);
          $this->setObjViaje($objViaje);
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

  /** Retorna una arreglo de objetos la clase Pasajero
   * @return Array
   */
  public function listar($condicion = "")
  {
    $arregloPasajeros = null;
    $base = new BaseDatos();
    $consulta = "Select * from pasajero";
    if ($condicion != "") {
      $consulta = $consulta . ' where ' . $condicion;
    }
    $consulta .= "";
    if ($base->Iniciar()) {
      if ($base->Ejecutar($consulta)) {
        //si hay registros creamos un arreglo				
        $arregloPasajeros = array();
        while ($row2 = $base->Registro()) {

          $objViaje = new Viaje();
          $objViaje->Buscar("idViaje=" . $row2['idviaje']);
          $pasajero = new Pasajero();
          $pasajero->Buscar($row2['rdocumento']);

          array_push($arregloPasajeros, $pasajero);
        }
      } else {
        $this->setmensajeoperacion($base->getError());
      }
    } else {
      $this->setmensajeoperacion($base->getError());
    }
    return $arregloPasajeros;
  }
  public function getRdocumento()
  {
    return $this->rdocumento;
  }
  public function getPnombre()
  {
    return $this->pnombre;
  }

  public function getPapellido()
  {
    return $this->papellido;
  }
  public function getPtelefono()
  {
    return $this->ptelefono;
  }

  public function setRdocumento($docu)
  {
    $this->rdocumento = $docu;
  }
  public function setPnombre($pnombre)
  {
    $this->pnombre = $pnombre;
  }


  public function setPapellido($papellido)
  {
    $this->papellido = $papellido;
  }


  public function setPtelefono($ptelefono)
  {
    $this->ptelefono = $ptelefono;
  }


  /**
   * Retorna en forma de cadena de texto los valores de los atributos de la instancia clase Pasajero. 
   * String cadena
   * @return String
   */
  public function __toString()
  {
    $cadena = "¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬\n";
    $cadena .= "Num. documento: " . $this->getRdocumento() . " Nombre: " . $this->getPnombre() . " Apellido: " . $this->getPapellido() .
      " Telefono: " . $this->getPtelefono() .
      " ID Viaje: " . $this->getObjViaje()->getIdviaje();
    return $cadena;
  }


  public function getObjViaje()
  {
    return $this->objViaje;
  }

  public function setObjViaje($objViaje)
  {
    $this->objViaje = $objViaje;
  }

  public function getMensajeoperacion()
  {
    return $this->mensajeoperacion;
  }

  public function setMensajeoperacion($mensajeoperacion)
  {
    $this->mensajeoperacion = $mensajeoperacion;
  }
}
