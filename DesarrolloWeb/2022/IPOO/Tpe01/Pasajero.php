<?php 

class Pasajero
{
  private $num_documento;
  private $nombre;
  private $apellido;
  private $telefono;
  public function __construct($num_docu,$nom,$ape,$telef)
  {
    $this->num_documento=$num_docu;
    $this->nombre=$nom;
    $this->apellido=$ape;
    $this->telefono=$telef;

      
  }
  public function getNumDocumento() 
  {
    return $this->num_documento;
  }
  public function getNombre()
  {
    return $this->nombre;
  }

  public function getApellido()
  {
    return $this->apellido;
  }
  public function getTelefono() 
  {
    return $this->telefono;
  }
 /*Suponiendo que no se deberia modificar el numero de documento */
 
  public function setNombre($nombre)
  {
    $this->nombre = $nombre;


  }


  public function setApellido($apellido)
  {
    $this->apellido = $apellido;

  }
 

  public function setTelefono($telefono)
  {
    $this->telefono = $telefono;

  }
  /**
    * Actualiza los datos del pasajero. 
    * INT $cant_pasajero
    * BOOLEAN $res
    * @param String $num_documento
    * @param String $nombre
    * @param String $apellido
    * @return Boolean
    */
  public function actualizarDatos($nombre,$apellido,$telefono)
  {
    $this->setNombre($nombre);
    $this->setApellido($apellido);
    $this->setTelefono($telefono);

    return true;
  }
  /**
 * Retorna en forma de cadena de texto los valores de los atributos de la instancia clase Pasajero. 
 * String cadena
 * @return String
 */
  public function __toString()
  {
      $cadena="";
      $cadena.="Num. documento: ".$this->getNumDocumento()." Nombre: ".$this->getNombre()." Apellido: ".$this->getApellido().
      " Telefono: ".$this->getTelefono();
      return $cadena;
  }
   /**
    * Verifica si el pasajero tiene el mismo numero de documento y retorna true, sino es asi retorna false. 
    * BOOLEAN $res
    * @param String $num_documento
    * @return Boolean
    */
  public function verificarPasajero($num_documento)
  {
     $res=($num_documento==$this->getNumDocumento()); 
     
     return $res; 

  }
  

}
