<?php
include "Viaje.php";
include "Pasajero.php";
include "ResponsableV.php";
include "Terrestre.php";
include "Aereo.php";

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
    echo "2) Ver los pasajeros y datos del viaje."."\n";
    echo "3) Modificar los datos de un pasajero."."\n";
    echo "4) Agregar un pasajeros al viaje."."\n";
    echo "5) Eliminar un pasajero del viaje."."\n";
    echo "6) Modificar responsable viaje"."\n";
    echo "7) Ver datos de un pasajero"."\n";
    echo "8) Cambiar destino del viaje."."\n";
    echo "9) Cambiar capacidad maxima del viaje."."\n";
    echo "10) Cambiar codigo del viaje."."\n";
    echo "0) Volver"."\n";
    echo "Opcion: ";
    $menu = trim(fgets(STDIN));
    echo "\n";
    return $menu;
}

/**
 * Muestra el menu de inicio para que el usuario elija y retorna la opcion
 * @return int 
 */
function menuInicio()
{
    echo "\n"."MENU DE OPCIONES"."\n";
    echo "ingrese que desea hacer: "."\n".
    "0. Salir"."\n".
    "1. Vender un viaje"."\n".
    "2. Crear un nuevo Viaje"."\n".
    "3. Ver todos los viajes."."\n".
    "4. Modificar un viaje"."\n".
    "5. Elimina un viaje"."\n";
    echo "Opcion: ";
    $menu = trim(fgets(STDIN));
    echo "\n";
    return $menu;
}
/**
 * Este modulo crea un array con todos los viajes que el usuario desea ingresar
 * @param int $cant
 * @return array
 */
function creaViajes($cant, $tipoViaje)
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
        echo "Ingrese si el viaje es de ida o vuelta ".($i+1)." : ";
        $idaVuelta = strtolower(trim(fgets(STDIN)));
        $idaVuelta = ($idaVuelta == "ida") ? false : true;
        echo "Ingrese el importe del viaje ".($i+1)." : ";
        $importe = trim(fgets(STDIN));
        $importe = verificadorInt($importe);
        if($cantPersonas <= $cantMax){
            for($i = 0;$i < $cantPersonas;$i++){
                $objPasajero = personasViaje();
                array_push($arrayPasajeros, $objPasajero);
            }
        }else{
            echo "La cantidad de personas supera a la cantidad maxima del viaje!"."\n";
        }
        if($tipoViaje == 1){
            echo "Ingrese el tipo de asiento del viaje ".($i)." ('1' para asiento de primera clase / '0' para asiento estandar) : ";
            $tipoAsiento = trim(fgets(STDIN));
            $tipoAsiento = verificadorInt($tipoAsiento);
            echo "Ingrese el numero del vuelo ".($i)."\n";
            $nroVuelo = trim(fgets(STDIN));
            $nroVuelo = verificadorInt($nroVuelo);
            echo "Ingrese el nombre de la aerolinea del vuelo ".($i)."\n";
            $nombreAero = trim(fgets(STDIN));
            echo "Ingrese las escalas del vuelo ".($i)."\n";
            $escalas = trim(fgets(STDIN));
            $escalas = verificadorInt($escalas);
            $arrayViajes[$i] = new Aereo($responsable,$arrayPasajeros,$cantMax,$destViaje,$codigoViaje,$importe,$tipoAsiento,$nroVuelo,$nombreAero,$escalas,$idaVuelta);
            echo "El viaje se ha creado correctamente!"."\n";
        }else{
            echo "Ingrese el tipo de asiento del viaje ".($i)." ('1' para asiento cama o semicama/ '0' para asiento ) : ";
            $tipoAsiento = trim(fgets(STDIN));
            $tipoAsiento = verificadorInt($tipoAsiento);
            $arrayViajes[$i] = new Terrestre($responsable,$arrayPasajeros,$cantMax,$destViaje,$codigoViaje,$importe,$tipoAsiento,$idaVuelta);
            echo "El viaje se ha creado correctamente!"."\n";
        }
    }
    return $arrayViajes;  
}


