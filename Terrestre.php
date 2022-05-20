<?php
class Terrestre extends Viaje {

    /**************************************/
    /************** FUNCIONES *************/
    /**************************************/
    
    public function __construct($responsableV,$arrayPasajero,$cantidadMax,$destino,$codigoViaje,$importe,$tipoAsiento,$idaVuelta){
        parent::__construct($responsableV,$arrayPasajero,$cantidadMax,$destino,$codigoViaje,$importe,$tipoAsiento,$idaVuelta);
    }
    
    public function venderPasaje($objPasajero){
        $importe = parent::venderPasaje($objPasajero);
        if($importe != null){
            $agregadoCama = ($this->getTipoAsiento() == 1) ? ($importe * 1.25) : ($importe);  /* 1 = semicama o cama  /  x = asiento   */
            $importe = $importe + $agregadoCama;
        }
        return $importe;
    }

    public function __toString(){
        return parent::__toString();
    }

}
?>