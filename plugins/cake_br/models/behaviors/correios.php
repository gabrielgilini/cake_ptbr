<?php

// Tipo de frete
define('CORREIOS_SEDEX', 40010);
define('CORREIOS_SEDEX_A_COBRAR', 40045);
define('CORREIOS_SEDEX_10', 40215);
define('CORREIOS_SEDEX_HOJE', 40290);
define('CORREIOS_ENCOMENDA_NORMAL', 41017);

// Erros
define('ERRO_CORREIOS_PARAMETROS_INVALIDOS', -1000);
define('ERRO_CORREIOS_EXCESSO_PESO', -1001);
define('ERRO_CORREIOS_FALHA_COMUNICACAO', -1002);
define('ERRO_CORREIOS_CONTEUDO_INVALIDO', -1003);

App::import('Behavior', 'CakeBr.Validacao');
App::import('Core', array('HttpSocket', 'Xml'));

class CorreiosBehavior extends ModelBehavior {

	function valorFrete($servico, $cepOrigem, $cepDestino, $peso, $maoPropria = false, $valorDeclarado = 0.0, $avisoRecebimento = false) {
		// Validação dos parâmetros
		$tipos = array(CORREIOS_SEDEX, CORREIOS_SEDEX_A_COBRAR, CORREIOS_SEDEX_10, CORREIOS_SEDEX_HOJE, CORREIOS_ENCOMENDA_NORMAL);
		if (!in_array($servico, $tipos)) {
			return ERRO_CORREIOS_PARAMETROS_INVALIDOS;
		}
		$Validacao = new ValidacaoBehavior();
		if (!$Validacao->_cep($cepOrigem, '-') || !$Validacao->_cep($cepDestino, '-')) {
			return ERRO_CORREIOS_PARAMETROS_INVALIDOS;
		}
		if (!is_numeric($peso) || !is_numeric($valorDeclarado)) {
			return ERRO_CORREIOS_PARAMETROS_INVALIDOS;
		}
		if ($peso > 30.0) {
			return ERRO_CORREIOS_EXCESSO_PESO;
		} elseif ($peso < 0.0) {
			return ERRO_CORREIOS_PARAMETROS_INVALIDOS;
		}
		if ($valorDeclarado < 0.0) {
			return ERRO_CORREIOS_PARAMETROS_INVALIDOS;
		}

		// Ajustes nos parâmetros
		if ($maoPropria) {
			$maoPropria = 'S';
		} else {
			$maoPropria = 'N';
		}
		if ($avisoRecebimento) {
			$avisoRecebimento = 'S';
		} else {
			$avisoRecebimento = 'N';
		}

		// Requisição
		$HttpSocket = new HttpSocket();
		$uri = array(
			'scheme' => 'http',
			'host' => 'www.correios.com.br',
			'port' => 80,
			'path' => '/encomendas/precos/calculo.cfm',
			'query' => array(
				'resposta' => 'xml',
				'servico' => $servico,
				'cepOrigem' => $cepOrigem,
				'cepDestino' => $cepDestino,
				'peso' => $peso,
				'MaoPropria' => $maoPropria,
				'valorDeclarado' => $valorDeclarado,
				'avisoRecebimento' => $avisoRecebimento
			)
		);
		$retornoCorreios = $HttpSocket->get($uri);
		if ($HttpSocket->response['status']['code'] != 200) {
			return ERRO_CORREIOS_FALHA_COMUNICACAO;
		}
		$Xml = new Xml($retornoCorreios);
		$infoCorreios = $Xml->toArray();
		if (!isset($infoCorreios['calculo_precos']['dados_postais'])) {
			return ERRO_CORREIOS_CONTEUDO_INVALIDO;
		}
		return $infoCorreios['calculo_precos']['dados_postais'];
	}

}

?>