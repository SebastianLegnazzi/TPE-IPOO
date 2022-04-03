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
    // int $menu
    echo "\n"."MENU DE OPCIONES"."\n";
    echo "1) Crear un viaje."."\n";
    echo "2) Saber la cantidad de pasajeros."."\n";
    echo "3) Ver los pasajeros del viaje."."\n";
    echo "4) Ver datos del viaje."."\n";
    echo "5) Modificar los datos de un pasajero."."\n";
    echo "6) Agregar un pasajero al viaje."."\n";
    echo "7) Eliminar un pasajero del viaje."."\n";
    echo "8) Ver datos de un pasajero"."\n";
    echo "9) Salir"."\n";
    echo "Opcion: ";
    $menu = trim(fgets(STDIN));
    echo "\n";
    return $menu;
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
        echo "ingrese el nombre del pasajero ".($i+1).": ";
        $nombrePasajero =  trim(fgets(STDIN));
        echo "ingrese el apellido del pasajero ".($i+1).": ";
        $apellidoPasajero =  trim(fgets(STDIN));
        echo "ingrese el DNI del pasajero".($i+1).": ";
        $dniPasajero =  trim(fgets(STDIN));
        echo "\n";
        $arrayPersonas[$i] = ["nombre"=> $nombrePasajero,"apellido"=> $apellidoPasajero,"dni"=>$dniPasajero];
    }
    return $arrayPersonas;
}




/**************************************/
/********* PROGRAMA PRINCIPAL *********/
/**************************************/


//Este programa ejecuta segun la opcion elegida del usuario la secuencia de pasos a seguir
$opcion = menu();
do {
switch ($opcion) { //Según lo visto en clase, switch es una instrucción de estructura de control alternativa, ya que, es similar a la instrucción IF
    
    case 1: 
        echo "Ingrese el codigo del viaje: ";
        $codigoViaje = trim(fgets(STDIN));
        echo "Ingrese el destino del viaje: ";
        $destViaje = trim(fgets(STDIN));
        echo "Ingrese la cantidad de personas maximas que pueden realizar el viaje: ";
        $cantMax = trim(fgets(STDIN));
        echo "Ingrese la cantidad de personas que realizaran el viaje: ";
        $cantPersonas = trim(fgets(STDIN));
        $personas = personasViaje($cantPersonas);
        $objViaje = new Viaje($personas,$cantMax,$destViaje,$codigoViaje);
        echo "El viaje se ha creado correctamente!"."\n";
        $opcion = menu();
        break;


    case 2: 
        echo "la cantidad de pasajeros del viaje ".$objViaje->getDestino()." es: ".$objViaje->cantidadPasajeros()."\n";
        $opcion = menu();
        break;


    case 3: 
        echo "Las personas del viaje ".$objViaje->getDestino()." son: "."\n";
        $objViaje->verPasajeros();
        $opcion = menu();
        break;

        
    case 4: 
        echo "Los datos del viaje ".$objViaje->getDestino()." son: "."\n";
        echo $objViaje."\n";
        $opcion = menu();
        break;
       
        
    case 5: 
        "Ingrese el DNI de que pasajero desea cambiar el dato: ";
        $dni = trim(fgets(STDIN));
        "Ingrese que dato desea cambiar (nombre/apellido/DNI): ";
        $tipoDatoCambiar = strtolower(trim(fgets(STDIN)));
        "Ingrese el nuevo dato: ";
        $nuevoValor = trim(fgets(STDIN));
        $objViaje->cambiarDatoPasajero($dni,$datoACambiar,$nuevoValor);
        echo "El dato se ha modificado correctamente!"."\n";
        $opcion = menu();
        break;
        

    case 6: 
        $superaCapacidad = $objViaje->superaCapacidad();
        if($superaCapacidad){
            echo "ingrese el nombre del nuevo pasajero: ";
            $nombrePasajero = trim(fgets(STDIN));
            echo "Ingrese el apellido del nuevo pasajero: ";
            $apellidoPasajero = trim(fgets(STDIN));
            echo "Ingrese el DNI del nuevo pasajero: ";
            $dniPasajero = trim(fgets(STDIN));
            $pasajero = ["nombre"=> $nombrePasajero,"apellido"=> $apellidoPasajero,"dni"=>$dniPasajero];
            $objViaje->agregarPasajero($pasajero);
            echo "El pasajero se agrego correctamente al viaje!"."\n";
        }else{
            echo "El vuelo ya esta lleno!"."\n";
        }
        $opcion = menu();
        break;
        

    case 7: 
        echo "ingrese el DNI del pasajero que desea eliminar: ";
        $dni = trim(fgets(STDIN));
        if($objViaje->existePasajero($dni)){
            $objViaje->quitarPasajero($dni);
            echo "El pasajero se elimino correctamente!"."\n";
        }else{
            echo "El DNI no coincide con ningun pasajero del vuelo"."\n";
        }
        $opcion = menu();
        break;
        

    case 8: 
        echo "ingrese el DNI del pasajero que desea eliminar: ";
        $dni = trim(fgets(STDIN));
        if($objViaje->existePasajero($dni)){
            echo "Los datos datos del pasajero ".$dni." son:"."\n";
            $objViaje->verUnPasajero($dni);
        }
        $opcion = menu();
        break;


    default: 
        echo "El número que ingresó no es válido, por favor ingrese un número del 1 al 9"."\n"."\n";
        $opcion = menu();
        break;
    }
} while ($opcion < 9 || $opcion > 9);
exit();


?>