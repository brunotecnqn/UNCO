<?php

class Empresa
{
    private $idempresa;
    private $enombre;
    private $edireccion;
    private $mensajeoperacion;
    function __construct()
    {
        $this->idempresa = "";
        $this->enombre = "";
        $this->edireccion = "";
    }
    /** Permite cargar los datos de la empresa
     * 
     */
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


    /** Permite insertar la empresa en la base de datos
     * @return Boolean
     */

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO empresa(enombre, edireccion) 
            VALUES ('" . $this->getEnombre() . "','" . $this->getEdireccion() . "')";

        if ($base->Iniciar()) {

            if ($base->Ejecutar($consultaInsertar)) {

                $resp =  true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    /** Permite modificar la empresa en la base de datos
     * @return Boolean
     */
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE empresa SET enombre='" . $this->getEnombre() . "',edireccion='" . $this->getEdireccion() . "'
     WHERE idempresa=" . $this->getIdempresa();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    /** Permite eliminar la empresa en la base de datos
     * @return Boolean
     */
    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorra = "DELETE FROM empresa WHERE idempresa=" . $this->getIdempresa();
            if ($base->Ejecutar($consultaBorra)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }
    /**
     * Recupera los datos de la empresa por ID empresa
     * @param int $idemp
     * @return true en caso de encontrar los datos, false en caso contrario 
     */
    public function Buscar($idemp)
    {
        $base = new BaseDatos();
        $consulta = "Select * from empresa where idempresa=" . $idemp;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row2 = $base->Registro()) {

                    $this->setIdempresa($row2['idempresa']);
                    $this->setEnombre($row2['enombre']);
                    $this->setEdireccion($row2['edireccion']);
                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }
    /**
     *  Retorna en forma de cadena de texto la informacion de todas las empresas.
     * String cadena
     * @return String
     */
    public function mostrarEmpresas()
    {
        $arreEmpresas = $this->listar();
        $cadena = "\n▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀\n";
        $cadena .= "| Seleccione Empresa |\n";


        foreach ($arreEmpresas as $objEmpresa) {
            $cadena .= "\nID: " . $objEmpresa->getIdempresa() . " Empresa: " . $objEmpresa->getEnombre() . "\n";
        }
        return $cadena;
    }

    /** Retorna una arreglo de objetos la clase Empresa
     * @return Array
     */
    public function listar($condicion = "")
    {
        $arregloEmpresa = null;
        $base = new BaseDatos();
        $consultaEmpresas = "Select * from empresa";
        if ($condicion != "") {
            $consultaEmpresas = $consultaEmpresas . ' where ' . $condicion;
        }
        $consultaEmpresas .= " order by enombre ASC";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEmpresas)) {
                //si hay registros creamos un arreglo				
                $arregloEmpresa = array();
                while ($row2 = $base->Registro()) {

                    $idempresa = $row2['idempresa'];
                    $nombre = $row2['enombre'];
                    $direccion = $row2['edireccion'];


                    $emp = new Empresa();
                    $emp->cargar($idempresa, $nombre, $direccion);
                    array_push($arregloEmpresa, $emp);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
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
    /**
     * Retorna en forma de cadena de texto los valores de los atributos de la clase Empresa. 
     * String cadena
     * @return String
     */
    public function __toString()
    {
        return "\nID Empresa: " . $this->getIdempresa() . " Nombre:" . $this->getEnombre() . " Direccion: " . $this->getEdireccion() . "\n";
    }
}
