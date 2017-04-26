<?php

include_once 'vtlib/Vtiger/Module.php';

$Vtiger_Utils_Log = true;

$MODULENAME = 'Isa';

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
        $field1->name = 'policynumber';
        $field1->label= 'Policy Number';
        $field1->uitype= 2;
        $field1->column = $field1->name;
        $field1->columntype = 'VARCHAR(255)';
        $field1->typeofdata = 'V~M';
        $block->addField($field1);

        $moduleInstance->setEntityIdentifier($field1);
		
		$field2  = new Vtiger_Field();
        $field2->name = 'relatedclient';
        $field2->label= 'Client';
        $field2->uitype= 10;
        $field2->column = $field2->name;
        $field2->columntype = 'VARCHAR(255)';
        $field2->typeofdata = 'V~M';
        $block->addField($field2);
		$field2->setRelatedModules(Array('Contacts'));
		
		$field3  = new Vtiger_Field();
        $field3->name = 'isatype';
        $field3->label= 'Type of ISA';
        $field3->uitype= 15;
        $field3->column = $field3->name;
        $field3->columntype = 'VARCHAR(255)';
        $field3->typeofdata = 'V~M';
        $block->addField($field3);
		$field3->setPicklistValues( Array ('Stocks and Shares') );
		
		$field4  = new Vtiger_Field();
        $field4->name = 'isaname';
        $field4->label= 'Fund Name';
        $field4->uitype= 2;
        $field4->column = $field4->name;
        $field4->columntype = 'VARCHAR(255)';
        $field4->typeofdata = 'V~M';
        $block->addField($field4);

        $field5  = new Vtiger_Field();
        $field5->name = 'startdate';
        $field5->label= 'Start Date';
        $field5->uitype= 5;
        $field5->column = $field5->name;
        $field5->columntype = 'Date';
        $field5->typeofdata = 'D~O';
        $block->addField($field5);
		
		$field6  = new Vtiger_Field();
        $field6->name = 'unitvalue';
        $field6->label= 'Unit Value';
        $field6->uitype= 71;
        $field6->column = $field6->name;
        $field6->columntype = 'VARCHAR(255)';
        $field6->typeofdata = 'V~M';
        $block->addField($field6);
		
		$field7  = new Vtiger_Field();
        $field7->name = 'numberofunits';
        $field7->label= 'Number of Units';
        $field7->uitype= 7;
        $field7->column = $field7->name;
        $field7->columntype = 'VARCHAR(255)';
        $field7->typeofdata = 'NN~M~10,3';
        $block->addField($field7);

        $field8  = new Vtiger_Field();
        $field8->name = 'currentamount';
        $field8->label= 'Total Current Amount';
        $field8->uitype= 71;
        $field8->column = $field8->name;
        $field8->columntype = 'VARCHAR(255)';
        $field8->typeofdata = 'V~O';
        $block->addField($field8);
		
		// Used to show ISA within contacts module
		$moduleInstance = Vtiger_Module::getInstance('Contacts');
		$accountsModule = Vtiger_Module::getInstance('Isa');
		$relationLabel = 'Isa';
		$moduleInstance->setRelatedList(
		$accountsModule, $relationLabel, Array('ADD','SELECT')

		


      // Filter Setup
        $filter1 = new Vtiger_Filter();
        $filter1->name = 'All';
        $filter1->isdefault = true;
        $moduleInstance->addFilter($filter1);
        $filter1->addField($field1)->addField($field2, 1)->addField($field8, 2);

        // Sharing Access Setup
        $moduleInstance->setDefaultSharing();

        // Webservice Setup
        $moduleInstance->initWebservice();

        mkdir('modules/'.$MODULENAME);
        echo "OK\n";
}
?>