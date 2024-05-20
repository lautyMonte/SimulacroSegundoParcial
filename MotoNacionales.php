<?php
class MotoNacionales extends Moto{
    private $descuento;

	public function __construct($codigo,$precio,$anioFabricacion,$descripcion,$incrementoAnual,$activa,$descuento) {
        parent::__construct($codigo,$precio,$anioFabricacion,$descripcion,$incrementoAnual,$activa);
		$this->descuento = $descuento;
	}

    public function getDescuento(){
        return $this->descuento;
    }


    //propias del tipo
    public function __toString(){
        $cadena=parent::__toString();

        $cadena.="\nDescuento: ".$this->getDescuento();
        return $cadena;
    }

    public function darPrecioVenta(){
        $venta=parent::darPrecioVenta();
        if($venta>0){
            $venta=$venta-($venta*($this->getDescuento()/100));
        }
        return $venta;
    }
}
?>