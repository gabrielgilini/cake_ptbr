<?php
/**
 * Behavior de validação de CPF, CNPJ, CEP e Telefone
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

class ValidacaoBehavior extends ModelBehavior {

	function cpf($model, $data, $apenasNumeros, $extra = null) {
		if ($extra) {
			return $this->_cpf(current($data), $apenasNumeros);
		} else {
			return $this->_cpf(current($data));
		}
	}

	function _cpf($data, $apenasNumeros = false) {
		// Testar o formato da string
		if ($apenasNumeros) {
			if (!ctype_digit($data) || strlen($data) != 11) {
				return false;
			}
			$numeros = $data;
		} else {
			if (!preg_match('/\d{3}\.\d{3}\.\d{3}-\d{2}/', $data)) {
				return false;
			}
			$numeros = substr($data, 0, 3) . substr($data, 4, 3) . substr($data, 8, 3) . substr($data, 12, 2);
		}
		// Testar se todos os números estão iguais
		for ($i = 0; $i <= 9; $i++) {
			if (str_repeat($i, 11) == $numeros) {
				return false;
			}
		}
		// Testar o dígito verificador
		$dv = substr($numeros, -2);
		for ($pos = 9; $pos <= 10; $pos++) {
			$soma = 0;
			$posicao = $pos + 1;
			for ($i = 0; $i <= $pos - 1; $i++, $posicao--) {
				$soma += $numeros{$i} * $posicao;
			}
			$div = $soma % 11;
			if ($div < 2) {
				$numeros{$pos} = 0;
			} else {
				$numeros{$pos} = 11 - $div;
			}
		}
		$dvCorreto = $numeros{9} * 10 + $numeros{10};
		return $dvCorreto == $dv;
	}

	function cnpj($model, $data, $apenasNumeros, $extra = null) {
		if ($extra) {
			return $this->_cnpj(current($data), $apenasNumeros);
		} else {
			return $this->_cnpj(current($data));
		}
	}

	function _cnpj($data, $apenasNumeros = false) {
		// Testar o formato da string
		if ($apenasNumeros) {
			if (!ctype_digit($data) || strlen($data) != 14) {
				return false;
			}
			$numeros = $data;
		} else {
			if (!preg_match('/\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}/', $data)) {
				return false;
			}
			$numeros = substr($data, 0, 2) . substr($data, 3, 3) . substr($data, 7, 3) . substr($data, 11, 4) . substr($data, 16, 2);
		}
		// Testar o dígito verificador
		for ($pos = 12; $pos <= 13; $pos++) {
			$soma = 0;
			$mult = $pos - 7; // 5 ou 6
			for ($i = 0; $i < $pos; $i++) {
				$soma += $numeros{$i} * $mult--;
				if ($mult === 1) {
					$mult = 9;
				}
			}
			$div = $soma % 11;
			if ($div < 2) {
				$dvCorreto = 0;
			} else {
				$dvCorreto = 11 - $div;
			}
			if ($dvCorreto != $numeros{$pos}) {
				return false;
			}
		}
		return true;
	}

	function cep($model, $data, $separadores, $extra = null) {
		if ($extra) {
			return $this->_cep(current($data), $separadores);
		} else {
			return $this->_cep(current($data));
		}
	}

	function _cep($data, $separadores = array('', '-')) {
		if (!is_array($separadores)) {
			$separadores = array($separadores);
		}
		if (strlen($data) < 8) {
			return false;
		} else {
			$numeros = preg_replace('/[^\d]/', '', $data);
			if (strlen($numeros) < 8) {
				return false;
			}
		}
		$primeiraParte = substr($numeros, 0, 5);
		$segundaParte = substr($numeros, -3);
		foreach ($separadores as $separador) {
			$formatado = $primeiraParte . $separador . $segundaParte;
			if ($formatado == $data) {
				return true;
			}
		}
		return false;
	}

	function telefone($model, $data, $apenasNumeros, $extra = null) {
		if ($extra) {
			return $this->_telefone(current($data), $apenasNumeros);
		} else {
			return $this->_telefone(current($data));
		}
	}

	function _telefone($data, $apenasNumeros = false) {
		if ($apenasNumeros) {
			$tam = strlen($data);
			if ($tam == 8 || $tam == 10) {
				return true;
			}
			return false;
		}
		if (preg_match('/^\d{4}-\d{4}$/', $data)) { // 9999-9999
			return true;
		}
		if (preg_match('/^\(\d{2}\) ?\d{4}-\d{4}$/', $data)) { // (99) 9999-9999 ou (48)9999-9999
			return true;
		}
		if (preg_match('/^\+\d{2} ?\(\d{2}\) ?\d{4}-\d{4}$/', $data)) { // +55 (99) 9999-9999
			return true;
		}
		return false;
	}

}

?>