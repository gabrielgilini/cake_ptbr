<?php
/**
 * Behavior de acesso a serviços dos Correios
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

// Tipo de frete
define('CORREIOS_SEDEX', 40010);
define('CORREIOS_SEDEX_A_COBRAR', 40045);
define('CORREIOS_SEDEX_10', 40215);
define('CORREIOS_SEDEX_HOJE', 40290);
define('CORREIOS_E_SEDEX', 81019);
define('CORREIOS_ENCOMENDA_NORMAL', 41017);
define('CORREIOS_PAC', 41106);

// Erros
define('ERRO_CORREIOS_PARAMETROS_INVALIDOS', -1000);
define('ERRO_CORREIOS_EXCESSO_PESO', -1001);
define('ERRO_CORREIOS_FALHA_COMUNICACAO', -1002);
define('ERRO_CORREIOS_CONTEUDO_INVALIDO', -1003);

App::import('Behavior', 'CakePtbr.Validacao');
App::import('Core', array('HttpSocket', 'Xml'));

class CorreiosBehavior extends ModelBehavior {

	function valorFrete(&$model, $servico, $cepOrigem, $cepDestino, $peso, $maoPropria = false, $valorDeclarado = 0.0, $avisoRecebimento = false) {
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
		$retornoCorreios = trim($HttpSocket->get($uri));
		if ($HttpSocket->response['status']['code'] != 200) {
			return ERRO_CORREIOS_FALHA_COMUNICACAO;
		}
		$Xml = new Xml($retornoCorreios);
		$infoCorreios = $Xml->toArray();
		if (!isset($infoCorreios['CalculoPrecos']['DadosPostais'])) {
			return ERRO_CORREIOS_CONTEUDO_INVALIDO;
		}
		extract($infoCorreios['CalculoPrecos']['DadosPostais']);
		return array(
			'ufOrigem' => $uf_origem,
			'ufDestino' => $uf_destino,
			'capitalOrigem' => ($local_origem == 'Capital'),
			'capitalDestino' => ($local_destino == 'Capital'),
			'valorMaoPropria' => $mao_propria,
			'valorTarifaValorDeclarado' => $tarifa_valor_declarado,
			'valorFrete' => ($preco_postal - $tarifa_valor_declarado - $mao_propria),
			'valorTotal' => $preco_postal
		);
	}

	function endereco(&$model, $cep) {
		$Validacao = new ValidacaoBehavior();
		if (!$Validacao->_cep($cep, '-')) {
			return ERRO_CORREIOS_PARAMETROS_INVALIDOS;
		}

		// Requisição
		$HttpSocket = new HttpSocket();
		$uri = array(
			'scheme' => 'http',
			'host' => 'www.correios.com.br',
			'port' => 80,
			'path' => '/encomendas/prazo/prazo.cfm',
		);
		$data = array(
			'resposta' => 'paginaCorreios',
			'servico' => CORREIOS_SEDEX,
			'cepOrigem' => $cep,
			'cepDestino' => $cep,
			'peso' => 1,
			'MaoPropria' => 'N',
			'valorDeclarado' => 0,
			'avisoRecebimento' => 'N',
			'Altura' => '',
			'Comprimento' => '',
			'Diametro' => '',
			'Formato' => 1,
			'Largura' => '',
			'embalagem' => 116600055,
			'valorD' => ''
		);
		$retornoCorreios = $HttpSocket->post($uri, $data);
		if ($HttpSocket->response['status']['code'] != 200) {
			return ERRO_CORREIOS_FALHA_COMUNICACAO;
		}

		// Convertendo para o encoding da aplicação. Isto só funciona se a extensão multibyte estiver ativa
		$encoding = Configure::read('App.encoding');
		if (function_exists('mb_convert_encoding') && $encoding != null && strcasecmp($encoding, 'iso-8859-1') != 0) {
			$retornoCorreios = mb_convert_encoding($retornoCorreios, $encoding, 'ISO-8859-1');
		}
		// Checar se o conteúdo está lá e reduzir o escopo de busca dos valores
		if (!preg_match('/\<b\>CEP:\<\/b\>(.*)\<b\>Prazo de Entrega/', $retornoCorreios, $matches)) {
			return ERRO_CORREIOS_CONTEUDO_INVALIDO;
		}
		$escopoReduzido = $matches[1];
		// Logradouro
		preg_match('/\<b\>Endere&ccedil;o:\<\/b\>\s*\<\/td\>\s*\<td[^\>]*>([^\<]*)\</', $escopoReduzido, $matches);
		$logradouro = $matches[1];
		// Bairro
		preg_match('/\<b\>Bairro:\<\/b\>\s*\<\/td\>\s*\<td[^\>]*>([^\<]*)\</', $escopoReduzido, $matches);
		$bairro = $matches[1];
		// Cidade e Estado
		preg_match('/\<b\>Cidade\/UF:\<\/b\>\s*\<\/td\>\s*\<td[^\>]*>([^\<]*)\</', $escopoReduzido, $matches);
		list($cidade, $uf) = explode('/', $matches[1]);

		return compact('logradouro', 'bairro', 'cidade', 'uf');
	}

}

?>