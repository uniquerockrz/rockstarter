<?php $strPageTitle="Panel Drafts" ?>
<?php require(__CONFIGURATION__ . '/header.inc.php'); ?>
<?php $this->RenderBegin(); ?>
	<div id="pageTitle"><?php $this->lblTitle->Render(); ?></div><div id="formDraftLink"><a href="<?php _p(__VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__) ?>/index.php">&laquo; <?php _t('Go to "Form Drafts"'); ?></a></div>

	<div id="dashboard">
		<div id="left">
			<p><strong>Select a Class to View/Edit</strong>
			<?php $this->lstClassNames->Render('FontSize=10px','Width=100px'); ?> <span class="waitIcon"><?php $this->objDefaultWaitIcon->Render(); ?></span></p>
		</div>
		<br />
		<div id="right">
			<?php $this->pnlList->Render(); ?>
			<?php $this->pnlEdit->Render(); ?>
		</div>
	</div>
	<br clear="all" style="clear:both" />
<?php $this->RenderEnd(); ?>
<?php require(__CONFIGURATION__ . '/footer.inc.php'); ?>
