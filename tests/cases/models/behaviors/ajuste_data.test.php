<?php

App::import('Core', 'Model');
App::import('Behavior', 'CakePtbr.AjusteData');

class CakePtbrNoticia extends Model {

	var $name = 'Noticia';
	var $useTable = false;

}

class CakePtbrNoticiaSemNada extends CakePtbrNoticia {

	var $name = 'CakePtbrNoticiaSemNada';
	var $actsAs = array('CakePtbr.AjusteData');

}

class CakePtbrNoticiaString extends CakePtbrNoticia {

	var $name = 'CakePtbrNoticiaString';
	var $actsAs = array('CakePtbr.AjusteData' => 'data');

}

class CakePtbrNoticiaArrayVazio extends CakePtbrNoticia {

	var $name = 'CakePtbrNoticiaArrayVazio';
	var $actsAs = array('CakePtbr.AjusteData' => array());

}

class CakePtbrNoticiaArrayComCampo extends CakePtbrNoticia {

	var $name = 'CakePtbrNoticiaArrayComCampo';
	var $actsAs = array('CakePtbr.AjusteData' => array('data'));

}

class CakePtbrNoticiaArrayComCampos extends CakePtbrNoticia {

	var $name = 'CakePtbrNoticiaArrayComCampos';
	var $actsAs = array('CakePtbr.AjusteData' => array('data', 'publicado'));
}

class CakePtbrAjusteData extends CakeTestCase {

	var $_envio = array(
		'id' => 1,
		'nome' => 'Teste',
		'data' => '20/03/2009',
		'data_falsa' => '30/01/2009',
		'publicado' => '01/01/2010'
	);

	function testSemNada() {
		$esperado = array(
			'CakePtbrNoticiaSemNada' => array(
				'id' => 1,
				'nome' => 'Teste',
				'data' => '20/03/2009',
				'data_falsa' => '30/01/2009',
				'publicado' => '01/01/2010'
			)
		);
		$this->_testModel('CakePtbrNoticiaSemNada', $esperado);
	}

	function testString() {
		$esperado = array(
			'CakePtbrNoticiaString' => array(
				'id' => 1,
				'nome' => 'Teste',
				'data' => '2009-03-20',
				'data_falsa' => '30/01/2009',
				'publicado' => '01/01/2010'
			)
		);
		$this->_testModel('CakePtbrNoticiaString', $esperado);
	}

	function testArrayVazio() {
		$esperado = array(
			'CakePtbrNoticiaArrayVazio' => array(
				'id' => 1,
				'nome' => 'Teste',
				'data' => '20/03/2009',
				'data_falsa' => '30/01/2009',
				'publicado' => '01/01/2010'
			)
		);
		$this->_testModel('CakePtbrNoticiaArrayVazio', $esperado);
	}

	function testArrayComCampo() {
		$esperado = array(
			'CakePtbrNoticiaArrayComCampo' => array(
				'id' => 1,
				'nome' => 'Teste',
				'data' => '2009-03-20',
				'data_falsa' => '30/01/2009',
				'publicado' => '01/01/2010'
			)
		);
		$this->_testModel('CakePtbrNoticiaArrayComCampo', $esperado);
	}

	function testArrayComCampos() {
		$esperado = array(
			'CakePtbrNoticiaArrayComCampos' => array(
				'id' => 1,
				'nome' => 'Teste',
				'data' => '2009-03-20',
				'data_falsa' => '30/01/2009',
				'publicado' => '2010-01-01'
			)
		);
		$this->_testModel('CakePtbrNoticiaArrayComCampos', $esperado);
	}

	function _testModel($nomeModel, $esperado) {
		$Model = new $nomeModel();
		$Model->create();
		$Model->save(array($nomeModel => $this->_envio));
		$this->assertEqual($Model->data, $esperado);
	}

}

?>