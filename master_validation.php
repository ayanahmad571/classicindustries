<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
}

if((count($_POST) > 0)  or (count($_GET) > 0)){
	if((count($_POST) > 0)){
		if(isset($_SERVER['HTTP_REFERER'])){
		}else{
			die('Refferer Not Found');
		}
		if((strpos($_SERVER['HTTP_REFERER'],'http://stilwwell.ddns.net') == '0') or (strpos($_SERVER['HTTP_HOST'],'http://localhost/') == '0') or (strpos($_SERVER['HTTP_REFERER'],'http://192.168.') == '0'))
	{
	  //only process operation here
	}else{
		die('Only tld process are allowed');
	}
	}

}else{
	
	die(header('Location: master-validation.php'));
	
}


if(isset($_POST['add_proforma'])){
		if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');
	}
#---------------------------------------
if(isset($_POST['add_proforma_client'])){
  if(!ctype_alnum($_POST['add_proforma_client'])){
  die('Invalid Characters used in add_proforma_client');   }
  else{}
}else{
  die('Enter add_proforma_client');
}
#---------------------------------------
if(isset($_POST['add_proforma_client_ship'])){
  if(!ctype_alnum($_POST['add_proforma_client_ship'])){
  die('Invalid Characters used in add_proforma_client_ship');   }
  else{}
}else{
  die('Enter add_proforma_client_ship');
}
#---------------------------------------
if(isset($_POST['add_po_ref'])){
  if(!is_string($_POST['add_po_ref'])){
  die('Invalid Characters used in add_po_ref');   }
  else{}
}else{
  die('Enter add_po_ref');
}
#---------------------------------------
if(isset($_POST['add_proforma_igst'])){
  if(!is_numeric($_POST['add_proforma_igst']) or !in_range($_POST['add_proforma_igst'],0,100,true)){
  die('Invalid Characters used in add_proforma_igst');   }
  else{}
}else{
  die('Enter add_proforma_igst');
}
#---------------------------------------
if(isset($_POST['add_proforma_cgst'])){
  if(!is_numeric($_POST['add_proforma_cgst']) or !in_range($_POST['add_proforma_cgst'],0,100,true)){
  die('Invalid Characters used in add_proforma_cgst');   }
  else{}
}else{
  die('Enter add_proforma_cgst');
}
#---------------------------------------
if(isset($_POST['add_proforma_sgst'])){
  if(!is_numeric($_POST['add_proforma_sgst']) or !in_range($_POST['add_proforma_sgst'],0,100,true)){
  die('Invalid Characters used in add_proforma_sgst');   }
  else{}
}else{
  die('Enter add_proforma_sgst');
}
#---------------------------------------
if(isset($_POST['add_po_car'])){
  if(!is_string($_POST['add_po_car'])){
  die('Invalid Characters used in add_po_car');   }
  else{}
}else{
  die('Enter add_po_car');
}
#---------------------------------------
if(isset($_POST['add_po_transport'])){
  if(!is_string($_POST['add_po_transport'])){
  die('Invalid Characters used in add_po_transport');   }
  else{}
}else{
  die('Enter add_po_transport');
}
#---------------------------------------
if(isset($_POST['add_po_reverse'])){
  if(!is_numeric($_POST['add_po_reverse'])  or !in_range($_POST['add_po_reverse'],1,2,true) ){
  die('Invalid Characters used in add_po_reverse');   }
  else{}
}else{
  die('Enter add_po_reverse');
}
#---------------------------------------
if(isset($_POST['add_po_supply'])){
  if(!is_string($_POST['add_po_supply'])){
  die('Invalid Characters used in add_po_supply');   }
  else{}
}else{
  die('Enter add_po_supply');
}
#---------------------------------------
if(isset($_POST['add_po_bill_name'])){
  if(!is_string($_POST['add_po_bill_name'])){
  die('Invalid Characters used in add_po_bill_name');   }
  else{}
}else{
  die('Enter add_po_bill_name');
}
#---------------------------------------
if(isset($_POST['add_po_bill_addr1'])){
  if(!is_string($_POST['add_po_bill_addr1'])){
  die('Invalid Characters used in add_po_bill_addr1');   }
  else{}
}else{
  die('Enter add_po_bill_addr1');
}
#---------------------------------------
if(isset($_POST['add_po_bill_addr2'])){
  if(!is_string($_POST['add_po_bill_addr2'])){
  die('Invalid Characters used in add_po_bill_addr2');   }
  else{}
}else{
  die('Enter add_po_bill_addr2');
}
#---------------------------------------
if(isset($_POST['add_po_bill_addr3'])){
  if(!is_string($_POST['add_po_bill_addr3'])){
  die('Invalid Characters used in add_po_bill_addr3');   }
  else{}
}else{
  die('Enter add_po_bill_addr3');
}
#---------------------------------------
if(isset($_POST['add_po_bill_gstin'])){
  if(!is_string($_POST['add_po_bill_gstin'])){
  die('Invalid Characters used in add_po_bill_gstin');   }
  else{}
}else{
  die('Enter add_po_bill_gstin');
}
#---------------------------------------
if(isset($_POST['add_po_bill_state'])){
  if(!is_string($_POST['add_po_bill_state'])){
  die('Invalid Characters used in add_po_bill_state');   }
  else{}
}else{
  die('Enter add_po_bill_state');
}
#---------------------------------------
if(isset($_POST['add_po_ship_name'])){
  if(!is_string($_POST['add_po_ship_name'])){
  die('Invalid Characters used in add_po_ship_name');   }
  else{}
}else{
  die('Enter add_po_ship_name');
}
#---------------------------------------
if(isset($_POST['add_po_ship_addr1'])){
  if(!is_string($_POST['add_po_ship_addr1'])){
  die('Invalid Characters used in add_po_ship_addr1');   }
  else{}
}else{
  die('Enter add_po_ship_addr1');
}
#---------------------------------------
if(isset($_POST['add_po_ship_addr2'])){
  if(!is_string($_POST['add_po_ship_addr2'])){
  die('Invalid Characters used in add_po_ship_addr2');   }
  else{}
}else{
  die('Enter add_po_ship_addr2');
}
#---------------------------------------
if(isset($_POST['add_po_ship_addr3'])){
  if(!is_string($_POST['add_po_ship_addr3'])){
  die('Invalid Characters used in add_po_ship_addr3');   }
  else{}
}else{
  die('Enter add_po_ship_addr3');
}
#---------------------------------------
if(isset($_POST['add_po_ship_gstin'])){
  if(!is_string($_POST['add_po_ship_gstin'])){
  die('Invalid Characters used in add_po_ship_gstin');   }
  else{}
}else{
  die('Enter add_po_ship_gstin');
}
#---------------------------------------
if(isset($_POST['add_po_ship_state'])){
  if(!is_string($_POST['add_po_ship_state'])){
  die('Invalid Characters used in add_po_ship_state');   }
  else{}
}else{
  die('Enter add_po_ship_state');
}
#---------------------------------------



