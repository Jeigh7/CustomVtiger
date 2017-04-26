<?php
date_default_timezone_set('Europe/London');
include_once 'modules/AddIsa/MyDateTime.php';

class AddIsaHandler extends VTEventHandler { 
	function handleEvent($eventName, $entityData) {
		global $adb;
		global $remaining;
		global $isaAllowance;
		global $clientotal;
		global $end;
		$moduleName = $entityData->getModuleName();	
		if($moduleName=='AddIsa'){		
			if($eventName == 'vtiger.entity.beforesave.modifiable') {
				//Set total based on inputs
				$total = $entityData->get('newunitvalue') * $entityData->get('newnumberofunits') / 100;
				$entityData->set('newcurrentamount', $total);
				
				//Check if policynumber already exists.
				$policynumbervalue = $entityData->get('newpolicynumber');
				$sql = $adb->pquery("SELECT policynumber 
									FROM vtiger_isa 
									WHERE policynumber=?",array($policynumbervalue));
									
				$nrows = $adb->num_rows($sql);
				
	 			if($nrows == 0){ 
					
				echo "<script type=\"text/javascript\">window.alert('Cannot add to a policy which does not exist, you will be redirected to the ISA module.');
window.location.href = '/vtigercrm/index.php?module=Isa&view=Edit';</script>"; 
				exit;
	
				}  									
			}
			if($eventName == 'vtiger.entity.beforesave') {
				$relatedclient = $entityData->get('addrelatedclient'); // Input of client
				$policynumbervalue = $entityData->get('newpolicynumber'); // Input of policy number
				$totalinput = $entityData->get('newcurrentamount');
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
window.location.href = '/vtigercrm/index.php';</script>"; 
												exit;
												
												
											}
											
			}
			if($eventName == 'vtiger.entity.beforesave.final') {}
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