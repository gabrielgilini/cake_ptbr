<?php
/**
 * Teste do behavior dos Correios
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

App::import('Behavior', 'CakePtbr.Correios');

class CorreiosBehaviorTest extends CorreiosBehavior {

	var $conectado = true;
	var $_valorFrete = array(
		'ufOrigem' => 'SC',
		'ufDestino' => 'SC',
		'capitalOrigem' => true,
		'capitalDestino' => true,
		'valorMaoPropria' => 0,
		'valorTarifaValorDeclarado' => 0,
		'valorFrete' => 22.5,
		'valorTotal' => 22.5
	);

	var $_endereco = array(
		'logradouro' => 'Rua Acadêmico Reinaldo Consoni',
		'bairro' => 'Santa Mônica',
		'cidade' => 'Florianópolis',
		'uf' => 'SC'
	);


	function valorFrete($servico, $cepOrigem, $cepDestino, $peso, $maoPropria = false, $valorDeclarado = 0.0, $avisoRecebimento = false) {
		$model = null;
		$retorno = parent::valorFrete($model, $servico, $cepOrigem, $cepDestino, $peso, $maoPropria, $valorDeclarado, $avisoRecebimento);
		if ($retorno === ERRO_CORREIOS_FALHA_COMUNICACAO) {
			return $this->_valorFrete;
		}
		return $retorno;
	}

	function endereco($cep) {
		$model = null;
		$retorno = parent::endereco($model, $cep);
		if ($retorno === ERRO_CORREIOS_FALHA_COMUNICACAO) {
			return $this->_endereco;
		}
		return $retorno;
	}

}

class CakePtbrCorreiosCase extends CakeTestCase {

	var $Correios = null;

	function setUp() {
		parent::setUp();
		$this->Correios = new CorreiosBehaviorTest();
	}

	function testValorFrete() {
		$this->assertNotEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', 10), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(40000, '88000-000', '88888-000', 10), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000000', '88888-000', 10), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888000', 10), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', 'peso'), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', -12), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', 10, true, -10), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', 30.5), ERRO_CORREIOS_EXCESSO_PESO);
		// Dados obtidos dia 25/04/2009
		$correios = $this->Correios->valorFrete(CORREIOS_SEDEX, '88037-100', '88037-100', 10, true, 30, false);
		$correto = array(
			'ufOrigem' => 'SC',
			'ufDestino' => 'SC',
			'capitalOrigem' => true,
			'capitalDestino' => true,
			'valorMaoPropria' => 0,
			'valorTarifaValorDeclarado' => 0,
			'valorFrete' => 22.5,
			'valorTotal' => 22.5
		);
		$this->assertEqual($correios, $correto);
	}

	function testEndereco() {
		$correios = $this->Correios->endereco('88037-100');
		$correto = array(
			'logradouro' => 'Rua Acadêmico Reinaldo Consoni',
			'bairro' => 'Santa Mônica',
			'cidade' => 'Florianópolis',
			'uf' => 'SC'
		);
		$this->assertEqual($correios, $correto);
	}

}

?>