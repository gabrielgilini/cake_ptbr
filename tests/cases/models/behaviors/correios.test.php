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

App::import('Core', 'Model');
App::import('Behavior', 'CakePtbr.Correios');

class CakePtbr extends Model {

/**
 * Nome da model
 *
 * @var string
 * @access public
 */
	var $name = 'CakePtbr';

/**
 * Usar tabela?
 *
 * @var boolean
 * @access public
 */
	var $useTable = false;

/**
 * Lista de Behaviors
 *
 * @var array
 * @access public
 */
	var $actsAs = array('CakePtbr.Correios');
}


class CorreiosBehaviorTest extends CorreiosBehavior {

/**
 * Conectado
 *
 * @var boolean
 * @access public
 */
	var $conectado = true;

/**
 * Valor do frete
 *
 * @var array
 * @access protected
 */
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

/**
 * Endereço
 *
 * @var array
 * @access protected
 */
	var $_endereco = array(
		'logradouro' => 'Rua Acadêmico Reinaldo Consoni',
		'bairro' => 'Santa Mônica',
		'cidade' => 'Florianópolis',
		'uf' => 'SC'
	);

/**
 * Cálculo do valor do frete
 *
 * @param object $model
 * @param integer $servico Código do serviço, ver as defines CORREIOS_*
 * @param string $cepOrigem CEP de origem no formato XXXXX-XXX
 * @param string $cepDestino CEP de destino no formato XXXXX-XXX
 * @param float $peso Peso do pacote, em quilos
 * @param boolean $maoPropria Usar recurso de mão própria?
 * @param float $valorDeclarado Valor declarado do pacote
 * @param boolean $avisoRecebimento Aviso de recebimento?
 * @return mixed Array com os dados do frete ou integer com erro. Ver defines ERRO_CORREIOS_* para erros.
 * @access public
 */
	function valorFrete($servico, $cepOrigem, $cepDestino, $peso, $maoPropria = false, $valorDeclarado = 0.0, $avisoRecebimento = false) {
		$model = null;
		$retorno = parent::valorFrete($model, $servico, $cepOrigem, $cepDestino, $peso, $maoPropria, $valorDeclarado, $avisoRecebimento);
		if ($retorno === ERRO_CORREIOS_FALHA_COMUNICACAO) {
			return $this->_valorFrete;
		}
		return $retorno;
	}

/**
 * Pegar o endereço de um CEP específico
 *
 * @param object $model
 * @param string $cep CEP no format XXXXX-XXX
 * @return mixed Array com os dados do endereço ou interger para erro. Ver defines ERRO_CORREIOS_* para os erros.
 * @access public
 */
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

/**
 * Correios
 *
 * @var object
 * @access public
 */
	var $Correios = null;

/**
 * setUp
 *
 * @retun void
 * @access public
 */
	function setUp() {
		parent::setUp();
		$this->Correios = new CorreiosBehaviorTest();
	}

/**
 * testValorFrete
 *
 * @retun void
 * @access public
 */
	function testValorFrete() {
		$this->assertNotEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', 10), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(40000, '88000-000', '88888-000', 10), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', 'peso'), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', -12), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', 10, true, -10), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', 30.5), ERRO_CORREIOS_EXCESSO_PESO);
		// Dados obtidos dia 15/08/2010
		$correios = $this->Correios->valorFrete(CORREIOS_SEDEX, '88037-100', '88037-100', 10, true, 30, false);
		$correto = array(
			'ufOrigem' => 'SC',
			'ufDestino' => 'SC',
			'capitalOrigem' => true,
			'capitalDestino' => true,
			'valorMaoPropria' => 3.5,
			'valorTarifaValorDeclarado' => 0,
			'valorFrete' => 23.4,
			'valorTotal' => 26.9
		);
		$this->assertEqual($correios, $correto);
	}

/**
 * testEndereco
 *
 * @retun void
 * @access public
 */
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
