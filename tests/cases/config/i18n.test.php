<?php
/**
 * Testes das funções de internacionalização
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

class CakePtbrI18nCase extends CakeTestCase {

	function testCore() {
		$this->assertEqual(__('Missing Component File', true), 'Arquivo de Component não encontrado');
		$this->assertEqual(__d('default', 'Missing Database', true), 'Database não encontrado');
	}
}

?>