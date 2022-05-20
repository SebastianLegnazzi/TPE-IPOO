<?php
class Aereo extends Viaje {
    private $nroVuelo;
    private $nombreAereolinea;
    private $escalas;

    
    /**************************************/
    /**************** SET *****************/
    /**************************************/
    
    /**
     * Establece el valor de nroVuelo
     */ 
    public function setNroVuelo($nroVuelo){
        $this->nroVuelo = $nroVuelo;
    }

    /**
     * Establece el valor de nombreAereolinea
     */ 
    public function setNombreAereolinea($nombreAereolinea){
        $this->nombreAereolinea = $nombreAereolinea;
    }

    /**
     * Establece el valor de escalas
     */ 
    public function setEscalas($escalas){
        $this->escalas = $escalas;
    }
    

    /**************************************/
    /**************** GET *****************/
    /**************************************/
    
    /**
     * Obtiene el valor de nroVuelo
     */ 
    public function getNroVuelo(){
        return $this->nroVuelo;
    }

    /**
     * Obtiene el valor de nombreAereolinea
     */ 
    public function getNombreAereolinea(){
        return $this->nombreAereolinea;
    }

    /**
     * Obtiene el valor de escalas
     */ 
    public function getEscalas(){
        return $this->escalas;
    }

    
    /**************************************/
    /************** FUNCIONES *************/
    /**************************************/
    
    public function __construct($responsableV,$arrayPasajero,$cantidadMax,$destino,$codigoViaje,$importe,$tipoAsiento,$nroVuelo,$nombreAereolinea,$escalas,$idaVuelta){
        parent::__construct($responsableV,$arrayPasajero,$cantidadMax,$destino,$codigoViaje,$importe,$tipoAsiento,$idaVuelta);
        $this->nroVuelo = $nroVuelo;
        $this->nombreAereolinea = $nombreAereolinea;
        $this->escalas = $escalas;
    }

    public function venderPasaje($objPasajero){
        $importe = parent::venderPasaje($objPasajero);
        if($importe != null){
            $tipoAsiento = $this->getTipoAsiento();
            if(($tipoAsiento == "1") && ($this->getEscalas() > 0)){                     /* 1 = primera clase  /  2 = clase estandar  */
                $importe = $importe * 1.6;
            }else if(($tipoAsiento == "1") && ($this->getEscalas() == 0)){
                $importe = $importe * 1.4;
            }else if (($tipoAsiento != "1") && ($this->getEscalas() > 0)){
                $importe = $importe * 1.2;
            }
        }
        return $importe;
    }
    
    /**
     * Este modulo devuelve una cadena de caracteres mostrando el contenido de los atributos
     * @return string
    */
    public function __toString(){
        $cadena = parent::__toString();
        return $cadena.
                "El numero del vuelo es: ".$this->getNroVuelo()."\n".
                "El nombre de la aerolinea es: ".$this->getNombreAereolinea()."\n".
                "La escalas del vuelo son: ".$this->getEscalas()."\n";
    }
    
    
    






}
?>