<?php
include "Viaje.php";

/**************************************/
/************** MODULOS ***************/
/**************************************/

/**
 * Muestra el menu para que el usuario elija y retorna la opcion
 * @return int 
 */
function menu()
{
    echo "\n"."MENU DE OPCIONES"."\n";
    echo "1) Saber la cantidad de pasajeros."."\n";
    echo "2) Ver los pasajeros del viaje."."\n";
    echo "3) Ver datos del viaje."."\n";
    echo "4) Modificar los datos de un pasajero."."\n";
    echo "5) Agregar un pasajeros al viaje."."\n";
    echo "6) Eliminar un pasajero del viaje."."\n";
    echo "7) Ver datos de un pasajero"."\n";
    echo "8) Cambiar destino del viaje."."\n";
    echo "9) Cambiar capacidad maxima del viaje."."\n";
    echo "10) Cambiar codigo del viaje."."\n";
    echo "11) Modificar otro viaje."."\n";
    echo "12) Crear otro viaje."."\n";
    echo "13) Elimina un viaje."."\n";
    echo "14) Ver todos los viajes."."\n";
    echo "0) Salir"."\n";
    echo "Opcion: ";
    $menu = trim(fgets(STDIN));
    echo "\n";
    return $menu;
}


/**
 * Inicia el programa y pide que ingrese los viajes que luego devuelve al programa principal
 * @return array
 */
function inicioPrograma()
{
    separador();
    echo "Bienvenido a la aplicacion de viajesulis :D"."\n";
    echo "Ingrese la cantidad de viajes que desea ingresar: ";
    $cantViajes = trim(fgets(STDIN));
    $cantViajes = verificadorInt($cantViajes);
    $objViajes = creaViajes($cantViajes);
    return $objViajes;
}


/**
 * Este modulo crea un array con todos los viajes que el usuario desea ingresar
 */
function creaViajes($cant)
{
    $objViajes = [];
    for($i = 0; $i < $cant;$i++){
        separador();
        echo "Ingrese el codigo del viaje ".($i+1)." : ";
        $codigoViaje = trim(fgets(STDIN));
        echo "Ingrese el destino del viaje ".($i+1)." : ";
        $destViaje = trim(fgets(STDIN));
        echo "Ingrese la cantidad de personas maximas que pueden realizar el viaje ".($i+1)." : ";
        $cantMax = trim(fgets(STDIN));
        $cantMax = verificadorInt($cantMax);
        echo "Ingrese la cantidad de personas que realizaran el viaje ".($i+1)." : ";
        $cantPersonas = trim(fgets(STDIN));
        $cantPersonas = verificadorInt($cantPersonas);
        if($cantPersonas <= $cantMax){
            $personas = personasViaje($cantPersonas);
            $objViajes[$i] = new Viaje($personas,$cantMax,$destViaje,$codigoViaje);
            echo "El viaje se ha creado correctamente!"."\n";
        }else{
            echo "La cantidad de personas supera a la cantidad maxima del viaje!"."\n";
        }
    }
    return $objViajes;  
}


/**
 * Busca el index del viaje con el que va a realizar las operaciones
 * @param array $viajes
 * @return int
 */
function viajeModificar($viajes)
{
    separador();
    $dimension = count($viajes);
    $buscarCodigo = true;
    $i = 0;
    echo "Ingrese el codigo del viaje con el que desea interactuar: ";
    $codigo = trim(fgets(STDIN));
    $verificacion = existeViaje($viajes, $codigo);
    while($verificacion){
        echo "El codigo ingresado no existe o esta mal ingresado, Ingreselo nuevamente: "."\n";
        $codigo = trim(fgets(STDIN));
        $verificacion = existeViaje($viajes, $codigo);
    }
    $index = buscarViaje($viajes, $codigo);
    separador();
    return $index;
}


/**
 * Devuelve true si el viaje existe, false en caso contrario
 * @param array $arrayViajes
 * @param string $codigoViaje
 * @return boolean
 */
function existeViaje($arrayViajes, $codigoViaje)
{
    $dimension = count($arrayViajes);
    $buscarCodigo = true;
    $i = 0;
    while($buscarCodigo && ($i < $dimension)){
        if(strtolower($arrayViajes[$i]->getCodigoViaje()) == strtolower($codigoViaje)){
            $buscarCodigo = false;
        }else{
            $i++;
        }
    }
    return $buscarCodigo;
}


/**
 * Devuelve en que posicion del $arrayViajes se encuentra el codigo ingresado
 * @param array $arrayViajes
 * @param string $codigoViaje
 * @return int
 */
function buscarViaje($arrayViajes, $codigoViaje)
{
    $dimension = count($arrayViajes);
    $buscarCodigo = true;
    $i = 0;
    while($buscarCodigo && ($i < $dimension)){
        if(strtolower($arrayViajes[$i]->getCodigoViaje()) == strtolower($codigoViaje)){
            $buscarCodigo = false;
        }else{
            $i++;
        }
    }
    return $i;
}


