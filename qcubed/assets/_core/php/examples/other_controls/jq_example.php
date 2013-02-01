<?php
    require_once('../qcubed.inc.php');	
    
	class ExampleForm extends QForm {
		/** @var QDraggable */
		protected $Draggable;
		/** @var QDroppable */
		protected $Droppable;
		/** @var QResizable */
		protected $Resizable;
		/** @var QSelectable */
		protected $Selectable;
		/** @var QSortable */
		protected $Sortable;
	
		/** @var QAccordion */
		protected $Accordion;
		/** @var QAutocomplete */
		protected $Autocomplete1;
		protected $Autocomplete2;
		/** @var QAutocomplete */
		protected $AjaxAutocomplete;
		/** @var QJqButton */
		protected $Button;
		/** @var QJqCheckBox */
		protected $CheckBox;
		/** @var QJqRadioButton */
		protected $RadioButton;
		/** @var QJqButton */
		protected $IconButton;
		/** @var QCheckBoxList */
		protected $CheckList1;
		/** @var QCheckBoxList */
		protected $CheckList2;
		/** @var QRadioButtonList */
		protected $RadioList1;
		/** @var QRadioButtonList */
		protected $RadioList2;
		
		/** @var QDatepicker */
		protected $Datepicker;
		/** @var QDatepickerBox */
		protected $DatepickerBox;
		/** @var QDialog */
		protected $Dialog;
		/** @var QProgressbar */
		protected $Progressbar;
		/** @var QSlider */
		protected $Slider;
		protected $Slider2;
		/** @var QTabs */
		protected $Tabs;

		// Array we'll use to demonstrate the autocomplete functionality
		static private $LANGUAGES = array("c++", "java", "php",
			"coldfusion", "javascript", "asp", "ruby");

		protected function Form_Create() {
			$this->Draggable = new QPanel($this);
			$this->Draggable->Text = 'Drag me';
			$this->Draggable->CssClass = 'draggable';
			$this->Draggable->Moveable = true;
			//$this->Draggable->AddAction(new QDraggable_StopEvent(), new QJavascriptAction("alert('Dragged to ' + ui.position.top + ',' + ui.position.left)"));
			$this->Draggable->AddAction(new QDraggable_StopEvent(), new QAjaxAction("drag_stop"));
						
			// Dropable
			$this->Droppable = new QPanel($this);
			$this->Droppable->Text = "Drop here";
			//$this->Droppable->AddAction(new QDroppable_DropEvent(), new QJavascriptAction("alert('Dropped ' + ui.draggable.attr('id'))"));
			$this->Droppable->AddAction(new QDroppable_DropEvent(), new QAjaxAction("droppable_drop"));
			$this->Droppable->CssClass = 'droppable';
			$this->Droppable->Droppable = true;
	
			// Resizable
			$this->Resizable = new QPanel($this);
			$this->Resizable->CssClass = 'resizable';
			$this->Resizable->Resizable = true;
			$this->Resizable->AddAction (new QResizable_StopEvent(), new QAjaxAction ('resizable_stop'));

			
			// Selectable
			$this->Selectable = new QSelectable($this);
			$this->Selectable->AutoRenderChildren = true;
			$this->Selectable->CssClass = 'selectable';
			for ($i = 1; $i <= 5; ++$i) {
				$pnl = new QPanel($this->Selectable);
				$pnl->Text = 'Item '.$i;
				$pnl->CssClass = 'selitem';
			}
			$this->Selectable->Filter = 'div.selitem';
			$this->Selectable->SelectedItems = array ($pnl->ControlId);	// pre-select last item
			$this->Selectable->AddAction(new QSelectable_StopEvent(), new QAjaxAction ('selectable_stop'));

			// Sortable
			$this->Sortable = new QSortable($this);
			$this->Sortable->AutoRenderChildren = true;
			$this->Sortable->CssClass = 'sortable';
			for ($i = 1; $i <= 5; ++$i) {
				$pnl = new QPanel($this->Sortable);
				$pnl->Text = 'Item '.$i;
				$pnl->CssClass = 'sortitem';
			}
			$this->Sortable->Items = 'div.sortitem';
			$this->Sortable->AddAction(new QSortable_StopEvent(), new QAjaxAction ('sortable_stop'));
			
			// Accordion
			$this->Accordion = new QAccordion($this);
			$lbl = new QLinkButton($this->Accordion);
			$lbl->Text = 'Header 1';
			$pnl = new QPanel($this->Accordion);
			$pnl->Text = 'Section 1';
			$lbl = new QLinkButton($this->Accordion);
			$lbl->Text = 'Header 2';
			$pnl = new QPanel($this->Accordion);
			$pnl->Text = 'Section 2';
			$lbl = new QLinkButton($this->Accordion);
			$lbl->Text = 'Header 3';
			$pnl = new QPanel($this->Accordion);
			$pnl->Text = 'Section 3';
			
			$this->Accordion->AddAction (new QChangeEvent(), new QAjaxAction ('accordion_change'));

			// Autocomplete

			// Both autocomplete controls below will use the mode
			// "match only on the beginning of the word"
			QAutocomplete::UseFilter(QAutocomplete::FILTER_STARTS_WITH);

			// Client-side only autocomplete
			$this->Autocomplete1 = new QAutocomplete($this);
			$this->Autocomplete1->Source = self::$LANGUAGES;
			$this->Autocomplete1->Name = "Standard Autocomplete";

			$this->Autocomplete2 = new QAutocomplete($this);
			$this->Autocomplete2->Source = self::$LANGUAGES;
			$this->Autocomplete2->AutoFocus = true;
			$this->Autocomplete2->MustMatch = true;
			$this->Autocomplete2->Name = "AutoFocus and MustMatch";
	
			// Ajax Autocomplete
			// Note: To show the little spinner while the ajax search is happening, you
			// need to define the .ui-autocomplete-loading class in a style sheet. See
			// header.inc.php for an example.
			$this->AjaxAutocomplete = new QAutocomplete($this);
			$this->AjaxAutocomplete->SetDataBinder("update_autocompleteList");
			$this->AjaxAutocomplete->AddAction (new QAutocomplete_ChangeEvent(), new QAjaxAction ('ajaxautocomplete_change'));

			// Button
			$this->Button = new QJqButton($this);
			$this->Button->Label = "Click me";	// Label overrides Text
			$this->Button->AddAction(new QClickEvent, new QServerAction("button_click"));

			$this->CheckBox = new QJqCheckBox($this);
			$this->CheckBox->Text = "CheckBox";
			
			$this->RadioButton = new QJqRadioButton($this);
			$this->RadioButton->Text = "RadioButton";

			$this->IconButton = new QJqButton($this);
			$this->IconButton->Text = "Sample";
			$this->IconButton->ShowText = false;
			$this->IconButton->Icons = array ("primary"=>JqIcon::Lightbulb);
			
			// Lists
			$this->CheckList1 = new QCheckBoxList($this);
			$this->CheckList1->Name = "CheckBoxList with buttonset";
			foreach (self::$LANGUAGES as $strLang) {
				$this->CheckList1->AddItem ($strLang);
			}
			$this->CheckList1->ButtonMode = QCheckBoxList::ButtonModeSet;

			$this->CheckList2 = new QCheckBoxList($this);
			$this->CheckList2->Name = "CheckBoxList with button style";
			foreach (self::$LANGUAGES as $strLang) {
				$this->CheckList2->AddItem ($strLang);
			}
			$this->CheckList2->ButtonMode = QCheckBoxList::ButtonModeJq;
			$this->CheckList2->RepeatColumns = 4;
			
			$this->RadioList1 = new QRadioButtonList($this);
			$this->RadioList1->Name = "RadioButtonList with buttonset";
			foreach (self::$LANGUAGES as $strLang) {
				$this->RadioList1->AddItem ($strLang);
			}
			$this->RadioList1->ButtonMode = QCheckBoxList::ButtonModeSet;

			$this->RadioList2 = new QRadioButtonList($this);
			$this->RadioList2->Name = "RadioButtonList with button style";
			foreach (self::$LANGUAGES as $strLang) {
				$this->RadioList2->AddItem ($strLang);
			}
			$this->RadioList2->ButtonMode = QCheckBoxList::ButtonModeJq;
			$this->RadioList2->RepeatColumns = 4;
			
			// Datepicker
			$this->Datepicker = new QDatepicker($this);
	
			// DatepickerBox
			$this->DatepickerBox = new QDatepickerBox($this);

			// Dialog
			$this->Dialog = new QDialog($this);
			$this->Dialog->Text = 'a non modal dialog';
			$this->Dialog->AddButton ('Cancel', 'cancel');
			$this->Dialog->AddButton ('OK', 'ok');
			$this->Dialog->AddAction (new QDialog_ButtonEvent(), new QAjaxAction ('dialog_press'));
			
			// Progressbar
			$this->Progressbar = new QProgressbar($this);
			$this->Progressbar->Value = 37;
	
			// Slider
			$this->Slider = new QSlider($this);
			$this->Slider->AddAction (new QSlider_SlideEvent(), new QJavascriptAction (
				'jQuery("#' . $this->Progressbar->ControlId . '").progressbar ("value", ui.value)'
			));
			$this->Slider->AddAction (new QSlider_ChangeEvent(), new QAjaxAction ('slider_change'));

			$this->Slider2 = new QSlider($this);
			$this->Slider2->Range = true;
			$this->Slider2->Values = array(10, 50);
			$this->Slider2->AddAction (new QSlider_ChangeEvent(), new QAjaxAction ('slider2_change'));
						
			// Tabs
			$this->Tabs = new QTabs($this);
			$tab1 = new QPanel($this->Tabs);
			$tab1->Text = 'First tab is active by default';
			$tab2 = new QPanel($this->Tabs);
			$tab2->Text = 'Tab 2';
			$tab3 = new QPanel($this->Tabs);
			$tab3->Text = 'Tab 3';
			$this->Tabs->Headers = array('One', 'Two', 'Three');
		}

		protected function update_autocompleteList() {
			$strTyped = $this->AjaxAutocomplete->Text;
			
			$cond = QQ::OrCondition (
						QQ::Like (QQN::Person()->FirstName, '%' . $strTyped . '%'),
						QQ::Like (QQN::Person()->LastName, '%' . $strTyped . '%')
					);
					
			$clauses[] = QQ::OrderBy (QQN::Person()->LastName, QQN::Person()->FirstName);
					
			$lst = Person::QueryArray ($cond, $clauses);
			
			// If you implement Person::__toString in the model->Person.class.php file, you 
			// could just pass the $lst to the DataSource.
			// Instead, we will  build the list using autcomplete list items
			
			//$this->AjaxAutocomplete->DataSource = $lst; 
			$a = array();
			foreach ($lst as $objPerson) {
				$a[] = new QAutocompleteListItem ($objPerson->FirstName . ' ' . $objPerson->LastName, $objPerson->Id);
			}
			$this->AjaxAutocomplete->DataSource = $a;
		}
		
		protected function ajaxautocomplete_change() {
			QApplication::DisplayAlert ('Selected item ID: ' . $this->AjaxAutocomplete->SelectedId);
		}
		
		protected function button_click() {
			$dtt = $this->DatepickerBox->DateTime;
			if ($dtt) {
				QApplication::DisplayAlert ($dtt->qFormat('MM/DD/YY'));
			}
		}
		
		protected function slider_change() {
			QApplication::DisplayAlert ($this->Progressbar->Value . ', ' . $this->Slider->Value);
		}
		
		protected function slider2_change() {
			$a = $this->Slider2->Values;
			QApplication::DisplayAlert ($a[0] . ', ' . $a[1]);
		}
		
		public function dialog_press($strFormId, $strControlId, $strParameter) {
			$id = $this->Dialog->ClickedButton;
			QApplication::DisplayAlert ($id . ' was pressed');
		}
		
		public function droppable_drop($strFormId, $strControlId, $strParameter) {
			$id = $this->Droppable->DropObj->DroppedId;
			QApplication::DisplayAlert ($id . ' was dropped.');
		}
		
		public function resizable_stop($strFormId, $strControlId, $strParameter) {
			QApplication::DisplayAlert ( 'Width change = ' . $this->Resizable->ResizeObj->DeltaX . ', height change = ' . $this->Resizable->ResizeObj->DeltaY);
		}

		public function drag_stop($strFormId, $strControlId, $strParameter) {
			$x = $this->Draggable->DragObj->DeltaX;
			$y = $this->Draggable->DragObj->DeltaY;
			QApplication::DisplayAlert ( 'Left change = ' . $x . ', top change = ' . $y);
		}
		
		public function selectable_stop($strFormId, $strControlId, $strParameter) {
			$a = $this->Selectable->SelectedItems;
			$strItems = join (",", $a);
			QApplication::DisplayAlert ($strItems);
		}
		
		public function sortable_stop($strFormId, $strControlId, $strParameter) {
			$a = $this->Sortable->ItemArray;
			$strItems = join (",", $a);
			QApplication::DisplayAlert ($strItems);
		}

		protected function accordion_change() {
			QApplication::DisplayAlert ($this->Accordion->Active . ' selected.');
		}
		
	}

    ExampleForm::Run('ExampleForm');
?>