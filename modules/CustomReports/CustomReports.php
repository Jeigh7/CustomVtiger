<?php

include_once 'modules/Vtiger/CRMEntity.php';
include_once('vtlib/Vtiger/Event.php');



class CustomReports extends Vtiger_CRMEntity {
        var $table_name = 'vtiger_customreports';
        var $table_index= 'customreportsid';

        var $customFieldTable = Array('vtiger_customreportscf', 'customreportsid');

        var $tab_name = Array('vtiger_crmentity', 'vtiger_customreports', 'vtiger_customreportscf');

        var $tab_name_index = Array(
                'vtiger_crmentity' => 'crmid',
                'vtiger_customreports' => 'customreportsid',
                'vtiger_customreportscf'=>'customreportsid');

        var $list_fields = Array (
                /* Format: Field Label => Array(tablename, columnname) */
                // tablename should not have prefix 'vtiger_'
                'Client' => Array('customreports', 'relatedclient'),
                'Assigned To' => Array('crmentity','smownerid')
        );
        var $list_fields_name = Array (
                /* Format: Field Label => fieldname */
                'Client' => 'relatedclient',
                'Assigned To' => 'assigned_user_id',
        );

        // Make the field link to detail view
        var $list_link_field = 'relatedclient';

        // For Popup listview and UI type support
        var $search_fields = Array(
                /* Format: Field Label => Array(tablename, columnname) */
                // tablename should not have prefix 'vtiger_'
                'Client' => Array('customreports', 'relatedclient'),
                'Assigned To' => Array('vtiger_crmentity','assigned_user_id'),
        );
        var $search_fields_name = Array (
                /* Format: Field Label => fieldname */
                'Client' => 'relatedclient',
                'Assigned To' => 'assigned_user_id',
        );

        // For Popup window record selection
        var $popup_fields = Array ('relatedclient');

        // For Alphabetical search
        var $def_basicsearch_col = 'relatedclient';

        // Column value to use on detail view record text display
        var $def_detailview_recname = 'relatedclient';

        // Used when enabling/disabling the mandatory fields for the module.
        // Refers to vtiger_field.fieldname values.
        var $mandatory_fields = Array('relatedclient','assigned_user_id');

        var $default_order_by = 'relatedclient';
        var $default_sort_order='ASC';
		
		function save_module($module) {



		}
		
}