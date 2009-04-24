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
$localePaths = Configure::read('localePaths');
$localePaths[] = dirname(dirname(__FILE__)) . DS . 'locale';
Configure::write('localePaths', $localePaths);

// Alteração do inflection
require dirname(__FILE__) . DS . 'inflections.php';
$inflector = Inflector::getInstance();
$inflector->__pluralRules = $pluralRules;
$inflector->__uninflectedPlural = $uninflectedPlural;
$inflector->__irregularPlural = $irregularPlural;
$inflector->__singularRules = $singularRules;
$inflector->__uninflectedSingular = $uninflectedPlural;
$inflector->__irregularSingular = array_flip($irregularPlural);

?>