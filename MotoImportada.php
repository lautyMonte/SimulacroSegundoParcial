<?php
class MotoImportada extends Moto{
    private $paisImporta;
    private $importe;

	public function __construct($codigo,$precio,$anioFabricacion,$descripcion,$incrementoAnual,$activa,$paisImporta, $importe) {
        parent::__construct($codigo,$precio,$anioFabricacion,$descripcion,$incrementoAnual,$activa);
		$this->paisImporta = $paisImporta;
		$this->importe = $importe;
	}

    //observadores
	public function getPaisImporta() {
		return $this->paisImporta;
	}

	public function getImporte() {
		return $this->importe;
	}

    //modificadores
    public function setPaisImporta($paisImporta) {
		$this->paisImporta = $paisImporta;
	}

	public function setImporte($importe) {
		$this->importe = $importe;
	}

    //propias del tipo
    public function __toString(){
        $cadena=parent::__toString();

        $cadena.="\nPais desde el que se importa: ".$this->getPaisImporta();
        $cadena.="\nImporte correspondiente: ".$this->getImporte();
        return $cadena;
    }

    public function darPrecioVenta(){
        $venta=parent::darPrecioVenta();
        if($venta>0){
            $venta=$venta+$this->getImporte();
        }
        return $venta;
    }

}
?>