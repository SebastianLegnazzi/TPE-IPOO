<?php
class Viaje{
    private $codigoViaje;
    private $destino;
    private $cantidadMax;
    private $pasajeros;
    private $responsableV;

    
    /**************************************/
    /**************** SET *****************/
    /**************************************/

    /**
     * Cambia el valor de cantidad maxima
     *
     * @param int $cantidadMax
     */ 
    public function setCantidadMax($cantidadMax){
        $this->cantidadMax = $cantidadMax;
    }

    /**
     * Cambia el valor de destino
     *
     * @param string $destino
     */ 
    public function setDestino($destino){
        $this->destino = $destino;
    }

    /**
     * Cambia el valor del codigo del viaje
     *
     * @param int $codigoViaje
     */ 
    public function setCodigoViaje($codigoViaje){
        $this->codigoViaje = $codigoViaje;
    }

    /**
     * Cambia el valor de los pasajeros
     *
     * @param array $pasajeros
     */ 
    public function setPasajeros($pasajeros){
        $this->pasajeros = $pasajeros;
    }

    /**
     * Establece el valor de responsable
     */ 
    public function setResponsableV($responsableV){
        $this->responsableV = $responsableV;
    }


    /**************************************/
    /**************** GET *****************/
    /**************************************/

    /**
     * Devuelve el array con la cantidad de pasajeros
     * 
     * @return array
     */ 
    public function getPasajeros(){
        return $this->pasajeros;
    }

    /**
     * Devuelve la cantidad maxima de pasajeros
     * 
     * @return int
     */ 
    public function getCantidadMax(){
        return $this->cantidadMax;
    }

    /**
     * Devuelve el nombre del viaje
     * 
     * @return  string
     */ 
    public function getDestino(){
        return $this->destino;
    }

    /**
     * Devuelve el codigo del viaje
     * 
     * @return int
     */ 
    public function getCodigoViaje(){
        return $this->codigoViaje;
    }

    /**
     * Obtiene el valor de responsable
     */ 
    public function getResponsableV(){
        return $this->responsableV;
    }


    /**************************************/
    /************** FUNCIONES *************/
    /**************************************/

    /**
     * Este modulo asigna los valores a los atributos cuando se crea una instancia de la clase 
     * @param array $pasajeros
     * @param int $cantidadMax
     * @param string $destino
     * @param int $codigoViaje
    */
    public function __construct($responsableV, $pasajeros,$cantidadMax,$destino,$codigoViaje){
        $this->responsableV = $responsableV;
        $this->pasajeros = $pasajeros;
        $this->cantidadMax = $cantidadMax;
        $this->destino = $destino;
        $this->codigoViaje = $codigoViaje;
    }

    /**
     * Este modulo cambia datos del array Pasajeros
     * @param int $documento
     * @param string $datoACambiar
     * @param string $dato
    */
    public function cambiarDatoPasajero($documento,$datoACambiar,$dato){
        $arrayPasajeros = $this->getPasajeros();
        $objPasajero = $this->buscarPasajero($documento);
        if("nombre" == $datoACambiar){
            $objPasajero->setNombre($dato);
        }else if ("apellido" == $datoACambiar){
            $objPasajero->setApellido($dato);
        }else if ("documento" == $datoACambiar){
            $objPasajero->setDocumento($dato);
        }else{
            $objPasajero->setTelefono($dato);
        }
        array_push($arrayPasajeros, $objPasajero);
        $this->setPasajeros($arrayPasajeros);
    }

    /**
     * Este modulo cambia datos del responsable del vuelo
     * @param string $datoACambiar
     * @param string $dato
    */
    public function cambiarDatoResponsable($datoACambiar,$dato){
        $responsableV = $this->getResponsableV();
        if("nombre" == $datoACambiar){
            $responsableV->setNombre($dato);
        }else if ("apellido" == $datoACambiar){
            $responsableV->setApellido($dato);
        }else if ("numero empleado" == $datoACambiar){
            $responsableV->setNumEmpleado($dato);
        }else{
            $responsableV->setNumLicencia($dato);
        }
    }

