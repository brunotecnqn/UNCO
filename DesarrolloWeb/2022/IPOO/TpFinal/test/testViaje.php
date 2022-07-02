<?php 
 /*TPFinal
   Bruno Terrazas FAI-2585*/
include_once("../datos/BaseDatos.php");
include_once("../datos/Empresa.php");
include_once("../datos/Responsable.php");
include_once("../datos/Viaje.php");
include_once("../datos/Pasajero.php");
iniciarTest();

function crearEmpresa()
{
	$objEmpresa=new Empresa();
	echo "Registrar Empresa\n";
	echo "Ingrese nombre\n";
	$enombre=   "San Juan BUS"; 
    echo "Ingrese dirección\n";
	$edireccion= "AV Salta";
	$objEmpresa->cargar(0,$enombre,$edireccion);
	$respuesta=$objEmpresa->insertar();
	return $respuesta;
}
function crearResponsable()
{
	echo "Registrar Responsable\n";
	$objResponsable=new Responsable();
	echo "Ingrese numero de licencia\n";
	$numLicencia=23588532;
	echo "Ingrese nombre";
	$nombre="Claudio";
	echo "Ingrese apellido";
	$apellido="Lopez";
	$objResponsable->cargar($numLicencia,$nombre,$apellido);
	$respuesta=$objResponsable->insertar();
	return $respuesta;
}
function crearViaje()
{
	echo "Crear viaje\n";
	//Antes de crear el viaje verificamos que tenga al menos una empresa y un responsable registrado en la BDD
	
	$objViaje=new Viaje();
	//verificar si hay otro viaje con el mismo destino
	$destino="Las Grutas";
	//Mostrar lista  Empresas 
	$objEmpresa=new Empresa();
	//seleccionar empresa
    $objEmpresa->Buscar(1);
	//Mostrar lista  Responsables
	$objResponsable=new Responsable();
	$objResponsable->Buscar(2);
	//seleccionar empresa
	$capacidadMax=120;
	$importe=25000;
	$tipoAsiento="cama";//cama o semicama
	$esIdaVuelta="si";//si o no
	$objViaje->cargar(0,$destino,$capacidadMax,$objEmpresa,$objResponsable,$importe,$tipoAsiento,$esIdaVuelta);
	$res=$objViaje->insertar();
 return $res;
}
function venderPasaje()
{
	echo "Vender pasaje\n";
	//Antes verifico si hay al menos un viaje registrado
	//Mostrar Lista de viajes
	$objViaje=new Viaje();
	//seleccionar viaje
    $objViaje->Buscar(1); 

	$objPasajero=new Pasajero();
	//verificar que si ya esta registrado en algun viaje, buscando por su dni
	$dni=742342333;

	$pnombre="Pablo";
	$papellido="Rojas";
	$ptelefono=011551333;
	$objPasajero->cargar($dni,$pnombre,$papellido,$ptelefono,$objViaje);
	$res=$objPasajero->insertar();
  return $res;
}

function imprimirMenu()
{
    echo "*******************MENU PRINCIPAL*******************\n";
    echo " (1) Registrar Empresa\n";
    echo " (2) Registrar Responsable \n";
    echo " (3) Editar Responsable\n";
    echo " (4) Crear viaje\n";
    echo " (5) Editar viaje\n";
    echo " (6) Vender pasaje \n";
	echo " (5) Editar pasajero\n";
    echo " (6) Cambiar Pasaje\n";
	echo " Presione (0) o cualquier letra para salir del submenu\n";
}
function iniciarTest()
{
    $salir = false;
    do {
        imprimirMenu();

        $opcion = validarNumero("una opcion");
        switch ($opcion) {
            case 0:
                $salir = true;
                break;
            case 1:
				if(crearEmpresa())
				{
				  echo "Empresa registrada correctamente\n";
				}
				else{
				  echo "No se pudo registrar la empresa\n";
				}
                break;
            case 2:
				if(crearResponsable())
				{
				  echo "Responsable registrado correctamente\n";
				}
				else{
				  echo "No se pudo registrar la  empresa\n";
				}
                break;
			case 3:
              
				break;
			case 4:
				if(crearViaje())
				{
				  echo "Viaje creado correctamente\n";
				}
				else{
				  echo "No se pudo crear el viaje\n";
				}
			    break;	

			case 5:
              
				break;
			case 6:
				if(venderPasaje())
				{
				  echo "Pasajero registrado correctamente!\n";
				}
				else{
				  echo "No se pudo registrar el pasajero\n";
				}
				break;

            default:
                echo "¡Opcion Incorrecta! de nuevo\n";
                break;
        }
    } while (!$salir);
}
function validarEmpresa()
{
    $objEmpresa=new Empresa(); 
    echo" Ingrese  ID Empresa\n";
    $valor = trim(fgets(STDIN));
    $res =$objEmpresa->Buscar($valor);
    while (!$res) {
        echo "¡Error! Ingrese id empresa\n";
        $valor = trim(fgets(STDIN));
        $res =$objEmpresa->Buscar($valor);
    }
    return $objEmpresa;
}
/**
 * Valida que sea un numero, solo si se cumple, retorna ese valor 
 * FLOAT $valor
 * BOOLEAN $res
 * @param $texto
 * @return Int
 */
function validarNumero($texto)
{

    echo "Ingrese " . $texto . "\n";
    $valor = trim(fgets(STDIN));
    $res = is_numeric($valor);
    while (!$res) {
        echo "¡Error! Ingrese " . $texto . "\n";
        $valor = trim(fgets(STDIN));
        $res = is_numeric($valor);
    }
    return $valor;
}
	?>