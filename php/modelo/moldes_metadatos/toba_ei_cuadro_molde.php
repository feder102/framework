<?php
/*
*	
*/
class toba_ei_cuadro_molde extends toba_molde_elemento_componente_ei
{
	protected $clase = 'toba_ei_cuadro';
	protected $columnas;
	protected $proxima_col = 0;
	
	function ini()
	{
		parent::ini();
		$this->datos->tabla('prop_basicas')->nueva_fila(array());
		$this->datos->tabla('prop_basicas')->set_cursor(0);
	}
	
	//---------------------------------------------------
	//-- API de construccion
	//---------------------------------------------------	
	
	function agregar_columna($identificador, $tipo)
	{
		$this->columnas[$identificador] = new toba_molde_cuadro_col($identificador, $tipo);
		$this->columnas[$identificador]->set_orden($this->proxima_col);
		$this->proxima_col++;
		return $this->columnas[$identificador];
	}
	
	function columna($identificador)
	{
		if(!isset($this->columnas[$identificador])) {
			throw new toba_error('Molde cuadro: la columna solicitada no existe');	
		}
		return $this->columnas[$identificador];
	}

	function set_clave($clave)
	{
		if(is_array($clave)){
			$clave = implode(',',$clave);
		}
		$this->datos->tabla('prop_basicas')->set_fila_columna_valor(0,'columnas_clave',$clave);
	}

	//---------------------------------------------------
	//-- Generacion de METADATOS & ARCHIVOS
	//---------------------------------------------------
	
	function generar()
	{
		foreach($this->columnas as $ef) {
		 	$this->datos->tabla('columnas')->nueva_fila($ef->get_datos());
		}
		parent::generar();
	}
}
?>