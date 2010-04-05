<?php

require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . DS . 'vendors' . DS . 'shells' . DS . 'templates' . DS . 'default' . DS . 'inflexao.php';

class InflexaoTest extends CakeTestCase {

	function testAcentos() {
		$this->assertEqual('caminhão', Inflexao::acentos('caminhao'));
		$this->assertEqual('Pão', Inflexao::acentos('Pao'));
		$this->assertEqual('canção', Inflexao::acentos('cancao'));
		$this->assertEqual('canções', Inflexao::acentos('cancoes'));
		$this->assertEqual('limões', Inflexao::acentos('limoes'));
		$this->assertEqual('mães', Inflexao::acentos('maes'));

		$this->assertEqual('joão do caminhão', Inflexao::acentos('joao do caminhao'));
		$this->assertEqual('joão_do_caminhão', Inflexao::acentos('joao_do_caminhao'));
	}

}

?>