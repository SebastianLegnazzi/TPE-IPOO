<?php
include "Viaje.php";
include "Pasajero.php";
include "ResponsableV.php";

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
    echo "7) Modificar responsable viaje"."\n";
    echo "8) Ver datos de un pasajero"."\n";
    echo "9) Cambiar destino del viaje."."\n";
    echo "10) Cambiar capacidad maxima del viaje."."\n";
    echo "11) Cambiar codigo del viaje."."\n";
    echo "12) Modificar otro viaje."."\n";
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
        $responsable = responsableViaje();
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
            $objViajes[$i] = new Viaje($responsable,$personas,$cantMax,$destViaje,$codigoViaje);
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
 * Retorna el responsable del vuelo
 * @return object
 */
function responsableViaje()
{
    separador();
    echo "ingrese el nombre del responsable: ";
    $nombreResp =  trim(fgets(STDIN));
    echo "ingrese el apellido del responsable: ";
    $apellidoResp =  trim(fgets(STDIN));
    echo "ingrese el numero de empleado del responsable: ";
    $numEmpleadoResp =  trim(fgets(STDIN));
    echo "ingrese el numero de licencia del responsable: ";
    $numLincenciaResp =  trim(fgets(STDIN));
    separador();
    echo "\n";
    $responsableV = new ResponsableV($nombreResp,$apellidoResp,$numEmpleadoResp,$numLincenciaResp);
    return $responsableV;
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
        echo "ingrese el telefono del pasajero ".($i+1).": ";
        $telefonoPasajero =  trim(fgets(STDIN));
        separador();
        echo "\n";
        $arrayPersonas[$i] = new Pasajero($nombrePasajero,$apellidoPasajero,$dniPasajero,$telefonoPasajero);
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
$arrayPersonas = [new Pasajero("Paula","Lopez",4020310,29946879),
                new Pasajero("Mariano","Martinez",4687955,29946879),
                new Pasajero("Sebastian","Legnazzi",4397918,299646879),
                new Pasajero("Alejandra","Alegre",2546548,299564787),
                new Pasajero("Martina","Laurel",3533646,299566477),
                new Pasajero("Mauricio","Lamelin",4343458,29948997)];
$objViaje[0] = new Viaje(new ResponsableV("Pablo","Orejas",516464,787554),$arrayPersonas,20,"Neuquen","NQN");
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
            echo "El DNI del pasajero ingresado no existe!"."\n";
        }
        separador();
        $opcion = menu();
        break;
        

    case 5: 
        separador();
        $superaCapacidad = $objViaje[$indexViaje]->superaCapacidad();
        if($superaCapacidad){
            echo "Ingrese cuantos pasajeros nuevos ingresaran al viaje: ";
            $cantPasajerosNuevos = trim(fgets(STDIN));
            verificadorInt($cantPasajerosNuevos);
            $cantidadAumentada = $objViaje[$indexViaje]->cantidadPasajeros() + $cantPasajerosNuevos;
            if($cantidadAumentada <= $objViaje[$indexViaje]->getCantidadMax()){
                $arrayPasajeros = personasViaje($cantPasajerosNuevos);
                $objViaje[$indexViaje]->agregarPasajero($arrayPasajeros);
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
        echo "Ingrese que dato desea cambiar (Nombre/Apellido/Numero Empleado/Numero Licencia/Todo): ";
        $tipoDatoCambiar = strtolower(trim(fgets(STDIN)));
        while(($tipoDatoCambiar <> "nombre") && ($tipoDatoCambiar <> "apellido") && ($tipoDatoCambiar <> "numero empleado") && ($tipoDatoCambiar <> "numero licencia") && ($tipoDatoCambiar <> "todo")){
            echo "El valor ".$tipoDatoCambiar." no es correcto, Por favor ingrese (Nombre/Apellido/Numero Empleado/Numero Licencia/Todo): ";
            $tipoDatoCambiar = trim(fgets(STDIN));
        }
        if($tipoDatoCambiar == "todo"){
            echo "Ingrese el nombre: ";
            $nombre = trim(fgets(STDIN));
            echo "Ingrese el apellido: ";
            $apellido = trim(fgets(STDIN));
            echo "Ingrese el Numero de Empleado: ";
            $numEmpleado = trim(fgets(STDIN));
            echo "Ingrese el Numero de Licencia: ";
            $numLicencia = trim(fgets(STDIN));
            echo "los datos se han modificado correctamente!"."\n";
            $objViaje[$indexViaje]->setResponsableV(new ResponsableV($nombre,$apellido,$numEmpleado,$numLicencia));
        }else{
            echo "Ingrese el nuevo dato: ";
            $nuevoValor = trim(fgets(STDIN));
            $objViaje[$indexViaje]->cambiarDatoResponsable($tipoDatoCambiar,$nuevoValor);
            echo "El dato se ha modificado correctamente!"."\n";
        }
        separador();
        $opcion = menu();
        break;

    case 8: 
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


    case 9: 
        separador();
        echo "ingrese el nuevo destino: ";
        $nuevoDestino = trim(fgets(STDIN));
        $objViaje[$indexViaje]->setDestino($nuevoDestino);
        echo "El destino se ha cambiado correctamente!"."\n";
        separador();
        $opcion = menu();
        break;


    case 10: 
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


    case 11: 
        separador();
        echo "ingrese el nuevo codigo del viaje: ";
        $nuevoCodigo = trim(fgets(STDIN));
        $objViaje[$indexViaje]->setCodigoViaje($nuevoCodigo);
        echo "El codigo se ha cambiado correctamente!"."\n";
        separador();
        $opcion = menu();
        break;


    case 12: 
        $indexViaje = viajeModificar($objViaje);
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
        echo "El número que ingresó no es válido, por favor ingrese un número del 0 al 14"."\n"."\n";
        $opcion = menu();
        break;
    }
} while ($opcion < 0 || $opcion > 0);
exit();
?>