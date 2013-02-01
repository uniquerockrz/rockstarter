<?php
require_once('../qcubed.inc.php');

class PluginEditForm extends QForm {		
	/**
	 * @var QPlugin the plugin we're currently viewing the details for
	 */
	private $objPlugin = null;
	
	private $strPluginType; // one of the constants TYPE_*, defined below
	
	protected $lblName;
	protected $lblDescription;
	protected $lblPluginVersion;
	protected $lblPlatformVersion;
	protected $lblAuthorName;
	protected $lblAuthorEmail;
	protected $lblFiles;
	protected $dlgStatus;
	
	protected $btnInstall;
	protected $btnCancelInstallation;
	protected $btnUninstall;
	
	const TYPE_INSTALLING_NEW = "new";
	const TYPE_VIEWING_ALREADY_INSTALLED = "installed";
	
	protected function Form_Run() {
		QApplication::CheckRemoteAdmin();
	}

	protected function Form_Create() {
		$strPluginName = QApplication::QueryString('strName');
		$this->strPluginType = QApplication::QueryString('strType');
		if (!isset($strPluginName) || !isset($this->strPluginType) ||
			strlen($strPluginName) == 0 || strlen($this->strPluginType) == 0) {
			throw new Exception("Mandatory parameter was not set");
		}
		
		if ($this->strPluginType == self::TYPE_VIEWING_ALREADY_INSTALLED) {
			$installedPlugins = QPluginConfigParser::parseInstalledPlugins();
			
			foreach ($installedPlugins as $item) {
				if ($item->strName == $strPluginName) {
					$this->objPlugin = $item;
				}
			}
		} else if ($this->strPluginType == self::TYPE_INSTALLING_NEW) {
			$configFile = __INCLUDES__ . QPluginInstaller::PLUGIN_EXTRACTION_DIR .
							$strPluginName . '/' . QPluginInstaller::PLUGIN_CONFIG_FILE;
			$this->objPlugin = QPluginConfigParser::parseNewPlugin($configFile);
		} else {
			throw new Exception("Invalid value of the type URL parameter: " . $this->strPluginType);
		}
		
		if ($this->objPlugin == null) {
			throw new Exception ("Plugin not found: " . $strPluginName);
		}
		
		$this->lblName_Create();
		$this->lblDescription_Create();
		$this->lblPluginVersion_Create();
		$this->lblPlatformVersion_Create();
		$this->lblAuthorName_Create();
		$this->lblAuthorEmail_Create();
		$this->lblFiles_Create();
		$this->dlgStatus_Create();
		
		$this->btnInstall_Create();
		$this->btnCancelInstallation_Create();
		$this->btnUninstall_Create();
		
		$this->objDefaultWaitIcon = new QWaitIcon($this);
	}
	
	private function dlgStatus_Create(){
		$this->dlgStatus = new QDialogBox($this);

		// Let's setup some basic appearance options
		// This could and should normally be done in a separate CSS class using the CssClass property
		$this->dlgStatus->Width = '500px';
		$this->dlgStatus->Height = 'auto';
		$this->dlgStatus->Overflow = QOverflow::Auto;
		$this->dlgStatus->Padding = '10px';
		$this->dlgStatus->MatteClickable = false;
		$this->dlgStatus->Display = false;
	}
	
	private function btnInstall_Create() {
		$this->btnInstall = new QButton($this);
		$this->btnInstall->Text = "Install this Plugin";
		$this->btnInstall->AddAction(new QClickEvent(), new QAjaxAction('btnInstall_click'));
		
		if ($this->strPluginType != self::TYPE_INSTALLING_NEW) {
			$this->btnInstall->Visible = false;
		}
	}
	
	public function btnInstall_Click() {
		list($status, $log) = QPluginInstaller::installFromExpanded(QApplication::QueryString('strName'));
		
		$linkToProceed = "<h2><a href='plugin_manager.php'>Click here to continue</a></h2>";
		$this->dlgStatus->Text = $status.'<br/>'.$linkToProceed.'<a href="#" onclick="jQuery(\'#install_details\').toggle()">Details</a><div id="install_details" style="display:none;border:1px solid black;height:300px; overflow-y:auto;margin-top:20px;padding:10px;">'.nl2br($log).'</div>';
		$this->dlgStatus->ShowDialogBox();
	}
	