/**
 * Retorna un array con todos los pasajeros del viaje
 * @param int $cantidad
 * @return array
 */
function personasViaje($cantidad)
{
    $arrayPersonas = [];
    for($i = 0; $i < $cantidad; $i++){
        separador();
        echo "ingrese el nombre del pasajero ".($i+1).": ";
        $nombrePasajero =  trim(fgets(STDIN));
        echo "ingrese el apellido del pasajero ".($i+1).": ";
        $apellidoPasajero =  trim(fgets(STDIN));
        echo "ingrese el DNI del pasajero ".($i+1).": ";
        $dniPasajero =  trim(fgets(STDIN));
        separador();
        echo "\n";
        $arrayPersonas[$i] = ["nombre"=> $nombrePasajero,"apellido"=> $apellidoPasajero,"documento"=>$dniPasajero];
    }
    return $arrayPersonas;
}


/**
 * Retorna un array con todos los pasajeros del viaje
 * @param array $viajes
 */
function mostrarViajes($viajes)
{
    $dimension = count($viajes);
    for($i = 0; $i < $dimension; $i++){
        separador();
        echo "Viaje: ".($i+1)."\n";
        echo $viajes[$i];
        separador();
    }
}

/**
 * Devuelve por pantalla un string que separa los puntos
 */
function separador()
{
    echo "========================================================"."\n";
}

/**
 * Verifica que el valor ingreasado sea un entero, en caso contario lo vuelve a pedir hasta que sea un entero
 * @param int $dato
 * @return int
 */
function verificadorInt($dato)
{
    while(is_numeric($dato) == false){
        echo "El valor ".$dato." no es correcto, Por favor ingrese numeros: ";
        $dato = trim(fgets(STDIN));
    }
    return $dato;
}

/**
 * Este modulo devuelve todos los pasajeros del viaje por pantalla
*/
function verPasajeros($viajes){
    $arrayPasajeros = $viajes->getPasajeros();
    $dimension = count($arrayPasajeros);
    for($i = 0; $i < $dimension; $i++){
        datoPasajero($viajes, $i);
    }
}

/**
 * Este modulo devuelve todos los pasajeros del viaje por pantalla
*/
function verUnPasajero($viajes, $documento){
    $posicion = $viajes->buscarPasajero($documento);
    datoPasajero($viajes, $posicion);
}


/**
 * Este modulo devuelve todos los pasajeros del viaje por pantalla
*/
function datoPasajero($arrayViaje, $index){
    echo ("La ubicacion del pasajero es: ".($index+1)."\n".
        "El Nombre es: ".($arrayViaje->getPasajeros())[$index]["nombre"]."\n".
        "El Apellido es: ".($arrayViaje->getPasajeros())[$index]["apellido"]."\n".
        "El DNI es: ".($arrayViaje->getPasajeros())[$index]["documento"]."\n"."\n");
}

/**************************************/
/********* PROGRAMA PRINCIPAL *********/
/**************************************/


