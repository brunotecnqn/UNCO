<?php

class ResponsableV
{
    private $numero_empleado;
    private $numero_licencia;
    private $nombre;
    private $apellido;
   public function __construct($num_empleado,$num_licencia,$nom,$ape)
   {
       $this->numero_empleado=$num_empleado;
       $this->numero_licencia=$num_licencia;
       $this->nombre=$nom;
       $this->apellido=$ape;
   }

   
    public function getNumeroEmpleado()
    {
        return $this->numero_empleado;
    }

    public function setNumeroEmpleado($numero_empleado)
    {
        $this->numero_empleado = $numero_empleado;

        return $this;
    }

    public function getNumeroLicencia() 
    {
        return $this->numero_licencia;
    }

    public function setNumeroLicencia($numero_licencia)
    {
        $this->numero_licencia = $numero_licencia;

    }

    public function getNombre() 
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

   
    }
    public function getApellido() 
    {
        return $this->apellido;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

   
    }
      /**
 * Retorna un string represente a los objetos de la clase ResponsableV. 
 * String cadena
 * @return String
 */
    public function __toString()
    {
        $cadena="";
        $cadena.="Num. Empleado: ".$this->getNumeroEmpleado()." Nº Licencia: ".$this->getNumeroLicencia()." Nombre: ".$this->getNombre()." Apellido: ".$this->getApellido();
      return $cadena;
    }
}
?>