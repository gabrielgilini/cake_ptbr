<?php

class AjusteFloatBehavior extends ModelBehavior {

	var $floatFields = array();

	function setup(&$model, $config = array()) {
		foreach ($model->_schema as $field => $spec) {
			if ($spec['type'] == 'float') {
				$this->floatFields[$model->alias][] = $field;
			}
		}
	}

	function beforeSave(&$model) {
		$data =& $model->data[$model->alias];
		foreach ($data as $name => $value) {
			if (in_array($name, $this->floatFields[$model->alias])) {
				$data[$name] = str_replace(array('.', ','), array('', '.'), $value);
			}
		}

		return true;
	}

	function afterFind(&$model, $results, $primary) {
		foreach ($results as $key => $r) {
			if (isset($r[$model->alias]) && is_array($r[$model->alias])) {
				foreach (array_keys($r[$model->alias]) as $arrayKey) {
					if (in_array($arrayKey, $this->floatFields[$model->alias])) {
						$results[$key][$model->alias][$arrayKey] = number_format($r[$model->alias][$arrayKey], 2, ',', '.');
					}
				}
			}
		}
		return $results;
	}
}

?>