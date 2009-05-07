<?php
/**
 * Regras de pluralização e singualização do português
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Sadjow Medeiros Leão <sadjow@gmail.com>
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

    $pluralRules = array(
        '/^(.*)ao$/i' => '\1oes',

        '/^(.*)a$/i' => '\1as',
        '/^(.*)e$/i' => '\1es',
        '/^(.*)i$/i' => '\1is',
        '/^(.*)o$/i' => '\1os',
        '/^(.*)u$/i' => '\1us',

        '/^(.*)r$/i' => '\1res',
        '/^(.*)s$/i' => '\1ses',
        '/^(.*)z$/i' => '\1zes',

        '/^(.*)al$/i' => '\1ais',
        '/^(.*)el$/i' => '\1eis',
        '/^(.*)il$/i' => '\1is',
        '/^(.*)ol$/i' => '\1ois',
        '/^(.*)ul$/i' => '\1uis',

        '/^(.*)(m|n)$/i' => '\1ns',

        '/^(.*)$/i' => '\1s'
     );

    $uninflectedPlural = array('atlas', 'lapis', 'onibus', 'pires', 'virus', '.*x');

    $irregularPlural = array(
        'alemao' => 'alemaes',
        'artesa' => 'artesaos',
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
        'fossel,' => 'fosseis',
        'grao' => 'graos',
        'irmao' => 'irmaos',
        'mal' => 'males',
        'mao' => 'maos',
        'orfao' => 'orfaos',
        'pais' => 'paises',
        'pao' => 'paes',
        'projetil' => 'projeteis',
        'reptil' => 'repteis',
        'sacristao' => 'sacristaes',
        'sotao' => 'sotaos',
        'tabeliao' => 'tabeliaes'
    );

    $singularRules = array(
        '/^(.*)oes$/i' => '\1ao',
        '/^(.*)aes$/i' => '\1ao',
        '/^(.*)aos$/i' => '\1ao',

        '/^(.*)ais$/i' => '\1al',
        '/^(.*)eis$/i' => '\1el',
        '/^(.*)ois$/i' => '\1ol',
        '/^(.*)uis$/i' => '\1ul',

        '/^(.*)res$/i' => '\1r',
        '/^(.*)ses$/i' => '\1s',
        '/^(.*)zes$/i' => '\1z',

        '/^(.*)as$/i' => '\1a',
        '/^(.*)es$/i' => '\1e',
        '/^(.*)is$/i' => '\1i',
        '/^(.*)os$/i' => '\1o',
        '/^(.*)us$/i' => '\1u',

        '/^(.*)ns$/i' => '\1m',

        '/^(.*)s$/i' => '\1',
    );

    $uninflectedSingular = $uninflectedPlural;

    $irregularSingular = array_merge(array_flip($irregularPlural), array(
        'abdomens' => 'abdomen',
        'germens' => 'germen',
        'hifens' => 'hifen',
        'liquens' => 'liquen'
    ));
?>