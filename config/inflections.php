<?php
/**
 * Ajustes das inflections para portuguкs
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

// Alteraзгo do inflector
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
	'email' => 'emails',
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
	'/А|Б|В|Г|Д|Е|?|A|A|A|A/' => 'A',
	'/И|Й|К|Л|E|E|E|E|E/' => 'E',
	'/М|Н|О|П|I|I|I|I|I|I/' => 'I',
	'/Т|У|Ф|Х|Ц|O|O|O|O|O|Ш|?/' => 'O',
	'/Щ|Ъ|Ы|Ь|U|U|U|U|U|U|U|U|U|U|U|U/' => 'U',
	'/З|C|C|C|C/' => 'C',
	'/Р|D|Р/' => 'D',
	'/G|G|G|G/' => 'G',
	'/H|H/' => 'H',
	'/J/' => 'J',
	'/K/' => 'K',
	'/L|L|L|?|L/' => 'L',
	'/С|N|N|N/' => 'N',
	'/R|R|R/' => 'R',
	'/S|S|S|Љ/' => 'S',
	'/T|T|T/' => 'T',
	'/Э|џ|Y/' => 'Y',
	'/Z|Z|Ћ/' => 'Z',
	'/W/' => 'W',
	'/Ж|?/' => 'AE',
	'/Я/'=> 'ss',
	'/?/' => 'IJ',
	'/Њ/' => 'OE',
	'/а|б|в|г|д|е|?|a|a|a|a|Є/' => 'a',
	'/и|й|к|л|e|e|e|e|e|&/' => 'e',
	'/м|н|о|п|i|i|i|i|i|i/' => 'i',
	'/т|у|ф|х|ц|o|o|o|o|o|ш|?|є/' => 'o',
	'/щ|ъ|ы|ь|u|u|u|u|u|u|u|u|u|u|u|u/' => 'u',
	'/з|c|c|c|c/' => 'c',
	'/р|d|d/' => 'd',
	'/g|g|g|g/' => 'g',
	'/h|h/' => 'h',
	'/j/' => 'j',
	'/k/' => 'k',
	'/l|l|l|?|l/' => 'l',
	'/с|n|n|n|?/' => 'n',
	'/r|r|r/' => 'r',
	'/s|s|s|љ|?/' => 's',
	'/t|t|t/' => 't',
	'/э|я|y/' => 'y',
	'/w/' => 'w',
	'/z|z|ћ/' => 'z',
	'/ж|?/' => 'ae',
	'/?/' => 'ij',
	'/њ/' => 'oe',
	'/ѓ/' => 'f'
));

unset($_uninflected, $_pluralIrregular);
