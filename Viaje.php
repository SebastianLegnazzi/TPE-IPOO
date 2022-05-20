<?php
class Viaje{
    private $codigoViaje;
    private $destino;
    private $cantidadMax;
    private $arrayPasajero;
    private $responsableV;
    private $tipoAsiento;
    private $importe;    
    private $idaVuelta;    

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

    /**
     * Establece el valor de tipo
     */ 
    public function setTipoAsiento($tipoAsiento){
        $this->tipo = $tipoAsiento;
    }

    /**
     * Establece el valor de importe
     */ 
    public function setImporte($importe){
        $this->importe = $importe;
    }

    /**
     * Establece el valor de idaVuelta
     */ 
    public function setIdaVuelta($idaVuelta){
        $this->idaVuelta = $idaVuelta;
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

    /**
     * Obtiene el valor de tipo
     */ 
    public function getTipoAsiento(){
        return $this->tipoAsiento;
    }

    /**
     * Obtiene el valor de importe
     */ 
    public function getImporte(){
        return $this->importe;
    }

    /**
     * Obtiene el valor de idaVuelta
     */ 
    public function getIdaVuelta(){
        return $this->idaVuelta;
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
    public function __construct($responsableV, $arrayPasajero,$cantidadMax,$destino,$codigoViaje,$importe,$tipoAsiento,$idaVuelta){
        $this->responsableV = $responsableV;
        $this->arrayPasajero = $arrayPasajero;
        $this->cantidadMax = $cantidadMax;
        $this->destino = $destino;
        $this->codigoViaje = $codigoViaje;
        $this->importe = $importe;
        $this->tipoAsiento = $tipoAsiento;
        $this->idaVuelta = $idaVuelta;
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
    public function hayPasajesDisponible(){
        $capacidad = count($this->getArrayPasajero());
        $verificacion = ($capacidad < $this->getCantidadMax()) ? true : false;
        return $verificacion;
    }

    /**
     * Este modulo cambia datos del array Pasajeros
     * @param int $documento
     * @param int $opcion
     * @param string $dato
    */
    public function cambiarDatoPasajero($documento,$opcion,$dato){
        $objPasajero = $this->buscarPasajero($documento);
        switch($opcion){
            case 1: 
                $objPasajero->setNombre($dato);
            break;
            case 2: 
                $objPasajero->setApellido($dato);
            break;
            case 3: 
                $objPasajero->setTelefono($dato);
            break;
        }
    }

    /**
     * Este modulo cambia datos del responsable del viaje
     * @param int $opcion
     * @param string $dato
    */
    public function cambiarDatoResponsable($opcion,$dato){
        $objRespo = $this->getResponsableV();
        switch($opcion){
            case 1: 
                $objRespo->setNombre($dato);
            break;
            case 2: 
                $objRespo->setApellido($dato);
            break;
            case 3: 
                $objRespo->setNumEmpleado($dato);
            break;
            case 4: 
                $objRespo->setNumLicencia($dato);
            break;
        }
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
     * Este modulo devuelve el pasajero buscado
     * @param int $documento
     * @return object
     */
    public function verUnPasajero($documento){
        $objPasajero = $this->buscarPasajero($documento);
        return $objPasajero;
    }

    public function venderPasaje($objPasajero){
        $importe = null;
        if($this->hayPasajesDisponible()){
            $this->agregarPasajero($objPasajero);
            if($this->getIdaVuelta()){
                $importe = ($this->getImporte() * 1.25);
            }else{
                $importe = $this->getImporte();
            }
        }
        return $importe;
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


    /**************************************/
    /********* FUNCIONES PRIVADAS *********/
    /**************************************/

    /**
     * Este modulo devuelve un string con todos los pasajeros
     * @return string
     */
    private function pasajerosToString(){
        $arrayPasajeros = $this->getArrayPasajero();
        $separador = "================================";
        $toString = $separador."\n";
        foreach ($arrayPasajeros as $pasajero){
           $toString.=$pasajero."\n".$separador."\n";
        }
        return $toString;
    }





}

?>