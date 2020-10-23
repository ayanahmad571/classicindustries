<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
}
		?>
<?php
if(!isset($_POST['rep_time_from'])){
	die('<h1>Could not find time from</h1>');
}
if(!isset($_POST['rep_time_till'])){
	die('<h1>Could not find time till</h1>');
}

if(!isset($_POST['rep_cli_hashes'])){
	die('<h1>No client Selected</h1>');
}

if(isset($_POST['rep_profit'])){
	$calcprofit = 1;
}else{
	$calcprofit = 0;
}

if(isset($_POST['rep_det'])){
	$calcdet= 1;
}else{
	$calcdet = 0;
}
?>

<?php

$fromraw = str_replace(".","-",$_POST['rep_time_from']);
$tillraw = str_replace(".","-",$_POST['rep_time_till']);

if((strtotime($fromraw) == true) and (strtotime($tillraw) == true)){
	
}else{
	die('Invalid Dates');}

$from = (strtotime($fromraw));
$till = (strtotime($tillraw));

?>

<!DOCTYPE html>
<html lang="en" >
    
<!-- the maninvoice.htmlby ayan ahmad 07:31:27 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="img/logo.png">

        <title>Sales Report</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">

        <!--Animation css-->
        <link href="css/animate.css" rel="stylesheet">

        <!--Icon-fonts css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/ionicon/css/ionicons.min.css" rel="stylesheet" />


        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/helper.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
<link href="assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">
<link href="assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />  
        


        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
   <style>
   

   hr {
	   color:#000;
	   border-color:#000;
   }
   td {
	   padding:6px !important;
   }
   </style>

    </head>


    <body style="font-size:12px;">


                <div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Sales</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style=" overflow:auto;
 position:relative;" class="row">
                                    <table id="datatable1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Invoice Ref</th>
                                                    <th>Client</th>
		  		      <?php if($calcdet == '1'){ ?> <th>Items</th> <?php } ?>
                                                    <th>CGST</th>
                                                    <th>SGST</th>
                                                    <th>IGST</th>
	<?php if($calcprofit == '1'){ $totalcost = 0; ?><th>Total Cost</th><?php $totalmk = 0; } ?>
                                                    <th>Total Sales</th>
					<?php if($calcprofit == '1'){ ?><th>Markup</th><?php } ?>
                    								<th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
											
											$totalsales = 0;
											$totalcgst = 0;
											$totalsgst = 0;
											$totaligst = 0;
											
$productsql = "SELECT * FROM `sw_proformas` 
left join sw_clients on po_rel_cli_id = cli_id
WHERE po_valid=1 and po_cancel = 0 and po_rel_cli_id in (".implode(',',$_POST['rep_cli_hashes']).")
and po_dnt <= ".($till +86400)." and po_dnt >= ".($from)."
order by po_ref desc
";
$productres = $conn->query($productsql);

/*
select * from sw_purchaseorders where pco_valid =1 and pco_revision_id = '".$_POST['add_salesinvoice_proforma_hash']."' order by pco_revision desc limit 1 
*/
	$con = 1;

