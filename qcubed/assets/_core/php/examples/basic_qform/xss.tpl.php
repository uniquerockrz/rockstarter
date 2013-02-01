<?php require('../includes/header.inc.php'); ?>
	<?php $this->RenderBegin(); ?>

	<div class="instructions">
		<h1 class="instruction_title">Security: Cross-Site Scripting (XSS) Prevention</h1>
		Cross-site scripting, or XSS, is a type of software vulnerability that allows attackers to inject JavaScript
		into web pages viewed by other users. This attack, if executed successfully, can provide the attacker
		a way to steal other users' cookies, thus enabling them to gain unauthorized access to your website. 
		It's one of the most frequently exploited vulnerabilities on the Web; read more about 
		it <a href="http://en.wikipedia.org/wiki/Cross-site_scripting">on Wikipedia</a>.<br><br>
		
		QCubed comes with two layers of protection against XSS. Both of these are enabled by default, and you don't
		need to do anything to make use of them.<br><br>

		The first layer is around filtering input - particularly in <b>QTextbox</b> controls. This is about filtering
		the input that the user has placed into the text box, and rejecting or removing any potential script and tags from it.
		By default QCubed . However this behaviour
		can be changed per QTextBox instance by setting its <strong>CrossScripting</strong>
		property to one of the following values:
		<ul>
			<li><strong>QCrossScripting::Deny</strong> (aka <strong>QCrossScripting::Legacy</strong>) uses an internal regular expression matching algorithm
				to reject the submitted input if it contains
				any potentially harmful tags or attributes, such as <strong>&lt;script&gt;</strong> or <strong>onclick=</strong>.
				It does not do any filtering, it simply throws an exception if a match is found.
				For backward compatibility reasons this is the default value used when creating QTextBox instances.
				However this default can be changed (see below).
				</li>
			<li><strong>QCrossScripting::Allow</strong> completely disables any checks and filtering and would let any posted data through. This is the most
				insecure option and should be avoided unless you have very good reasons for it.</li>
			<li><strong>QCrossScripting::HtmlEntities</strong> simply calls PHP's htmlentities() function on the submitted text. This will protect against
				cross-site scripting attacks, however it will not filter anything out, which may still be undesirable.</li>
			<li><strong>QCrossScripting::HTMLPurifier</strong> is the option that offers fine-grained control over filtering. It uses the well
				known <a href="http://htmlpurifier.org/">HTML Purifier</a> library. From the library's home page:
				<div style="margin-left: 50px; "><em>
					"HTML Purifier will not only remove all malicious
					code (better known as XSS) with a thoroughly audited,
					secure yet permissive whitelist,
					it will also make sure your documents are
					standards compliant, something only achievable with a
					comprehensive knowledge of W3C's specifications."
				</em>
				</div>
			</li>
		</ul>

		As mentioned above the default value used for creating QTextBox instances can be altered by setting
		<strong>QApplication::$DefaultCrossScriptingMode</strong> to one of the values above.<br/><br/>

		The second layer is about escaping output - so that if a piece of undesirable JavaScript somehow made it into
		the database, QCubed will run it through the HTMLEntities function, escaping each possible entity (such as
		an HTML tag, for example, &lt;script&gt; tag).<br/><br/>
		
		Note that sometimes, there's a need to allow users to input some form of HTML (for example, if you want to 
		allow the input of a few tags, such as the innocent tags &lt;b&gt,&lt;i&gt). In those cases, you need to disable
		the second protection (output filtering), and also list the tags that you want to allow by specifying:<br><br>

		<div style="margin-left: 20px"><code>
			$this->txtTextbox2->CrossScripting = QCrossScripting::HTMLPurifier;<br/>
			$this->txtTextbox2->SetPurifierConfig("HTML.Allowed", "b,i");
		</code></div>

		<br>See the five textboxes below to learn more about how this XSS protection works.

	</div>

	<p><b>Textbox protected with the default <code>QCrossScripting::Deny</code>. If you enter any text that contains one of
		the disallowed tags, pressing any of the buttons on this page will result in an exception.</b></p>
	<p><?php $this->txtTextbox1->Render() ?></p>
	<p><?php $this->btnButton1->Render(); ?></p>
	<p>&nbsp;<?php $this->lblLabel1->Render() ?></p>

	<p><b>Textbox protected with <code>QCrossScripting::HtmlEntities</code>:</b></p>
	<p><?php $this->txtTextbox2->Render() ?></p>
	<p><?php $this->btnButton2->Render(); ?></p>
	<p>&nbsp;<?php $this->lblLabel2->Render() ?></p>

	<p><b>Textbox protected with <code>QCrossScripting::HTMLPurifier</code> with default settings:</b></p>
	<p><?php $this->txtTextbox3->Render() ?></p>
	<p><?php $this->btnButton3->Render(); ?></p>
	<p>&nbsp;<?php $this->lblLabel3->Render() ?></p>

	<p><b>Textbox protected with <code>QCrossScripting::HTMLPurifier</code> with a set of tags that's allowed (ex.&lt;b&gt;, &lt;i&gt;)</b></p>
	<p><?php $this->txtTextbox4->Render() ?></p>
	<p><?php $this->btnButton4->Render(); ?></p>
	<p>&nbsp;<?php $this->lblLabel4->Render() ?></p>

	<p><b>Unprotected textbox (uses <code>QCrossScripting::Allow</code>). Not recommended - don't do this unless you have a good reason!:</b></p>
	<p><?php $this->txtTextbox5->Render() ?></p>
	<p><?php $this->btnButton5->Render(); ?></p>
	<p>&nbsp;<?php $this->lblLabel5->Render() ?></p>


	<?php $this->RenderEnd(); ?>
<?php require('../includes/footer.inc.php'); ?>
