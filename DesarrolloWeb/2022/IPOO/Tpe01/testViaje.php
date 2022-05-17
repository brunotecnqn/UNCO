<?php
/*TPE 01 
   Bruno Terrazas FAI-2585*/
include_once 'Viaje.php';
include 'ViajeAereo.php';
include 'ViajeTerrestre.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';

/************ PROGRAMA PRINCIPAL***************/
iniciarTest();



/************ FIN PROGRAMA PRINCIPAL***************/

/**
 * Muestra el menu de opciones
 * BOOLEAN $salir
 * Viaje $objViaje
 * INT $opcion
 * @return Void 
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
                $objViaje = cargarViajeAereo();
                $opcion = menuOpciones($objViaje,"Aéreo");
                break;
            case 2:
                $objViaje = cargarViajeTerrestre();
                $opcion = menuOpciones($objViaje,"Terrestre");
                break;

            default:
                echo "¡Opcion Incorrecta! de nuevo\n";
                break;
        }
    } while (!$salir);
}

function imprimirMenu()
{
    echo "**********************************************\n";
    echo "(1) Cargar viaje Aereo\n";
    echo "(2) Cargar viaje Terrestre\n";
    echo "Presione (0) o cualquier letra para salir del programa\n";
}
function imprimirSubMenu($tipo)
{
    echo "*******************OPCIONES*******************\n";
    echo " (1) Editar datos del viaje\n";
    echo " (2) Agregar pasajero\n";
    echo " (3) Editar pasajero\n";
    echo " (4) Modificar Responsable del viaje\n";
    echo " (5) Mostrar datos del viaje\n";
    echo " (6) Vender pasaje $tipo\n";
    echo " Presione (0) o cualquier letra para salir del submenu\n";
}
/**
 * Muestra el menu de opciones
 * BOOLEAN $salir,$res
 * STRING $num_documento,$nombre,$apellido,$telefono
 * INT $opcion
 * @param Viaje $objViaje
 * @param String $tipo
 * @return Int 
 */
function menuOpciones(Viaje $objViaje,$tipo)
{

    $salir = false;
    do {
        imprimirSubMenu($tipo);

        $opcion = validarNumero("una opcion");
        switch ($opcion) {
            case 0:
                $salir = true;
                break;
            case 1:
                modificarViaje($objViaje);
                break;
            case 2:
                if ($objViaje-> hayPasajesDisponible()) {

                    echo "--------------------/Registrar Pasajero\--------------------\n";

                    $num_documento = validarPasajero($objViaje);
                    echo "Ingrese nombre\n";
                    $nombre = trim(fgets(STDIN));
                    echo "Ingrese apellido\n";
                    $apellido = trim(fgets(STDIN));
                    echo "Ingrese telefono\n";
                    $telefono = trim(fgets(STDIN));

                    $res = registrarPasajero($objViaje, $num_documento, $nombre, $apellido, $telefono);
                    if ($res) {
                        echo "'Pasajero registrado correctamente'\n0";
                    } else {
                        echo "'No se pudo registrar'\n";
                    }
                } else {
                    echo  "'No hay espacio disponible'\n";
                }
                break;
            case 3:
                echo "*******************DATOS DEL VIAJE*******************\n" . $objViaje;
                modificarPasajero($objViaje);
                break;
            case 4:
                echo "*******************DATOS DEL VIAJE*******************\n" . $objViaje;
                modificarResponsable($objViaje);
                break;
            case 5:
                echo "*******************DATOS DEL VIAJE*******************\n" . $objViaje;
                break;
            case 6:
                echo "*******************DATOS DEL VIAJE*******************\n" . $objViaje;
                if($objViaje->hayPasajesDisponible())
                {
                    
                    echo "--------------------/Vender pasaje $tipo - Registrar pasajero\--------------------\n";

                    $num_documento = validarPasajero($objViaje);
                    echo "Ingrese nombre\n";
                    $nombre = trim(fgets(STDIN));
                    echo "Ingrese apellido\n";
                    $apellido = trim(fgets(STDIN));
                    echo "Ingrese telefono\n";
                    $telefono = trim(fgets(STDIN));
                     
                    $pasajero =new Pasajero($num_documento,$nombre,$apellido,$telefono);
                    
                    $importe=$objViaje->venderPasaje($pasajero);
                    if($importe!="")
                        echo "Importe total:".$importe."\n";
                    else 
                       echo "No se pudo realizar la venta\n";
                    
                }
                    break;

            default:
                echo "¡Opcion Incorrecta!, de nuevo\n";
                break;
        }
    } while (!$salir);

    return $opcion;
}