/**
 * Busca el index del viaje con el que va a realizar las operaciones
 * @param array $viajes
 * @return object
 */
function viajeModificar($viajes)
{
    separador();
    echo "los viajes son: "."\n";
    echo stringObjViajes($viajes);
    echo "Ingrese el codigo del viaje con el que desea interactuar: ";
    $codigo = trim(fgets(STDIN));
    $objViaje = buscarViaje($viajes, $codigo);
    while($objViaje == null){
        echo "El codigo ingresado no existe o esta mal ingresado, Ingreselo nuevamente: "."\n";
        $codigo = trim(fgets(STDIN));
        $objViaje = buscarViaje($viajes, $codigo);
    }
    separador();
    return $objViaje;
}

/**
 * Verifica que tipo de asiento es y devuelve una cadena de caracteres correspondiente
 * @param object $objViaje
 * @return string
 */
function tipoAsientoViaje($objViaje){
    if(($objViaje->getTipoAsiento() == 1) && (get_class($objViaje) == "Aereo")){
        $stringClase = "de primera clase";
    }else if(($objViaje->getTipoAsiento() == 1) && (get_class($objViaje) == "Terrestre")){
        $stringClase = "con asiento tipo cama/semicama";
    }else{
        $stringClase = "tipo estandar";
    }
    return $stringClase;
}

/**
 * Verifica que tipo de vuelo es y devuelve una cadena de caracteres correspondiente
 * @param object $objViaje
 * @return string
 */
function tipoVuelo($objViaje){
    if($objViaje->getIdaVuelta() == true){
        $stringTipo = "ida y vuelta";
    }else{
        $stringTipo = "ida";
    }
    return $stringTipo;
}

/**
 * Devuelve una cadena de caracteres para ver los datos del viaje por pantalla
 * @param array $arrayViajes
 * @return string
 */
function stringObjViajes($arrayViajes){
    $stringViajes = "";
    foreach($arrayViajes as $objViaje){
        $stringTipoAsiento = tipoAsientoViaje($objViaje);
        $tipoVuelo = tipoVuelo($objViaje);
        $stringViajes.="- El codigo del viaje ".get_class($objViaje)." ".$stringTipoAsiento." de tipo ".$tipoVuelo." con destino a ".$objViaje->getDestino()." es: ".$objViaje->getCodigoViaje()."\n";
    }
    return $stringViajes;
}

/**
 * Devuelve true si el viaje existe, false en caso contrario
 * @param array $arrayViajes
 * @param string $codigoViaje
 * @return int
 */
function indexViaje($arrayViajes, $codigoViaje)
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
 * Devuelve en que posicion del $arrayViajes se encuentra el codigo ingresado
 * @param array $arrayViajes
 * @param string $codigoViaje
 * @return object
 */
function buscarViaje($arrayViajes, $codigoViaje)
{
    $dimension = count($arrayViajes);
    $buscarCodigo = true;
    $i = 0;
    $objViaje = null;
    while($buscarCodigo && ($i < $dimension)){
        if(strtolower($arrayViajes[$i]->getCodigoViaje()) == strtolower($codigoViaje)){
            $buscarCodigo = false;
            $objViaje = $arrayViajes[$i];
        }else{
            $i++;
        }
    }
    return $objViaje;
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
        }while($seleccion != 5);
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
        }while($seleccion != 6);
}

function venderBoleto($objPasajero, $arrayViajes){
    $stringObjViajes = stringObjViajes($arrayViajes);
    echo "ingrese el codigo del viaje de ida o ida y vuelta, Las opciones son: "."\n";
    echo $stringObjViajes;
    $codigoDest = trim(fgets(STDIN));
    $objViajeDestino = buscarViaje($arrayViajes, $codigoDest);
    $importe = $objViajeDestino->venderPasaje($objPasajero);
    if($importe != null){
        echo "Compra Realizada!"."\n".
            "importe del viaje es: $".$importe."\n";
    }else{
        echo "El vuelo ".$objViajeDestino()." no existe o no hay lugar"."\n";
    }
}

