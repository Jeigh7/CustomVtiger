 <?php
date_default_timezone_set('Europe/London');
include_once './Isa/MyDateTime.php';

class IsaHandler extends VTEventHandler { 
    function handleEvent($eventName, $entityData) {
        global $adb;
		global $remaining;
		global $isaAllowance;
		global $clientotal;
		global $end;
        $moduleName = $entityData->getModuleName(); 
        if($moduleName=='Isa'){     
            if($eventName == 'vtiger.entity.beforesave.modifiable') {
				//Declaring variables
				$total = $entityData->get('unitvalue') * $entityData->get('numberofunits') /100;
				$entityData->set('currentamount', $total);
				$policynumbervalue = $entityData->get('policynumber');
				//Check if policynumber already exists.
				$sql = $adb->pquery("SELECT policynumber 
									FROM vtiger_isa
									WHERE policynumber=?",array($policynumbervalue)); // Select where policynumber = input
									
				$nrows = $adb->num_rows($sql);
				
				if($nrows > 0){ // Number of rows more than one
					
				echo "<script type=\"text/javascript\">window.alert('ISA policy number already exists, you will be redirected to the AddIsa module.');
window.location.href = '/vtigercrm/index.php?module=AddIsa&view=Edit';</script>"; 
	exit;
	
				}

			}
            if($eventName == 'vtiger.entity.beforesave') {
					$price = $entityData->get('numberofunits')*$entityData->get('unitvalue') / 100;
					$isaAllowance = 20000;
					// Maximum ISA allowance check
                    if($price > $isaAllowance){
                   echo "<script type=\"text/javascript\">window.alert('Please enter an amount less than £20,000.');
window.location.href = '/vtigercrm/index.php?module=Isa&view=Edit';</script>"; 
					exit;
					 }
			}
               
            if($eventName == 'vtiger.entity.beforesave.final') {
				$relatedclient = $entityData->get('relatedclient'); // Input of client
				$totalinput = $entityData->get('currentamount');
				$mydate = new MyDateTime();						
				$result = $mydate->fiscalYear();
				$start = $result['start']->format('d M Y');
				$end = $result['end']->format('d M Y');

											
							$sumtotal = $adb->pquery("SELECT 
														SUM(currentamount),
														SUM(newcurrentamount),
														(SUM(currentamount) + SUM(newcurrentamount)) as 'Total'
																	FROM vtiger_addisa, vtiger_isa
																	WHERE vtiger_addisa.addrelatedclient = $relatedclient
																	AND vtiger_isa.relatedclient = $relatedclient
																	AND vtiger_addisa.date >= '$start'
																	AND vtiger_isa.startdate >= '$start'
																	");
																	
																	
											$sumtotal->fetchInto($row);
											$clientotal = $row['Total'] + $totalinput;
											$isaAllowance = 20000;
											$remaining = $isaAllowance - $clientotal;
											
											if($clientotal > $isaAllowance){
												echo "<script type=\"text/javascript\">window.alert('Client has no more ISA allowance remaining, this will start again on $end.');
window.location.href = '/vtigercrm/index.php?module=Isa&view=Edit';</script>"; 
												exit;
											}
											
			}
            if($eventName == 'vtiger.entity.aftersave') {
				if($clientotal < $isaAllowance){
					echo "<script type=\"text/javascript\">window.alert('Client has £$remaining remaining until $end.');
window.location.href = '/vtigercrm/index.php';</script>"; 
	exit;
				}
			}
        }   
    }

}
?>