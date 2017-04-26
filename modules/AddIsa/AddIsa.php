<?php

include_once 'modules/Vtiger/CRMEntity.php';
include_once('vtlib/Vtiger/Event.php');



class AddIsa extends Vtiger_CRMEntity {
        var $table_name = 'vtiger_addisa';
        var $table_index= 'addisaid';

        var $customFieldTable = Array('vtiger_addisacf', 'addisaid');

        var $tab_name = Array('vtiger_crmentity', 'vtiger_addisa', 'vtiger_addisacf');

        var $tab_name_index = Array(
                'vtiger_crmentity' => 'crmid',
                'vtiger_addisa' => 'addisaid',
                'vtiger_addisacf'=>'addisaid');

        var $list_fields = Array (
                /* Format: Field Label => Array(tablename, columnname) */
                // tablename should not have prefix 'vtiger_'
                'Policy Number' => Array('addisa', 'newpolicynumber'),
                'Assigned To' => Array('crmentity','smownerid')
        );
        var $list_fields_name = Array (
                /* Format: Field Label => fieldname */
                'Policy Number' => 'newpolicynumber',
                'Assigned To' => 'assigned_user_id',
        );

        // Make the field link to detail view
        var $list_link_field = 'newpolicynumber';

        // For Popup listview and UI type support
        var $search_fields = Array(
                /* Format: Field Label => Array(tablename, columnname) */
                // tablename should not have prefix 'vtiger_'
                'Policy Number' => Array('addisa', 'newpolicynumber'),
                'Assigned To' => Array('vtiger_crmentity','assigned_user_id'),
        );
        var $search_fields_name = Array (
                /* Format: Field Label => fieldname */
                'Policy Number' => 'newpolicynumber',
                'Assigned To' => 'assigned_user_id',
        );

        // For Popup window record selection
        var $popup_fields = Array ('newpolicynumber');

        // For Alphabetical search
        var $def_basicsearch_col = 'newpolicynumber';

        // Column value to use on detail view record text display
        var $def_detailview_recname = 'newpolicynumber';

        // Used when enabling/disabling the mandatory fields for the module.
        // Refers to vtiger_field.fieldname values.
        var $mandatory_fields = Array('newpolicynumber','assigned_user_id');

        var $default_order_by = 'newpolicynumber';
        var $default_sort_order='ASC';
		
		/**********************************************************************
* Function to handle module specific operations when saving a entity
***********************************************************************/
function save_module($module) {



		}
}
?>