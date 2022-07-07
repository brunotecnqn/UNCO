<?php
/*TPFinal
   Bruno Terrazas FAI-2585*/
include_once("../datos/BaseDatos.php");
include_once("../datos/Empresa.php");
include_once("../datos/Responsable.php");
include_once("../datos/Viaje.php");
include_once("../datos/Pasajero.php");

iniciarTest();

/** Permite crear una empresa
 * @return Boolean
 */
function crearEmpresa()
{
    $objEmpresa = new Empresa();
    echo "Registrar Empresa\n";
    echo "Ingrese nombre\n";
    $enombre = trim(fgets(STDIN));
    echo "Ingrese dirección\n";
    $edireccion = trim(fgets(STDIN));
    $objEmpresa->cargar(0, $enombre, $edireccion);
    $respuesta = $objEmpresa->insertar();
    return $respuesta;
}
/** Permite editar una empresa
 * @return Boolean
 */
function editarEmpresa()
{ //Mostrar lista  Empresas 

    $objEmpresa = new Empresa();
    echo  $objEmpresa->mostrarEmpresas();
    //seleccionar empresa
    $objEmpresa = validarEmpresa();
    echo "Registrar Empresa\n";
    echo "Ingrese nombre\n";
    $enombre = trim(fgets(STDIN));
    echo "Ingrese dirección\n";
    $edireccion = trim(fgets(STDIN));
    $objEmpresa->cargar($objEmpresa->getIdempresa(), $enombre, $edireccion);
    return $objEmpresa->modificar();
}
/** Permite eliminar una empresa
 * @return Boolean
 */
function eliminarEmpresa()
{
    //Mostrar lista  Empresas 
    $objEmpresa = new Empresa();
    echo  $objEmpresa->mostrarEmpresas();
    //seleccionar empresa
    $objEmpresa = validarEmpresa();
    return $objEmpresa->eliminar();
}
/** Permite crear un responsable
 * @return Boolean
 */
function crearResponsable()
{
    echo "■■■■■■■■■■■■■■■■■■■■■■■■■■■CREAR RESPONSABLE■■■■■■■■■■■■■■■■■■■■■■■■■■\n";
    echo "Registrar Responsable\n";
    $objResponsable = new Responsable();
    echo "Ingrese numero de licencia\n";
    $numLicencia = validarNumero("Nº Licencia");
    echo "Ingrese nombre\n";
    $nombre = trim(fgets(STDIN));
    echo "Ingrese apellido\n";
    $apellido = trim(fgets(STDIN));
    $objResponsable->cargar(0, $numLicencia, $nombre, $apellido);
    $respuesta = $objResponsable->insertar();
    return $respuesta;
}
/** Permite editar un responsable
 * @return Boolean
 */
function editarResponsable()
{
    //Mostrar lista  Responsables
    $objResponsable = new Responsable();
    echo $objResponsable->mostrarResponsables();
    echo "■■■■■■■■■■■■■■■■■■■■■■■■■■■EDITAR RESPONSABLE■■■■■■■■■■■■■■■■■■■■■■■■■■\n";
    $objResponsable = validarResponsable();
    echo $objResponsable;
    echo "Ingrese numero de licencia\n";
    $numLicencia = validarNumero("Nº Licencia");
    echo "Ingrese nombre\n";
    $nombre = trim(fgets(STDIN));
    echo "Ingrese apellido\n";
    $apellido = trim(fgets(STDIN));
    $objResponsable->cargar($objResponsable->getRnumeroempleado(), $numLicencia, $nombre, $apellido);

    return $objResponsable->modificar();
}
/** Permite eliminar un responsable
 * @return Boolean
 */
function eliminarResponsable()
{   //Mostrar lista  Responsables
    $objResponsable = new Responsable();
    echo $objResponsable->mostrarResponsables();
    echo "■■■■■■■■■■■■■■■■■■■■■■■■■ELIMINAR RESPONSABLE■■■■■■■■■■■■■■■■■■■■■■■■\n";
    $objResponsable = validarResponsable();

    return $objResponsable->eliminar();
}
/** Permite crear un nuevo viaje
 * @return Boolean
 */
