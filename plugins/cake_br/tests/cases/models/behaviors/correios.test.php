<?php

App::import('Behavior', 'CakeBr.Correios');

class CakeBrCorreiosCase extends CakeTestCase {

	var $Correios = null;

	function startTest() {
		$this->Correios = new CorreiosBehavior();
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
		$correios = $this->Correios->valorFrete(CORREIOS_SEDEX, '88037-100', '88037-100', 10, true, 30, false);
		$correto = array(
			'ufOrigem' => 'SC',
			'ufDestino' => 'SC',
			'capitalOrigem' => true,
			'capitalDestino' => true,
			'valorMaoPropria' => 3.3,
			'valorTarifaValorDeclarado' => 0,
			'valorFrete' => 22.5,
			'valorTotal' => 25.8
		);
		$this->assertEqual($correios, $correto);
	}

}

?>