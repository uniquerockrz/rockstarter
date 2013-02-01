<?php
	/**
	 * @package Controls
	 */
	class QFileAsset extends QFileAssetBase {
		protected $strTemporaryUploadPath = '/tmp';
		
		public function __construct($objParentObject, $strControlId = null) {
			parent::__construct($objParentObject, $strControlId);

			// Setup Default Properties
			$this->strTemplate = __DOCROOT__ . __PHP_ASSETS__ . '/QFileAsset.tpl.php';
			$this->dlgFileAsset->Width = '300';
			$this->UploadText = QApplication::Translate('Upload');
			$this->CancelText = QApplication::Translate('Cancel');
			$this->btnUpload->Text = '<img src="' . __VIRTUAL_DIRECTORY__ . __IMAGE_ASSETS__ . '/add.png" alt="' . QApplication::Translate('Upload') . '" border="0"/> ' . QApplication::Translate('Upload');
			$this->btnDelete->Text = '<img src="' . __VIRTUAL_DIRECTORY__ . __IMAGE_ASSETS__ . '/delete.png" alt="' . QApplication::Translate('Delete') . '" border="0"/> ' . QApplication::Translate('Delete');
			$this->DialogBoxHtml = '<p>' . QApplication::Translate('Please select a file to upload.') . '</p>';
		}
	}
?>