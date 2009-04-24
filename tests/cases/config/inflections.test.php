<?php
/**
 * Testes das regras de pluralização e singularização
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

class CakePtbrInflectionsCase extends CakeTestCase {

	function testPlural() {
		// Regulares
		$this->assertEqual(Inflector::pluralize('Compra'), 'Compras');
		$this->assertEqual(Inflector::pluralize('Caminhao'), 'Caminhoes');
		$this->assertEqual(Inflector::pluralize('Motor'), 'Motores');
		$this->assertEqual(Inflector::pluralize('Bordel'), 'Bordeis');
		// Não pluralizável
		$this->assertEqual(Inflector::pluralize('Lapis'), 'Lapis');
		// Irregulares
		$this->assertEqual(Inflector::pluralize('Alemao'), 'Alemaes');
		$this->assertEqual(Inflector::pluralize('Mao'), 'Maos');
	}

	function testSingular() {
		// Regulares
		$this->assertEqual(Inflector::singularize('Compras'), 'Compra');
		$this->assertEqual(Inflector::singularize('Caminhoes'), 'Caminhao');
		$this->assertEqual(Inflector::singularize('Motores'), 'Motor');
		$this->assertEqual(Inflector::singularize('Bordeis'), 'Bordel');
		// Não pluralizável
		$this->assertEqual(Inflector::singularize('Lapis'), 'Lapis');
		// Irregulares
		$this->assertEqual(Inflector::singularize('Alemaes'), 'Alemao');
		$this->assertEqual(Inflector::singularize('Maos'), 'Mao');
	}

}

?>