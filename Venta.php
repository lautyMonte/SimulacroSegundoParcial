<?php
class Venta{
    private $numero;
    private $fecha;
    private $objCliente;
    private $colMotos;
    private $precioFinal;

    public function __construct($numero,$fecha,$unCliente,$colMotos,$precioFinal){
        $this->numero=$numero;
        $this->fecha=$fecha;
        $this->objCliente=$unCliente;
        $this->colMotos=$colMotos;
        $this->precioFinal=$precioFinal;
    }

    //observadores
    public function getNumero(){
     return $this->numero;   
    }

    public function getFecha(){
        return $this->fecha;   
    }
       
    public function getObjCliente(){
        return $this->objCliente;   
    }

    public function getColMotos(){
        return $this->colMotos;   
    }

    public function getPrecioFinal(){
        return $this->precioFinal;   
    }

    //modificadores
    public function setNumero($numero){
        $this->numero=$numero;
    }

    public function setFecha($fecha){
        $this->fecha=$fecha;
    }

    public function setObjCliente($objCliente){
        $this->objCliente=$objCliente;
    }

    public function setColMoto($colMotos){
        $this->colMotos=$colMotos;
    }

    public function setPrecioFinal($precioFinal){
        $this->precioFinal=$precioFinal;
    }

    //propias del tipo
    public function __toString(){
        //no tengo que utilizar implode, creo una funcion aparte,para devolver la coleccion de motos
       /*lo del return esta bien */ 
       return "numero: ".$this->getNumero()."\nfecha: ".$this->getFecha().
        "\ndatos del cliente: \n".$this->getObjCliente().
        "\n<------------motos que se vendieron----------->\n".$this->colMotosAString().
        "\nsu precio final: $".$this->getPrecioFinal().
        "\n<--------------------------------------------->";
    }

    public function colMotosAString(){
        $cadena="";
        $i=1;
        foreach($this->getColMotos() as $unaMoto){
              $cadena.="moto ".$i.$unaMoto."\n\n";
              $i++;  
        }
        return $cadena;
    }


    /**
     * Guarda en la coleccion, la nueva moto que compra el cliente y actualiza el 
     * precio final
     * @param Moto
     */
    public function incorporarMoto($objMoto){
        //esta forma la hizo la profe
        if($objMoto->getActiva()){
            $auxColMoto = $this->getColMotos();
            array_push($auxColMoto,$objMoto);
            $this->setColMoto($auxColMoto);

            $precioNuevaMoto = $objMoto->darPrecioVenta();    
            $nuevoPrecioFinal = $this->getPrecioFinal() + $precioNuevaMoto;
            $this->setPrecioFinal($nuevoPrecioFinal);
        }
    }


    /**
     * Metodo que determina si es el cliente o no de la venta
     * @return boolean
     */
    public function buscarCliente($tipo,$numDoc){
        $cumple=false;
        $auxCliente=$this->getObjCliente();
        if(strcmp($auxCliente->getTipo(),$tipo)==0 & $auxCliente->getDocumento()==$numDoc){
            $cumple=true;
        }
        return $cumple;
    }

    /**
     * Que retorna la sumatoria del precio venta de cada una de las
     * motos Nacionales vinculadas a la venta
     * @return float
     */
    public function retornarTotalVentaNacional(){
        
        $precioNacionales=0;
        foreach($this->getColMotos() as $auxMoto){
            if(is_a($auxMoto,'MotoNacionales')){
                $precioNacionales+=$auxMoto->darPrecioVenta();
            }
        }
        return $precioNacionales;
    }

    /**
     *  Retorna una colección de motos importadas vinculadas a la venta. 
     *  Si la venta solo se corresponde con motos Nacionales la colección retornada debe ser vacía
     * @return array
     */
    public function retornarMotosImportadas(){
        $colMotosImportadas=array();

        foreach($this->getColMotos() as $auxMoto){
            if(is_a($auxMoto,'MotoImportada')){
                array_push($colMotosImportadas,$auxMoto);
            }
        }
        return $colMotosImportadas;
    }


    
}
?>