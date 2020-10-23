<?php
ob_start();
require_once('tcpdf/tcpdf.php');
require_once('include.php');

 $_COMPANY = make_company_ar($conn);
if(isset($_GET['id']) and ctype_alnum($_GET['id'])){
		$sql = "SELECT * FROM `sw_proformas` g
left join sw_clients ci on g.po_rel_cli_id = ci.cli_id
left join sw_master_states_gst on cli_rel_state_id = state_id

where md5(g.`po_id`)= '".$_GET['id']."' and g.po_valid = 1 and ci.cli_valid =1  ";
$row = getdatafromsql($conn,$sql);

}else{
	die("Give Valdi ID");
}
if($row['po_cancel'] == 1){
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Set font
		$this->SetFont('helvetica', 'B', 15);
		// Title
		$this->Cell(0, 15, 'CLASSIC INDUSTRIES - VOID', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->SetFont('helvetica', 'B', 5);
		$this->WriteHtml('<h2><strong>GSTIN</strong>: 09AFHPS1459R1ZI</h2>');
		$this->SetFont('helvetica', '', 5);
		$this->WriteHtml('<h2 align="center"> Manufacturer & Supplier of Corrugated Boxes (Packing Materials)</h2>');
		$this->SetFont('helvetica', '', 5);
		$this->WriteHtml('<h2 align="center"> Ghair Mardan Khan, Rampur UP 244901, State Code: 09 Tel: 9997380560</h2>');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font	
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

}else{
	// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Set font
		$this->SetFont('helvetica', 'B', 15);
		// Title
		$this->Cell(0, 15, 'CLASSIC INDUSTRIES', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->SetFont('helvetica', 'B', 5);
		$this->WriteHtml('<h2><strong>GSTIN</strong>: 09AFHPS1459R1ZI</h2>');
		$this->SetFont('helvetica', '', 5);
		$this->WriteHtml('<h2 align="center"> Manufacturer & Supplier of Corrugated Boxes (Packing Materials)</h2>');
		$this->SetFont('helvetica', '', 5);
		$this->WriteHtml('<h2 align="center"> Ghair Mardan Khan, Rampur UP 244901, State Code: 09 Tel: 9997380560</h2>');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font	
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Administrator');
$pdf->SetTitle($row['cli_name'].' - '.$row['po_ref']);
$pdf->SetSubject('Invoice Print');
$pdf->SetKeywords('Invoice Classic Industries');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 8.5);

// add a page
$pdf->AddPage();

// set some text to print



if(1==1){

if (is_array($row)) {
    // output data of each row
		
		
		
$print =array('ORIGINAL / TRANSPORT / SUPPLIER'); 
foreach($print as $akjd){



/*$csss = array('css/bootstrap.min.css','css/bootstrap-reset.css','css/helper.css','css/style.css');
foreach($csss as $css){
	$txt.= file_get_contents($css);
}
*/
$txt='        
   <style type="text/css">
   table td {
	   padding:10px !important;
   }
</style>
    
                        <div style="background-color:white" >
                        
                            <div class="panel-body">
';




$txt .= '


<table cellpadding="3" border="1">
                                             
    <thead>
        <tr>
            <td colspan="2" ><strong>Invoice Number</strong>: &nbsp;&nbsp;'. $row['po_ref'].'</td>
            <td colspan="2" ><strong>Invoice Date.</strong>:&nbsp;&nbsp;'. date('d-m-Y',$row['po_dnt']).'</td>

            <td colspan="2"><strong>Transportation Mode</strong>:&nbsp;&nbsp;'. $row['po_transport'].'</td>
            <td colspan="2"><strong>Vehicle No.</strong>:&nbsp;&nbsp;'. $row['po_vehicle'].'</td>
        </tr>

    </thead>
        <tbody>

        <tr>
        
            <td colspan="2"><strong>Reverse Charge</strong>:&nbsp;&nbsp;'. ($row['po_reverse_charge'] == '1' ? 'No' : 'Yes').'</td>
            <td colspan="2"><strong>Order Ref</strong>:&nbsp;&nbsp;'. $row['po_lpo'].'</td>
            
            <td colspan="4" ><strong>Date and Place of Supply</strong>:&nbsp;&nbsp;'. $row['po_dapos'] .'</td>
        </tr>
        <tr>
			<td colspan="4" style=" text-align:centre"><strong>Details of Reciever/ Billed to</strong></td>
			<td colspan="4" style=" text-align:centre"><strong>Details of Consignee/ Shipped to</strong></td>
        </tr>
        <tr>
            <td colspan="4" ><strong>Name</strong>:&nbsp;&nbsp;'. $row['po_bill_to_name'].'</td>
            
            <td colspan="4"  ><strong>Name</strong>:&nbsp;&nbsp;'. $row['po_ship_to_name'].'</td>
        </tr>
        <tr>
            <td colspan="4" ><strong>Address </strong>:&nbsp;&nbsp;'. $row['po_bill_to_addr1'].'</td>
            
            <td colspan="4" ><strong>Address </strong>:&nbsp;&nbsp;'. $row['po_ship_to_addr1'].'</td>
        </tr>
        <tr>
            <td colspan="4" >'. $row['po_bill_to_addr2'].'</td>
            <td colspan="4" >'. $row['po_ship_to_addr2'].'</td>
        </tr>
        <tr>
            <td colspan="2" >'. $row['po_bill_to_addr3'].'</td>
            <td  colspan="2"><strong>State</strong>:&nbsp;&nbsp;'. $row['po_bill_to_state'].'</td>

            <td colspan="2" >'. $row['po_ship_to_addr3'].'</td>
            <td colspan="2" ><strong>State</strong>:&nbsp;&nbsp;'. $row['po_ship_to_state'].'</td>

        </tr>
        <tr>
            <td colspan="2" ><strong>GSTIN</strong>:</td>
            <td colspan="2" >'. $row['po_bill_to_gstin'].'</td>
            <td colspan="2" ><strong>GSTIN</strong>:</td>
            <td colspan="2" >'. $row['po_ship_to_gstin'].'</td>
        </tr>
    </tbody>
</table>';
$txt .='
<br><hr>
<table cellpadding="4" border="1">
    <thead>
        <tr>
        <th style="text-align:centre"><strong>#</strong></th>
        <th colspan="3" style="text-align:centre"><strong>Item</strong></th>
        <th style="text-align:centre"><strong>HSN</strong></th>
        <th style="text-align:centre"><strong>Qty</strong></th>
        <th style="text-align:centre"><strong>Rate</strong></th>
        <th style="text-align:centre"><strong>Total</strong></th>
    </tr></thead>
    <tbody>';
                                                
												
												
$productssql = "SELECT * from sw_proformas_items i
left join sw_products_list p on i.pi_rel_pr_id = p.pr_id
where pi_valid =1  and pi_rel_po_id = ".$row['po_id'];
$productsresult = $conn->query($productssql);

if ($productsresult->num_rows > 0) {
    // output data of each row
	$c = 1;
	$total = 0;	
    while($productrow = $productsresult->fetch_assoc()) {
		$qty = ($productrow['pi_qty']);
		$price = ($productrow['pi_price']);
		$itotal = round(($qty * $price),2);
		
		if(trim($productrow['pr_code']) == 'FRT'){
$txt .= '
                <tr>
                    <td style="text-align:centre">'. $c .'</td>
                    <td style="" colspan="3">'."".($productrow['pi_desc'] == '-' ? '' : $productrow['pi_desc']).'</td>
                    <td style="text-align:center">4819</td>
                    <td style="text-align:right">'. 1*((int)$qty) .' </td>
                    <td style="text-align:right">'. number_format($price,2) .'</td>
                    <td style="text-align:right">'. number_format($itotal,2) .'</td>
                </tr>
                
';

		}else{
			
$txt .= '
                <tr>
                    <td style="text-align:centre">'. $c .'</td>
                    <td style="" colspan="3">'. ($productrow['pr_code'] == "0" ? "" :$productrow['pr_code'].'-'.$productrow['pr_name'].' ').($productrow['pi_desc'] == '-' ? '' : $productrow['pi_desc']).'</td>
                    <td style="text-align:center">'. ($productrow['pr_code'] == "0" ? "4819" :$productrow['pi_hsn_code']).'</td>
                    <td style="text-align:right">'. 1*((int)$qty) .' </td>
                    <td style="text-align:right">'. number_format($price,2) .'</td>
                    <td style="text-align:right">'. number_format($itotal,2) .'</td>
                </tr>
                
';

		}
$total = $itotal + $total;
  $c++;  }
} else {
    $txt .= "<tr><td colspan='7'>No Items</td></tr>";
}

$txt .= '</tbody></table>';

$total = $total;
/*		
if($row['pog_discount'] == 0){
	$discount = 0;
}else{
	$discount = round($row['pog_discount'],2);
	echo '<tr><td colspan="7"><p class="text-right"><strong>Discount :</strong> '.$row['cur_name'].' '.number_format($discount,2).'</p></td></tr>';
	
}
*/

$igstp = $row['po_igst'];
$cgstp = $row['po_cgst'] ;
$sgstp = $row['po_sgst'];
		
$igst = $igstp * $total * 0.01;
$cgst = $cgstp * $total * 0.01;
$sgst = $sgstp * $total * 0.01;
/*if($row['pog_vat'] == 0){
	$vat = 0;
}else{
	$vat = round((($row['pog_vat']/100) * $total),2);
	echo '<tr><td colspan="7"><p class="text-right"><strong>Vat ('.$row['pog_vat'].'%):</strong> '.$row['cur_name'].' '.number_format($vat,2).'</p></td></tr>';
	
}
*/
$txt .='  <br><hr>
<table border="1">
    <tbody >
	
	<tr>
	<td colspan="4">
	<strong>Total Amount in Words:</strong><br><u>'. 
		'Rs. '.strtoupper(getIndianCurrency(round((($total + $igst  + $cgst + $sgst )),2)))
		.'</u><br><br>
Bank Details:<br>
        Bank A/C: 066905001908 <br>
		Bank IFSC Code: ICIC0000669
<br>

	</td>
	<td style="text-align:right" colspan="2">
	<strong>Total Before Tax</strong>:'. ' '.number_format(($total),2) .'<br>
	<strong>CGST '. $cgstp .'%</strong>:'. ' '.number_format(($cgst),2) .'<br>
	<strong>SGST '. $sgstp .'%</strong>: '. ' '.number_format(($sgst),2).'<br>
	<strong>IGST '. $igstp .'%</strong>: '. ' '.number_format(($igst),2).'<br>
	<strong>Total Tax</strong>: '.number_format((( $igst  + $cgst + $sgst )),2).'<br>
	<strong>Grand Total</strong>: <u>'.'Rs. '.number_format((($total + $igst  + $cgst + $sgst )),2).'</u>

	</td>
	</tr>
	
	

<tr>
	    <td colspan="3" style="font-size:9px !important; text-align:left">
        	1. All disputes to be subject of Rampur Jurisdiction only<br>
            2. Goods once sold will not be replaced or taken back<br>
            3. An Interest @ 24% will be charged after 7 days<br>
			4. Certified that the particulars given are true and correct
		</td>
        <td colspan="3" style="text-align:center">
			For <strong>'.  $_COMPANY['cp_name'].'</strong>
<br><br><br>AUTH SIGNATORY
		</td>
</tr>

                                                </tbody>
                                            </table>
                            </div>
                        </div>
';
}
    }
 else {
    echo "0 results";
}
}else{
	die('Give Id');
}

ob_flush();
// print a block of text using Write()
$pdf->writeHTML($txt);

//Close and output PDF document
$pdf->Output('invoice.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>