<template OverwriteFlag="true" DocrootFlag="false" DirectorySuffix="" TargetDirectory="<?php echo __MODEL_GEN__  ?>" TargetFileName="<?php echo $objTable->ClassName  ?>Gen.class.php"/>
<?php print("<?php\n"); ?>
	/**
	 * The abstract <?php echo $objTable->ClassName  ?>Gen class defined here is
	 * code-generated and contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * To use, you should use the <?php echo $objTable->ClassName  ?> subclass which
	 * extends this <?php echo $objTable->ClassName  ?>Gen class.
	 *
	 * Because subsequent re-code generations will overwrite any changes to this
	 * file, you should leave this file unaltered to prevent yourself from losing
	 * any information or code changes.  All customizations should be done by
	 * overriding existing or implementing new methods, properties and variables
	 * in the <?php echo $objTable->ClassName  ?> class.
	 *
	 * @package <?php echo QCodeGen::$ApplicationName;  ?>

	 * @subpackage GeneratedDataObjects
<?php include("property_comments.tpl.php"); ?>

	 */
	class <?php echo $objTable->ClassName  ?>Gen extends QBaseClass implements IteratorAggregate {

		<?php include("protected_member_variables.tpl.php"); ?>




		<?php include("protected_member_objects.tpl.php"); ?>


		<?php include("class_initialize.tpl.php"); ?>


		<?php include("class_load_and_count_methods.tpl.php"); ?>




		<?php include("qcubed_query_methods.tpl.php"); ?>




		<?php include("instantiation_methods.tpl.php"); ?>




		<?php include("index_load_methods.tpl.php"); ?>




		//////////////////////////
		// SAVE, DELETE AND RELOAD
		//////////////////////////

		<?php include("object_save.tpl.php"); ?>


		<?php include("object_delete.tpl.php"); ?>


		<?php include("object_reload.tpl.php"); ?>




		////////////////////
		// PUBLIC OVERRIDERS
		////////////////////

		<?php include("property_get.tpl.php"); ?>


		<?php include("property_set.tpl.php"); ?>


		/**
		 * Lookup a VirtualAttribute value (if applicable).  Returns NULL if none found.
		 * @param string $strName
		 * @return string
		 */
		public function GetVirtualAttribute($strName) {
			if (array_key_exists($strName, $this->__strVirtualAttributeArray))
				return $this->__strVirtualAttributeArray[$strName];
			return null;
		}



		<?php include("associated_objects_methods.tpl.php"); ?>





		<?php include("soap_methods.tpl.php"); ?>


		<?php include("json_methods.tpl.php"); ?>


<?php if ($this->blnManualQuerySupport) { ?>

		<?php include("manual_query_methods.tpl.php"); ?>
<?php } ?>
	}



	<?php include("qcubed_query_classes.tpl.php"); ?>

?>
