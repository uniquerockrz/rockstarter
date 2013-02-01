<?php
/**
 * @package PluginManager
 * @author Alex Weinstein <alex94040@yahoo.com>
 */

/**
 * This class has shared settings and constants that are used by both the 
 * plugin installer and uninstaller child classes. 
 * It also has a very useful function for the outside world: isPluginInstalled(). 
 */
abstract class QPluginInstallerBase {
	private static $strLastError = "";
	
	const ONLINE_PLUGIN_REPOSITORY = "http://trac.qcu.be/projects/qcubed/wiki/plugins";
	
	const PLUGIN_EXTRACTION_DIR = "/tmp/plugin.tmp/";
	/**
	 * @var string Name of the the file defines plugin settings in XML format.
	 */
	const PLUGIN_CONFIG_FILE = "plugin.xml";

	/**
	 * @var string Name of the the file defines plugin settings in PHP format.
	 */	
	const PLUGIN_CONFIG_GENERATION_FILE = "install.php";
	
	// these three have to be functions - PHP doesn't allow for static vars with concatenation :(
	public static function getMasterConfigFilePath() { 
		return __PLUGINS__ . '/plugin_config.xml';
	}
	
	public static function getMasterIncludeFilePath() {
		return __PLUGINS__ . '/plugin_includes.php';
	}
	
	public static function getMasterExamplesFilePath() {
		return __PLUGINS__ . '/plugin_examples.php';
	}
	
	public static function getLastError() {
		return self::$strLastError;
	}
			
	/**
	 * Given a plugin name, returns true if a plugin with this name is installed on the system. 
	 */
	public static function isPluginInstalled($strPluginName) {
		$installedPlugins = QPluginConfigParser::parseInstalledPlugins();
		$found = false;
		foreach ($installedPlugins as $plugin) {
			if (strcmp($plugin->strName, $strPluginName) == 0) {
				$found = true;
				break;
			}
		}
		
		return $found;
	}
		
	protected static function replaceFileSection($strFilePath, $strSearch, $strReplace) {
		$contents = QFile::readFile($strFilePath);
		
		$contents = str_replace($strSearch, $strReplace, $contents);
		
		QFile::writeFile($strFilePath, self::stripExtraNewlines($contents));
	}
		
	/**
	 * Copies the file to the destination folder for the plugin,
	 * creating all relevant directories in the process, if necessary.
	 */
	protected static function writeFileHelper($strSourcePath, $strDestinationPath) {
		$result = "";
		
		// Creating folder hierarchy if necessary
		$strDestinationDir = dirname($strDestinationPath);
		if (!is_dir($strDestinationDir)) {
			mkdir ($strDestinationDir, 0777, true);
			$result .= "Created deployment destination directory " . $strDestinationDir . "\r\n";
		}

		copy($strSourcePath, $strDestinationPath);
		$result .= "Deployed file to " . $strDestinationPath . "\r\n";
		
		return $result;
	}
	
	protected static function getBeginMarker($strId) {
		return "\r\n//// BEGIN " . $strId . "\r\n";
	}
	
	protected static function getEndMarker ($strId) {
		return "//// END " . $strId . "\r\n";
	}
	
	public static function cleanupExtractedFiles($strExtractedFolderName) {
		QFolder::DeleteFolder(__INCLUDES__ . self::PLUGIN_EXTRACTION_DIR . $strExtractedFolderName);
		return "\r\nCleaned up installation files.\r\n";
	}
		
	
	protected static function stripExtraNewlines($strInput) {
		$strInput = str_replace("\r\n", "\n", $strInput);
		return preg_replace("/\n\n+/", "\n\n", $strInput);
	}
}


?>