function opcionesViaje($arrayViajes){
    $objViaje = viajeModificar($arrayViajes);
    $opcion = menu();
    do {
    switch ($opcion) {
        
        // Saber la cantidad de pasajeros
        case 1: 
            separador();
            echo "la cantidad de pasajeros del viaje ".$objViaje->getDestino()." es: ".$objViaje->cantidadPasajeros()."\n";
            separador();
            break;
    
        // Ver los pasajeros y datos del viaje
        case 2: 
            separador();
            echo "Las personas y datos del viaje ".$objViaje->getDestino()." son: "."\n";
            echo $objViaje;
            separador();
            break;

        // Modificar los datos de un pasajero
        case 3: 
            separador();
            echo "Ingrese el DNI de que pasajero desea cambiar el dato: ";
            $dni = trim(fgets(STDIN));
            if($objViaje->existePasajero($dni)){
                cambiarDatoPasajero($objViaje, $dni);
                echo "Los datos se han cambiado correctamente!"."\n";
            }else{
                echo "El DNI del pasajero ingresado no existe!"."\n";
            }
            separador();
            break;
            
        // Agregar un pasajeros al viaje
        case 4: 
            separador();
            $superaCapacidad = $objViaje->hayPasajesDisponible();
            if($superaCapacidad){
                echo "Ingrese cuantos pasajeros nuevos ingresaran al viaje: ";
                $cantPasajerosNuevos = trim(fgets(STDIN));
                $cantPasajerosNuevos = verificadorInt($cantPasajerosNuevos);
                $cantidadAumentada = $objViaje->cantidadPasajeros() + $cantPasajerosNuevos;
                if($cantidadAumentada <= $objViaje->getCantidadMax()){
                    for($i = 0;$i < $cantPasajerosNuevos;$i++){
                        $objPasajero = personasViaje();
                        $objViaje->agregarPasajero($objPasajero);
                    }                
                    echo "Los pasajeros se agregaron correctamente al viaje!"."\n";
                }else{
                    echo "La cantidad de pasajeros es superior a la capacidad maxima!"."\n";
                }
            }else{
                echo "El vuelo ya esta lleno!"."\n";
            }
            separador();
            break;
            
        // Eliminar un pasajero del viaje
        case 5: 
            separador();
            echo "ingrese el DNI del pasajero que desea eliminar: ";
            $dni = trim(fgets(STDIN));
            if($objViaje->existePasajero($dni)){
                $objViaje->quitarPasajero($dni);
            }else{
                echo "El DNI no coincide con ningun pasajero del vuelo"."\n";
            }
            separador();
            break;
            
        // Modificar responsable viaje
        case 6: 
            separador();
            cambiarDatoResponsable($objViaje);
            separador();
            break;
    
        // Ver datos de un pasajero
        case 7: 
            separador();
            echo "ingrese el DNI del pasajero que desea buscar: ";
            $dni = trim(fgets(STDIN));
            if($objViaje->existePasajero($dni)){
                echo "Los datos datos del pasajero ".$dni." son:"."\n";
                echo $objViaje->verUnPasajero($dni);
            }
            separador();
            break;
    
        // Cambiar destino del viaje
        case 8: 
            separador();
            echo "ingrese el nuevo destino: ";
            $nuevoDestino = trim(fgets(STDIN));
            $objViaje->setDestino($nuevoDestino);
            echo "El destino se ha cambiado correctamente!"."\n";
            separador();
            break;
    
        // Cambiar capacidad maxima del viaje
        case 9: 
            separador();
            echo "ingrese la nueva capacidad del viaje: ";
            $nuevaCapacidad = trim(fgets(STDIN));
            while(is_numeric($nuevaCapacidad) == false){
                echo "El valor ".$nuevaCapacidad." no es correcto, Por favor ingrese numeros: ";
                $nuevaCapacidad = trim(fgets(STDIN));
            }
            $objViaje->setCantidadMax($nuevaCapacidad);
            echo "La capacidad se ha cambiado correctamente!"."\n";
            separador();
            break;
    
        // Cambiar codigo del viaje
        case 10: 
            separador();
            echo "ingrese el nuevo codigo del viaje: ";
            $nuevoCodigo = trim(fgets(STDIN));
            $objViaje->setCodigoViaje($nuevoCodigo);
            echo "El codigo se ha cambiado correctamente!"."\n";
            separador();
            break;
    
        default: 
            echo "El número que ingresó no es válido, por favor ingrese un número del 0 al 10"."\n"."\n";
            break;
        }
        $opcion = menu();
    } while ($opcion != 0);
}

