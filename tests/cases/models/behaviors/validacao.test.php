<?php
/**
 * Teste do Behavior de validaчуo
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

App::import('Behavior', 'CakePtbr.Validacao');

class CakePtbrValidacaoCase extends CakeTestCase {

	var $Validacao = null;

	function setUp() {
		parent::setUp();
		$this->Validacao = new ValidacaoBehavior();
	}

	function testCPF() {
		$validos = array(
			'22692173813',
			'50549727302',
			'21861338651',
			'74567904699',
			'44985137464'
		);
		$validosFormatados = array(
			'869.283.422-00',
			'843.701.734-34',
			'323.188.174-99',
			'655.338.112-73',
			'804.342.163-30'
		);
		$invalidos = array(
			'22692173811',
			'50549727322',
			'21861338633',
			'74567904644',
			'44985137455',
			'453423422321',
			'12'
		);
		$invalidosFormatados = array(
			'869.283.422-11',
			'843.701.734-22',
			'323.188.174-33',
			'655.338.112-44',
			'804.342.163-55',
			'4534.2342.2321',
			'8043.4216.330',
			'12'
		);

		foreach ($validos as $cpf) {
			$this->assertTrue($this->Validacao->_cpf($cpf, true));
			$this->assertFalse($this->Validacao->_cpf($cpf, false));
		}
		foreach ($validosFormatados as $cpf) {
			$this->assertTrue($this->Validacao->_cpf($cpf, false));
			$this->assertFalse($this->Validacao->_cpf($cpf, true));
		}
		foreach ($invalidos as $cpf) {
			$this->assertFalse($this->Validacao->_cpf($cpf, true));
			$this->assertFalse($this->Validacao->_cpf($cpf, false));
		}
		foreach ($invalidosFormatados as $cpf) {
			$this->assertFalse($this->Validacao->_cpf($cpf, true));
			$this->assertFalse($this->Validacao->_cpf($cpf, false));
		}
	}

	function testCNPJ() {
		$validos = array(
			'86606851000106',
			'68231454000107',
			'23875227000186',
			'72595043000178',
			'47825154000186'
		);
		$validosFormatados = array(
			'70.373.767/0001-41',
			'52.222.021/0001-55',
			'52.615.723/0001-07',
			'67.288.744/0001-24',
			'72.240.263/0001-89'
		);
		$invalidos = array(
			'86606851000111',
			'68231454000122',
			'23875227000133',
			'72595043000144',
			'47825154000155',
			'4352345452452345',
			'452345324'
		);
		$invalidosFormatados = array(
			'70.373.767/0001-11',
			'52.222.021/0001-22',
			'52.615.723/0001-33',
			'67.288.744/0001-44',
			'72.240.263/0001-55',
			'72.240.263.0001-89',
			'72.240/2630/001.89',
			'047.825.154/0001-86'
		);
		foreach ($validos as $cnpj) {
			$this->assertTrue($this->Validacao->_cnpj($cnpj, true));
			$this->assertFalse($this->Validacao->_cnpj($cnpj, false));
		}
		foreach ($validosFormatados as $cnpj) {
			$this->assertTrue($this->Validacao->_cnpj($cnpj, false));
			$this->assertFalse($this->Validacao->_cnpj($cnpj, true));
		}
		foreach ($invalidos as $cnpj) {
			$this->assertFalse($this->Validacao->_cnpj($cnpj, true));
			$this->assertFalse($this->Validacao->_cnpj($cnpj, false));
		}
		foreach ($invalidosFormatados as $cnpj) {
			$this->assertFalse($this->Validacao->_cnpj($cnpj, true));
			$this->assertFalse($this->Validacao->_cnpj($cnpj, false));
		}
	}

	function testCEP() {
		$this->assertTrue($this->Validacao->_cep('01555-120'));
		$this->assertTrue($this->Validacao->_cep('81555-120'));
		$this->assertTrue($this->Validacao->_cep('81555120'));
		$this->assertTrue($this->Validacao->_cep('01555.120', '.'));
		$this->assertTrue($this->Validacao->_cep('01555.120', array('.')));
		$this->assertTrue($this->Validacao->_cep('01555.120', array('', '.', '-')));

		$this->assertFalse($this->Validacao->_cep('81555.120'));
		$this->assertFalse($this->Validacao->_cep('81555120', '.'));
		$this->assertFalse($this->Validacao->_cep('81555-120', array('.')));
		$this->assertFalse($this->Validacao->_cep('8155120'));
		$this->assertFalse($this->Validacao->_cep('8155-120'));
	}

	function testTelefone() {
		$this->assertTrue($this->Validacao->_telefone('5555-5555', false));
		$this->assertTrue($this->Validacao->_telefone('(55)5555-5555', false));
		$this->assertTrue($this->Validacao->_telefone('(55) 5555-5555', false));
		$this->assertTrue($this->Validacao->_telefone('+55(55)5555-5555', false));
		$this->assertTrue($this->Validacao->_telefone('+55(55) 5555-5555', false));
		$this->assertTrue($this->Validacao->_telefone('+55 (55) 5555-5555', false));
		$this->assertTrue($this->Validacao->_telefone('55555555', true));
		$this->assertTrue($this->Validacao->_telefone('5555555555', true));

		$this->assertFalse($this->Validacao->_telefone('5555-5555', true));
		$this->assertFalse($this->Validacao->_telefone('555555', true));
		$this->assertFalse($this->Validacao->_telefone('5555-55555', false));
		$this->assertFalse($this->Validacao->_telefone('55555-5555', false));
		$this->assertFalse($this->Validacao->_telefone('55.5555-5555', false));
		$this->assertFalse($this->Validacao->_telefone('55555555', false));
		$this->assertFalse($this->Validacao->_telefone('55 (55) 5555-5555', false));
	}

}

?>