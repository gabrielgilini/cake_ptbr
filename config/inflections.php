<?php
/*
* Por Sadjow Medeiros Leão (sadjow@gmail.com) - http://manual.cakephp.com.br/doku.php?id=inflections_portugues
* Atualizado por Juan Basso (jrbasso@cakephp-brasil.org)
*/

    $pluralRules = array(
        '/^([a-zA-Z]*)ao$/i' => '\1oes',

        '/^([a-zA-Z]*)a$/i' => '\1as',
        '/^([a-zA-Z]*)e$/i' => '\1es',
        '/^([a-zA-Z]*)i$/i' => '\1is',
        '/^([a-zA-Z]*)o$/i' => '\1os',
        '/^([a-zA-Z]*)u$/i' => '\1us',

        '/^([a-zA-Z]*)r$/i' => '\1res',
        '/^([a-zA-Z]*)s$/i' => '\1ses',
        '/^([a-zA-Z]*)z$/i' => '\1zes',

        '/^([a-zA-Z]*)al$/i' => '\1ais',
        '/^([a-zA-Z]*)el$/i' => '\1eis',
        '/^([a-zA-Z]*)il$/i' => '\1is',
        '/^([a-zA-Z]*)ol$/i' => '\1ois',
        '/^([a-zA-Z]*)ul$/i' => '\1uis',

        '/^([a-zA-Z]*)(m|n)$/i' => '\1ns',

        '/^([a-zA-Z]*)$/i' => '\1s'
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
        '/^([a-zA-Z]*)oes$/i' => '\1ao',
        '/^([a-zA-Z]*)aes$/i' => '\1ao',
        '/^([a-zA-Z]*)aos$/i' => '\1ao',

        '/^([a-zA-Z]*)as$/i' => '\1a',
        '/^([a-zA-Z]*)es$/i' => '\1e',
        '/^([a-zA-Z]*)is$/i' => '\1i',
        '/^([a-zA-Z]*)os$/i' => '\1o',
        '/^([a-zA-Z]*)us$/i' => '\1u',

        '/^([a-zA-Z]*)res$/i' => '\1r',
        '/^([a-zA-Z]*)ses$/i' => '\1s',
        '/^([a-zA-Z]*)zes$/i' => '\1z',

        '/^([a-zA-Z]*)ais$/i' => '\1al',
        '/^([a-zA-Z]*)eis$/i' => '\1el',
        '/^([a-zA-Z]*)is$/i' => '\1il',
        '/^([a-zA-Z]*)ois$/i' => '\1ol',
        '/^([a-zA-Z]*)uis$/i' => '\1ul',

        '/^([a-zA-Z]*)ns$/i' => '\1m',

        '/^([a-zA-Z]*)s$/i' => '\1',
    );

    $uninflectedSingular = $uninflectedPlural;

    $irregularSingular = array_merge(array_flip($irregularPlural), array(
        'abdomens' => 'abdomen',
        'germens' => 'germen',
        'hifens' => 'hifen',
        'liquens' => 'liquen'
    ));
?> 