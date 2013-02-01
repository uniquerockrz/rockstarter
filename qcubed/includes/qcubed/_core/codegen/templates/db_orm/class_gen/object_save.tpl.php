/**
		 * Save this <?php echo $objTable->ClassName  ?>

		 * @param bool $blnForceInsert
		 * @param bool $blnForceUpdate
<?php
	$returnType = 'void';
	foreach ($objArray = $objTable->ColumnArray as $objColumn)
		if ($objColumn->Identity) {
			$returnType = 'int';
			break;
		}
	print '		 * @return '.$returnType;
?>

		 */
		public function Save($blnForceInsert = false, $blnForceUpdate = false) {
			// Get the Database Object for this Class
			$objDatabase = <?php echo $objTable->ClassName  ?>::GetDatabase();

			$mixToReturn = null;

			try {
				if ((!$this->__blnRestored) || ($blnForceInsert)) {
					// Perform an INSERT query
					$objDatabase->NonQuery('
						INSERT INTO <?php echo $strEscapeIdentifierBegin  ?><?php echo $objTable->Name  ?><?php echo $strEscapeIdentifierEnd  ?> (
<?php foreach ($objTable->ColumnArray as $objColumn) { ?>
<?php if ((!$objColumn->Identity) && (!$objColumn->Timestamp)) { ?>
							<?php echo $strEscapeIdentifierBegin  ?><?php echo $objColumn->Name  ?><?php echo $strEscapeIdentifierEnd  ?>,
<?php } ?>
<?php } ?><?php GO_BACK(2); ?>

						) VALUES (
<?php foreach ($objTable->ColumnArray as $objColumn) { ?>
<?php if ((!$objColumn->Identity) && (!$objColumn->Timestamp)) { ?>
							' . $objDatabase->SqlVariable($this-><?php echo $objColumn->VariableName  ?>) . ',
<?php } ?>
<?php } ?><?php GO_BACK(2); ?>

						)
					');

<?php 
	foreach ($objArray = $objTable->PrimaryKeyColumnArray as $objColumn)
		if ($objColumn->Identity)
			print sprintf('					// Update Identity column and return its value
					$mixToReturn = $this->%s = $objDatabase->InsertId(\'%s\', \'%s\');',
					$objColumn->VariableName, $objTable->Name, $objColumn->Name);
?>

				} else {
					// Perform an UPDATE query

					// First checking for Optimistic Locking constraints (if applicable)
<?php foreach ($objTable->ColumnArray as $objColumn) { ?>
<?php if ($objColumn->Timestamp) { ?>
					if (!$blnForceUpdate) {
						// Perform the Optimistic Locking check
						$objResult = $objDatabase->Query('
							SELECT
								<?php echo $strEscapeIdentifierBegin  ?><?php echo $objColumn->Name  ?><?php echo $strEscapeIdentifierEnd  ?>

							FROM
								<?php echo $strEscapeIdentifierBegin  ?><?php echo $objTable->Name  ?><?php echo $strEscapeIdentifierEnd  ?>

							WHERE
<?php foreach ($objTable->PrimaryKeyColumnArray as $objPkColumn) { ?>
<?php if ($objPkColumn->Identity) { ?>
								<?php echo $strEscapeIdentifierBegin  ?><?php echo $objPkColumn->Name  ?><?php echo $strEscapeIdentifierEnd  ?> = ' . $objDatabase->SqlVariable($this-><?php echo $objPkColumn->VariableName  ?>) . ' AND
<?php } ?><?php if (!$objPkColumn->Identity) { ?>
								<?php echo $strEscapeIdentifierBegin  ?><?php echo $objPkColumn->Name  ?><?php echo $strEscapeIdentifierEnd  ?> = ' . $objDatabase->SqlVariable($this->__<?php echo $objPkColumn->VariableName  ?>) . ' AND
<?php } ?>
<?php } ?><?php GO_BACK(5); ?>

						');

						$objRow = $objResult->FetchArray();
						if ($objRow[0] != $this-><?php echo $objColumn->VariableName  ?>)
							throw new QOptimisticLockingException('<?php echo $objTable->ClassName  ?>');
					}
<?php } ?>
<?php } ?>

					// Perform the UPDATE query
					$objDatabase->NonQuery('
						UPDATE
							<?php echo $strEscapeIdentifierBegin  ?><?php echo $objTable->Name  ?><?php echo $strEscapeIdentifierEnd  ?>

						SET
<?php foreach ($objTable->ColumnArray as $objColumn) { ?>
<?php if ((!$objColumn->Identity) && (!$objColumn->Timestamp)) { ?>
							<?php echo $strEscapeIdentifierBegin  ?><?php echo $objColumn->Name  ?><?php echo $strEscapeIdentifierEnd  ?> = ' . $objDatabase->SqlVariable($this-><?php echo $objColumn->VariableName  ?>) . ',
<?php } ?>
<?php } ?><?php GO_BACK(2); ?>

						WHERE
<?php foreach ($objTable->PrimaryKeyColumnArray as $objColumn) { ?>
<?php if ($objColumn->Identity) { ?>
							<?php echo $strEscapeIdentifierBegin  ?><?php echo $objColumn->Name  ?><?php echo $strEscapeIdentifierEnd  ?> = ' . $objDatabase->SqlVariable($this-><?php echo $objColumn->VariableName  ?>) . ' AND
<?php } ?><?php if (!$objColumn->Identity) { ?>
							<?php echo $strEscapeIdentifierBegin  ?><?php echo $objColumn->Name  ?><?php echo $strEscapeIdentifierEnd  ?> = ' . $objDatabase->SqlVariable($this->__<?php echo $objColumn->VariableName  ?>) . ' AND
<?php } ?>
<?php } ?><?php GO_BACK(5); ?>

					');
				}

<?php foreach ($objTable->ReverseReferenceArray as $objReverseReference) { ?>
<?php if ($objReverseReference->Unique) { ?>
<?php $objReverseReferenceTable = $objCodeGen->TableArray[strtolower($objReverseReference->Table)]; ?>
<?php $objReverseReferenceColumn = $objReverseReferenceTable->ColumnArray[strtolower($objReverseReference->Column)]; ?>


				// Update the adjoined <?php echo $objReverseReference->ObjectDescription  ?> object (if applicable)
				// TODO: Make this into hard-coded SQL queries
				if ($this->blnDirty<?php echo $objReverseReference->ObjectPropertyName  ?>) {
					// Unassociate the old one (if applicable)
					if ($objAssociated = <?php echo $objReverseReference->VariableType  ?>::LoadBy<?php echo $objReverseReferenceColumn->PropertyName  ?>(<?php echo $objCodeGen->ImplodeObjectArray(', ', '$this->', '', 'VariableName', $objTable->PrimaryKeyColumnArray)  ?>)) {
						$objAssociated-><?php echo $objReverseReferenceColumn->PropertyName  ?> = null;
						$objAssociated->Save();
					}

					// Associate the new one (if applicable)
					if ($this-><?php echo $objReverseReference->ObjectMemberVariable  ?>) {
						$this-><?php echo $objReverseReference->ObjectMemberVariable  ?>-><?php echo $objReverseReferenceColumn->PropertyName  ?> = $this-><?php echo $objTable->PrimaryKeyColumnArray[0]->VariableName  ?>;
						$this-><?php echo $objReverseReference->ObjectMemberVariable  ?>->Save();
					}

					// Reset the "Dirty" flag
					$this->blnDirty<?php echo $objReverseReference->ObjectPropertyName  ?> = false;
				}
<?php } ?>
<?php } ?>
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Update __blnRestored and any Non-Identity PK Columns (if applicable)
			$this->__blnRestored = true;
<?php foreach ($objTable->PrimaryKeyColumnArray as $objColumn) { ?>
<?php if ((!$objColumn->Identity) && ($objColumn->PrimaryKey)) { ?>
			$this->__<?php echo $objColumn->VariableName  ?> = $this-><?php echo $objColumn->VariableName  ?>;
<?php } ?>
<?php } ?>

<?php foreach ($objTable->ColumnArray as $objColumn) { ?>
<?php if ($objColumn->Timestamp) { ?>
			// Update Local Timestamp
			$objResult = $objDatabase->Query('
				SELECT
					<?php echo $strEscapeIdentifierBegin  ?><?php echo $objColumn->Name  ?><?php echo $strEscapeIdentifierEnd  ?>

				FROM
					<?php echo $strEscapeIdentifierBegin  ?><?php echo $objTable->Name  ?><?php echo $strEscapeIdentifierEnd  ?>

				WHERE
<?php foreach ($objTable->PrimaryKeyColumnArray as $objPkColumn) { ?>
<?php if ($objPkColumn->Identity) { ?>
					<?php echo $strEscapeIdentifierBegin  ?><?php echo $objPkColumn->Name  ?><?php echo $strEscapeIdentifierEnd  ?> = ' . $objDatabase->SqlVariable($this-><?php echo $objPkColumn->VariableName  ?>) . ' AND
<?php } ?><?php if (!$objPkColumn->Identity) { ?>
					<?php echo $strEscapeIdentifierBegin  ?><?php echo $objPkColumn->Name  ?><?php echo $strEscapeIdentifierEnd  ?> = ' . $objDatabase->SqlVariable($this->__<?php echo $objPkColumn->VariableName  ?>) . ' AND
<?php } ?>
<?php } ?><?php GO_BACK(5); ?>

			');

			$objRow = $objResult->FetchArray();
			$this-><?php echo $objColumn->VariableName  ?> = $objRow[0];
<?php } ?>
<?php } ?>

			$this->DeleteCache();

			// Return
			return $mixToReturn;
		}