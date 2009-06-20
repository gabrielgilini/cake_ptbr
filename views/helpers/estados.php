<?php
/**
 * Helper para exibir os estados brasileiros
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

class EstadosHelper extends AppHelper {

	var $helpers = array('Form');

	function select($fieldName, $selected = null, $attributes = array(), $showEmpty = false) {
		App::import('Vendor', 'CakePtbr.Estados');
		$options = Estados::lista();
		if (isset($attributes['uf']) && $attributes['uf'] === true) {
			$estados = array_keys($options);
			$options = array_combine($estados, $estados);
			unset($attributes['uf']);
		}
		return $this->Form->select($fieldName, $options, $selected, $attributes, $showEmpty);
	}
}

?>