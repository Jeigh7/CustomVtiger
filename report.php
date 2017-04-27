<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
<center><h1>Client ISA Statement</h1><br><br><br></center>
</head>
<body>
<?php
require_once('include/database/PearDatabase.php');
include_once('include/events/include.inc');
include_once ('modules/Vtiger/CustomReportsHandler.php');

		$adb = PearDatabase::getInstance();
		$em = new VTEventsManager($adb);

$clientpolicy = $adb->query("SELECT relatedclient, policynumber 
										FROM vtiger_customreports
										ORDER BY customreportsid DESC LIMIT 1");
										
										//print_r($clientpolicy);
										
										$clientpolicy->fetchInto($row);
										$clientid = $row['relatedclient'];
										$polnum = $row['policynumber'];
										
									

$sql = $adb->query("SELECT firstname, lastname, policynumber, isatype, isaname, startdate, unitvalue, numberofunits, currentamount
								FROM vtiger_isa, vtiger_contactdetails
								WHERE vtiger_isa.relatedclient = vtiger_contactdetails.contactid
								AND vtiger_isa.policynumber = $polnum
								AND vtiger_contactdetails.contactid = $clientid"
						       );
							
					
			
$newsql = $adb->query("SELECT newpolicynumber, addrelatedclient, newunitvalue, newnumberofunits, newcurrentamount, date
						FROM vtiger_addisa
						WHERE newpolicynumber = $polnum
						AND addrelatedclient = $clientid
						ORDER BY date ASC");
						
						
						$sql->fetchInto($row);
						
	
   echo $row['firstname'] . "\n";
	echo $row['lastname'] . "<br><br>"; 
	 echo "Policy number: " . $row['policynumber'] . "<br><br>"; 
	  echo $row['isatype'] . ":\n"; 
	   echo $row['isaname'] . "<br><br>"; 
		echo "<b>" . "Initial figues as of: " . $row['startdate'] . "</b>" . ".<br>"; 	
				


?>
<table style="width:100%">
  <tr>
    <th>Unit Value (P)</th>
    <th>Number of Units</th> 
    <th>Total Value (£)</th>
  </tr>
  <tr>
    <td><?php echo $row['unitvalue'];?></td>
    <td><?php echo $row['numberofunits'];?></td> 
    <td><?php echo $row['currentamount'];?></td>
  </tr>
 </table> 
 <br>
 <br>
 <?php 
 $nrows = $adb->num_rows($newsql);
 if ($nrows > 0){
	 ?>

 <b> New Figures:</b>
 <table  style="width:100%">
 <tr>
	<th>Date</th>
	<th>Unit Value (P)</th>
    <th>Number of Units</th> 
    <th>Total Value (£)</th>
	</tr>
	<?php;
 }
 ?>
 <?php
foreach($newsql as $row){
	?>
   <tr>
   <td><?php $newsql->fetchInto($row);
   echo $row['date'];?></td>
   <td><?php echo $row['newunitvalue'];?></td>
	<td><?php echo $row['newnumberofunits'];?></td>
	<td><?php echo $row['newcurrentamount'];?></td>
	</tr>
	<?php
}?>
 </table>
 </body>
</html>