	private function btnUninstall_Create() {
		$this->btnUninstall = new QButton($this);
		$this->btnUninstall->Text = "Uninstall (delete) this Plugin";
		$this->btnUninstall->AddAction(new QClickEvent(), new QConfirmAction('Are you SURE you want to uninstall this plugin?'));
		$this->btnUninstall->AddAction(new QClickEvent(), new QAjaxAction('btnUninstall_click'));
		
		if ($this->strPluginType != self::TYPE_VIEWING_ALREADY_INSTALLED) {
			$this->btnUninstall->Visible = false;
		}
	}
	
	public function btnUninstall_Click() {
		list($status,$log) = QPluginUninstaller::uninstallExisting(QApplication::QueryString('strName'));

		$linkToProceed = "<h2><a href='plugin_manager.php'>Click here to continue</h2></a>";
		$this->dlgStatus->Text = $status.'<br/>'.$linkToProceed.'<a href="#" onclick="jQuery(\'#uninstall_details\').toggle()">Details</a><div id="uninstall_details" style="display:none;border:1px solid black;height:300px; overflow-y:auto;margin-top:20px;padding:10px;">'.nl2br($log).'</div>';
		$this->dlgStatus->ShowDialogBox();
	}


	private function btnCancelInstallation_Create() {
		$this->btnCancelInstallation = new QButton($this);
		$this->btnCancelInstallation->Text = "Cancel Installation";
		$this->btnCancelInstallation->AddAction(new QClickEvent(), new QAjaxAction('btnCancelInstallation_click'));

		if ($this->strPluginType != self::TYPE_INSTALLING_NEW) {
			$this->btnCancelInstallation->Visible = false;
		}
	}
	
	public function btnCancelInstallation_click() {
		QPluginInstaller::cleanupExtractedFiles(QApplication::QueryString('strName'));
		self::redirectToListPage();
	}
			
	private function lblName_Create() {
		$this->lblName = new QLabel($this);
		$this->lblName->Text = $this->objPlugin->strName;
		$this->lblName->Name = QApplication::Translate('Title');
	}
	
	private function lblDescription_Create() {
		$this->lblDescription = new QLabel($this);
		$this->lblDescription->Text = $this->objPlugin->strDescription;
		$this->lblDescription->Name = QApplication::Translate('Description');
	}
	
	private function lblPluginVersion_Create() {
		$this->lblPluginVersion = new QLabel($this);
		$this->lblPluginVersion->Text = $this->objPlugin->strVersion;
		$this->lblPluginVersion->Name = QApplication::Translate('Plugin Version');
	}
	
	private function lblPlatformVersion_Create() {
		$this->lblPlatformVersion = new QLabel($this);
		$this->lblPlatformVersion->Text = $this->objPlugin->strPlatformVersion;
		$this->lblPlatformVersion->Name = QApplication::Translate('Compatible QCubed Version');
	}
	
	private function lblAuthorName_Create() {
		$this->lblAuthorName = new QLabel($this);
		$this->lblAuthorName->Text = $this->objPlugin->strAuthorName;
		$this->lblAuthorName->Name = QApplication::Translate('Author');
	}
	
	private function lblAuthorEmail_Create() {
		$this->lblAuthorEmail = new QLabel($this);
		$this->lblAuthorEmail->Name = QApplication::Translate('Author\'s email');
		$this->lblAuthorEmail->HtmlEntities = false;

		if (strlen($this->objPlugin->strAuthorEmail) > 0) {		
			$email = $this->objPlugin->strAuthorEmail;
			
			// Light processing of the field to make it friendlier
			$email = str_replace(" ", "", $email);
			$braceOpen = "[\<\[{\(]";
			$braceClosed = "[\]}\)\>]";
			
			$email = preg_replace("/" . $braceOpen . "at" . $braceClosed . "/", "@", $email);
			$email = preg_replace("/" . $braceOpen . "dot" . $braceClosed . "/", ".", $email);
			
			$this->lblAuthorEmail->Text = "<a href='mailto:{$email}'>{$email}</a>";
		}
	}

	private function lblFiles_Create() {
		$this->lblFiles = new QLabel($this);
		$this->lblFiles->Name = QApplication::Translate("Contains: ");
		$this->lblFiles->Text = count($this->objPlugin->objAllFilesArray) . ' ' . QApplication::Translate("file(s)") . "; ";
		$this->lblFiles->Text .=  count($this->objPlugin->objIncludesArray) . ' ' . QApplication::Translate("include(s)") . "; ";
		$this->lblFiles->Text .=  count($this->objPlugin->objExamplesArray) . ' ' . QApplication::Translate("example(s)");
	}
	
	private function redirectToListPage() {
		QApplication::Redirect('plugin_manager.php');
	}
}

PluginEditForm::Run('PluginEditForm');
?>