//Este programa ejecuta segun la opcion elegida del usuario la secuencia de pasos a seguir
$objViaje = inicioPrograma();
$indexViaje = viajeModificar($objViaje);
$opcion = menu();
do {
switch ($opcion) {
    
    case 1: 
        separador();
        echo "la cantidad de pasajeros del viaje ".$objViaje[$indexViaje]->getDestino()." es: ".$objViaje[$indexViaje]->cantidadPasajeros()."\n";
        separador();
        $opcion = menu();
        break;


    case 2: 
        separador();
        echo "Las personas del viaje ".$objViaje[$indexViaje]->getDestino()." son: "."\n";
        verPasajeros($objViaje[$indexViaje]);
        separador();
        $opcion = menu();
        break;

        
    case 3: 
        separador();
        echo "Los datos del viaje ".$objViaje[$indexViaje]->getDestino()." son: "."\n";
        echo $objViaje[$indexViaje]."\n";
        separador();
        $opcion = menu();
        break;
       
        
    case 4: 
        separador();
        echo "Ingrese el DNI de que pasajero desea cambiar el dato: ";
        $dni = trim(fgets(STDIN));
        if($objViaje[$indexViaje]->existePasajero($dni)){
            echo "Ingrese que dato desea cambiar (Nombre/Apellido/Documento): ";
            $tipoDatoCambiar = strtolower(trim(fgets(STDIN)));
            while((($tipoDatoCambiar <> "nombre") && ($tipoDatoCambiar <> "apellido") && ($tipoDatoCambiar <> "documento"))){
                echo "El valor ".$tipoDatoCambiar." no es correcto, Por favor ingrese (Nombre/Apellido/Documento): ";
                $tipoDatoCambiar = trim(fgets(STDIN));
            }
            echo "Ingrese el nuevo dato: ";
            $nuevoValor = trim(fgets(STDIN));
            $objViaje[$indexViaje]->cambiarDatoPasajero($dni,$tipoDatoCambiar,$nuevoValor);
            echo "El dato se ha modificado correctamente!"."\n";
        }else{
            echo "Debes crear un viaje antes de usas las opciones. Seleccione la opcion 1"."\n";
        }
        separador();
        $opcion = menu();
        break;
        

    case 5: 
        separador();
        $superaCapacidad = $objViaje[$indexViaje]->superaCapacidad();
        if($superaCapacidad){
            echo "Ingrese cuantos pasajeros nuevos ingresaran al viaje: ";
            $pasajerosNuevos = trim(fgets(STDIN));
            $cantidadAumentada = $objViaje[$indexViaje]->cantidadPasajeros() + $pasajerosNuevos;
            if($cantidadAumentada <= $objViaje[$indexViaje]->getCantidadMax()){
                for($i=0;$i < $pasajerosNuevos;$i++){
                    echo "Ingrese el nombre del nuevo pasajero: ";
                    $nombrePasajero = trim(fgets(STDIN));
                    echo "Ingrese el apellido del nuevo pasajero: ";
                    $apellidoPasajero = trim(fgets(STDIN));
                    echo "Ingrese el DNI del nuevo pasajero: ";
                    $dniPasajero = trim(fgets(STDIN));
                    $pasajero = ["nombre"=> $nombrePasajero,"apellido"=> $apellidoPasajero,"documento"=>$dniPasajero];
                    $objViaje[$indexViaje]->agregarPasajero($pasajero);
                }
                echo "Los pasajeros se agregaron correctamente al viaje!"."\n";
            }else{
                echo "La cantidad de pasajeros es superior a la capacidad maxima!"."\n";
            }
        }else{
            echo "El vuelo ya esta lleno!"."\n";
        }
        separador();
        $opcion = menu();
        break;
        

    case 6: 
        separador();
        echo "ingrese el DNI del pasajero que desea eliminar: ";
        $dni = trim(fgets(STDIN));
        if($objViaje[$indexViaje]->existePasajero($dni)){
            $objViaje[$indexViaje]->quitarPasajero($dni);
            echo "El pasajero se elimino correctamente!"."\n";
        }else{
            echo "El DNI no coincide con ningun pasajero del vuelo"."\n";
        }
        separador();
        $opcion = menu();
        break;
        

    case 7: 
        separador();
        echo "ingrese el DNI del pasajero que desea buscar: ";
        $dni = trim(fgets(STDIN));
        if($objViaje[$indexViaje]->existePasajero($dni)){
            echo "Los datos datos del pasajero ".$dni." son:"."\n";
            verUnPasajero($objViaje[$indexViaje],$dni);
        }
        separador();
        $opcion = menu();
        break;


    case 8: 
        separador();
        echo "ingrese el nuevo destino: ";
        $nuevoDestino = trim(fgets(STDIN));
        $objViaje[$indexViaje]->setDestino($nuevoDestino);
        echo "El destino se ha cambiado correctamente!"."\n";
        separador();
        $opcion = menu();
        break;


    case 9: 
        separador();
        echo "ingrese la nueva capacidad del viaje: ";
        $nuevaCapacidad = trim(fgets(STDIN));
        while(is_numeric($nuevaCapacidad) == false){
            echo "El valor ".$nuevaCapacidad." no es correcto, Por favor ingrese numeros: ";
            $nuevaCapacidad = trim(fgets(STDIN));
        }
        $objViaje[$indexViaje]->setCantidadMax($nuevaCapacidad);
        echo "La capacidad se ha cambiado correctamente!"."\n";
        separador();
        $opcion = menu();
        break;


    case 10: 
        separador();
        echo "ingrese el nuevo codigo del viaje: ";
        $nuevoCodigo = trim(fgets(STDIN));
        $objViaje[$indexViaje]->setCodigoViaje($nuevoCodigo);
        echo "El codigo se ha cambiado correctamente!"."\n";
        separador();
        $opcion = menu();
        break;


    case 11: 
        $indexViaje = viajeModificar($objViaje);
        $opcion = menu();
        break;


    case 12: 
        separador();
        echo "Ingrese la cantidad de viajes que desea agregar: ";
        $cant = trim(fgets(STDIN));
        $cant = verificadorInt($cant);
        $nuevosViajes = creaViajes($cant);
        $objViaje = array_merge($objViaje, $nuevosViajes);
        separador();
        $opcion = menu();
        break;


    case 13: 
        separador();
        echo "Ingrese el codigo del viaje que desea eliminar: ";
        $codigo = trim(fgets(STDIN));
        $existe = existeViaje($objViaje, $codigo);
        if(!$existe){
            $index = buscarViaje($objViaje, $codigo);
            unset($objViaje[$index]);
            sort($objViaje);
        }else{
            echo "el codigo ingresado no coicide con ningun viaje!"."\n";
        }
        separador();
        $opcion = menu();
        break;


    case 14: 
        separador();
        echo "Los viajes creados son: "."\n";
        mostrarViajes($objViaje);
        $opcion = menu();
        break;


    default: 
        echo "El número que ingresó no es válido, por favor ingrese un número del 0 al 12"."\n"."\n";
        $opcion = menu();
        break;
    }
} while ($opcion < 0 || $opcion > 0);
exit();
?>