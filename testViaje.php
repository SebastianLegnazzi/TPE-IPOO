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
    echo ") Salir"."\n";
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
        echo "ingrese el nombre del pasajero";
        $nombrePasajero =  trim(fgets(STDIN));
        echo "ingrese el apellido del pasajero";
        $apellidoPasajero =  trim(fgets(STDIN));
        echo "ingrese el DNI del pasajero";
        $dniPasajero =  trim(fgets(STDIN));
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
        $menu = seleccionarOpcion();
        break;


    case 2: 

        $menu = seleccionarOpcion();
        break;


    case 3: 

        $menu = seleccionarOpcion();
        break;

        
    case 4: 

        $menu = seleccionarOpcion();
        break;
       
        
    case 5: 

        $menu = seleccionarOpcion();
        break;
        

    case 6: 

        $menu = seleccionarOpcion();
        break;
        

    default: 
        echo "El número que ingresó no es válido, por favor ingrese un número del 1 al 7"."\n"."\n";
        $menu = seleccionarOpcion();
    break;
    }
} while ($menu < 7 || $menu > 7);
exit();


?>