function crearViaje()
{
    echo "■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■CREAR VIAJE■■■■■■■■■■■■■■■■■■■■■■■■■■■■\n";
    //Antes de crear el viaje verificamos que tenga al menos una empresa y un responsable registrado en la BDD
    $objResponsable = new Responsable();
    $objViaje = new Viaje();
    $objEmpresa = new Empresa();
    if(count($objResponsable->listar())>0&&count($objEmpresa->listar()))
    {//verificar si hay otro viaje con el mismo destino
    $destino = validarDestino();
    //Mostrar lista  Empresas 

   
    echo  $objEmpresa->mostrarEmpresas();
    //seleccionar empresa
    $objEmpresa = validarEmpresa();
    //Mostrar lista  Responsables
    
    echo $objResponsable->mostrarResponsables();
    $objResponsable = validarResponsable();
    //seleccionar empresa
    $capacidadMax = validarNumero("Capacidad máxima");
    $importe = validarNumero("Importe");
    $tipoAsiento = elegirTipoAsiento(); //cama o semicama
    $esIdaVuelta = elegirIdaVuelta(); //si o no
    $objViaje->cargar(0, $destino, $capacidadMax, $objEmpresa, $objResponsable, $importe, $tipoAsiento, $esIdaVuelta);
    $res = $objViaje->insertar();
    }
    else{
        $res=false;
    }

    return $res;
}
/** Permite editar un viaje
 * @return Boolean
 */
function editarViaje()
{
    echo "■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■EDITAR VIAJE■■■■■■■■■■■■■■■■■■■■■■■■■■■■\n";
    //Ver Lista de viajes
    verViajes();
    $objViaje = new Viaje();
    //selecciono viaje
    $objViaje = validarViaje();
    echo $objViaje;
    $objEmpresa =  $objViaje->getObjEmpresa();
    $objResponsable = $objViaje->getObjResponsable();
    //verificar si hay otro viaje con el mismo destino
    $destino = validarDestino();
    $capacidadMax = validarCapacidadMaxima($objViaje, "Capacidad Maxima");
    $importe = validarNumero("Importe");
    $tipoAsiento = elegirTipoAsiento(); //cama o semicama
    $esIdaVuelta = elegirIdaVuelta(); //si o no
    $objViaje->cargar($objViaje->getIdviaje(), $destino, $capacidadMax, $objEmpresa, $objResponsable, $importe, $tipoAsiento, $esIdaVuelta);

    return $objViaje->modificar();
}
/** Permite eliminar un viaje incluyendo sus pasajeros
 * @return Boolean
 */
function eliminarViaje()
{
    echo "■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ELIMINAR VIAJE■■■■■■■■■■■■■■■■■■■■■■■■■■■■\n";
    //Ver Lista de viajes
    verViajes();
    $objViaje = new Viaje();
    //selecciono viaje
    $objViaje = validarViaje();
    $objPasajero = new Pasajero();

    $objPasajero=new Pasajero();
    $arregloPasajeros=$objPasajero->listar("idviaje=".$objViaje->getIdviaje());
    //elimina uno por a cada pasajero
    foreach($arregloPasajeros as $objPasajero)
    {
        $objPasajero->eliminar();
    }
    //al final elimina el viaje
    return $objViaje->eliminar();
}
/** Valida que la capacidad maxima no sea menor a la cantidad de pasajeros registrados en ese viaje
 * INT $valor
 * BOOLEAN $res
 * @return Int
 */
function validarCapacidadMaxima($objViaje, $texto)
{
    echo "Ingrese " . $texto . "\n";
    $valor = trim(fgets(STDIN));
    $res = is_numeric($valor) && ($valor >= count($objViaje->getListaPasajeros()));
    while (!$res) {
        echo "¡Error! Ingrese " . $texto . "\n";
        $valor = trim(fgets(STDIN));
        $res = is_numeric($valor) && ($valor >= count($objViaje->getListaPasajeros()));
    }
    return $valor;
}
/** Retorna si es o no el viaje de ida y vuelta
 * @return String
 */
