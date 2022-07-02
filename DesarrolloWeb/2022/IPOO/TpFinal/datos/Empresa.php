<?php

class Empresa{
private $idempresa;
private $enombre;
private $edireccion;
private $mensajeoperacion;
function __construct()
{
    $this->idempresa="";
    $this->enombre="";
    $this->edireccion="";
    
}
public function cargar($idempresa, $enombre, $edireccion)
{
  $this->setIdempresa($idempresa);
  $this->setEnombre($enombre);
  $this->setEdireccion($edireccion);
}
public function getIdempresa()
{
return $this->idempresa;
}

public function setIdempresa($idempresa)
{
$this->idempresa = $idempresa;
}

public function getEnombre()
{
return $this->enombre;
}

public function setEnombre($enombre)
{
$this->enombre = $enombre;
}

public function getEdireccion()
{
return $this->edireccion;
}

public function setEdireccion($edireccion)
{
$this->edireccion = $edireccion;

}



public function insertar(){
    $base=new BaseDatos();
    $resp= false;
    $consultaInsertar="INSERT INTO empresa(enombre, edireccion) 
            VALUES ('".$this->getEnombre()."','".$this->getEdireccion()."')";
    
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
public function listarViajes($idempresa){
    $arregloViajes = null;
    $base=new BaseDatos();
    $consulta="Select * from viaje";
    if ($idempresa!=""){
        $consulta =$consulta .' where idempresa='.$idempresa;
    }
    $consulta .=" order by idventa DESC";
    //echo $consultaEmpresas ;
    if($base->Iniciar()){
        if($base->Ejecutar($consulta )){
            //si hay registros creamos un arreglo				
            $arregloViajes= array();
            while($row2=$base->Registro()){
                $idviaje=($row2['idviaje']);
               $destino=($row2['vdestino']);
               $cantmaxpasajeros=($row2['vcantmaxpasajeros']);
               $idemp=($row2['idempresa']);
               $numeroempleado=($row2['rnumeroempleado']);
               $importe=($row2['vimporte']);
               $tipoAsiento=($row2['tipoAsiento']);
               $idayvuelta=($row2['idayvuelta']);
                            
                $objViaje=new Viaje();
                $objViaje->cargar($idviaje,$destino,$cantmaxpasajeros,$idemp,$numeroempleado,$importe,$tipoAsiento,$idayvuelta);
                array_push($arregloViajes,$objViaje);

            }
            
        
         }	else {
                 $this->setmensajeoperacion($base->getError());
             
        }
     }	else {
             $this->setmensajeoperacion($base->getError());
         
     }	
     return $arregloViajes;
}
public function Buscar($idemp){
    $base=new BaseDatos();
    $consulta="Select * from empresa where idempresa=".$idemp;
    $resp= false;
    if($base->Iniciar()){
        if($base->Ejecutar($consulta)){
            if($row2=$base->Registro()){					
                
                $this->setIdempresa($row2['idempresa']);
                $this->setEnombre($row2['enombre']);
                $this->setEdireccion($row2['edireccion']);
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

public function listar($condicion=""){
    $arregloEmpresa = null;
    $base=new BaseDatos();
    $consultaEmpresas="Select * from empresa";
    if ($condicion!=""){
        $consultaEmpresas =$consultaEmpresas .' where '.$condicion;
    }
    $consultaEmpresas .=" order by enombre";
    //echo $consultaEmpresas ;
    if($base->Iniciar()){
        if($base->Ejecutar($consultaEmpresas )){
            //si hay registros creamos un arreglo				
            $arregloEmpresa= array();
            while($row2=$base->Registro()){
                
                $idempresa=$row2['idempresa'];
                $nombre=$row2['enombre'];
                $direccion=$row2['edireccion'];
                
            
                $emp=new Empresa();
                $emp->cargar($idempresa,$nombre,$direccion);
                array_push($arregloEmpresa,$emp);

            }
            
        
         }	else {
                 $this->setmensajeoperacion($base->getError());
             
        }
     }	else {
             $this->setmensajeoperacion($base->getError());
         
     }	
     return $arregloEmpresa;
}


public function getMensajeoperacion()
{
return $this->mensajeoperacion;
}

public function setMensajeoperacion($mensajeoperacion)
{
$this->mensajeoperacion = $mensajeoperacion;
}
public function __toString(){
    return "\nID Empresa: ".$this->getIdempresa(). " Nombre:".$this->getEnombre()." Direccion: ".$this->getEdireccion()."\n";
        
}
}

?>