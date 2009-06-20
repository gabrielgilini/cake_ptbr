<?php
/**
 * Teste do Model EstadoBrasileiro
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

App::import('Model', 'CakePtbr.EstadoBrasileiro');

class EstadoBrasileiroTestCase extends CakeTestCase {
	var $EstadoBrasileiro = null;

	function start() {
		parent::start();
		$this->EstadoBrasileiro = new EstadoBrasileiro();
	}

	function testInstance() {
		$this->assertTrue(is_a($this->EstadoBrasileiro, 'EstadoBrasileiro'));
	}

	function testFind() {
		$results = $this->EstadoBrasileiro->find('list');
		$this->assertEqual(count($results), 27);

		$results = $this->EstadoBrasileiro->find('all');
		$this->assertTrue(is_array($results['EstadoBrasileiro']));
		$this->assertEqual(count($results['EstadoBrasileiro']), 27);

		$results = $this->EstadoBrasileiro->find('first');
		$this->assertFalse($results);
	}

	function testListaEstados() {
		$results = $this->EstadoBrasileiro->listaEstados();
		$this->assertEqual(count($results), 27);
		$this->assertEqual($results, $this->EstadoBrasileiro->find('list'));
		$this->assertTrue(isset($results['DF']));

		$results = $this->EstadoBrasileiro->listaEstados(false);
		$this->assertEqual(count($results), 26);
		$this->assertFalse(isset($results['DF']));
	}

	function testTodosEstados() {
		$results = $this->EstadoBrasileiro->todosEstados();
		$this->assertTrue(is_array($results['EstadoBrasileiro']));
		$this->assertEqual(count($results['EstadoBrasileiro']), 27);
		$this->assertEqual($results, $this->EstadoBrasileiro->find('all'));

		$results = $this->EstadoBrasileiro->todosEstados(false);
		$this->assertTrue(is_array($results['EstadoBrasileiro']));
		$this->assertEqual(count($results['EstadoBrasileiro']), 26);
	}

	function testEstadoPorSigla() {
		$results = $this->EstadoBrasileiro->estadoPorSigla('SC');
		$this->assertEqual($results, 'Santa Catarina');

		$results = $this->EstadoBrasileiro->estadoPorSigla('SP');
		$this->assertEqual($results, 'São Paulo');
		$this->assertNotEqual($results, 'Sao Paulo');
	}

	function testSiglaPorEstado() {
		$results = $this->EstadoBrasileiro->siglaPorEstado('Santa Catarina');
		$this->assertEqual($results, 'SC');

		$results = $this->EstadoBrasileiro->siglaPorEstado('São Paulo');
		$this->assertEqual($results, 'SP');

		$results = $this->EstadoBrasileiro->siglaPorEstado('Sao Paulo');
		$this->assertFalse($results);
	}

	function testEstadosDoSul() {
		$results = $this->EstadoBrasileiro->estadosDoSul();
		$expected = array(
			'PR' => 'Paraná',
			'RS' => 'Rio Grande do Sul',
			'SC' => 'Santa Catarina'
		);
		$this->assertEqual($results, $expected);
	}

	function testEstadosDoSudeste() {
		$results = $this->EstadoBrasileiro->estadosDoSudeste();
		$expected = array(
			'ES' => 'Espírito Santo',
			'MG' => 'Minas Gerais',
			'RJ' => 'Rio de Janeiro',
			'SP' => 'São Paulo'
		);
		$this->assertEqual($results, $expected);
	}

	function testEstadosDoCentroOeste() {
		$results = $this->EstadoBrasileiro->estadosDoCentroOeste();
		$expected = array(
			'DF' => 'Distrito Federal',
			'GO' => 'Goiás',
			'MT' => 'Mato Grosso',
			'MS' => 'Mato Grosso do Sul'
		);
		$this->assertEqual($results, $expected);

		$results = $this->EstadoBrasileiro->estadosDoCentroOeste(false);
		unset($expected['DF']);
		$this->assertEqual($results, $expected);
	}

	function testEstadosDoNorte() {
		$results = $this->EstadoBrasileiro->estadosDoNorte();
		$expected = array(
			'AC' => 'Acre',
			'AP' => 'Amapá',
			'AM' => 'Amazonas',
			'PA' => 'Pará',
			'RO' => 'Rondônia',
			'RR' => 'Roraima',
			'TO' => 'Tocantins'
		);
		$this->assertEqual($results, $expected);
	}

	function testEstadosDoNordeste() {
		$results = $this->EstadoBrasileiro->estadosDoNordeste();
		$expected = array(
			'AL' => 'Alagoas',
			'BA' => 'Bahia',
			'CE' => 'Ceará',
			'MA' => 'Maranhão',
			'PB' => 'Paraíba',
			'PI' => 'Piauí',
			'PE' => 'Pernambuco',
			'RN' => 'Rio Grande do Norte',
			'SE' => 'Sergipe'
		);
		$this->assertEqual($results, $expected);
	}

}

?>