function elegirIdaVuelta()
{
    do {
        $opcion = validarNumero("\n(1)Solo Ida\n(2)Ida y Vuelta\n");
        switch ($opcion) {
            case 1:
                $res = "no";
                $salir = true;
                break;
            case 2:
                $res = "si";
                $salir = true;
                break;

            default:
                echo "¡Valor Incorrecto! de nuevo\n";
                break;
        }
    } while (!$salir);
    return $res;
}
/** Retorna el tipo de asiento elegido
 * @return String
 */
function elegirTipoAsiento()
{
    do {
        $opcion = validarNumero("\n(1)cama\n(2)semicama\n");
        switch ($opcion) {
            case 1:
                $res = "cama";
                $salir = true;
                break;
            case 2:
                $res = "semicama";
                $salir = true;
                break;

            default:
                echo "¡Valor Incorrecto! de nuevo\n";
                break;
        }
    } while (!$salir);
    return $res;
}
/** Muestra todos los viajes registrado detalladamente
 * 
 * */
function mostrarViajes()
{
    $objViaje = new Viaje();
    $colViajes = $objViaje->listar();

    foreach ($colViajes as $viaje) {
        echo $viaje->__toString();
    }
}
/** Muestra una vista de todos los viajes para seleccionar
 * 
 */
function verViajes()
{
    $objViaje = new Viaje();
    $colViajes = $objViaje->listar();

    foreach ($colViajes as $viaje) {
        $empresa = $viaje->getObjEmpresa();
        echo "Empresa: " . $empresa->getEnombre() . " ID Viaje: " . $viaje->getIdviaje() . " Destino: " . $viaje->getVdestino() . " Cantidad Disponible: " . $viaje->getCantidadDisponible() . "\n"
        ."       Importe: ".$viaje->getVimporte()." Tipo asiento: ".$viaje->getTipoAsiento()." Es ida y vuelta: ".$viaje->getIdayvuelta()."\n";
        ;
    }
}
/** Permite vender pasaje, agregando un pasajero al viaje
 * @return Boolean
 */
function venderPasaje()
{
    //Antes verifico si hay al menos un viaje registrado

    echo "■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■VENDER PASAJE■■■■■■■■■■■■■■■■■■■■■■■■■■■■\n";
    $objViaje = new Viaje();
    $res = false;
    if (count($objViaje->listar()) > 0) {
        //Ver Lista de viajes
        verViajes();
        $objViaje = new Viaje();

        $objViaje = validarViaje();
        if ($objViaje->hayPasajesDisponible()) {
            $objPasajero = new Pasajero();
            //verificar que si ya esta registrado en algun viaje, buscando por su dni
            $dni = validarDniPasajero();
            if ($dni != 0) {
                echo " Ingrese  Nombre\n";
                $pnombre = trim(fgets(STDIN));
                echo " Ingrese  Apellido\n";
                $papellido = trim(fgets(STDIN));
                echo " Ingrese  Telefono\n";
                $ptelefono = trim(fgets(STDIN));
                $objPasajero->cargar($dni, $pnombre, $papellido, $ptelefono, $objViaje);
                $res = $objPasajero->insertar();
                echo $objViaje;
            } else {
                $res = false;
            }
        } else {
            echo "\nNo hay asientos disponibles\n";
        }
    }



    return $res;
}

/** Permite editar un pasajero
 * @return Boolean
 */
function editarPasajero()
{
    echo "■■■■■■■■■■■■■■■■■■■■■■■■■■■■EDITAR PASAJERO■■■■■■■■■■■■■■■■■■■■■■■■■■\n";
    $objPasajero = buscarPasajero();
    echo $objPasajero;

    echo " Ingrese  Nombre\n";
    $pnombre = trim(fgets(STDIN));
    echo " Ingrese  Apellido\n";
    $papellido = trim(fgets(STDIN));
    echo " Ingrese  Telefono\n";
    $ptelefono = trim(fgets(STDIN));
    $objPasajero->cargar($objPasajero->getRdocumento(), $pnombre, $papellido, $ptelefono, $objPasajero->getObjViaje());
    return $objPasajero->modificar();
}
/** Valida que el Nº de documento del pasajero no este registrado,
 *  solo si no esta o ingresando 0, retorna el Nº de documento o 0 
 * @return Boolean
 */
