<?php
/**
 * Arquivo para adaptação da aplicação para Português-Brasil
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

// Definindo idioma da aplicação
Configure::write('Config.language', 'pt-br');

// Adicionando o caminho do locale
App::build(array('locales' => dirname(dirname(__FILE__)) . DS . 'locale' . DS));

// Alteração do inflector
$_uninflected = array('atlas', 'lapis', 'onibus', 'pires', 'virus', '.*x');
$_pluralIrregular = array(
	'abdomens' => 'abdomen',
	'alemao' => 'alemaes',
	'artesa' => 'artesaos',
	'as' => 'ases',
	'bencao' => 'bencaos',
	'cao' => 'caes',
	'capelao' => 'capelaes',
	'capitao' => 'capitaes',
	'chao' => 'chaos',
	'charlatao' => 'charlataes',
	'cidadao' => 'cidadaos',
	'consul' => 'consules',
	'cristao' => 'cristaos',
	'dificil' => 'dificeis',
	'escrivao' => 'escrivaes',
	'fossel' => 'fosseis',
	'germens' => 'germen',
	'grao' => 'graos',
	'hifens' => 'hifen',
	'irmao' => 'irmaos',
	'liquens' => 'liquen',
	'mal' => 'males',
	'mao' => 'maos',
	'orfao' => 'orfaos',
	'pais' => 'paises',
	'pai' => 'pais',
	'pao' => 'paes',
	'perfil' => 'perfis',
	'projetil' => 'projeteis',
	'reptil' => 'repteis',
	'sacristao' => 'sacristaes',
	'sotao' => 'sotaos',
	'tabeliao' => 'tabeliaes'
);

Inflector::rules('singular', array(
	'rules' => array(
		'/^(.*)(oes|aes|aos)$/i' => '\1ao',
		'/^(.*)(a|e|o|u)is$/i' => '\1\2l',
		'/^(.*)e?is$/i' => '\1il',
		'/^(.*)(r|s|z)es$/i' => '\1\2',
		'/^(.*)ns$/i' => '\1m',
		'/^(.*)s$/i' => '\1',
	),
	'uninflected' => $_uninflected,
	'irregular' => array_flip($_pluralIrregular)
), true);

Inflector::rules('plural', array(
	'rules' => array(
		'/^(.*)ao$/i' => '\1oes',
		'/^(.*)(r|s|z)$/i' => '\1\2es',
		'/^(.*)(a|e|o|u)l$/i' => '\1\2is',
		'/^(.*)il$/i' => '\1is',
		'/^(.*)(m|n)$/i' => '\1ns',
		'/^(.*)$/i' => '\1s'
	),
	'uninflected' => $_uninflected,
	'irregular' => $_pluralIrregular
), true);

Inflector::rules('transliteration', array(
	'/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ/' => 'A',
	'/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě/' => 'E',
	'/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ/' => 'I',
	'/Ò|Ó|Ô|Õ|Ö|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ/' => 'O',
	'/Ù|Ú|Û|Ü|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/' => 'U',
	'/Ç|Ć|Ĉ|Ċ|Č/' => 'C',
	'/Ð|Ď|Đ/' => 'D',
	'/Ĝ|Ğ|Ġ|Ģ/' => 'G',
	'/Ĥ|Ħ/' => 'H',
	'/Ĵ/' => 'J',
	'/Ķ/' => 'K',
	'/Ĺ|Ļ|Ľ|Ŀ|Ł/' => 'L',
	'/Ñ|Ń|Ņ|Ň/' => 'N',
	'/Ŕ|Ŗ|Ř/' => 'R',
	'/Ś|Ŝ|Ş|Š/' => 'S',
	'/Ţ|Ť|Ŧ/' => 'T',
	'/Ý|Ÿ|Ŷ/' => 'Y',
	'/Ź|Ż|Ž/' => 'Z',
	'/Ŵ/' => 'W',
	'/Æ|Ǽ/' => 'AE',
	'/ß/'=> 'ss',
	'/Ĳ/' => 'IJ',
	'/Œ/' => 'OE',
	'/à|á|â|ã|ä|å|ǻ|ā|ă|ą|ǎ|ª/' => 'a',
	'/è|é|ê|ë|ē|ĕ|ė|ę|ě|&/' => 'e',
	'/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı/' => 'i',
	'/ò|ó|ô|õ|ö|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/' => 'o',
	'/ù|ú|û|ü|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/' => 'u',
	'/ç|ć|ĉ|ċ|č/' => 'c',
	'/ð|ď|đ/' => 'd',
	'/ĝ|ğ|ġ|ģ/' => 'g',
	'/ĥ|ħ/' => 'h',
	'/ĵ/' => 'j',
	'/ķ/' => 'k',
	'/ĺ|ļ|ľ|ŀ|ł/' => 'l',
	'/ñ|ń|ņ|ň|ŉ/' => 'n',
	'/ŕ|ŗ|ř/' => 'r',
	'/ś|ŝ|ş|š|ſ/' => 's',
	'/ţ|ť|ŧ/' => 't',
	'/ý|ÿ|ŷ/' => 'y',
	'/ŵ/' => 'w',
	'/ź|ż|ž/' => 'z',
	'/æ|ǽ/' => 'ae',
	'/ĳ/' => 'ij',
	'/œ/' => 'oe',
	'/ƒ/' => 'f'
));

unset($_uninflected, $_pluralIrregular);

?>