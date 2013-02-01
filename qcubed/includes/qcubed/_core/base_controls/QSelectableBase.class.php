<?php
	/**
	 * The QSelectableBase class defined here provides an interface between the generated
	 * QSelectableGen class, and QCubed. This file is part of the core and will be overwritten
	 * when you update QCubed. To override, make your changes to the QSelectable.class.php file instead.
	 *
	 */

	/**
	 * @property-read Array $SelectedItems ControlIds of the items selected
	 */
	class QSelectableBase extends QSelectableGen
	{
		/** @var array */
		protected $arySelectedItems = null;
		

		// These functions are used to keep track of the selected items 
		
		public function GetControlJavaScript() {
			$strJS = parent::GetControlJavaScript();
			
			$strJS .=<<<FUNC
			.on("selectablestop", function (event, ui) {
				var strItems;
				
				strItems = "";
				jQuery(".ui-selected", this).each(function() {
					strItems = strItems + "," + this.id;
				});
				
				if (strItems) {
					strItems = strItems.substring (1);
				}
				qcubed.recordControlModification("$this->ControlId", "_SelectedItems", strItems);
				
			})
FUNC;
			
			return $strJS;
		}


		public function __set($strName, $mixValue) {
			switch ($strName) {
				case '_SelectedItems':	// Internal only. Do not use. Used by JS above to keep track of selections.
					try {
						$strItems = QType::Cast($mixValue, QType::String);
						$this->arySelectedItems = explode (",", $strItems);
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;
					
				case 'SelectedItems':
					// Set the selected items to an array of object ids
					try {
						$aValues = QType::Cast($mixValue, QType::ArrayType);
						$aJqIds = array();
						foreach ($aValues as $val) {
							$aJqIds[] = '"#' . $val . '"';
						}
						$strJqItems = join (',', $aJqIds);
							
						$strJS =<<<FUNC
							var item = jQuery("#$this->ControlId");
							
							jQuery(".ui-selectee", item).each(function() {
								jQuery(this).removeClass('ui-selected');
							});
							
							jQuery($strJqItems).each(function() {
								jQuery(this).addClass('ui-selected');
							});
FUNC;
						$this->arySelectedItems = $aValues;
						QApplication::ExecuteJavascript ($strJS);
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;
					 
				default:
					try {
						parent::__set($strName, $mixValue);
						break;
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
			
		}
		
		public function __get($strName) {
			switch ($strName) {
				case 'SelectedItems': return $this->arySelectedItems;
				
				default: 
					try { 
						return parent::__get($strName); 
					} catch (QCallerException $objExc) { 
						$objExc->IncrementOffset(); 
						throw $objExc; 
					}
			}
		}

	}
?>