function eliminarPasajero()
{
    echo "■■■■■■■■■■■■■■■■■■■■■■■■■■■■ELIMINAR PASAJERO■■■■■■■■■■■■■■■■■■■■■■■■\n";
    $objPasajero = buscarPasajero();
    echo $objPasajero;

    return $objPasajero->eliminar();
}
/** Valida que el Nº de documento del pasajero no este registrado,
 *  solo si no esta o ingresando 0, retorna el Nº de documento o 0 
 * INT $valor
 * BOOLEAN $res
 * @return Int
 */
function validarDniPasajero()
{
    $objPasajero = new Pasajero();
    echo "\nIngrese  Nº documento\n";
    $valor = trim(fgets(STDIN));
    $res = $objPasajero->Buscar($valor);
    while ($res) {
        echo "¡Error! Ingrese otro Nº documento o presione '0' para salir\n";
        $valor = trim(fgets(STDIN));
        $res = $objPasajero->Buscar($valor);
    }
    return $valor;
}
/** Valida que sea un Nº de documento correcto,
 *  solo si se cumple, retorna el Nº de documento  
 * INT $valor
 * BOOLEAN $res
 * @return Pasajero
 */
function buscarPasajero()
{
    $objPasajero = new Pasajero();
    echo "\nIngrese  Nº documento\n";
    $valor = trim(fgets(STDIN));
    $res = $objPasajero->Buscar($valor);
    while (!$res) {
        echo "¡Error! Ingrese otro Nº documento\n";
        $valor = trim(fgets(STDIN));
        $res = $objPasajero->Buscar($valor);
    }
    return $objPasajero;
}
/** Valida que sea un destino que no haya sido registrado en otro viaje,
 *  solo si se cumple, retorna el destino  
 * INT $valor
 * BOOLEAN $res
 * @return String
 */
function validarDestino()
{
    $objViaje = new Viaje();
    echo " Ingrese  Destino\n";
    $destino = trim(fgets(STDIN));
    $res = $objViaje->Buscar("vdestino='$destino'");
    while ($res) {
        echo "¡Error! Ingrese otro Destino\n";
        $destino = trim(fgets(STDIN));
        $res = $objViaje->Buscar("vdestino='$destino'");
    }
    return $destino;
}
/**
 *  Muestra el menu de opciones
 */