$getclient = getdatafromsql($conn,"select * from sw_clients where md5(cli_id) = '".$_POST['add_proforma_client']."' and cli_valid =1");
if(!is_array($getclient)){
	die('Client not found');
}

$getclient2 = getdatafromsql($conn,"select * from sw_clients where md5(cli_id) = '".$_POST['add_proforma_client_ship']."' and cli_valid =1");
if(!is_array($getclient2)){
	die('Client not found');
}

for($c = 1;$c < 101 ;$c++){
	
	$numi = $c;
		if(isset($_POST['add_proforma_product'.$numi]) ){
		#---------------------------------------
	if(isset($_POST['add_proforma_product'.$numi]) and !is_array($_POST['add_proforma_product'.$numi])){

		if(($_POST['add_proforma_product'.$numi] !== '0') and ($_POST['add_proforma_product'.$numi] !== '987654321987654321')){
			$checklast=1;
			if(ctype_alnum($_POST['add_proforma_product'.$numi])){
					if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_proforma_product'.$numi]."' and pr_valid =1"))){
					}else{
						die('Invalid Product');
						}
				}else{
					die('Invalid Characters used in add_proforma_product'.$numi);   
				}
				
				#---------------------------------------
				if(isset($_POST['add_proforma_product_desc'.$numi])){
				  if(!is_string($_POST['add_proforma_product_desc'.$numi])){
				  die('Invalid Characters used in add_proforma_product_desc'.$numi);   }
				  else{}
				}else{
				  die('Enter add_proforma_product_desc'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_product_remarks'.$numi])){
				  if(!is_string($_POST['add_proforma_product_remarks'.$numi])){
				  die('Invalid Characters used in add_proforma_product_remarks'.$numi);   }
				  else{}
				}else{
				  die('Enter add_proforma_product_remarks'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_product_cost'.$numi])){
				  if(!is_numeric($_POST['add_proforma_product_cost'.$numi])){
				  die('Invalid Characters used in add_proforma_product_cost'.$numi);   }
				  else{}
				}else{
				  die('Enter add_proforma_product_cost'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_product_hsn'.$numi])){
				  if(!is_numeric($_POST['add_proforma_product_hsn'.$numi])){
				  die('Invalid Characters used in add_proforma_product_hsn'.$numi);   }
				  else{}
				}else{
				  die('Enter add_proforma_product_hsn'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_product_price'.$numi])){
				  if(!is_numeric($_POST['add_proforma_product_price'.$numi])){
				  die('Invalid Characters used in add_proforma_product_price'.$numi);   }
				  else{}
				}else{
				  die('Enter add_proforma_product_price'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_product_qty'.$numi])){
				  if(!is_numeric($_POST['add_proforma_product_qty'.$numi])){
				  die('Invalid Characters used in add_proforma_product_qty'.$numi);   }

				  else{}
				}else{
				  die('Enter add_proforma_product_qty'.$numi);
				}
				
		}
		if(($_POST['add_proforma_product'.$numi] == '987654321987654321')){
$checklast = 1;
				#---------------------------------------
				if(isset($_POST['add_proforma_product_desc'.$numi])){
				  if(!is_string($_POST['add_proforma_product_desc'.$numi])){
				  die('Invalid Characters used in add_proforma_product_desc'.$numi);   }
				  else{}
				}else{
				  die('Enter add_proforma_product_desc'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_product_remarks'.$numi])){
				  if(!is_string($_POST['add_proforma_product_remarks'.$numi])){
				  die('Invalid Characters used in add_proforma_product_remarks'.$numi);   }
				  else{}
				}else{
				  die('Enter add_proforma_product_remarks'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_product_cost'.$numi])){
				  if(!is_numeric($_POST['add_proforma_product_cost'.$numi])){
				  die('Invalid Characters used in add_proforma_product_cost'.$numi);   }
				  else{}
				}else{
				  die('Enter add_proforma_product_cost'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_product_hsn'.$numi])){
				  if(!is_numeric($_POST['add_proforma_product_hsn'.$numi])){
				  die('Invalid Characters used in add_proforma_product_hsn'.$numi);   }
				  else{}
				}else{
				  die('Enter add_proforma_product_hsn'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_product_price'.$numi])){
				  if(!is_numeric($_POST['add_proforma_product_price'.$numi])){
				  die('Invalid Characters used in add_proforma_product_price'.$numi);   }
				  else{}
				}else{
				  die('Enter add_proforma_product_price'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_product_qty'.$numi])){
				  if(!is_numeric($_POST['add_proforma_product_qty'.$numi])){
				  die('Invalid Characters used in add_proforma_product_qty'.$numi);   }

				  else{}
				}else{
				  die('Enter add_proforma_product_qty'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_add_new_pr_name'.$numi])){
				  if(!is_string($_POST['add_proforma_add_new_pr_name'.$numi])){
				  die('Invalid Characters used in add_proforma_add_new_pr_name'.$numi);   }

				  else{}
				}else{
				  die('Enter add_proforma_add_new_pr_name'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_add_new_pr_code'.$numi])){
				  if(!is_string($_POST['add_proforma_add_new_pr_code'.$numi])){
				  die('Invalid Characters used in add_proforma_add_new_pr_code'.$numi);   }

				  else{
					  $checkdupeofthis = getdatafromsql($conn,"select * from sw_products_list where pr_code = '".$_POST['add_proforma_add_new_pr_code'.$numi]."' and pr_valid =1");
					  if(is_string($checkdupeofthis)){}else{
						  die('A product with code '.$_POST['add_proforma_add_new_pr_code'.$numi].' already exists');
					  }
					  }
				}else{
				  die('Enter add_proforma_add_new_pr_code'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_add_new_pr_inner_cost'.$numi])){
				  if(!is_numeric($_POST['add_proforma_add_new_pr_inner_cost'.$numi])){
				  die('Invalid Characters used in add_proforma_add_new_pr_inner_cost'.$numi);   }

				  else{}
				}else{
				  die('Enter add_proforma_add_new_pr_inner_cost'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_proforma_add_new_pr_outer_cost'.$numi])){
				  if(!is_numeric($_POST['add_proforma_add_new_pr_outer_cost'.$numi])){
				  die('Invalid Characters used in add_proforma_add_new_pr_outer_cost'.$numi);   }

				  else{}
				}else{
				  die('Enter add_proforma_add_new_pr_outer_cost'.$numi);
				}
				
		}
	}
}
}



$checklast = 0;



if($checklast == 0){
	die('No Items Chosen');
}



}



?>