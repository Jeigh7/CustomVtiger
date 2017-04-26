<?php
//USE THIS ONE JEIGH FOR ISA!!!!!!!!!!!
include_once 'vtlib/Vtiger/Module.php';

$Vtiger_Utils_Log = true;

$MODULENAME = 'AddIsa';

$moduleInstance = Vtiger_Module::getInstance($MODULENAME);
if ($moduleInstance || file_exists('modules/'.$MODULENAME)) {
        echo "Module already present - choose a different name.";
} else {
        $moduleInstance = new Vtiger_Module();
        $moduleInstance->name = $MODULENAME;
        $moduleInstance->parent= 'Tools';
        $moduleInstance->save();

        // Schema Setup
        $moduleInstance->initTables();

        // Field Setup
        $block = new Vtiger_Block();
        $block->label = 'LBL_'. strtoupper($moduleInstance->name) . '_INFORMATION';
        $moduleInstance->addBlock($block);

        $blockcf = new Vtiger_Block();
        $blockcf->label = 'LBL_CUSTOM_INFORMATION';
        $moduleInstance->addBlock($blockcf);

        $field1  = new Vtiger_Field();
        $field1->name = 'newpolicynumber';
        $field1->label= 'Policy Number';
        $field1->uitype= 2;
        $field1->column = $field1->name;
        $field1->columntype = 'VARCHAR(255)';
        $field1->typeofdata = 'V~M';
        $block->addField($field1);

        $moduleInstance->setEntityIdentifier($field1);
		
		$field2  = new Vtiger_Field();
        $field2->name = 'addrelatedclient';
        $field2->label= 'Client';
        $field2->uitype= 10;
        $field2->column = $field2->name;
        $field2->columntype = 'VARCHAR(255)';
        $field2->typeofdata = 'V~M';
        $block->addField($field2);
		$field2->setRelatedModules(Array('Contacts'));
		
		$field3  = new Vtiger_Field();
        $field3->name = 'newunitvalue';
        $field3->label= 'New Unit Value';
        $field3->uitype= 71;
        $field3->column = $field3->name;
        $field3->columntype = 'decimal(11,0)';
        $field3->typeofdata = 'N~M~10,2';
        $block->addField($field3);
		
		$field4  = new Vtiger_Field();
        $field4->name = 'newnumberofunits';
        $field4->label= 'New Number of Units';
        $field4->uitype= 7;
        $field4->column = $field4->name;
        $field4->columntype = 'VARCHAR(255)';
        $field4->typeofdata = 'NN~M~10,3';
        $block->addField($field4);

        $field5  = new Vtiger_Field();
        $field5->name = 'newcurrentamount';
        $field5->label= 'Total - Leave Blank';
        $field5->uitype= 71;
        $field5->column = $field5->name;
        $field5->columntype = 'VARCHAR(255)';
        $field5->typeofdata = 'V~O';
        $block->addField($field5);
		
		$field6  = new Vtiger_Field();
        $field6->name = 'date';
        $field6->label= 'Date:';
        $field6->uitype= 5;
        $field6->column = $field6->name;
        $field6->columntype = 'Date';
        $field6->typeofdata = 'D~M';
        $block->addField($field6);
		
		        // Recommended common fields every Entity module should have (linked to core table)
        $mfield1 = new Vtiger_Field();
        $mfield1->name = 'assigned_user_id';
        $mfield1->label = 'Assigned To';
        $mfield1->table = 'vtiger_crmentity';
        $mfield1->column = 'smownerid';
        $mfield1->uitype = 53;
        $mfield1->typeofdata = 'V~M';
        $block->addField($mfield1);

        $mfield2 = new Vtiger_Field();
        $mfield2->name = 'CreatedTime';
        $mfield2->label= 'Created Time';
        $mfield2->table = 'vtiger_crmentity';
        $mfield2->column = 'createdtime';
        $mfield2->uitype = 70;
        $mfield2->typeofdata = 'T~O';
        $mfield2->displaytype= 2;
        $block->addField($mfield2);

        $mfield3 = new Vtiger_Field();
        $mfield3->name = 'ModifiedTime';
        $mfield3->label= 'Modified Time';
        $mfield3->table = 'vtiger_crmentity';
        $mfield3->column = 'modifiedtime';
        $mfield3->uitype = 70;
        $mfield3->typeofdata = 'T~O';
        $mfield3->displaytype= 2;
        $block->addField($mfield3);
		
		// Used to show ISA within contacts module
		$moduleInstance = Vtiger_Module::getInstance('Contacts');
		$accountsModule = Vtiger_Module::getInstance('AddIsa');
		$relationLabel = 'AddIsa';
		$moduleInstance->setRelatedList(
		$accountsModule, $relationLabel, Array('ADD','SELECT')

      // Filter Setup
        $filter1 = new Vtiger_Filter();
        $filter1->name = 'All';
        $filter1->isdefault = true;
        $moduleInstance->addFilter($filter1);
        $filter1->addField($field1)->addField($field2, 1)->addField($field3, 2);

        // Sharing Access Setup
        $moduleInstance->setDefaultSharing();

        // Webservice Setup
        $moduleInstance->initWebservice();

        mkdir('modules/'.$MODULENAME);
        echo "OK\n";
}
?>