function imprimirMenu()
{
    echo "*******************************************MENU PRINCIPAL****************************************\n";
    echo " (1) Registrar Empresa\n";
    echo " (2) Editar Empresa\n";
    echo " (3) Eliminar Empresa\n";
    echo " (4) Mostrar Empresas\n";
    echo " (5) Registrar Responsable \n";
    echo " (6) Editar Responsable\n";
    echo " (7) Eliminar Responsable\n";
    echo " (8) Crear viaje\n";
    echo " (9)  Listar viajes\n";
    echo " (10) Editar viaje\n";
    echo " (11) Eliminar viaje\n";
    echo " (12) Vender pasaje \n";
    echo " (13) Eliminar pasajero \n";
    echo " (14) Editar pasajero\n";
    echo " Presione (0) o cualquier letra para salir del submenu\n";
}
/**
 *  Inicia el programa y permite seleccionar las opciones del menu
 */
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
                if (crearEmpresa()) {
                    echo "Empresa registrada correctamente\n";
                } else {
                    echo "No se pudo registrar la empresa\n";
                }
                break;
            case 2:
                if (editarEmpresa()) {
                    echo "Empresa modificada correctamente\n";
                } else {
                    echo "No se pudo modificar la empresa\n";
                }
                break;
            case 3:
                if (eliminarEmpresa()) {
                    echo "Empresa eliminada correctamente\n";
                } else {
                    echo "No se pudo eliminar la empresa\n";
                }
                break;
            case 4:
                $objEmpresa = new Empresa();
                echo $objEmpresa->mostrarEmpresas();
                break;
            case 5:
                if (crearResponsable()) {
                    echo "Responsable registrado correctamente\n";
                } else {
                    echo "No se pudo  registrar al Responsable\n";
                }
                break;
            case 6:
                if (editarResponsable()) {
                    echo "Responsable modificado correctamente\n";
                } else {
                    echo "No se pudo  modificar al Responsable\n";
                }

                break;
            case 7:
                if (eliminarResponsable()) {
                    echo "Responsable eliminado correctamente\n";
                } else {
                    echo "No se pudo  registrar al Responsable\n";
                }

                break;
            case 8:
                if (crearViaje()) {
                    echo "Viaje creado correctamente\n";
                } else {
                    echo "No se pudo crear el viaje\n";
                }

                break;
            case 9:
                mostrarViajes();
                break;
            case 10:
                if (editarViaje()) {
                    echo "Viaje modificado correctamente\n";
                } else {
                    echo "No se pudo modificar el viaje\n";
                }

                break;
            case 11:
                if (eliminarViaje()) {
                    echo "Viaje eliminado correctamente\n";
                } else {
                    echo "No se pudo eliminar el viaje\n";
                }

                break;
            case 12:
                if (venderPasaje()) {
                    echo "Pasajero registrado correctamente!\n";
                } else {
                    echo "No se pudo registrar al pasajero\n";
                }
                break;
            case 13:
                if (eliminarPasajero()) {
                    echo "\nPasajero eliminado correctamente\n";
                } else {
                    echo "\nNo se pudo eliminar el Pasajero\n";
                }
                break;
            case 14:
                if (editarPasajero()) {
                    echo "\nPasajero modificado correctamente\n";
                } else {
                    echo "\nNo se pudo modificar el Pasajero\n";
                }


                break;


            default:
                echo "¡Opcion Incorrecta! de nuevo\n";
                break;
        }
    } while (!$salir);
}

/** Valida que sea un ID empresa correcto, solo si se cumple, retorna el objeto empresa  
 * INT $valor
 * BOOLEAN $res
 * @return Empresa
 */
function validarEmpresa()
{
    $objEmpresa = new Empresa();
    echo " Ingrese  ID Empresa\n";
    $valor = trim(fgets(STDIN));
    $res = $objEmpresa->Buscar($valor);
    while (!$res) {
        echo "¡Error! Ingrese ID Empresa\n";
        $valor = trim(fgets(STDIN));
        $res = $objEmpresa->Buscar($valor);
    }
    return $objEmpresa;
}
/**
 * Valida que sea un Nº de empleado correcto, solo si se cumple, retorna el objeto  
 * INT $valor
 * BOOLEAN $res
 * @return Responsable
 */
function validarResponsable()
{
    $objResponsable = new Responsable();
    echo " Ingrese Nº Empleado\n";
    $valor = trim(fgets(STDIN));
    $res = $objResponsable->Buscar($valor);
    while (!$res) {
        echo "¡Error! Ingrese Nº Empleado\n";
        $valor = trim(fgets(STDIN));
        $res = $objResponsable->Buscar($valor);
    }
    return $objResponsable;
}
/**
 * Valida que sea un Id viaje correcto, solo si se cumple, retorna el objeto viaje 
 * INT $valor
 * BOOLEAN $res
 * @return Viaje
 */
function validarViaje()
{
    $objViaje = new Viaje();
    echo " Ingrese  ID Viaje\n";
    $valor = trim(fgets(STDIN));
    $res = $objViaje->Buscar($valor);
    while (!$res) {
        echo "¡Error! Ingrese ID Viaje\n";
        $valor = trim(fgets(STDIN));
        $res = $objViaje->Buscar($valor);
    }
    return $objViaje;
}
/**
 * Valida que sea un numero, solo si se cumple, retorna ese valor 
 * INT $valor
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
