<?php

App::import('Core', 'Model');
App::import('Behavior', 'CakePtbr.AjusteFloat');

class Produto extends CakeTestModel {
	var $name = 'Produto';
	var $actsAs = array('CakePtbr.AjusteFloat');
}

class CakePtbrAjusteFloat extends CakeTestCase {

	var $fixtures = array('plugin.cake_ptbr.produto');
	var $Produto = null;

	function startTest() {
		$this->Produto =& ClassRegistry::init('Produto');
	}

	function testFind() {
		$result = $this->Produto->find('all');
		$expected = array(
			array(
				'Produto' => array(
					'id' => 1,
					'nome' => 'Produto 1',
					'valor' => '1,99'
				)
			),
			array(
				'Produto' => array(
					'id' => 2,
					'nome' => 'Produto 2',
					'valor' => '1.000,20'
				)
			),
			array(
				'Produto' => array(
					'id' => 3,
					'nome' => 'Produto 3',
					'valor' => '1.999.000,00'
				)
			)
		);
		$this->assertEqual($result, $expected);
	}

	function testSave() {
		$data = array(
			'Produto' => array(
				'nome' => 'Produto 4',
				'valor' => '5.000,00'
			)
		);
		$this->Produto->create();
		$this->assertTrue($this->Produto->save($data));

		$id = $this->Produto->getInsertId();
		$data['Produto']['id'] = $id;
		$result = $this->Produto->read(null, $id);
		$this->assertEqual($data, $result);

		$result = $this->Produto->read(array('valor'), $id);
		$this->assertEqual(array('Produto' => array('valor' => '5.000,00')), $result);

		$result = $this->Produto->read(array('nome'), $id); // Verificar se dá erro quando não vem o campo
		$this->assertEqual(array('Produto' => array('nome' => 'Produto 4')), $result);
	}
}

?>