/**
 * Crea un viaje y carga sus datos
 * INT $cant_maxima
 * STRING $codigo_viaje
 * STRING $destino
 * ARRAY $listapasajero
 * @return Viaje
 */
function cargarViajeAereo()
{
    $unResponsableV = new ResponsableV(1, 234234, "Viviana", "Jimenez");
    $listapasajero = array();
    $listapasajero[0] = new Pasajero("77723222", "Carlos", "Perez", "2991542323");
    $listapasajero[1] = new Pasajero("88823222", "Esteban", "Rosales", "292542323");
    $listapasajero[2] = new Pasajero("1323222", "Pablo", "Perez", "2995532322");
    $listapasajero[3] = new Pasajero("6323222", "Carlos", "Nuñez", "0115423444");
    $listapasajero[4] = new Pasajero("7323222", "Pedro", "Solari", "2903333323");
    $listapasajero[5] = new Pasajero("3333222", "Raul", "Gonzalez", "297772323");
    $listapasajero[6] = new Pasajero("2443222", "Maria", "Rojas", "2995423881");
    $listapasajero[7] = new Pasajero("6766622", "Juana", "Lozada", "0115314299");
    $codigo_viaje = "v01";
    $destino = "Bariloche";
    $cant_maxima = 10;
    $esIdaVuelta=true;
    $importe=10000;
    $num_vuelo=01;
    $nombre_aero="Aerolineas Argentinas";
    $esPrimeraClase=true;
    //si es sin escalas se asigna 0
    $cantidad_escalas=0;
    $objViaje = new ViajeAereo($codigo_viaje, $destino, $cant_maxima, $listapasajero,$unResponsableV,$esIdaVuelta,$importe,$num_vuelo,$nombre_aero,$esPrimeraClase,$cantidad_escalas);
    return $objViaje;
}
/**
 * Crea un viaje y carga sus datos
 * INT $cant_maxima
 * STRING $codigo_viaje
 * STRING $destino
 * ARRAY $listapasajero
 * @return Viaje
 */
function cargarViajeTerrestre()
{
    $unResponsableV = new ResponsableV(1, 234234, "Julio", "Cruz");
    $listapasajero = array();
    $listapasajero[0] = new Pasajero("2323222", "Enzo", "Perez", "2991542323");
    $listapasajero[1] = new Pasajero("4323222", "Facundo", "Rosales", "292542323");
    $listapasajero[2] = new Pasajero("1323222", "Pablo", "Perez", "2995532322");
    $listapasajero[3] = new Pasajero("6323222", "Carlos", "Nuñez", "0115423444");
    $listapasajero[4] = new Pasajero("7323222", "Pedro", "Solari", "2903333323");
    $listapasajero[5] = new Pasajero("3333222", "Raul", "Gonzalez", "297772323");
    $listapasajero[6] = new Pasajero("3443222", "Maria", "Rojas", "2995423881");
    $listapasajero[7] = new Pasajero("2366622", "Esteban", "Lopez", "0115314299");
    $codigo_viaje = "v01";
    $destino = "Bariloche";
    $cant_maxima = 10;
    $esIdaVuelta=true;
    $importe=10000;
    //tipo de asiento debe ser: Cama o Semicama
    $tipo_asiento="Cama";
    $objViaje = new ViajeTerrestre($codigo_viaje, $destino, $cant_maxima, $listapasajero,$unResponsableV,$esIdaVuelta,$importe,$tipo_asiento);

    return $objViaje;
}

/**
 * Permite modificar al responsable del viaje
 * INT $num_responsable,$numlicencia
 * STRING $nombre,apellido
 * @param Viaje $objViaje
 * @return Void
 */
