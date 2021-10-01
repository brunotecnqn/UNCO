    <?php

    /*TP Obligatorio 
     Bruno Terrazas FAI-2585 
     Tec. en Desarrollo Web*/
    /********************************PROGRAMA PRINCIPAL**********************************/
    /**
     *ARRAY $juegosMasVendido,$tickets
     *INT $opcion
     */
    $juegoMasVendido = precargarJuegosVendidos();
    $tickets = crearTotalVentas($juegoMasVendido);
    /*print_r permite imprimir la informacion de la estructura de datos, recibe como parametro 
    la expresion,(una variable) que va a ser impresa*/
    print_r($tickets);

    print_r($juegoMasVendido);

    $opcion = menuOpciones($juegoMasVendido, $tickets);

    /****************************** FIN PROGRAMA PRINCIPAL ******************************/
    /**
     * Muestra el menu de opciones
     * BOOLEAN $salir
     * INT $opcion,$indice
     * @param Array $juegoMasVendido
     * @param Array $tickets
     * @return Int 
     */
    function menuOpciones(&$juegoMasVendido, &$tickets)
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
                    ingresarVenta($tickets, $juegoMasVendido);
                    break;
                case 2:
                    $indice = mayorVenta($juegoMasVendido);
                    mostrarInformacion($juegoMasVendido, $tickets, $indice);

                    break;
                case 3:
                    $montoIn = validarNumero(" un monto total");
                    $indice = obtenerPrimerMes($tickets,$montoIn);
                    mostrarInformacion($juegoMasVendido, $tickets, $indice);
                    break;
                case 4:
                    $indice = mesAIndice();
                    mostrarInformacion($juegoMasVendido, $tickets, $indice);
                    break;
                case 5:

                    ordenarJuegoMasVendido($juegoMasVendido);

                    break;

                default:
                    echo "¡Opcion Incorrecta! de nuevo\n";
                    break;
            }
        } while (!$salir);

        return $opcion;
    }
    /**
     * Muestra la informacion completa de un mes
     * STRING mes
     * @param Array
     * @param Array
     * @param Int
     * @return void
     */
    function mostrarInformacion($juegoMasVendido, $tickets, $indice)
    {
        $mes = mesEnTexto($indice);
        $venta = ($juegoMasVendido[$indice]["precioTicket"] * $juegoMasVendido[$indice]["cantidadTickets"]);
        echo "----------------------------------------------------------------------\n";

        echo "<" . $mes . ">\n El juego con mayor  monto de venta: " . $juegoMasVendido[$indice]["juego"] . " \n";
        echo "Numero de Tickets Vendidos: " . $juegoMasVendido[$indice]["cantidadTickets"] . "\n";
        echo "Venta total del juego:" . $venta . "\n";
        echo "Monto total de ventas del mes de " . $mes . " es " . $tickets[$indice] . "\n";
        echo "----------------------------------------------------------------------\n";
    }
    /**
     * @return void
     */
    //Este metodo imprime el menu de opciones
    function imprimirMenu()
    {
        echo "(1) Ingresar una venta\n";
        echo "(2) Mes con mayor monto de ventas\n";
        echo "(3) Primer mes que supera un monto de ventas\n";
        echo "(4) Informacion de un mes\n";
        echo "(5) Juegos mas vendidos Ordenados\n";
        echo "Presione (0) o cualquier letra para salir\n";
    }
    /**
     * Valida que sea un numero, solo si se cumple, retorna ese valor 
     * FLOAT $valor
     * BOOLEAN $res
     * @param $texto
     * @return Float 
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
    /**
     * Permite ingresar una venta de tickets de un juego e  incrementa el monto total del mes ingresado
     * INT $indice, $cantidad
     * STRING $mes
     * FLOAT $precio,$monto,$montoIn
     * @param Array $tickets
     * @param Array $juegoMasVendido
     * @return void
     */
    function ingresarVenta(&$tickets, &$juegoMasVendido)
    {

        $mes = mesAIndice();
        echo "Ingresar juego\n";
        $juego = trim(fgets(STDIN));
        $precio = validarNumero("precio ticket");
        $cantidad = validarNumero("cantidad de tickets");
        $monto = $juegoMasVendido[$mes]["precioTicket"] * $juegoMasVendido[$mes]["cantidadTickets"];
        $montoIn=$precio*$cantidad;
        //Incrementa el monto total de ventas
        $tickets[$mes] = ($tickets[$mes] + $montoIn);
        /*si la venta ingresada tiene mayor monto de venta que el juego ya existente en ese mes
         se actualiza la estructura juegosMasVendido*/
        if ($montoIn > $monto) {
            $juegoMasVendido[$mes]["juego"] = $juego;
            $juegoMasVendido[$mes]["precioTicket"] = $precio;
            $juegoMasVendido[$mes]["cantidadTickets"] = $cantidad;
        }
    }
    /**
     * Retorna el indice del mes con mayor monto de ventas
     * FLOAT mayor, monto
     * INT indice
     * @param Array $juegoMasVendido
     * @return Int
     */
    function mayorVenta($juegoMasVendido)
    {
        $mayor = 0;

        foreach ($juegoMasVendido as $key => $value) {
            $monto = $value["precioTicket"] * $value["cantidadTickets"];
            if ($monto > $mayor) {
                $mayor = $monto;
                $indice = $key;
            }
        }

        return $indice;
    }
    /**
     * Retorna el indice del primer mes que supera un monto total
     * de venta ingresado por el usuario
     * INT $i
     * BOOLEAN $encontrado
     * @param Array $tickets
     * @return Int 
     */
    function obtenerPrimerMes($tickets,$montoIn)
    {

        $i = 0;
        
        
        $encontrado = false;
        while ($i < count($tickets) && !$encontrado) {
            $montoTotal = $tickets[$i];
            if ($montoTotal > $montoIn) {
                $encontrado = true;
            } else $i++;
        }
        return $i;
    }
    /**
     * Ordena de menor a mayor por el monto de venta 
     * ARRAY $clonJuegoMasVendido,$aux
     * FLOAT $monto
     * @param Array $juegoMasVendido
     * @return void
     */
    function ordenarJuegoMasVendido($juegoMasVendido)
    {
        //copia el arreglo $juegoMasVendido en otro arreglo
        $clonJuegoMasVendido = clonarJuegoMasVendido($juegoMasVendido);

        foreach ($clonJuegoMasVendido as $key => $value) {
            $monto = $value["precioTicket"] * $value["cantidadTickets"];
            $aux[$key] = $monto;
        }
        /**
         * El metodo array_multisort permite ordenar arreglos multidimensionales.
         * Pasa por parametro el arreglo auxiliar $aux, SORT_ASC (indica el orden Ascendente),
         * y la estructura $juegoMasVendido que vamos a modificar
         * @param Array $aux
         */
        array_multisort($aux, SORT_ASC, $clonJuegoMasVendido);
        /*print_r permite imprimir la informacion de la estructura de datos, recibe como parametro 
          la expresion,(una variable) que va a ser impresa*/
        print_r($clonJuegoMasVendido);
    }
    /**
     * Hace una copia de la estructura $juegoMasVendido
     * ARRAY $clon
     * STRING $juego
     * INT $cantidad
     * FLOAT $precio
     * @param Array $juegoMasVendido
     * @return Array
     */
    function clonarJuegoMasVendido($juegoMasVendido)
    {
        $clon = [];
        foreach ($juegoMasVendido as $key => $value) {
            $juego = $value["juego"];
            $precio = $value["precioTicket"];
            $cantidad = $value["cantidadTickets"];
            $clon[$key] = ["juego" => $juego, "precioTicket" => $precio, "cantidadTickets" => $cantidad];
        }
        return $clon;
    }
    /**
     * Crea la estructura $tickets, recibe como $juegoMasVendido
     * ARRAY $tickets
     * @param Array $juegoMasVendido
     * @return Array
     */
    function crearTotalVentas($juegoMasVendido)
    {
        $tickets = array();
        foreach ($juegoMasVendido as $key => $value) {
            $tickets[$key] = $value["precioTicket"] * $value["cantidadTickets"];
        }

        return $tickets;
    }
    /**
     * Inicializa los valores de la estructura juegoMasVendidos
     * @param Array $juegoMasVendido
     * @return Array retorna la estructura de datos con los valores cargados 
     */
    function precargarJuegosVendidos()
    {
        
        $juegoMasVendido = array();
        $juegoMasVendido[0] = ["juego" => "juegos Chocadores", "precioTicket" => 75, "cantidadTickets" => 45];
        $juegoMasVendido[1] = ["juego" => "Ruleta Rusa", "precioTicket" => 110.5, "cantidadTickets" => 30];
        $juegoMasVendido[2] = ["juego" => "Carusel Tematico", "precioTicket" => 65, "cantidadTickets" => 25];
        $juegoMasVendido[3] = ["juego" => "Gusano Loco", "precioTicket" => 42, "cantidadTickets" => 50];
        $juegoMasVendido[4] = ["juego" => "Ascensor Frenetico", "precioTicket" => 95, "cantidadTickets" => 28];
        $juegoMasVendido[5] = ["juego" => "Barco Pirata", "precioTicket" => 80, "cantidadTickets" => 25];
        $juegoMasVendido[6] = ["juego" => "juegos Chocadores", "precioTicket" => 75, "cantidadTickets" => 60];
        $juegoMasVendido[7] = ["juego" => "Ruleta Rusa", "precioTicket" => 110.5, "cantidadTickets" => 57];
        $juegoMasVendido[8] = ["juego" => "Carusel Tematico", "precioTicket" => 65, "cantidadTickets" => 35];
        $juegoMasVendido[9] = ["juego" => "Gusano Loco", "precioTicket" => 42, "cantidadTickets" => 90];
        $juegoMasVendido[10] = ["juego" => "Ascensor Frenetico", "precioTicket" => 95, "cantidadTickets" => 64];
        $juegoMasVendido[11] = ["juego" => "Barco Pirata", "precioTicket" => 80, "cantidadTickets" => 60];

        return $juegoMasVendido;
    }


    /** 
     * Retorna el mes como texto
     * STRING $mes
     * @param Int $indice
     * @return String 
     */
    function mesEnTexto($indice)
    {
        $mes = "";
        switch ($indice) {
            case 0:
                $mes = "Enero";
                break;
            case 1:
                $mes = "Febrero";
                break;
            case 2:
                $mes = "Marzo";
                break;
            case 3:
                $mes = "Abril";
                break;
            case 4:
                $mes = "Mayo";
                break;
            case 5:
                $mes = "Junio";
                break;
            case 6:
                $mes = "Julio";
                break;
            case 7:
                $mes = "Agosto";
                break;
            case 8:
                $mes = "Septiembre";
                break;
            case 9:
                $mes = "Octubre";
                break;
            case 10:
                $mes = "Noviembre";
                break;
            case 11:
                $mes = "Diciembre";
                break;
        }
        return $mes;
    }
    /** 
     * Retorna el indice del mes ingresado
     * INT $pos 
     * STRING $mesIn,$mes
     * @return Int 
     */
    function mesAIndice()
    {
        do {
            $pos = -1;
            echo  "Escriba el mes:\n";
            $mesIn = trim(fgets(STDIN));
            //cambio el texto a mayuscula
            $mes = strtoupper($mesIn);

            switch ($mes) {
                case "ENERO":
                    $pos = 0;
                    break;
                case "FEBRERO":
                    $pos = 1;
                    break;
                case "MARZO":
                    $pos = 2;
                    break;
                case "ABRIL":
                    $pos = 3;
                    break;
                case "MAYO":
                    $pos = 4;
                    break;
                case "JUNIO":
                    $pos = 5;
                    break;
                case "JULIO":
                    $pos = 6;
                    break;
                case "AGOSTO":
                    $pos = 7;
                    break;
                case "SEPTIEMBRE":
                    $pos = 8;
                    break;
                case "OCTUBRE":
                    $pos = 9;
                    break;
                case "NOVIEMBRE":
                    $pos = 10;
                    break;
                case "DICIEMBRE":
                    $pos = 11;
                    break;
                default:
                    echo "¡Mes incorrecto!,por favor de nuevo\n";
                    break;
            }
        } while ($pos == -1);

        return $pos;
    }
