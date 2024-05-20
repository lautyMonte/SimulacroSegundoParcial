<?php
include 'Cliente.php';
include 'Moto.php';
include 'MotoNacionales.php';
include 'MotoImportada.php';
include 'Venta.php';
include 'Empresa.php';

$objCliente1= new Cliente("Arturo","Hernandez","dado de baja","DNI",34678312);
$objCliente2= new Cliente("Lautaro","Montesino","no esta dado de baja","DNI",44323057);
$colClientes=[$objCliente1,$objCliente2];

$objMoto1=new MotoNacionales(11,2230000,2022,"Benelli Imperiale 400",85,true,10);
$objMoto2=new MotoNacionales(12,584000,2021,"Zanella Zr 150 Ohc",70,true,10);
$objMoto3=new MotoNacionales(13,999900,2023,"Zanella Patagonian Eagle 250",55,false,15);
$objMoto4=new MotoImportada(14,12499900,2020,"Pitbike Enduro Motocross Apollo Aiii 190cc Plr",100,true,"Francia",6244400);
$colMotos=[$objMoto1,$objMoto2,$objMoto3,$objMoto4];

$colVentas=array();

$objEmpresa=new Empresa("Alta Gama","Av Argenetina 123",$colClientes,$colMotos,$colVentas);


echo "Precio del cliente 2 comprando las motos 11,12,13,14\n"."$ ".$objEmpresa->registrarVenta([11,12,13,14],$objCliente2);
echo "\n\nPrecio del cliente 2 comprando las motos 13,14\n"."$ ".$objEmpresa->registrarVenta([13,14],$objCliente2);
echo "\n\nPrecio del cliente 2 comprando las motos 14,2\n"."$ ".$objEmpresa->registrarVenta([14,2],$objCliente2);
echo "\n\n<-----------Informe de motos Importadas----------->\n";
$motosImportadas= $objEmpresa->informarVentasImportadas();
    for($i=0;$i<count($motosImportadas);$i++){
        for($j=0;$j<count($motosImportadas[0]);$j++){
            echo $motosImportadas[$i][$j]->__toString()."\n";
        }
    }
echo "<----------------------------------------------------->";
echo "\nLa cantidad que se obtuvo por las ventas de motos nacionales es de: $".$objEmpresa->informarSumaVentasNacionales();
echo "\n\n<-----------Informacion de la Empresa----------->\n";
echo $objEmpresa;
?>