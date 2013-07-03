<?php
	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the Starter class.  It uses the code-generated
	 * StarterDataGrid control which has meta-methods to help with
	 * easily creating/defining Starter columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both starter_list.php AND
	 * starter_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package My QCubed Application
	 * @subpackage FormBaseObjects
	 */
	abstract class StarterListFormBase extends QForm {
		// Local instance of the Meta DataGrid to list Starters
		/**
		 * @var StarterDataGrid dtgStarters
		 */
		protected $dtgStarters;

		// Create QForm Event Handlers as Needed

//		protected function Form_Exit() {}
//		protected function Form_Load() {}
//		protected function Form_PreRender() {}
//		protected function Form_Validate() {}

		protected function Form_Run() {
			parent::Form_Run();
		}

		protected function Form_Create() {
			parent::Form_Create();

			// Instantiate the Meta DataGrid
			$this->dtgStarters = new StarterDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgStarters->CssClass = 'datagrid';
			$this->dtgStarters->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgStarters->Paginator = new QPaginator($this->dtgStarters);
			$this->dtgStarters->ItemsPerPage = __FORM_DRAFTS_FORM_LIST_ITEMS_PER_PAGE__;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/starter_edit.php';
			$this->dtgStarters->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for starter's properties, or you
			// can traverse down QQN::starter() to display fields that are down the hierarchy)
			$this->dtgStarters->MetaAddColumn('Id');
			$this->dtgStarters->MetaAddColumn('Email');
		}
	}
?>
