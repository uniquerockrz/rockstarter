<?php
	require_once('../qcubed.inc.php');

	// Define the Qform with all our Qcontrols
	class ExamplesForm extends QForm {
		// Local declarations of our Qcontrols
		protected $lblMessage;
		protected $btnButton;

		// Initialize our Controls during the Form Creation process
		protected function Form_Create() {
			// Define the Label
			$this->lblMessage = new QLabel($this);
			$this->lblMessage->Text = 'Click the button to change my message.';

			// Definte the Button
			$this->btnButton = new QButton($this);
			$this->btnButton->Text = 'Click Me!';
			
			// Add a Click event handler to the button -- the action to run is an AjaxAction.
			// The AjaxAction names a PHP method (which will be run asynchronously) called "btnButton_Click"
			$this->btnButton->AddAction(new QClickEvent(), new QAjaxAction('btnButton_Click'));
		}

		// The "btnButton_Click" Event handler
		protected function btnButton_Click($strFormId, $strControlId, $strParameter) {
			$this->lblMessage->Text = 'Hello, world!';
		}
	}

	// Run the Form we have defined
	ExamplesForm::Run('ExamplesForm');
?>
