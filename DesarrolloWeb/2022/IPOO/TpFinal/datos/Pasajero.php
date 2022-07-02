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
    $this->rdocumento="";
    $this->pnombre="";
    $this->papellido="";
    $this->ptelefono="";
    $this->objViaje=new Viaje();

      
  }
  public function cargar($num_docu,$nom,$ape,$telef,$objViaje)
  {
    
    $this->setRdocumento($num_docu);
    $this->setPnombre($nom);
    $this->setPapellido($ape);
    $this->setPtelefono($telef);
    $this->setObjViaje($objViaje);

  }
  public function insertar(){
		$base=new BaseDatos();
		$resp= false;
      
        $documento=$this->getRdocumento();
		$consultaInsertar="INSERT INTO pasajero(rdocumento, pnombre, papellido, ptelefono, idviaje) 
				VALUES ($documento,'".$this->getPnombre()."','".$this->getPapellido()."',".$this->getPtelefono().",".$this->getObjViaje()->getIdviaje().")";

        echo "\n ID viaje: ".$this->getObjViaje()->getIdviaje();
		echo "\n".$consultaInsertar;
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
  	
	public function modificar(){
    $resp =false; 
    $base=new BaseDatos();
  $consultaModifica="UPDATE pasajero SET papellido='".$this->getPapellido()."',pnombre='".$this->getPnombre()."'
                         ptelefono='".$this->getPtelefono()."' WHERE rdocumento=". $this->getRdocumento();
  if($base->Iniciar()){
    if($base->Ejecutar($consultaModifica)){
        $resp=  true;
    }else{
      $this->setmensajeoperacion($base->getError());
      
    }
  }else{
      $this->setmensajeoperacion($base->getError());
    
  }
  return $resp;
}

public function eliminar(){
  $base=new BaseDatos();
  $resp=false;
  if($base->Iniciar()){
      $consultaBorra="DELETE FROM pasajero WHERE rdocumento=".$this->getRdocumento();
      if($base->Ejecutar($consultaBorra)){
          $resp=  true;
      }else{
          $this->setmensajeoperacion($base->getError());
        
      }
  }else{
      $this->setmensajeoperacion($base->getError());
    
  }
  return $resp; 
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
      $cadena="";
      $cadena.="Num. documento: ".$this->getRdocumento() ." Nombre: ".$this->getPnombre()." Apellido: ".$this->getPapellido().
      " Telefono: ".$this->getPtelefono();
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
