<?php require('../includes/header.inc.php'); ?>
	<?php $this->RenderBegin(); ?>

	<div class="instructions">
		<h1 class="instruction_title">Extending QPanels to Create Modal "Dialog Boxes"</h1>
		In general UI programming, there are two kinds of dialog boxes: modal and non-modal.  Modal dialog boxes are
		the most common. When a program displays a modal dialog box, the user cannot switch between the dialog box
		and the program's main UI.  The user must explicitly close the dialog box, usually by clicking either "Ok" or "Cancel".
		<br/><br/>

		Obviously, with the current state of HTML and browser technologies, the <b>alert()</b> Javascript method
		is still the only <i>true</i> way to have any level of a modal dialog interaction.  And unfortuantely,
		<b>alert()</b> has very few features in terms of functionality.  
		<br/><br/>
		
		<b>QCubed</b> implements a JQuery UI dialog box as a standard extension to the <b>QPanel</b>, which gives you
		the ability to create modal and modeless dialog boxes with a wide range of capabilities and complexities.
		<br/><br/>

		Because it extends the <b>QPanel</b> control, you have full use of all the <b>QPanel's</b> resources
		to build and design the content of the dialog box itself, including using separate template files and
		adding child controls, events, actions and validation.
		<br/><br/>
		
		And since it also uses the JQuery UI <b>Dialog</b> control, you have full access to all of the JQuery UI
		capabilities as well, and a few extra extensions. In particular,
		you can call <b>AddButton()</b> to add buttons to the dialog that will be placed in standard
		dialog locations and colored with the current theme. Attach actions to the <b>QDialog_ButtonEvent</b> event,
		and use the <b>ClickedButton</b> attribute to detect which of these buttons were clicked. Of course, you
		could use  standard QCubed buttons as well.
		<br/><br/>
		

		The three examples below show a simple "display only" dialog box, a modal dialog that asks for user input,
		and a more complex dialog box that is meant to be a
		"calculator widget" with intra-control communication, where the contents of the calculator in the dialog box
		can be copied into a textbox on the main form.
	</div>
	
	<style type="text/css">
		.calculator_display { text-align: right; padding: 4px; width: 208px; border-width: 1px; border-style: solid; border-color: black; background-color: white; font: 24px verdana, arial, helvetica; }
		.calculator_button { width: 50px; height: 45px; font: 20px verdana, arial, helvetica; font-weight: bold; border-width: 1px; background-color: #eeffdd; }
		.calculator_top_button { width: 78px; height: 45px; font: 10px verdana, arial, helvetica; color: white; border-width: 1px; background-color: #336644; }
	</style>

	<fieldset style="width: 400px;">
		<legend>Simple Message Example</legend>
		<?php $this->dlgSimpleMessage->Render(); ?>
		<p><?php $this->btnDisplaySimpleMessage->Render(); ?></p>
		<p><?php $this->btnDisplaySimpleMessageJsOnly->Render(); ?></p>
	</fieldset>
	<br/><br/>
	<fieldset style="width: 400px;">
		<legend>Yes/No Example</legend>
		<?php $this->dlgYesNo->Render(); ?>
		<?php $this->btnDisplayYesNo->Render(); ?>
		<?php $this->pnlAnswer->Render(); ?>
	</fieldset>
	<br/><br/>
	
	<fieldset style="width: 400px;">
		<legend>Calculator Widget Example</legend>
		<?php $this->dlgCalculatorWidget->Render(); ?>
		<p>Current Value: <?php $this->txtValue->Render(); ?></p>
		<p><?php $this->btnCalculator->Render(); ?></p>
	</fieldset>
	
	<?php $this->RenderEnd(); ?>
<?php require('../includes/footer.inc.php'); ?>