    /**
     * Este modulo agrega un nuevo pasajero al final del array pasajero existente.
     * @param array $nuevoPasajero
    */
    public function agregarPasajero($nuevoPasajero){
        $arrayPasajeros = $this->getPasajeros();
        $this->setPasajeros(array_merge($arrayPasajeros, $nuevoPasajero));
    }

    /**
     * Este modulo quita un pasajero del array pasajero.
     * @param array $nuevoPasajero
     * @return boolean
    */
    public function quitarPasajero($documento){
        $arrayPasajeros = $this->getPasajeros();
        $dimension = count($arrayPasajeros);
        $buscar = true;
        $i = 0;
        while($buscar && $i <= $dimension){
            if($arrayPasajeros[$i]->getDocumento() == $documento){
                $buscar = false;
            }else{
                $i++;
            }
        }
        if(!$buscar){
            unset($arrayPasajeros[$i]);
            sort($arrayPasajeros);
            $this->setPasajeros($arrayPasajeros);
            $verificacion = true;
        }else{
            $verificacion = false;
        }
        return $verificacion;
        }

    /**
     * Este modulo analiza si la capacidad de los pasajeros es menor a la capacidad maxima
     * @return boolean
    */
    public function superaCapacidad(){
        $capacidad = count($this->getPasajeros());
        $verificacion = ($capacidad < $this->getCantidadMax()) ? true : false;
        return $verificacion;
    }


    /**
     * Este modulo devuelve la cantidad de pasajeros que hay en el viaje
    */
    public function cantidadPasajeros(){
        $cantidad = count($this->getPasajeros());
        return $cantidad;
    }


    /**
     * Este modulo busca si existe el pasajero y devuelve true o false
     * @return boolean
    */
    public function existePasajero($dni){
        $arrayPasajeros = $this->getPasajeros();
        $i = 0;
        $dimension = count($arrayPasajeros);
        $existe = false;
        if($dimension > 0){
            do{
                if($arrayPasajeros[$i]->getDocumento() == $dni){
                    $existe = true;
                }else{
                $i++;
                }
            }while(!$existe && ($i < $dimension));
        }
        return ($existe);
    }

    
    /**
     * Este modulo busca si existe el pasajero y devuelve el objeto con el pasajero
     * @return object
     */
    public function buscarPasajero($dni){
        $arrayPasajeros = $this->getPasajeros();
        $i = 0;
        $dimension = count($arrayPasajeros);
        $pasajero = null;
        $seguirBuscando = true;
        if($this->existePasajero($dni)){
            do{
                if($arrayPasajeros[$i]->getDocumento() == $dni){
                    $seguirBuscando = false;
                    $pasajero = $arrayPasajeros[$i];
                }else{
                    $i++;
                }
            }while($seguirBuscando && ($i < $dimension));
        }
        return ($pasajero);
    }
    

    /**
     * Este modulo devuelve una cadena de caracteres mostrando el contenido de los atributos
     * @return string
    */
    public function __toString(){
        return ("El destino del viaje es: ".$this->getDestino()."\n".
                "El codigo del viaje es: ".$this->getCodigoViaje()."\n".
                "La capacidad maxima del viaje es: ".$this->getCantidadMax()."\n"."\n".
                "El responsable del viaje es: "."\n".$this->getResponsableV()."\n".
                "Los pasajeros del viaje son: "."\n".$this->pasajerosToString()."\n");
    }

    /**
     * Este modulo devuelve el pasajero buscado
     * @param int $documento
     */
    public function verUnPasajero($documento){
        $objPasajero = $this->buscarPasajero($documento);
        return $objPasajero;
    }

    
    /**************************************/
    /********* FUNCIONES PRIVADAS *********/
    /**************************************/

    /**
     * Este modulo devuelve un string con todos los pasajeros
     * @return string
     */
    private function pasajerosToString(){
        $arrayPasajeros = $this->getPasajeros();
        $i = 1;
        $separador = "================================";
        $toString = $separador."\n";
        foreach ($arrayPasajeros as $pasajero){
           $toString.=$pasajero."\n".$separador."\n";
        }
        return $toString;
    }
}

?>