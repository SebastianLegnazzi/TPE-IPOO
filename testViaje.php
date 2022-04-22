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
    $arrayViajes = creaViajes($cantViajes);
    return $arrayViajes;
}


/**
 * Este modulo crea un array con todos los viajes que el usuario desea ingresar
 * @param int $cant
 * @return array
 */
function creaViajes($cant)
{
    $arrayViajes = [];
    $arrayPasajeros = [];
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
            for($i = 0;$i < $cantPersonas;$i++){
            $objPasajero = personasViaje();
            array_push($arrayPasajeros, $objPasajero);
            }
            $arrayViajes[$i] = new Viaje($responsable,$arrayPasajeros,$cantMax,$destViaje,$codigoViaje);
            echo "El viaje se ha creado correctamente!"."\n";
        }else{
            echo "La cantidad de personas supera a la cantidad maxima del viaje!"."\n";
        }
    }
    return $arrayViajes;  
}


/**
 * Busca el index del viaje con el que va a realizar las operaciones
 * @param array $viajes
 * @return int
 */
function viajeModificar($viajes)
{
    separador();
    echo "los viajes son: "."\n";
    foreach($viajes as $viaje){
        echo "El codigo del viaje con destino a ".$viaje->getDestino()." es: ".$viaje->getCodigoViaje()."\n";
    }
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
 * Retorna un objPerosna con todos los datos del pasajero del viaje
 * @return object
 */
function personasViaje()
{
    echo "ingrese el nombre del pasajero: ";
    $nombrePasajero =  trim(fgets(STDIN));
    echo "ingrese el apellido del pasajero: ";
    $apellidoPasajero =  trim(fgets(STDIN));
    echo "ingrese el DNI del pasajero: ";
    $dniPasajero =  trim(fgets(STDIN));
    echo "ingrese el telefono del pasajero: ";
    $telefonoPasajero =  trim(fgets(STDIN));
    echo "\n";
    $objPersona = new Pasajero($nombrePasajero,$apellidoPasajero,$dniPasajero,$telefonoPasajero);
    return $objPersona;
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

/**
 * Este modulo cambia datos del array Pasajeros
 * @param object $viaje
 */
function cambiarDatoPasajero($viaje, $dni)
{
    do{
        echo "Ingrese que dato desea cambiar: "."\n".
             "1. Modificar Nombre "."\n".
             "2. Modificar Apellido "."\n".
             "3. Modificar Telefono "."\n".
             "4. Ver datos "."\n".
             "5. Salir "."\n";
        $seleccion = trim(fgets(STDIN));
        switch ($seleccion){
            case 1: 
                separador();
                echo "Ingrese el nuevo nombre: "; 
                $nuevoNombre = trim(fgets(STDIN));
                $viaje->cambiarDatoPasajero($dni, $seleccion, $nuevoNombre);
                echo "El nombre se ha cambiado correctamente!"."\n";
                separador();
                break;

            case 2: 
                separador();
                echo "Ingrese el nuevo apellido: "; 
                $nuevoApellido = trim(fgets(STDIN));
                $viaje->cambiarDatoPasajero($dni, $seleccion, $nuevoApellido);
                echo "El apellido se ha cambiado correctamente!"."\n";
                separador();
                break;

            case 3: 
                separador();
                echo "Ingrese el nuevo Telefono: "; 
                $nuevoTelefono = trim(fgets(STDIN));
                $viaje->cambiarDatoPasajero($dni, $seleccion, $nuevoTelefono);
                echo "El telefono se ha cambiado correctamente!"."\n";
                separador();
                break;

            case 4: 
                separador();
                echo $viaje->buscarPasajero($dni);
                separador();
                break;

            default:
            echo "El número que ingresó no es válido, por favor ingrese un número del 1 al 5"."\n"."\n";
            break;
                
        }
        }while($seleccion < 5 || $seleccion > 5);
}

/**
 * Este modulo cambia los datos del responsable del vuelo
 * @param object $viaje
 */
function cambiarDatoResponsable($viaje)
{
    do{
        echo "Ingrese que dato desea cambiar: "."\n".
             "1. Modificar Nombre "."\n".
             "2. Modificar Apellido "."\n".
             "3. Modificar Numero de Empleado "."\n".
             "4. Modificar Numero de Licencia "."\n".
             "5. Ver datos "."\n".
             "6. Salir "."\n";
        $seleccion = trim(fgets(STDIN));
        switch ($seleccion){
            case 1: 
                separador();
                echo "Ingrese el nuevo nombre: "; 
                $nuevoNombre = trim(fgets(STDIN));
                $viaje->cambiarDatoResponsable($seleccion, $nuevoNombre);
                echo "El nombre se ha cambiado correctamente!"."\n";
                separador();
                break;

            case 2: 
                separador();
                echo "Ingrese el nuevo apellido: "; 
                $nuevoApellido = trim(fgets(STDIN));
                $viaje->cambiarDatoResponsable($seleccion, $nuevoApellido);
                echo "El apellido se ha cambiado correctamente!"."\n";
                separador();
                break;

            case 3: 
                separador();
                echo "Ingrese el nuevo numero de empleado: "; 
                $nuevoNumEmpleado = trim(fgets(STDIN));
                $viaje->cambiarDatoResponsable($seleccion, $nuevoNumEmpleado);
                echo "El numero de empleado se ha cambiado correctamente!"."\n";
                separador();
                break;

            case 4: 
                separador();
                echo "Ingrese el nuevo numero de licencia: "; 
                $nuevoNumLicencia = trim(fgets(STDIN));
                $viaje->cambiarDatoResponsable($seleccion, $nuevoNumLicencia);
                echo "El numero de licencia se ha cambiado correctamente!"."\n";
                separador();
                break;

            case 5: 
                separador();
                echo $viaje->getResponsableV();
                separador();
                break;

            default:
            echo "El número que ingresó no es válido, por favor ingrese un número del 1 al 6"."\n"."\n";
            break;
                
        }
        }while($seleccion < 6 || $seleccion > 6);
}

/**************************************/
/******** VIAJES PRECARGADOS **********/
/**************************************/

//Viaje 1
$arrayPersonas = [new Pasajero("Paula","Lopez",4020310,29946879),
                new Pasajero("Mariano","Martinez",4687955,29946879),
                new Pasajero("Juan","Legnazzi",3801546,29945879)];
$arrayViajes[0] = new Viaje(new ResponsableV("Pablo","Orejas",516464,787554),$arrayPersonas,20,"Neuquen",1);
//Viaje 2
$arrayPersonas = [new Pasajero("Sebastian","Legnazzi",4397918,299646879),
                new Pasajero("Alejandra","Alegre",2546548,299564787)];
$arrayViajes[1] = new Viaje(new ResponsableV("Felipe","Ortega",516778,55554),$arrayPersonas,30,"Misiones",2);
//Viaje 3
$arrayPersonas = [new Pasajero("Martina","Laurel",3533646,299566477),
                new Pasajero("Mauricio","Lamelin",4343458,29948997)];
$arrayViajes[2] = new Viaje(new ResponsableV("Chano","Tanbionica",121254,64684),$arrayPersonas,50,"Buenos Aires",3);

/**************************************/
/********* PROGRAMA PRINCIPAL *********/
/**************************************/

//Este programa ejecuta segun la opcion elegida del usuario la secuencia de pasos a seguir
$indexViaje = viajeModificar($arrayViajes);
$opcion = menu();
do {
switch ($opcion) {
    
    // Agregue mas viajes
    case 1: 
        separador();
        echo "Ingrese la cantidad de viajes que desea agregar: ";
        $cant = trim(fgets(STDIN));
        $cant = verificadorInt($cant);
        $nuevosViajes = creaViajes($cant);
        $arrayViajes = array_merge($arrayViajes, $nuevosViajes);
        separador();
        $opcion = menu();
        break;

    // Saber la cantidad de pasajeros
    case 2: 
        separador();
        echo "la cantidad de pasajeros del viaje ".$arrayViajes[$indexViaje]->getDestino()." es: ".$arrayViajes[$indexViaje]->cantidadPasajeros()."\n";
        separador();
        $opcion = menu();
        break;

    // Ver los pasajeros y datos del viaje
    case 3: 
        separador();
        echo "Las personas y datos del viaje ".$arrayViajes[$indexViaje]->getDestino()." son: "."\n";
        echo $arrayViajes[$indexViaje];
        separador();
        $opcion = menu();
        break;
        
    // Modificar los datos de un pasajero
    case 4: 
        separador();
        echo "Ingrese el DNI de que pasajero desea cambiar el dato: ";
        $dni = trim(fgets(STDIN));
        if($arrayViajes[$indexViaje]->existePasajero($dni)){
            cambiarDatoPasajero($arrayViajes[$indexViaje], $dni);
            echo "Los datos se han cambiado correctamente!"."\n";
        }else{
            echo "El DNI del pasajero ingresado no existe!"."\n";
        }
        separador();
        $opcion = menu();
        break;
        
    // Agregar un pasajeros al viaje
    case 5: 
        separador();
        $superaCapacidad = $arrayViajes[$indexViaje]->superaCapacidad();
        if($superaCapacidad){
            echo "Ingrese cuantos pasajeros nuevos ingresaran al viaje: ";
            $cantPasajerosNuevos = trim(fgets(STDIN));
            $cantPasajerosNuevos = verificadorInt($cantPasajerosNuevos);
            $cantidadAumentada = $arrayViajes[$indexViaje]->cantidadPasajeros() + $cantPasajerosNuevos;
            if($cantidadAumentada <= $arrayViajes[$indexViaje]->getCantidadMax()){
                for($i = 0;$i < $cantPasajerosNuevos;$i++){
                    $objPasajero = personasViaje();
                    $arrayViajes[$indexViaje]->agregarPasajero($objPasajero);
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
        
    // Eliminar un pasajero del viaje
    case 6: 
        separador();
        echo "ingrese el DNI del pasajero que desea eliminar: ";
        $dni = trim(fgets(STDIN));
        if($arrayViajes[$indexViaje]->existePasajero($dni)){
            $arrayViajes[$indexViaje]->quitarPasajero($dni);
        }else{
            echo "El DNI no coincide con ningun pasajero del vuelo"."\n";
        }
        separador();
        $opcion = menu();
        break;
        
    // Modificar responsable viaje
    case 7: 
        separador();
        cambiarDatoResponsable($arrayViajes[$indexViaje]);
        separador();
        $opcion = menu();
        break;

    // Ver datos de un pasajero
    case 8: 
        separador();
        echo "ingrese el DNI del pasajero que desea buscar: ";
        $dni = trim(fgets(STDIN));
        if($arrayViajes[$indexViaje]->existePasajero($dni)){
            echo "Los datos datos del pasajero ".$dni." son:"."\n";
            echo $arrayViajes[$indexViaje]->verUnPasajero($dni);
        }
        separador();
        $opcion = menu();
        break;

    // Cambiar destino del viaje
    case 9: 
        separador();
        echo "ingrese el nuevo destino: ";
        $nuevoDestino = trim(fgets(STDIN));
        $arrayViajes[$indexViaje]->setDestino($nuevoDestino);
        echo "El destino se ha cambiado correctamente!"."\n";
        separador();
        $opcion = menu();
        break;

    // Cambiar capacidad maxima del viaje
    case 10: 
        separador();
        echo "ingrese la nueva capacidad del viaje: ";
        $nuevaCapacidad = trim(fgets(STDIN));
        while(is_numeric($nuevaCapacidad) == false){
            echo "El valor ".$nuevaCapacidad." no es correcto, Por favor ingrese numeros: ";
            $nuevaCapacidad = trim(fgets(STDIN));
        }
        $arrayViajes[$indexViaje]->setCantidadMax($nuevaCapacidad);
        echo "La capacidad se ha cambiado correctamente!"."\n";
        separador();
        $opcion = menu();
        break;

    // Cambiar codigo del viaje
    case 11: 
        separador();
        echo "ingrese el nuevo codigo del viaje: ";
        $nuevoCodigo = trim(fgets(STDIN));
        $arrayViajes[$indexViaje]->setCodigoViaje($nuevoCodigo);
        echo "El codigo se ha cambiado correctamente!"."\n";
        separador();
        $opcion = menu();
        break;

    // Modificar otro viaje
    case 12: 
        $indexViaje = viajeModificar($arrayViajes);
        $opcion = menu();
        break;

    // Elimina un viaje
    case 13: 
        separador();
        echo "Ingrese el codigo del viaje que desea eliminar: ";
        $codigo = trim(fgets(STDIN));
        $existe = existeViaje($arrayViajes, $codigo);
        if(!$existe){
            $index = buscarViaje($arrayViajes, $codigo);
            unset($arrayViajes[$index]);
            sort($arrayViajes);
        }else{
            echo "el codigo ingresado no coicide con ningun viaje!"."\n";
        }
        separador();
        $opcion = menu();
        break;

    // Ver todos los viajes
    case 14: 
        separador();
        echo "Los viajes creados son: "."\n";
        mostrarViajes($arrayViajes);
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