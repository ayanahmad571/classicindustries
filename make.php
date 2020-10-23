<?php
/*include('include.php');
$start = 1501531200;

$end = 1504123200;


for($ia =0; $ia < 101; $ia++){
	$start  = $start + 26000;
	if($conn->query("INSERT INTO `sw_proformas`(`po_rel_cli_id`, `po_ref`, `po_dnt`, `po_ip`, `po_rel_lum_id`, `po_lpo`,
	 `po_igst`, `po_cgst`, `po_sgst`, `po_reverse_charge`, `po_transport`, `po_vehicle`, `po_bill_to_name`, `po_bill_to_addr1`, `po_bill_to_addr2`, `po_bill_to_addr3`, `po_bill_to_gstin`, 
	 `po_bill_to_state`, `po_ship_to_name`, `po_ship_to_addr1`, `po_ship_to_addr2`, `po_ship_to_addr3`, `po_ship_to_gstin`, `po_ship_to_state`, `po_dapos`) VALUES (
	 '".rand(1,2)."',
	 '".($ia + 8)."',
	 '".($start)."',
	 '::1',
	 '2',
	 '-".$ia."',
	 '0',
	 '6',
	 '6',
	 '1',
	 '-',
	 '-',
	 '-',
	 '-',
	 '-',
	 '-',
	 '-',
	 '-',
	 '-',
	 '-',
	 '-',
	 '-',
	 '-',
	 '-',
	 '-'
	 
	 )")){
		 echo 'Added po @ '.$ia.'<br>';
		 
		 for($iao =0;$iao < 5;$iao++){
		 if($conn->query("INSERT INTO `sw_proformas_items`(`pi_rel_po_id`, `pi_rel_pr_id`, `pi_io`, `pi_hsn_code`, `pi_qty`, `pi_cost`, `pi_price`, `pi_desc`, `pi_remarks`) VALUES (
		 	'".$conn->insert_id."',
			'".rand(1,15)."',
			'".rand(1,2)."',
			'4819',
			'".rand(10,500)."',
			'".rand(10,15)."',
			'".rand(20,25)."',
			'-',
			'-'
		 )")){
			 echo $iao.'- Added Item ';
			 }else{
				 die('No item'.$ia);
			 }
		 }
		 
	}else{
		die('No '.$ia);
	}
}*/
?>