<?php
class Viaje{
    private $codigoViaje;
    private $destino;
    private $cantidadMax;
    private $arrayPasajero;
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
    public function setArrayPasajero($arrayPasajero){
        $this->arrayPasajero = $arrayPasajero;
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
    public function getArrayPasajero(){
        return $this->arrayPasajero;
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
     * @param array $arrayPasajero
     * @param int $cantidadMax
     * @param string $destino
     * @param int $codigoViaje
     * @param object $responsableV
    */
    public function __construct($responsableV, $arrayPasajero,$cantidadMax,$destino,$codigoViaje){
        $this->responsableV = $responsableV;
        $this->arrayPasajero = $arrayPasajero;
        $this->cantidadMax = $cantidadMax;
        $this->destino = $destino;
        $this->codigoViaje = $codigoViaje;
    }

    /**
     * Este modulo agrega un nuevo pasajero al final del array pasajero existente.
     * @param object $nuevoObjPasajero
    */
    public function agregarPasajero($nuevoObjPasajero){
        $existe = $this->existePasajero($nuevoObjPasajero->getDocumento());
        if(!$existe){
            $arrayPasajeros = $this->getArrayPasajero();
            array_push($arrayPasajeros, $nuevoObjPasajero);
            $this->setArrayPasajero($arrayPasajeros);
        }
    }

    /**
     * Este modulo quita un pasajero del array pasajero.
     * @param array $nuevoPasajero
     * @return boolean
    */
    public function quitarPasajero($documento){
        $arrayPasajeros = $this->getArrayPasajero();
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
            $this->setArrayPasajero($arrayPasajeros);
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
        $capacidad = count($this->getArrayPasajero());
        $verificacion = ($capacidad < $this->getCantidadMax()) ? true : false;
        return $verificacion;
    }


    /**
     * Este modulo devuelve la cantidad de pasajeros que hay en el viaje
     * @return int
    */
    public function cantidadPasajeros(){
        $cantidad = count($this->getArrayPasajero());
        return $cantidad;
    }


    /**
     * Este modulo busca si existe el pasajero y devuelve true o false
     * @param $dni
     * @return boolean
    */
    public function existePasajero($dni){
        $arrayPasajeros = $this->getArrayPasajero();
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
     * @param $dni
     * @return object
     */
    public function buscarPasajero($dni){
        $arrayPasajeros = $this->getArrayPasajero();
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
     * @return object
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
        $arrayPasajeros = $this->getArrayPasajero();
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