function modificarResponsable(Viaje $objViaje)
{
    echo $objViaje;
    echo "---------------------/Modificar responsable de viaje\---------------------\n";
    echo "Ingrese Num. Responsable\n";
    $num_responsable = trim(fgets(STDIN));
    echo "Ingrese Nº licencia\n";
    $num_licencia = trim(fgets(STDIN));
    echo "Ingrese nombre\n";
    $nombre = trim(fgets(STDIN));
    echo "Ingrese apellido\n";
    $apellido = trim(fgets(STDIN));
    $objViaje->setObjResponsable(new ResponsableV($num_responsable, $num_licencia, $nombre, $apellido));
    echo "Responsable modificado Correctamente";
}
/**
 * Permite registrar un nuevo pasajero 
 * INT $new_cant_maxima
 * STRING $new_destino
 * @param Viaje $objViaje
 * @return Void
 */
function modificarViaje(Viaje $objViaje)
{
    echo $objViaje;
    echo "-----------------/Editar Viaje\----------------\n";
    echo "Ingrese nuevo destino\n";
    $new_destino = trim(fgets(STDIN));
    $new_cant_maxima = validarNumero("cantidad maxima");
    while ($new_cant_maxima < count($objViaje->getArre_pasajero())) {
        $new_cant_maxima = validarNumero("otra cantidad maxima");
    }
    $objViaje->editarViaje($new_destino, $new_cant_maxima);
}
/**
 * Permite registrar un nuevo pasajero 
 * INT $num_pasajero
 * BOOLEAN $res
 * @param Viaje $objViaje
 * @param String $num_documento
 * @param String $nombre
 * @param String $apellido
 * @param String $telefono
 * @return Boolean
 */
function registrarPasajero(Viaje $objViaje, $num_documento, $nombre, $apellido, $telefono)
{
    $cantPasajeros = count($objViaje->getArre_pasajero());
    $res=false;
    if (($objViaje->buscarPasajero($num_documento) == null)) {
        if ($cantPasajeros < $objViaje->getCant_maxima()) {
            $nuevo=new Pasajero($num_documento,$nombre,$apellido,$telefono);
            $res=$objViaje->agregarPasajero($nuevo);
        }
    }
    return $res;
}


/**
 * Permite editar los datos del pasajero 
 * STRING $num_documento,$nombre,$apellido
 * BOOLEAN $res
 * @param Viaje $objViaje
 * @return Void
 */
function modificarPasajero(Viaje $objViaje)
{
    echo "Ingrese numero de documento\n";
    $num_documento = trim(fgets(STDIN));
    $objPasajero = $objViaje->buscarPasajero($num_documento);;
    while ($objPasajero == null) {
        echo "Ingrese numero de documento\n";
        $num_documento = trim(fgets(STDIN));
        $objPasajero = $objViaje->buscarPasajero($num_documento);
    }
    echo $objPasajero;
    echo "---------------------/Editar Pasajero\---------------------\n";
    echo "Ingrese nombre\n";
    $nombre = trim(fgets(STDIN));
    echo "Ingrese apellido\n";
    $apellido = trim(fgets(STDIN));
    echo "Ingrese telefono\n";
    $telefono = trim(fgets(STDIN));
    $res = $objPasajero->actualizarDatos($nombre, $apellido, $telefono);
    if ($res) {
        echo "'Actualizado correctamente'\n";
    } else
        echo "'No se puedo actualizar'\n";
}
/**
 * Valida que el pasajero no esta registrado en el viaje, considerando su dni, 
 * retorna el numero de documento si no esta registrado 
 * STRING $num_documento,$nombre,$apellido
 * BOOLEAN $res
 * @param Viaje $objViaje
 * @return Pasajero
 */
function validarPasajero($objViaje)
{
    echo "Ingrese numero de documento\n";
    $num_documento = trim(fgets(STDIN));
    while (($objViaje->buscarPasajero($num_documento) != null)) {
        echo "Ya esta registrado en este viaje, por favor:\n";
        echo "Ingrese otro numero de documento\n";
        $num_documento = trim(fgets(STDIN));
    }
    return $num_documento;
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

