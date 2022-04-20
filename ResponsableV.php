<?php
class ResponsableV{
    private $nombre;
    private $apellido;
    private $numEmpleado;
    private $numLicencia;

    /**************************************/
	/**************** SET *****************/
	/**************************************/

    /**
     * Establece el valor de numLicencia
     */ 
    public function setNumLicencia($numLicencia){
        $this->numLicencia = $numLicencia;
    }

    /**
     * Establece el valor de numEmpleado
     */ 
    public function setNumEmpleado($numEmpleado){
        $this->numEmpleado = $numEmpleado;
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
     * Obtiene el valor de nombre
     */ 
    public function getNombre(){
        return $this->nombre;
    }

    /**
     * Obtiene el valor de apellido
     */ 
    public function getApellido(){
        return $this->apellido;
    }

    /**
     * Obtiene el valor de numEmpleado
     */ 
    public function getNumEmpleado(){
        return $this->numEmpleado;
    }

    /**
     * Obtiene el valor de numLicencia
     */ 
    public function getNumLicencia(){
        return $this->numLicencia;
    }


	/**************************************/
	/************** FUNCIONES *************/
	/**************************************/

	public function __construct($nombre,$apellido,$numEmpleado,$numLicencia)
	{
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->numEmpleado = $numEmpleado;
		$this->numLicencia = $numLicencia;
	}

	public function __toString()
	{
		return ("El nombre del responsable del viaje es: ".$this->getNombre()."\n".
				"El apellido del responsable del viaje es: ".$this->getApellido()."\n".
				"El numero de empleado es: ".$this->getNumEmpleado()."\n".
				"El numero de licencia es: ".$this->getNumLicencia()."\n");
	}

}
?>