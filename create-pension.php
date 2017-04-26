<?php

ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );

include_once 'vtlib/Vtiger/Module.php';

$Vtiger_Utils_Log = true;

$MODULENAME = 'Pension';

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
        $field3->name = 'company';
        $field3->label= 'Pension Company';
        $field3->uitype= 2;
        $field3->column = $field3->name;
        $field3->columntype = 'VARCHAR(255)';
        $field3->typeofdata = 'V~M';
        $block->addField($field3);
		
        $field4  = new Vtiger_Field();
        $field4->name = 'startdate';
        $field4->label= 'Start Date';
        $field4->uitype= 5;
        $field4->column = $field4->name;
        $field4->columntype = 'Date';
        $field4->typeofdata = 'D~O';
        $block->addField($field4);
		
		$field5  = new Vtiger_Field();
        $field5->name = 'monthly';
        $field5->label= 'Monthly Payment';
        $field5->uitype= 71;
        $field5->column = $field5->name;
        $field5->columntype = 'VARCHAR(255)';
        $field5->typeofdata = 'V~M';
        $block->addField($field5);


		$moduleInstance = Vtiger_Module::getInstance('Contacts');
		$accountsModule = Vtiger_Module::getInstance('Pension');
		$relationLabel  = 'Pension';
		$moduleInstance->setRelatedList(
		$accountsModule, $relationLabel, Array('ADD','SELECT'));
 


      // Filter Setup
        $filter1 = new Vtiger_Filter();
        $filter1->name = 'All';
        $filter1->isdefault = true;
        $moduleInstance->addFilter($filter1);
        $filter1->addField($field1)->addField($field2, 1);

        // Sharing Access Setup
        $moduleInstance->setDefaultSharing();

        // Webservice Setup
        $moduleInstance->initWebservice();

        mkdir('modules/'.$MODULENAME);
        echo "OK\n";
}
?>