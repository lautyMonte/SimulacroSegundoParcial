<?php
class Empresa{
    private $denominacion;
    private $direccion;
    private $colCliente;
    private $colMotos;
    private $colVentas;

    public function __construct($denominacion,$direccion,$colCliente,$colMotos,$colVentas){
        $this->denominacion=$denominacion;
        $this->direccion=$direccion;
        $this->colCliente=$colCliente;
        $this->colMotos=$colMotos;
        $this->colVentas=$colVentas;
    }

    //observadores
    public function getDenominacion(){
        return $this->denominacion;
    }

    public function getDireccion(){
        return $this->direccion;
    }

    public function getColCliente(){
        return $this->colCliente;
    }

    public function getColMotos(){
        return $this->colMotos;
    }

    public function getColVentas(){
        return $this->colVentas;
    }

    //modificadores
    public function setDenominacion($denominacion){
        $this->denominacion=$denominacion;
    }

    public function setDireccion($direccion){
        $this->direccion=$direccion;
    }

    public function setColCliente($colCliente){
        $this->colCliente=$colCliente;
    }

    public function setColMotos($colMotos){
        $this->colMotos=$colMotos;
    }

    public function setColVentas($colVentas){
        $this->colVentas=$colVentas;
    }

    //propias del tipo
    public function __toString(){
        $clientes=$this->getColCliente();
        $motos=$this->getColMotos();
        $ventas=$this->getColVentas();
        
        return "denominacion: ".$this->getDenominacion()."\ndireccion: ".$this->getDireccion().
        "\n<---------------coleccion de clientes------------------>\n".$this->colAtributosAString($clientes).
        "\n\n<----------------motos en la sucursal---------------->\n".$this->colAtributosAString($motos).
        "\n\n<----------------ventas realizadas------------------->\n".$this->colAtributosAString($ventas);
    }

    public function colAtributosAString($coleccion){
        $cadena="";
        foreach($coleccion as $unElementoCol){
              $cadena.=$unElementoCol."\n";
        }
        return $cadena;
    }



    /**
     * Busca la moto cuyo codigo coincide con el recibido por parametro
     * @param int
     * @return Moto
     */
    public function retornarMoto($codigoMoto){
        $encontrado=false;
        $i=0;
        $motoEncontrada=null;
        $cantMotos=count($this->getColMotos());
        while(!$encontrado && $i<$cantMotos){
            $motoAux=$this->getColMotos()[$i];
            if($motoAux->getCodigo()==$codigoMoto){
                $encontrado=true;
                $motoEncontrada=$motoAux;
            }else{
                $i++;
            }
        }
        return $motoEncontrada;
    }

    /**
     * Por cada codigo que encuentra incorporara esa moto a la coleccion que esta en ventas
     * creando una nueva instancia venta
     * @param array
     * @param Cliente
     * @return int
     */
    public function registrarVenta($colCodigosMoto,$objCliente){
        $importeFinal = 0;
        $arrMotos = array();
        if (!$objCliente->dadoDeBajaCliente()) {
            $numVenta = random_int(1, 999);
            $fecha = date("d/m/y");
            $nuevaVenta = new Venta($numVenta, $fecha, $objCliente, $arrMotos, 0);
            foreach ($colCodigosMoto as $unCodigoMoto) {
                $motoEncontrada = $this->retornarMoto($unCodigoMoto); //obtiene una moto, que la empresa esta vendiendo
                if ($motoEncontrada != null) {
                    $nuevaVenta->incorporarMoto($motoEncontrada);
                }
            }

            $importeFinal = $nuevaVenta->getPrecioFinal();
            $aux = $this->getColVentas();
            array_push($aux, $nuevaVenta);
            $this->setColVentas($aux);
        }
        
        return $importeFinal;
    }

    /** 
     * Retorna una coleccion con las ventas realizadas al cliente
     * @param String
     * @param int
     * @return Venta
    */
    public function retornarVentasXCliente($tipo,$numDoc){
        $i=0;
        $colVentaCliente=array();
        foreach($this->getColVentas() as $auxVenta){
            if($auxVenta->buscarCliente($tipo,$numDoc)){
                $colVentaCliente[$i]=$auxVenta;
                $i++;
            }
        }
        return $colVentaCliente;
    }

    /**
     * Recorre la colección de ventas realizadas por la empresa y 
     * retorna el importe total de ventas Nacionales realizadas por la empresa
     * @return float
     */
    public function informarSumaVentasNacionales(){
        $importeTotal=0;
        foreach($this->getColVentas() as $auxVenta){
            $importeTotal=$importeTotal+$auxVenta->retornarTotalVentaNacional();
        }
        return $importeTotal;
    }

    /**
     * Recorre la colección de ventas realizadas por la empresa y 
     * retorna una colección de ventas de motos importadas. 
     * Si en la venta al menos una de las motos es importada la venta debe ser informada
     * @return array
     */
    public function informarVentasImportadas(){
        $MotosImportadas=array();
        $i=0;
        foreach($this->getColVentas() as $auxVenta){
            $colImportadas=$auxVenta->retornarMotosImportadas();
            if($colImportadas!=null){
                $MotosImportadas[$i]=$colImportadas;
                $i++;
            }
        }
        return $MotosImportadas;
    }
}
?>