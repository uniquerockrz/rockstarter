<?php require('../includes/header.inc.php'); ?>
	<?php $this->RenderBegin(); ?>

	<div class="instructions">
		<h1 class="instruction_title">Triggering Arbitrary JavaScript, Alerts and Confirms</h1>
		QCubed includes several commonly used Javascript-based actions:
		<ul>
			<li><b>QAlertAction</b> - to display a javascript "alert" type of dialog box</li>
			<li><b>QConfirmAction</b> - to display a javascript "confirm" type of dialog box, and execute following optional actions if the user hits "Ok"</li>
			<li><b>QJavaScriptAction</b> - to run any arbitrary javascript command(s)</li>
		</ul>
		
		The example below shows three different <b>QButton</b> controls which use all three
		of these action types.
		<br/><br/>
		
		Specifically for the <b>QJavaScriptAction</b>, we've defined a simple <b>SomeArbitraryJavaScript()</b>
		javascript function on the page itself, so that the button has some javascript to perform.<br/><br/>
		
		If you are interested in more advanced and flexible types of confirmation or prompts, take a look at the 
		<a href="../../../../plugins/DialogBoxes/example/more_dialog_boxes.php">plugin that offers pre-built QDialogBox subclasses</a>.<br/><br/>
	</div>

	<script type="text/javascript">
		function SomeArbitraryJavaScript() {
			strName = prompt('What is your name?');
			if (strName)
				alert('Hello, ' + strName + '!');
		}
	</script>
	
	<p><?php $this->btnAlert->Render(); ?></p>
	<p><?php $this->btnConfirm->Render(); ?></p>
	<p><?php $this->btnJavaScript->Render(); ?></p>
	<p><?php $this->lblMessage->Render(); ?></p>

	<?php $this->RenderEnd(); ?>
<?php require('../includes/footer.inc.php'); ?>