/**************************************/
/******** VIAJES PRECARGADOS **********/
/**************************************/

//Viaje 1
$arrayPersonas = [new Pasajero("Paula","Lopez",4020310,29946879),
                new Pasajero("Mariano","Martinez",4687955,29946879),
                new Pasajero("Juan","Legnazzi",3801546,29945879)];
$arrayViajes[0] = new Aereo(new ResponsableV("Pablo","Orejas",516464,787554),$arrayPersonas,20,"Neuquen",1,30000,1,101,"FlyBondi",3,false);
//Viaje 2
$arrayPersonas = [new Pasajero("Sebastian","Legnazzi",4397918,299646879),
                new Pasajero("Alejandra","Alegre",2546548,299564787)];
$arrayViajes[1] = new Aereo(new ResponsableV("Felipe","Ortega",516778,55554),$arrayPersonas,30,"Buenos Aires",2,20000,0,202,"AeroArg",0,true);
//Viaje 3
$arrayPersonas = [new Pasajero("Martina","Laurel",3533646,299566477),
                new Pasajero("Mauricio","Lamelin",4343458,29948997)];
$arrayViajes[2] = new Terrestre(new ResponsableV("Chano","Tanbionica",121254,64684),$arrayPersonas,50,"Buenos Aires",3,20000,1,false);

/**************************************/
/********* PROGRAMA PRINCIPAL *********/
/**************************************/

//Este programa ejecuta segun la opcion elegida del usuario la secuencia de pasos a seguir
do{   
    $seleccion = menuInicio();
    switch($seleccion){
        case 0:
            exit();
        break;
        
        case 1: 
        $objPasajero = personasViaje();
        venderBoleto($objPasajero,$arrayViajes);
        break;

        case 2:
            separador();
            echo "Ingrese '1' si el viaje es Aereo / '2' si el viaje es Terrestre: ";
            $tipoViaje = trim(fgets(STDIN));
            $tipoViaje = verificadorInt($tipoViaje);
            echo "Ingrese la cantidad de viajes que desea agregar: ";
            $cant = trim(fgets(STDIN));
            $cant = verificadorInt($cant);
            $nuevosViajes = creaViajes($cant, $tipoViaje);
            $arrayViajes = array_merge($arrayViajes, $nuevosViajes);
            separador();
        break;

        // Ver todos los viajes
        case 3:
            separador();
            echo "Los viajes creados son: "."\n";
            mostrarViajes($arrayViajes);
        break;

        // Modificar un viaje
        case 4:
            opcionesViaje($arrayViajes);
        break;
        
        // Elimina un viaje
        case 5:
            separador();
            echo "Ingrese el codigo del viaje que desea eliminar: ";
            $codigo = trim(fgets(STDIN));
            $objViaje = buscarViaje($arrayViajes, $codigo);
            if($objViaje != null){
                $index = indexViaje($arrayViajes, $codigo);
                unset($arrayViajes[$index]);
                sort($arrayViajes);
            }else{
                echo "el codigo ingresado no coicide con ningun viaje!"."\n";
            }
            separador();
        break;

        default : 
        echo "El número que ingresó no es válido, por favor ingrese un número del 0 al 5"."\n"."\n";
        break;
    }
}while($seleccion != 0)

?>