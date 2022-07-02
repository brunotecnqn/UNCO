<?php

class Responsable
{
    private $rnumeroempleado;
    private $rnumerolicencia;
    private $rnombre;
    private $rapellido;
    private $mensajeoperacion;
   public function __construct()
   {
       $this->rnumeroempleado="";
       $this->rnumerolicencia="";
       $this->rnombre="";
       $this->rapellido="";
   }
   public function cargar($numLicencia, $nombre, $apellido)
   {
      $this->setRnumerolicencia($numLicencia);
      $this->setRnombre($nombre);
      $this->setRapellido($apellido);
   }
   
    public function getRnumeroempleado()
    {
        return $this->rnumeroempleado;
    }

    public function setRnumeroempleado($rnumeroempleado)
    {
        $this->rnumeroempleado = $rnumeroempleado;

        return $this;
    }

    public function getRnumerolicencia() 
    {
        return $this->rnumerolicencia;
    }

    public function setRnumerolicencia($rnumerolicencia)
    {
        $this->rnumerolicencia = $rnumerolicencia;

    }

    public function getRnombre() 
    {
        return $this->rnombre;
    }

    public function setRnombre($rnombre)
    {
        $this->rnombre = $rnombre;

   
    }
    public function getRapellido() 
    {
        return $this->rapellido;
    }

    public function setRapellido($rapellido)
    {
        $this->rapellido = $rapellido;

   
    }
    
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
      
        $numLicencia=$this->getRnumerolicencia();
		$consultaInsertar="INSERT INTO responsable(rnumerolicencia, rnombre,  rapellido) 
				VALUES ($numLicencia,'".$this->getRnombre()."','".$this->getRapellido()."')";
		
		if($base->Iniciar()){

			if($base->Ejecutar($consultaInsertar)){

			    $resp=  true;

			}	else {
					$this->setmensajeoperacion($base->getError());
					
			}

		} else {
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
		/**
	 * Recupera los datos de una responsable por numero de empleado
	 * @param int $numEmpleado
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($numEmpleado){
		$base=new BaseDatos();
		$consulta="Select * from responsable where rnumeroempleado=".$numEmpleado;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){					
				    $this->setRnumeroempleado($row2['rnumeroempleado']);
					$this->setRnumerolicencia($row2['rnumerolicencia']);
					$this->setRnombre($row2['rnombre']);
					$this->setRapellido($row2['rapellido']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
      /**
 * Retorna un string represente a los objetos de la clase ResponsableV. 
 * String cadena
 * @return String
 */
    public function __toString()
    {
        $cadena="";
        $cadena.="Num. Empleado: ".$this->getRnumeroempleado()." Nº Licencia: ".$this->getRnumerolicencia()." Nombre: ".$this->getrnombre()." Apellido: ".$this->getRapellido();
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
}
?>