<?php

class AjusteDataBehavior extends ModelBehavior {

	var $campos;

	function setup(&$model, $config = array()) {
		if (empty($config)) {
			// Caso não seja informado os campos, ele irá buscar no schema
			$this->campos[$model->name] = $this->_buscaCamposDate($model);
		} elseif (!is_array($config)) {
			$this->campos[$model->name] = array($config);
		} else {
			$this->campos[$model->name] = $config;
		}
	}

	function beforeSave(&$model) {
		$data =& $model->data[$model->name];
		foreach ($this->campos[$model->name] as $campo) {
			if (isset($data[$campo]) && preg_match('/\d{1,2}\/\d{1,2}\/\d{2,4}/', $data[$campo])) {
				list($dia, $mes, $ano) = explode('/', $data[$campo]);
				if (strlen($ano) == 2) {
					if ($ano > 50) {
						$ano += 1900;
					} else {
						$ano += 2000;
					}
				}
				$data[$campo] = "$ano-$mes-$dia";
			}
		}
		return true;
	}

	function _buscaCamposDate(&$model) {
		if (!is_array($model->_schema)) {
			return array();
		}
		$saida = array();
		foreach ($model->_schema as $campo => $infos) {
			if ($infos['type'] == 'date' && !in_array($campo, array('created', 'updated', 'modified'))) {
				$saida[] = $campo;
			}
		}
		return $saida;
	}
}

?>