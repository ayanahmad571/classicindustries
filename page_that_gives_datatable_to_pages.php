<?php
include('include.php');
if(!isset($_SERVER['HTTP_REFERER'])){
	header('Location: page_that_gives_datatable_to_pagas.php');
}
$_COMPANY = make_company_ar($conn);	

?>
<?php

if(isset($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID']) and trim($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID']) != ''){
}else{
	die('Login to continue <a href="login.php">Login	</a>');
}
?>
<?php

if(isset($_REQUEST['bills_get_table'])){

    $aColumns = array( 'po_ref','cli_name', 'state_name', 'tax','totaltax','totalbill','po_dnt',' ');
    $aColumnsSe = array( 'po_ref','cli_name', 'state_name');
     
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "po_id";
     
    /* DB table to use */
    $sTable = "sw_proformas";
     
     
    function fatal_error ( $sErrorMessage = '' )
    {
        header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
        die( $sErrorMessage );
    }
 
    /*
     * Paging
     */
    $sLimit = " limit 10";
    if ( isset( $_GET['start'] ) && $_GET['length'] != '-1' )
    {
        $sLimit = "LIMIT ".intval( $_GET['start'] ).", ".
            intval( $_GET['length'] );
    }
     
     
    /*
     * Ordering
     */
    $sOrder = "order by po_ref desc";
    if ( isset( $_GET['order'][0]) and ($_GET['order'][0]['column'] !==9) )
    {
        
		if($_GET['order'][0]['column'] == 0){
			$sOrder = "ORDER BY  po_ref
                    ".($_GET['order'][0]['dir']==='asc' ? 'asc' : 'desc') .", ";
		}else if($_GET['order'][0]['column'] == 3){
			$sOrder = "ORDER BY  po_dnt
                    ".($_GET['order'][0]['dir']==='asc' ? 'asc' : 'desc') .", ";
		}else if($_GET['order'][0]['column'] == 4){
			$sOrder = "ORDER BY  po_dnt
                    ".($_GET['order'][0]['dir']==='asc' ? 'asc' : 'desc') .", ";
		}else if($_GET['order'][0]['column'] == 5){
			$sOrder = "ORDER BY  po_dnt
                    ".($_GET['order'][0]['dir']==='asc' ? 'asc' : 'desc') .", ";
		}else if($_GET['order'][0]['column'] == 7){
			$sOrder = "ORDER BY  po_dnt
                    ".($_GET['order'][0]['dir']==='asc' ? 'asc' : 'desc') .", ";
		}else{
			$sOrder = "ORDER BY  ". $aColumns[$_GET['order'][0]['column']]."
                    ".($_GET['order'][0]['dir']==='asc' ? 'asc' : 'desc') .", ";
		}
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" )
        {
            $sOrder = "";
        }
    }
     
     
     
    /*
     * Filtering
     */
    $sWhere = " where p.po_valid =1 and c.cli_valid =1 ";
    if ( isset($_GET['search']) && $_GET['search']['value'] != "" )
    {
        $sWhere = "WHERE  p.po_valid =1 and c.cli_valid =1  and (";
        for ( $i=0 ; $i<(count($aColumnsSe)-1) ; $i++ )
        {
                $sWhere .= $aColumns[$i]." LIKE '%".$conn->escape_string( $_GET['search']['value'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ' )';
    }

    /* Individual column filtering 
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".$conn->escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }*/
     
     
    /*
     * SQL queries
     * Get data to display
     */
    $sQuery = "
SELECT  SQL_CALC_FOUND_ROWS *  FROM ".$sTable."  p
left join sw_clients c on p.po_rel_cli_id = c.cli_id
left join sw_master_states_gst stg on cli_rel_state_id = state_id


		
        ".$sWhere."
        ".$sOrder."
        ".$sLimit."
    ";
#var_dump($_REQUEST).'<hr>';
#echo $sQuery.'<hr>';

    $rResult = $conn->query( $sQuery) or fatal_error( 'MySQL Error: ' . $conn->error);
     
    /* Data set length after filtering */
    $sQuery = "
        SELECT FOUND_ROWS()
    ";
    $rResultFilterTotal = $conn->query( $sQuery) or fatal_error( 'MySQL Error: ' . $conn->error() );
    $aResultFilterTotal = $rResultFilterTotal->fetch_assoc();
	
    $iFilteredTotal = $aResultFilterTotal['FOUND_ROWS()'];
     
    /* Total data set length */
    $sQuery = "
        SELECT COUNT(".$sIndexColumn.")
        FROM   ".$sTable." p
		left join sw_clients c on p.po_rel_cli_id = c.cli_id
		left join sw_master_states_gst stg on cli_rel_state_id = state_id
		where p.po_valid =1 and c.cli_valid =1";
    $rResultTotal = $conn->query( $sQuery) or fatal_error( 'MySQL Error: ' . $conn->error() );
    $aResultTotal = $rResultTotal->fetch_assoc();
    $iTotal = $aResultTotal["COUNT(".$sIndexColumn.")"];
     
     
    /*
     * Output
     */
    $output = array(
        "draw" => intval($_GET['draw']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );
     
    while ( $aRow = $rResult->fetch_assoc() )
    {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( $aColumns[$i] == "version" )
            {
                /* Special output formatting for 'version' column */
                $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
            }else if($i == 0){
					if($aRow['po_cancel'] == 1){
						$row[]='<em style="color:red">'.$aRow['po_ref'].'</em>';
					}else{
						$row[]=$aRow['po_ref'];
					}
			}else if($i == 1){
					if($aRow['po_cancel'] == 1){
						$row[]='<em style="color:red">'.$aRow['cli_name'].'</em>';
					}else{
						$row[]=$aRow['cli_name'];
					}
			}else if($i == 2){
					if($aRow['po_cancel'] == 1){
						$row[]='<em style="color:red">'.$aRow['state_name'].' '.$aRow['state_code'].'</em>';
					}else{
						$row[]=$aRow['state_name'].' '.$aRow['state_code'];
					}
			}else if($i == 3){
					if($aRow['po_cancel'] == 1){
						if($_COMPANY['cp_rel_state_id'] == $aRow['state_id']){
							$row[]='<em style="color:red">CGST @ '.$aRow['po_cgst'].'%<br>SGST @ '.$aRow['po_sgst'].'%</em>';
						}else{
							$row[]='<em style="color:red">IGST @ '.$aRow['po_igst'].'%</em>';
						}
					}else{
						if($_COMPANY['cp_rel_state_id'] == $aRow['state_id']){
							$row[]='CGST @ '.$aRow['po_cgst'].'%<br>SGST @ '.$aRow['po_sgst'].'%';
						}else{
							$row[]='IGST @ '.$aRow['po_igst'].'%';
						}
					}
			}else if($i == 4){
$totalbill = getdatafromsql($conn, "select sum(pi_qty * pi_price) as totals from sw_proformas_items where pi_valid =1 and pi_rel_po_id = ".$aRow['po_id']);
if($aRow['state_id'] !== $_COMPANY['cp_rel_state_id']){
$totaltax = $aRow['po_igst']*0.01*$totalbill['totals']; 
}else{
$totaltax =  ( ($aRow['po_cgst']*0.01*$totalbill['totals']) + ($aRow['po_sgst']*0.01*$totalbill['totals']) );
}

					if($aRow['po_cancel'] == 1){
						$row[]='<em style="color:red">'.number_format(( $totaltax),2).'</em>';
					}else{
						$row[]=number_format(( $totaltax),2);
					}
			}else if($i == 5){
$totalbill = getdatafromsql($conn, "select sum(pi_qty * pi_price) as totals from sw_proformas_items where pi_valid =1 and pi_rel_po_id = ".$aRow['po_id']);
if($aRow['state_id'] !== $_COMPANY['cp_rel_state_id']){
$totaltax = $aRow['po_igst']*0.01*$totalbill['totals']; 
}else{
$totaltax =  ( ($aRow['po_cgst']*0.01*$totalbill['totals']) + ($aRow['po_sgst']*0.01*$totalbill['totals']) );
}

					if($aRow['po_cancel'] == 1){
						$row[]='<em style="color:red">'.number_format(($totalbill['totals'] + $totaltax),2).'</em>';
					}else{
						$row[]=number_format(($totalbill['totals'] + $totaltax),2);
					}
			}else if($i == 6){
					if($aRow['po_cancel'] == 1){
						$row[]='<em style="color:red">'.date('d-M-Y',$aRow['po_dnt']).'</em>';
					}else{
						$row[]=date('d-M-Y',$aRow['po_dnt']);
					}
			}else if($i == 7){
					if($aRow['po_cancel'] == 1){
						$row[]='<h3>Cancelled</h3><hr>
<a href="sw_proforma_print.php?id='.md5($aRow['po_id']).'"><button class="btn btn-sm btn-success">View</button>
<hr>';
					}else{
						$row[]='
						<button id="getPoEdit" data-toggle="modal" data-target="#view-modal" data-id="'.md5($aRow['po_id']).'" class="btn btn-sm btn-warning">Make Changes</button><hr>
<a href="sw_proforma_print.php?id='.md5($aRow['po_id']).'"><button class="btn btn-sm btn-success">View</button>
<hr>
<button id="getPoCancel" data-toggle="modal" data-target="#view-modal" data-id="'.md5($aRow['po_id']).'" class="btn btn-sm btn-danger">Cancel Invoice</button>';
					}
			}else if ( $aColumns[$i] !== ' ' )
            {
                /* General output */
                $row[] = $aRow[ $aColumns[$i] ];
            }else if ( $aColumns[$i] == ' ' ){
				$row[] = 'None';
			}
        }
        $output['aaData'][] = $row;
    }
     
    echo json_encode( $output );
	
}

?>