if ($productres->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	while($productrw = $productres->fetch_assoc()) {
$getsalesstotal = getdatafromsql($conn,"select sum(pi_qty * pi_price) as stotal from sw_proformas_items where pi_rel_po_id = ".$productrw['po_id']." and pi_valid =1");
$totalsales = $totalsales + $getsalesstotal['stotal'];

$totalcgst = $totalcgst + ($productrw['po_cgst'] * 0.01 * $getsalesstotal['stotal']);
$totalsgst = $totalsgst + ($productrw['po_sgst'] * 0.01 * $getsalesstotal['stotal']);
$totaligst = $totaligst + ($productrw['po_igst'] * 0.01 * $getsalesstotal['stotal']);

if($calcprofit == '1'){
	$getcosttotal = getdatafromsql($conn,"select sum(pi_qty * pi_cost) as ctotal from sw_proformas_items where pi_rel_po_id = ".$productrw['po_id']." and pi_valid =1");
	$tdcost = '<td>'.number_format($getcosttotal['ctotal'] ,2).'</td>';
	$totalcost = $totalcost + $getcosttotal['ctotal'];
	$totalmk = ($getcosttotal['ctotal'] == '0' ? ($totalmk + 0):($totalmk + ($getsalesstotal['stotal']/$getcosttotal['ctotal'])));
	$tdmark = '<td>'.($getcosttotal['ctotal'] == '0' ? '0':(round($getsalesstotal['stotal']/$getcosttotal['ctotal'],3))).'</td>';

}else{
	$tdcost = '';
	$tdmark = '';
}


		echo '<tr>
	<td>'.$con.'</td>
	<td>'.$productrw['po_ref'].'</td>
	<td>'.$productrw['cli_name'].'</td>
	'; 
	if($calcdet == '1'){
echo '<td>';
$innersql = "SELECT * from sw_proformas_items i
left join sw_products_list p on i.pi_rel_pr_id = p.pr_id
where pi_valid =1 and pi_rel_po_id = ".$productrw['po_id'];

$inneres = $conn->query($innersql);
$ttqty = 0;
if ($inneres->num_rows > 0) {
		// output data of each row
		echo '<table class="table-bordered">
		<thead>
			<tr>
			<th>Ref</th>
			<th>Type</th>
			<th>Cost</th>
			<th>Sale</th>
			<th>Qty</th>
			</tr>
		</thead>
		<tbody>';
		$indvsales = 0;
		while($innerw = $inneres->fetch_assoc()) {
			echo '<tr>';
					echo '<td>'.$innerw['pr_code'].'-'.$innerw['pr_name'].'<br>'.convert_desc($innerw['pi_desc']).'</td>'; 
					echo '<td>'.($innerw['pi_io'] == '1' ? 'Inner':'Outer').'</td>';
					echo '<td>'.$innerw['pi_cost'].'</td>';
					echo '<td>'.$innerw['pi_price'].'</td>';
					echo '<td>'.$innerw['pi_qty'].'</td>';

			echo '</tr>';

		}
		echo '</tbody></table>';
		
} else {
	
		echo "No Items";
}

	echo '</td>';
	}

		echo'
		<td>'.number_format(($productrw['po_cgst'] * 0.01 * $getsalesstotal['stotal']),2).'</td>
		<td>'.number_format(($productrw['po_sgst'] * 0.01 * $getsalesstotal['stotal']),2).'</td>
		<td>'.number_format(($productrw['po_igst'] * 0.01 * $getsalesstotal['stotal']),2).'</td>
	'.$tdcost.'
	<td>'.number_format( $getsalesstotal['stotal'],2).'</td>
	'.$tdmark.'
	<td>'.date('d-m-Y',$productrw['po_dnt']).'</td>
	</tr>';


	$con++;
	}

} else {
}
?>
<tr>
	<th colspan="3"></th>
  <?php if($calcdet == '1'){ ?> <th></th> <?php } ?>
	<th>Total CGST: <?php echo number_format($totalcgst,2); ?></th>
	<th>Total SGST: <?php echo number_format($totalsgst,2); ?></th>
	<th>Total IGST: <?php echo number_format($totaligst,2); ?></td>
  <?php if($calcprofit == '1'){ ?> <th>Total Cost: <?php echo number_format($totalcost,2);  ?></th> <?php } ?>
	<th>Total Sales (Without VAT) : <?php echo number_format($totalsales,2); ?><br>Total Sales (With VAT): <?php echo number_format(($totalsales +$totalcgst+$totalsgst+$totaligst ),2); ?></th>
  <?php if($calcprofit == '1' && $con > 1){ ?> <th>
  Total Markup: <?php echo number_format(($totalmk / ($con-1)),2);  ?>
  <br>
  Avg Markup: <?php echo number_format(($totalsales / $totalcost),2);  ?>
  <br>
Profit: <?php echo number_format(($totalsales - $totalcost),2);  ?></th> <?php } ?>
<th></th>
</tr>
                        </tbody>
                                        </table>
                                        <!-- -->
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div> <!-- End row -->

            </div>
                                <div class="hidden-print">
                        <div align="right">
                            <a onClick="window.print()" href="#" class="btn btn-danger btn-lg" style="font-size:60px; margin-bottom:10px"><i class="fa fa-print"></i></a>
                        </div>
                    </div>

            <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
            


            
<!-- Footer Start -->

<!-- Footer Ends -->




    </body>
      <?php  
	  get_end_script();
	  ?>   

<script src="assets/datatables/jquery.dataTables.min.js"></script>
<script src="assets/datatables/dataTables.bootstrap.js"></script>


</html>

