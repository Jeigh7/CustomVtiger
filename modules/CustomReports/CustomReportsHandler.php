 <?php

class CustomReportsHandler extends VTEventHandler { 
    function handleEvent($eventName, $entityData) {
        global $adb;
		global $relatedclient;
		global $policynumber;
        $moduleName = $entityData->getModuleName(); 
        if($moduleName=='CustomReports'){     
            if($eventName == 'vtiger.entity.beforesave.modifiable') {}
            if($eventName == 'vtiger.entity.beforesave') {}
            
            if($eventName == 'vtiger.entity.beforesave.final') {}
            if($eventName == 'vtiger.entity.aftersave') {
				$policynumber = $entityData->get('policynumber');
			$relatedclient = $entityData->get('relatedclient');
		echo "<script type=\"text/javascript\">window.alert('You are being redirected to the clients isa report.');
window.location.href = '/vtigercrm/report.php';</script>"; 
exit;
				
			}
        }   
    }

}
?>