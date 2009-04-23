<?php

App::import('Vendor', 'PluginManager.Installer');

class CakePtbrInstaller extends InstallerPM {

	function install() {
		App::import('Core', 'File');
		$bootstrap = new File(CONFIGS . 'bootstrap.php');
		$conteudo = $bootstrap->read();
		// Caso o plugin já esteja instalado, ignora
		if (strpos('cake_ptbr', $conteudo) !== false) {
			return;
		}
		$conteudo = str_replace('?>', "require APP . 'plugins' . DS . 'cake_ptbr' . DS . 'config' . DS . 'bootstrap.php';\n?>", $conteudo);
		$bootstrap->write($conteudo);
		$bootstrap->close();
	}

}

?>