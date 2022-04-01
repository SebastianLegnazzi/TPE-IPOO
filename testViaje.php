<?php
include "Viaje.php";

$pasajero = [
            ["nombre" => "Fran","apellido"=> "Stefano","documento"=> 41484978],
            ["nombre" => "Tita","apellido"=> "TicTac","documento"=> 40390293],
            ["nombre" => "Sebastian","apellido"=> "Legnazzi","documento"=> 43947118]
            ];
$objViaje = new Viaje($pasajero,);


?>