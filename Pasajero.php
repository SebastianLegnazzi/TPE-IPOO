<?php
class Pasajero{
    private $nombre;
    private $apellido;
    private $documento;
    private $telefono;

    /**************************************/
	/**************** SET *****************/
	/**************************************/

    /**
     * Establece el valor de telefono
     */ 
    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    /**
     * Establece el valor de documento
     */ 
    public function setDocumento($documento){
        $this->documento = $documento;
    }

    /**
     * Establece el valor de apellido
     */ 
    public function setApellido($apellido){
        $this->apellido = $apellido;
    }

    /**
     * Establece el valor de nombre
     */ 
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }


	/**************************************/
	/**************** GET *****************/
	/**************************************/

    /**
     * Obtiene el valor de documento
     */ 
    public function getDocumento(){
        return $this->documento;
    }

    /**
     * Obtiene el valor de telefono
     */ 
    public function getTelefono(){
        return $this->telefono;
    }

    /**
     * Obtiene el valor de apellido
     */ 
    public function getApellido(){
        return $this->apellido;
    }

    /**
     * Obtiene el valor de nombre
     */ 
    public function getNombre(){
        return $this->nombre;
    }


	/**************************************/
	/************** FUNCIONES *************/
	/**************************************/

    public function __construct($nombre,$apellido,$documento,$telefono)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->documento = $documento;
        $this->telefono = $telefono;
    }

    public function __toString()
    {
        return ("El nombre del pasajero es: ".$this->getNombre()."\n".
                "El apellido del pasajero es: ".$this->getApellido()."\n".
                "El documento del pasajero es: ".$this->getDocumento()."\n".
                "El telefono del pasajero es: ".$this->getTelefono()."\n");
    }
    
}
?>