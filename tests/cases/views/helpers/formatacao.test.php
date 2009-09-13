<?php
/**
 * Testes do helper de formatação
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

App::import('Helper', array('CakePtbr.Formatacao', 'Time', 'Number'));

class CakePtbrFormatacaoCase extends CakeTestCase {

	var $Formatacao = null;

	function setUp() {
		parent::setUp();
		$this->Formatacao = new FormatacaoHelper();
		$this->Formatacao->Time = new TimeHelper();
		$this->Formatacao->Number = new NumberHelper();
	}

	/* Data */

	function testData() {
		$this->assertEqual($this->Formatacao->data(), date('d/m/Y'));
		$this->assertEqual($this->Formatacao->data(strtotime('2009-04-21')), '21/04/2009');
	}

	function testDataHora() {
		$this->assertEqual($this->Formatacao->dataHora(), date('d/m/Y H:i:s'));
		$this->assertEqual($this->Formatacao->dataHora(null, false), date('d/m/Y H:i'));
		$this->assertEqual($this->Formatacao->dataHora(strtotime('2009-04-21 10:20:30')), '21/04/2009 10:20:30');
		$this->assertEqual($this->Formatacao->dataHora(strtotime('2009-04-21 10:20:30'), false), '21/04/2009 10:20');
	}

	function testDataCompleta() {
		$this->assertEqual($this->Formatacao->dataCompleta(), date('l, d \d\e F \d\e Y, H:i:s'));
		//$this->assertEqual($this->Formatacao->dataCompleta(strtotime('2009-04-21 10:20:30')), 'Terça-feira, 21 de abril de 2009, 10:20:30');
	}

	/* Números */

	function testPrecisao() {
		$this->assertEqual($this->Formatacao->precisao(-10), '-10,000');
		$this->assertEqual($this->Formatacao->precisao(0), '0,000');
		$this->assertEqual($this->Formatacao->precisao(10), '10,000');
		$this->assertEqual($this->Formatacao->precisao(10.323), '10,323');
		$this->assertEqual($this->Formatacao->precisao(10.56486), '10,565');
		$this->assertEqual($this->Formatacao->precisao(10.56486, 2), '10,56');
		$this->assertEqual($this->Formatacao->precisao(10.56486, 0), '11');
	}

	function testPorcentagem() {
		$this->assertEqual($this->Formatacao->porcentagem(-10), '-10,00%');
		$this->assertEqual($this->Formatacao->porcentagem(0), '0,00%');
		$this->assertEqual($this->Formatacao->porcentagem(10), '10,00%');
		$this->assertEqual($this->Formatacao->porcentagem(10, 1), '10,0%');
		$this->assertEqual($this->Formatacao->porcentagem(10.123), '10,12%');
		$this->assertEqual($this->Formatacao->porcentagem(10, 0), '10%');
	}

	function testMoeda() {
		$this->assertEqual($this->Formatacao->moeda(-10), '(R$ 10,00)');
		$this->assertEqual($this->Formatacao->moeda(-10.12), '(R$ 10,12)');
		$this->assertEqual($this->Formatacao->moeda(-0.12), '(R$ 0,12)');
		$this->assertEqual($this->Formatacao->moeda(0), 'R$ 0,00');
		$this->assertEqual($this->Formatacao->moeda(0.5), 'R$ 0,50');
		$this->assertEqual($this->Formatacao->moeda(0.52), 'R$ 0,52');
		$this->assertEqual($this->Formatacao->moeda(10), 'R$ 10,00');
		$this->assertEqual($this->Formatacao->moeda(10.12), 'R$ 10,12');
	}

	function testMoedaPorExtenso() {
		$this->assertEqual($this->Formatacao->moedaPorExtenso(0), 'zero');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(0.52), 'cinquenta e dois centavos');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(1), 'um real');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(1.2), 'um real e vinte centavos');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(10), 'dez reais');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(15), 'quinze reais');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(25), 'vinte e cinco reais');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(40), 'quarenta reais');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(100), 'cem reais');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(105), 'cento e cinco reais');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(120), 'cento e vinte reais');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(210), 'duzentos e dez reais');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(322), 'trezentos e vinte e dois reais');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(1234), 'um mil duzentos e trinta e quatro reais');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(100000), 'cem mil reais');
		$this->assertEqual($this->Formatacao->moedaPorExtenso(1045763), 'um milhão, quarenta e cinco mil setecentos e sessenta e três reais');
	}
}

?>