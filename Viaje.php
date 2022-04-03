<?php
class Viaje{
    private $codigoViaje;
    private $destino;
    private $cantidadMax;
    private $pasajeros;
    
    

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
    public function __construct($pasajeros,$cantidadMax,$destino,$codigoViaje){
        $this->pasajeros = $pasajeros;
        $this->cantidadMax = $cantidadMax;
        $this->destino = $destino;
        $this->codigoViaje = $codigoViaje;
    }

    /**
     * Este modulo cambia datos del array Pasajeros
     * @param int $documento
     * @param string $index
     * @param string $dato
     * @return array
    */
    public function cambiarDatoPasajero($documento,$datoACambiar,$dato){
        $arrayPasajeros = $this->getPasajeros();
        $i = 0;
        $dimension = count($arrayPasajeros);
        $indice = $this->buscarPasajero($documento);
        $arrayPasajeros[$indice][$datoACambiar] = $dato;
        $this->setPasajeros($arrayPasajeros);
    }

    /**
     * Este modulo agrega un nuevo pasajero al final del array pasajero existente.
     * @param array $nuevoPasajero
    */
    public function agregarPasajero($nuevoPasajero){
        if(in_array($nuevoPasajero, $this->getPasajeros())){
            echo "El pasajero ya esta ingresado en el vuelo!"."\n";
        }else{
            if($this->getCantidadMax() < count($this->getPasajeros())){
                $arrayPasajeros = $this->getPasajeros();
                array_push($arrayPasajero, $nuevoPasajero);
                $this->setPasajeros($arrayPasajeros);
                echo "El pasajero se agrego al viaje correctamente!"."\n";
            }else{
                echo "El pasajero no se pudo agregar ya que el vuelo esta lleno!"."\n";
            }
        }
    }

    /**
     * Este modulo quita un pasajero del array pasajero.
     * @param array $nuevoPasajero
     * @return boolean
    */
    public function quitarPasajero($documento){
        $arrayPasajeros = $this->getPasajeros();
        $i = 0;
        $dimension = count($arrayPasajeros);
        $indice = $this->buscarPasajero($documento);
        unset($arrayPasajeros[$indice]);
        $this->setPasajeros($arrayPasajeros);
        }

    /**
     * Este modulo analiza si la capacidad de los pasajeros es menor a la capacidad maxima
     * @return boolean
    */
    public function superaCapacidad(){
        $capacidad = count($this->getPasajeros());
        $verificacion = ($capacidad > $this->getCantidadMax()) ? true : false;
        return $verificacion;
    }

    /**
     * Este modulo devuelve todos los pasajeros del viaje por pantalla
    */
    public function verPasajeros(){
        $arrayPasajeros = $this->getPasajeros();
        $dimension = count($arrayPasajeros);
        for($i = 0; $i < $dimension; $i++){
            echo ("La ubicacion del pasajero es: ".($i+1)."\n".
                "El Nombre es: ".($this->getPasajeros())[$i]["nombre"]."\n".
                "El Apellido es: ".($this->getPasajeros())[$i]["apellido"]."\n".
                "El DNI es: ".($this->getPasajeros())[$i]["documento"]."\n"."\n");
        }
    }

    /**
     * Este modulo devuelve la cantidad de pasajeros que hay en el viaje
    */
    public function cantidadPasajeros(){
        $cantidad = count($this->getPasajeros());
        return $cantidad;
    }

    /**
     * Este modulo devuelve todos los pasajeros del viaje por pantalla
    */
    public function verUnPasajero($documento){
        $index = $this->buscarPasajero($documento);
        echo ("La ubicacion del pasajero es: ".($index+1)."\n".
            "El Nombre es: ".($this->getPasajeros())[$i]["nombre"]."\n".
            "El Apellido es: ".($this->getPasajeros())[$i]["apellido"]."\n".
            "El DNI es: ".($this->getPasajeros())[$i]["documento"]."\n"."\n");
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
        $seguirBuscando = true;
        do{
            if($arrayPasajeros[$i]["documento"] == $dni){
                $seguirBuscando = false;
                $existe = true;
            }else{
            $i++;
            }
        }while($seguirBuscando && ($i < $dimension));
        return ($existe);
    }

    /**
     * Este modulo devuelve una cadena de caracteres mostrando el contenido de los atributos
     * @return string
    */
    public function __toStrign(){
        return ("Los pasajeros del viaje son: ".count($this->getPasajeros())."\n".
                "La capacidad maxima del viaje es: ".$this->getCantidadMax()."\n".
                "El destino del viaje es: ".$this->getDestino()."\n".
                "El codigo del viaje es: ".$this->getCodigoViaje()."\n");
    }

    /**************************************/
    /********* FUNCIONES INTERNAS *********/
    /**************************************/
    
    /**
     * Este modulo busca si existe el pasajero y devuelve el indice donde se encuentra
     * @return string
    */
    private function buscarPasajero($dni){
        $arrayPasajeros = $this->getPasajeros();
        $i = 0;
        $dimension = count($arrayPasajeros);
        if($this->existePasajero($dni)){
            do{
                $seguirBuscando = true;
                if($arrayPasajeros[$i]["documento"] == $dni){
                    $seguirBuscando = false;
                }else{
                $i++;
                }
            }while($seguirBuscando && ($i < $dimension));
        }
        return ($i);
    }

}

?>