<?php
	/*
	 * error_page include file
	 * 
	 * expects the following variables to be set:
	 *	$__exc_strType
	 *	$__exc_strMessage
	 *	$__exc_strObjectType
	 *	$__exc_strFilename
	 *	$__exc_intLineNumber
	 *	$__exc_strStackTrace
	 *
	 * optional:
	 *	$__exc_strRenderedPage
	 *  $__exc_objErrorAttributeArray
	 */

	$__exc_strMessageBody = htmlentities($__exc_strMessage);
	$__exc_strMessageBody = str_replace(" ", "&nbsp;", str_replace("\n", "<br/>\n", $__exc_strMessageBody));
	$__exc_strMessageBody = str_replace(":&nbsp;", ": ", $__exc_strMessageBody);
	$__exc_objFileArray = file($__exc_strFilename);

	header("HTTP/1.1 500 Internal Server Error");
?>
<?php
if(stristr($__exc_strMessage, "Invalid Form State Data") !== false) {
	// It was a invalid form state data
	// We return this string because invalid form state data error response does not behave like other errors
	// and gets unable to render the QDialogBox for the error. Since qcubed.js searches for '<html>' in the beginning
	// of the response to display it in the new Window, the following line will circumvent that behavior
	echo '<!-- -->';
}
?>
<html>
	<head>
		<title>PHP <?php _p($__exc_strType); ?> - <?php _p($__exc_strMessage); ?></title>
		<style>
			body { font-family: 'Arial' 'Helvetica' 'sans-serif'; font-size: 11px; }
			a:link, a:visited { text-decoration: none; }
			a:hover { text-decoration: underline; }
			pre { font-family: 'Lucida Console' 'Courier New' 'Courier' 'monospaced'; font-size: 11px; line-height: 13px; }
			.page { padding: 10px; }
			.headingLeft { background-color: #440066; color: #ffffff; padding: 10px 0px 10px 10px; font-family: 'Verdana' 'Arial' 'Helvetica' 'sans-serif'; font-size: 18px; font-weight: bold; width: 70%; vertical-align: middle; }
			.headingLeftSmall { font-size: 10px; }
			.headingRight { background-color: #440066; color: #ffffff; padding: 0px 10px 10px 10px; font-family: 'Verdana' 'Arial' 'Helvetica' 'sans-serif'; font-size: 10px; width: 30%; vertical-align: middle; text-align: right; }
			.title { font-family: 'Verdana' 'Arial' 'Helvetica' 'sans-serif'; font-size: 19px; font-style: italic; color: #330055; }
			.code { background-color: #f4eeff; padding: 1px 10px 1px 10px; }
		</style>
		<script type="text/javascript">
			function ToggleHidden(strDiv) { var obj = document.getElementById(strDiv); var stlSection = obj.style; var isCollapsed = obj.style.display.length; if (isCollapsed) stlSection.display = ''; else stlSection.display = 'none'; }
		</script>
	</head>
	<body bgcolor="white" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

	<table border="0" cellspacing="0" width="100%">
		<tr>
			<td nowrap="nowrap" class="headingLeft"><span class="headingLeftSmall"><?php _p($__exc_strType); ?> in PHP Script<br /></span><?php _p($_SERVER["PHP_SELF"]); ?></div></td>
			<td nowrap="nowrap" class="headingRight">
				<b>PHP Version:</b> <?php _p(PHP_VERSION); ?>;&nbsp;&nbsp;<b>Zend Engine Version:</b> <?php _p(zend_version()); ?>;&nbsp;&nbsp;<b>QCubed Version:</b> <?php _p(QCUBED_VERSION); ?><br />
				<?php if (array_key_exists('OS', $_SERVER)) printf('<b>Operating System:</b> %s;&nbsp;&nbsp;', $_SERVER['OS']); ?><b>Application:</b> <?php _p($_SERVER['SERVER_SOFTWARE']); ?>;&nbsp;&nbsp;<b>Server Name:</b> <?php _p($_SERVER['SERVER_NAME']); ?><br />
				<b>HTTP User Agent:</b> <?php _p($_SERVER['HTTP_USER_AGENT']); ?></td>
		</tr>
	</table>

	<div class="page">
		<span class="title"><?php _p($__exc_strMessageBody, false); ?></span><br />
			<b><?php _p($__exc_strType); ?> Type:</b>&nbsp;&nbsp;
			<?php _p($__exc_strObjectType); ?>
			<br /><br />

<?php
			if (isset($__exc_strRenderedPage)) {
				$_SESSION['RenderedPageForError'] = $__exc_strRenderedPage; ?>
				<b>Rendered Page:</b>&nbsp;&nbsp;
				<a href="<?php _p(__VIRTUAL_DIRECTORY__ . __PHP_ASSETS__) ;?>/error_already_rendered_page.php" target="_blank">
					Click here</a> to view contents able to be rendered</a>
				<br /><br />
<?php
			}
?>
			<b>Source File:</b>&nbsp;&nbsp;
			<?php _p($__exc_strFilename); ?>
			&nbsp;&nbsp;&nbsp;&nbsp;<b>Line:</b>&nbsp;&nbsp;
			<?php _p($__exc_intLineNumber); ?>
			<br /><br />

			<div class="code">
<?php
						_p('<pre>', false);
						for ($__exc_intLine = max(1, $__exc_intLineNumber - 5); $__exc_intLine <= min(count($__exc_objFileArray), $__exc_intLineNumber + 5); $__exc_intLine++) {
							if ($__exc_intLineNumber == $__exc_intLine)
								printf("<font color=red>Line %s:    %s</font>", $__exc_intLine, htmlentities($__exc_objFileArray[$__exc_intLine - 1]));
							else
								printf("Line %s:    %s", $__exc_intLine, htmlentities($__exc_objFileArray[$__exc_intLine - 1]));
						}
						_p('</pre>', false);
?>
			</div><br />

<?php
			if (isset($__exc_objErrorAttributeArray))
				foreach ($__exc_objErrorAttributeArray as $__exc_objErrorAttribute) {
					printf("<b>%s:</b>&nbsp;&nbsp;", $__exc_objErrorAttribute->Label);
					$__exc_strJavascriptLabel = str_replace(" ", "", $__exc_objErrorAttribute->Label);
					if ($__exc_objErrorAttribute->MultiLine) {
						printf("\n<a href=\"#\" onclick=\"ToggleHidden('%s'); return false;\">Show/Hide</a>",
							$__exc_strJavascriptLabel);
						printf('<br /><br /><div id="%s" class="code" style="Display: none;"><pre>%s</pre></div><br />',
							$__exc_strJavascriptLabel,
							htmlentities($__exc_objErrorAttribute->Contents));
					} else
						printf("%s\n<br /><br />\n", htmlentities($__exc_objErrorAttribute->Contents));
				}
?>

			<b>Call Stack:</b>
			<br><br>
			<div class="code">
				<pre><?php _p($__exc_strStackTrace); ?></pre>
			</div><br />

			<b>Variable Dump:</b>&nbsp;&nbsp;
			<a href="#" onclick="ToggleHidden('VariableDump'); return false;">Show/Hide</a>
			<br /><br />
			<div id="VariableDump" class="code" style="Display: none;">
<?php
				_p('<pre>', false);

				// Dump All Variables
				foreach ($GLOBALS as $__exc_Key => $__exc_Value) {
					// TODO: Figure out why this is so strange
					if (isset($__exc_Key))
						if ($__exc_Key != "_SESSION")
							global $$__exc_Key;
				}

				$__exc_ObjVariableArray = get_defined_vars();
				$__exc_ObjVariableArrayKeys = array_keys($__exc_ObjVariableArray);
				sort($__exc_ObjVariableArrayKeys);

				$__exc_StrToDisplay = "";
				$__exc_StrToScript = "";
				$varCounter = 0;
				foreach ($__exc_ObjVariableArrayKeys as $__exc_Key) {
					if ((strpos($__exc_Key, "__exc_") === false) && (strpos($__exc_Key, "_DATE_") === false) && ($__exc_Key != "GLOBALS") && !($__exc_ObjVariableArray[$__exc_Key] instanceof QForm)) {
						try {
							if (($__exc_Key == 'HTTP_SESSION_VARS') || ($__exc_Key == '_SESSION')) {
								$__exc_ObjSessionVarArray = array();
								foreach ($$__exc_Key as $__exc_StrSessionKey => $__exc_StrSessionValue) {
									if (strpos($__exc_StrSessionKey, 'qform') !== 0)
										$__exc_ObjSessionVarArray[$__exc_StrSessionKey] = $__exc_StrSessionValue;
								}
								$__exc_StrVarExport = htmlentities(var_export($__exc_ObjSessionVarArray, true));
							} else if (($__exc_ObjVariableArray[$__exc_Key] instanceof QControl) || ($__exc_ObjVariableArray[$__exc_Key] instanceof QForm))
								$__exc_StrVarExport = htmlentities($__exc_ObjVariableArray[$__exc_Key]->VarExport());
							else
								$__exc_StrVarExport = htmlentities(var_export($__exc_ObjVariableArray[$__exc_Key], true));

							$__exc_StrToDisplay .= sprintf("  <a href=\"#\" onclick=\"ToggleHidden('%s'); return false;\">%s</a>\n", $varCounter, $__exc_Key);
							$__exc_StrToDisplay .= sprintf("<div id=\"%s\" style='display:none'>%s</div>", $varCounter, $__exc_StrVarExport);
							$varCounter++;
						} catch (Exception $__exc_objExcOnVarDump) {
							$__exc_StrToDisplay .= sprintf("  Fatal error:  Nesting level too deep - recursive dependency?\n", $__exc_objExcOnVarDump->Message);
						}
					}
				}

				_p($__exc_StrToDisplay . '</pre>', false);
				printf('<script type="text/javascript">%s</script>', $__exc_StrToScript);
?>
			</div><br />

			<hr width="100%" size="1" color="#dddddd" />
			<center><i><?php _p($__exc_strType); ?> Report Generated:&nbsp;&nbsp;<?php _p(date('l, F j Y, g:i:s A')); ?></i></center>
		</font>
	</div>
	</body>
</html>