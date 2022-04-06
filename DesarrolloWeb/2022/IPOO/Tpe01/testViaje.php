<?php 
 /*TPE 01 
   Bruno Terrazas FAI-2585*/
include 'Viaje.php';

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
             $objViaje=cargarViaje();
             $opcion=menuOpciones($objViaje);
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
    echo "(1) Cargar viaje\n";
    echo "Presione (0) o cualquier letra para salir del programa\n";

}
function imprimirSubMenu()
{
    echo "*******************OPCIONES*******************\n";
    echo " (1) Editar datos del viaje\n";
    echo " (2) Agregar pasajero\n";
    echo " (3) Editar pasajero\n";
    echo " (4) Mostrar datos del viaje\n";
    echo " Presione (0) o cualquier letra para salir del submenu\n";
}
/**
 * Muestra el menu de opciones
 * BOOLEAN $salir,$res
 * STRING $num_documento,$nombre,$apellido
 * INT $opcion
 * @param Viaje $objViaje
 * @return Int 
 */
function menuOpciones(Viaje $objViaje)
{
  
    $salir = false;
    do {
        imprimirSubMenu();

        $opcion = validarNumero("una opcion");
        switch ($opcion) {
            case 0:
                $salir = true;
                break;
            case 1:
                modificarViaje($objViaje);
                break;
            case 2:
            if($objViaje->verificarEspacio())
                {

                echo "--------------------/Registrar Pasajero\--------------------\n";   
                echo "Ingrese numero de documento\n";
                $num_documento = trim(fgets(STDIN));
                echo "Ingrese nombre\n";
                $nombre = trim(fgets(STDIN));
                echo "Ingrese apellido\n";
                $apellido = trim(fgets(STDIN));
                
                $res=registrarPasajero($objViaje,$num_documento,$nombre,$apellido);
                if($res)
                {
                    echo "'Pasajero registrado correctamente'\n0";
                }
                else 
                    {
                        echo "'No se pudo registrar'\n";
                    }
            }
            else
               {          
                echo  "'No hay espacio disponible'\n";
               }
            break;
            case 3:
                echo "*******************DATOS DEL VIAJE*******************\n".$objViaje;
                modificarPasajero($objViaje);
                break;
            case 4:
                echo "*******************DATOS DEL VIAJE*******************\n".$objViaje;
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
function cargarViaje()
{
    $listapasajero = array();
    $listapasajero[0] = ["num_documento" => "2323222", "nombre" => "Enzo", "apellido" => "Perez"];
    $listapasajero[1] = ["num_documento" => "5423343", "nombre" => "Cesar", "apellido" => "Martinez"];
    $listapasajero[2] = ["num_documento" => "3303332", "nombre" => "Mario", "apellido" => "Sosa"];
    $listapasajero[3] = ["num_documento" => "5533233", "nombre" => "Antonella", "apellido" => "Ledezma"];
    $listapasajero[4] = ["num_documento" => "2323222", "nombre" => "Xavier", "apellido" => "Hernandez"];
    $listapasajero[5] = ["num_documento" => "1332333", "nombre" => "Antonio", "apellido" => "Olmos"];
    $listapasajero[6] = ["num_documento" => "1322222", "nombre" => "Nicolas", "apellido" => "Nuñez"];
    $listapasajero[7] = ["num_documento" => "5555533", "nombre" => "Lara", "apellido" => "Mendez"];
    $codigo_viaje="v01";
    $destino="Bariloche";
    $cant_maxima=10;
   
 
    $objViaje= new Viaje($codigo_viaje,$destino,$cant_maxima,$listapasajero);
    
    return $objViaje;

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
     while($new_cant_maxima<count($objViaje->getArre_pasajero()))
     {
        $new_cant_maxima = validarNumero("otra cantidad maxima");     
     }
    $objViaje->editarViaje($new_destino,$new_cant_maxima);
}
/**
     * Permite registrar un nuevo pasajero 
     * INT $num_pasajero
     * BOOLEAN $res
     * @param Viaje $objViaje
     * @param String $num_documento
     * @param String $nombre
     * @param String $apellido
     * @return Boolean
     */
function registrarPasajero(Viaje $objViaje,$num_documento,$nombre,$apellido)
{   
    $cantPasajeros=count($objViaje->getArre_pasajero());
    $res=false;
    if($cantPasajeros<$objViaje->getCant_maxima())
    {
    $res=$objViaje->agregarPasajero($nombre,$apellido,$num_documento);
    }
   
    return $res;
     
}


/**
     * Permite editar los datos del pasajero 
     * INT $num_pasajero
     * STRING $num_documento,$nombre,$apellido
     * BOOLEAN $res
     * @param Viaje $objViaje
     * @return Void
     */
    function modificarPasajero(Viaje $objViaje)
    {
       echo $objViaje;
       $num_pasajero = validarNumero("Num. de pasajero");
       //verificamos si el numero de pasajero esta en la lista de pasajeros, sino vuelve a ingresar el num. pasajero
       while(!(($num_pasajero-1)>=0&&($num_pasajero-1)<count($objViaje->getArre_pasajero())))
       {
        $num_pasajero = validarNumero("Num. de pasajero");       
       }
       echo $objViaje->obtenerPasajero($num_pasajero-1); 
       echo "---------------------/Editar Pasajero\---------------------\n";  
       echo "Ingrese numero de documento\n";
       $num_documento = trim(fgets(STDIN));
       echo "Ingrese nombre\n";
       $nombre = trim(fgets(STDIN));
       echo "Ingrese apellido\n";
       $apellido = trim(fgets(STDIN));
       $res=$objViaje->editarPasajero($num_pasajero-1,$num_documento,$nombre,$apellido);
       if($res)
       {
           echo "'Actualizado correctamente'\n";
       }
       else
          echo "'No se puedo actualizar'\n";

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
