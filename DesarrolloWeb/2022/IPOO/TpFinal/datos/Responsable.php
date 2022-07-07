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
        $this->rnumeroempleado = "";
        $this->rnumerolicencia = "";
        $this->rnombre = "";
        $this->rapellido = "";
    }
    /** Permite cargar los datos del responsable
     * 
     */
    public function cargar($rnumeroempleado, $numLicencia, $nombre, $apellido)
    {
        $this->setRnumeroempleado($rnumeroempleado);
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
    /** Permite insertar el responsable en la base de datos
     * @return Boolean
     */
    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;

        $numLicencia = $this->getRnumerolicencia();
        $consultaInsertar = "INSERT INTO responsable(rnumerolicencia, rnombre,  rapellido) 
				VALUES ($numLicencia,'" . $this->getRnombre() . "','" . $this->getRapellido() . "')";

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
    /** Permite modificar el responsable en la base de datos
     * @return Boolean
     */
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE responsable SET rnumerolicencia=" . $this->getRnumerolicencia() . ",rnombre='" . $this->getRnombre() . "',
                             rapellido='" . $this->getRapellido() . "' WHERE rnumeroempleado=" . $this->getRnumeroempleado();
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
    /** Permite eliminar el responsable en la base de datos
     * @return Boolean
     */
    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorra = "DELETE FROM responsable WHERE rnumeroempleado=" . $this->getRnumeroempleado();
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
     *  Retorna en forma de cadena de texto la informacion de todas los empleados responsables del viaje.
     * String cadena
     * @return String
     */
    public function mostrarResponsables()
    {
        $arreResponsables = $this->listar();
        $cadena = "\n▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀\n";
        $cadena .= "| Seleccione Responsable |\n";


        foreach ($arreResponsables as $objResponsable) {
            $cadena .= $objResponsable->__toString() . "\n";
        }
        return $cadena;
    }
    /**
     * Recupera los datos de una responsable por numero de empleado
     * @param int $numEmpleado
     * @return true en caso de encontrar los datos, false en caso contrario 
     */
    public function Buscar($numEmpleado)
    {
        $base = new BaseDatos();
        $consulta = "Select * from responsable where rnumeroempleado=" . $numEmpleado;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row2 = $base->Registro()) {
                    $this->setRnumeroempleado($row2['rnumeroempleado']);
                    $this->setRnumerolicencia($row2['rnumerolicencia']);
                    $this->setRnombre($row2['rnombre']);
                    $this->setRapellido($row2['rapellido']);
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

    /** Retorna una arreglo de objetos la clase Responsable
     * @return Array
     */
    public function listar($condicion = "")
    {
        $arregloEmpresa = null;
        $base = new BaseDatos();
        $consultaEmpresas = "Select * from responsable";
        if ($condicion != "") {
            $consultaEmpresas = $consultaEmpresas . ' where ' . $condicion;
        }
        $consultaEmpresas .= " order by rapellido ASC";
        //echo $consultaEmpresas ;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEmpresas)) {
                //si hay registros creamos un arreglo				
                $arregloEmpresa = array();
                while ($row2 = $base->Registro()) {
                    $rnumeroempleado = ($row2['rnumeroempleado']);
                    $rnumerolicencia = ($row2['rnumerolicencia']);
                    $rnombre = ($row2['rnombre']);
                    $rapellido = ($row2['rapellido']);

                    $emp = new Responsable();
                    $emp->cargar($rnumeroempleado, $rnumerolicencia, $rnombre, $rapellido);
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

    /**
     * Retorna un string represente a los objetos de la clase Responsable. 
     * String cadena
     * @return String
     */
    public function __toString()
    {
        $cadena = "";
        $cadena .= "Nº Empleado: " . $this->getRnumeroempleado() . " Nº Licencia: " . $this->getRnumerolicencia() . " Nombre: " . $this->getrnombre() . " Apellido: " . $this->getRapellido();
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
