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
    echo "1) Agregue mas viajes."."\n";
    echo "2) Saber la cantidad de pasajeros."."\n";
    echo "3) Ver los pasajeros y datos del viaje."."\n";
    echo "4) Modificar los datos de un pasajero."."\n";
    echo "5) Agregar un pasajeros al viaje."."\n";
    echo "6) Eliminar un pasajero del viaje."."\n";
    echo "7) Ver datos de un pasajero"."\n";
    echo "8) Cambiar destino del viaje."."\n";
    echo "9) Cambiar capacidad maxima del viaje."."\n";
    echo "10) Cambiar codigo del viaje."."\n";
    echo "11) Modificar otro viaje."."\n";
    echo "12) Elimina un viaje."."\n";
    echo "13) Ver todos los viajes."."\n";
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
    $i = 1;
    foreach($viajes as $viaje){
        separador();
        echo "Viaje: ".($i)."\n";
        echo $viaje."\n";
        separador();
        $i++;
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

/**************************************/
/********* PROGRAMA PRINCIPAL *********/
/**************************************/


//Este programa ejecuta segun la opcion elegida del usuario la secuencia de pasos a seguir
$arrayPersonas = [["nombre"=> "Juan","apellido"=> "Lope","documento"=>42594711],
                ["nombre"=> "Paula","apellido"=> "Peralta","documento"=>45454545],
                ["nombre"=> "Maria","apellido"=> "Monjita","documento"=>3251515],
                ["nombre"=> "Camila","apellido"=> "Rodriguez","documento"=>2541556],
                ["nombre"=> "Franco","apellido"=> "Stefano","documento"=>45646411],
                ["nombre"=> "Sebastian","apellido"=> "Legnazzi","documento"=>32454945]];
$objViaje[0] = new Viaje($arrayPersonas,20,"Neuquen","NQN");
$indexViaje = 0;
$opcion = menu();
do {
switch ($opcion) {
    
    case 1: 
        separador();
        echo "Ingrese la cantidad de viajes que desea agregar: ";
        $cant = trim(fgets(STDIN));
        $cant = verificadorInt($cant);
        $nuevosViajes = creaViajes($cant);
        $objViaje = array_merge($objViaje, $nuevosViajes);
        separador();
        $opcion = menu();
        break;

    case 2: 
        separador();
        echo "la cantidad de pasajeros del viaje ".$objViaje[$indexViaje]->getDestino()." es: ".$objViaje[$indexViaje]->cantidadPasajeros()."\n";
        separador();
        $opcion = menu();
        break;


    case 3: 
        separador();
        echo "Las personas y datos del viaje ".$objViaje[$indexViaje]->getDestino()." son: "."\n";
        echo $objViaje[$indexViaje];
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
            echo $objViaje[$indexViaje]->verUnPasajero($dni);
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


    case 13: 
        separador();
        echo "Los viajes creados son: "."\n";
        mostrarViajes($objViaje);
        $opcion = menu();
        break;


    default: 
        echo "El número que ingresó no es válido, por favor ingrese un número del 0 al 13"."\n"."\n";
        $opcion = menu();
        break;
    }
} while ($opcion < 0 || $opcion > 0);
exit();
?>