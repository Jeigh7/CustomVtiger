<?php
 

include_once 'modules/Vtiger/CRMEntity.php';
include_once('vtlib/Vtiger/Event.php');



class Mortgage extends Vtiger_CRMEntity {
        var $table_name = 'vtiger_mortgage';
        var $table_index= 'mortgageid';

        var $customFieldTable = Array('vtiger_mortgagecf', 'mortgageid');

        var $tab_name = Array('vtiger_crmentity', 'vtiger_mortgage', 'vtiger_mortgagecf');

        var $tab_name_index = Array(
                'vtiger_crmentity' => 'crmid',
                'vtiger_mortgage' => 'mortgageid',
                'vtiger_mortgagecf'=>'mortgageid');

        var $list_fields = Array (
                /* Format: Field Label => Array(tablename, columnname) */
                // tablename should not have prefix 'vtiger_'
                'Policy Number' => Array('mortgage', 'policynumber'),
                'Assigned To' => Array('crmentity','smownerid')
        );
        var $list_fields_name = Array (
                /* Format: Field Label => fieldname */
                'Policy Number' => 'policynumber',
                'Assigned To' => 'assigned_user_id',
        );

        // Make the field link to detail view
        var $list_link_field = 'policynumber';

        // For Popup listview and UI type support
        var $search_fields = Array(
                /* Format: Field Label => Array(tablename, columnname) */
                // tablename should not have prefix 'vtiger_'
                'Policy Number' => Array('isa', 'policynumber'),
                'Assigned To' => Array('vtiger_crmentity','assigned_user_id'),
        );
        var $search_fields_name = Array (
                /* Format: Field Label => fieldname */
                'Policy Number' => 'policynumber',
                'Assigned To' => 'assigned_user_id',
        );

        // For Popup window record selection
        var $popup_fields = Array ('policynumber');

        // For Alphabetical search
        var $def_basicsearch_col = 'policynumber';

        // Column value to use on detail view record text display
        var $def_detailview_recname = 'policynumber';

        // Used when enabling/disabling the mandatory fields for the module.
        // Refers to vtiger_field.fieldname values.
        var $mandatory_fields = Array('policynumber','assigned_user_id');

        var $default_order_by = 'policynumber';
        var $default_sort_order='ASC';
		

}