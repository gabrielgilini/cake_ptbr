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

unset($_uninflected, $_pluralIrregular);

?>
