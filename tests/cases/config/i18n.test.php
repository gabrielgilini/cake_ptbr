<?php

class CakePtbrI18nCase extends CakeTestCase {

	function testCore() {
		$this->assertEqual(__('Missing Component File', true), 'Arquivo de Component não encontrado');
		$this->assertEqual(__d('default', 'Missing Database', true), 'Database não encontrado');
	}
}

?>