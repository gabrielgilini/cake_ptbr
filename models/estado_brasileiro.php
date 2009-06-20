<?php
/**
 * Model com as informações dos estados brasileiros
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

class EstadoBrasileiro extends AppModel {

	var $name = 'EstadoBrasileiro';
	var $useTable = false;

	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct();

		App::import('Vendor', 'CakePtbr.Estados');
		$this->_estados = Estados::lista();
	}

	function find($conditions = null, $fields = array(), $order = null, $recursive = null) {
		if (is_string($conditions)) {
			switch ($conditions) {
				case 'list':
					return $this->listaEstados();
				case 'all':
					return $this->todosEstados();
			}
		}
		return false;
	}

	function listaEstados($incluirDF = true) {
		if ($incluirDF) {
			return $this->_estados;
		}
		$estados = $this->_estados;
		unset($estados['DF']);
		return $estados;
	}

	function todosEstados($incluirDF = true) {
		$estados = array('EstadoBrasileiro' => array());
		foreach ($this->_estados as $sigla => $nome) {
			if (!$incluirDF && $sigla === 'DF') {
				continue;
			}
			$estados['EstadoBrasileiro'][] = array(
				'sigla' => $sigla,
				'nome' => $nome
			);
		}
		return $estados;
	}

	function estadoPorSigla($sigla) {
		if (isset($this->_estados[$sigla])) {
			return $this->_estados[$sigla];
		}
		return false;
	}

	function siglaPorEstado($estado) {
		if ($sigla = array_search($estado, $this->_estados)) {
			return $sigla;
		}
		return false;
	}

	function estadosDoSul() {
		return $this->_estadosPorRegiao(array('PR', 'RS', 'SC'));
	}

	function estadosDoSudeste() {
		return $this->_estadosPorRegiao(array('ES', 'MG', 'RJ', 'SP'));
	}

	function estadosDoCentroOeste($incluirDF = true) {
		if ($incluirDF) {
			return $this->_estadosPorRegiao(array('DF', 'GO', 'MT', 'MS'));
		}
		return $this->_estadosPorRegiao(array('GO', 'MT', 'MS'));
	}

	function estadosDoNorte() {
		return $this->_estadosPorRegiao(array('AC', 'AP', 'AM', 'PA', 'RO', 'RR', 'TO'));
	}

	function estadosDoNordeste() {
		return $this->_estadosPorRegiao(array('AL', 'BA', 'CE', 'MA', 'PB', 'PI', 'PE', 'RN', 'SE'));
	}

	function _estadosPorRegiao($estados) {
		$retorno = array();
		foreach ($estados as $estado) {
			$retorno[$estado] = $this->_estados[$estado];
		}
		return $retorno;
	}

}

?>