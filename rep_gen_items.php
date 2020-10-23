<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
}
		?>
<?php
if(isset($_POST['pr_rep_time_from']) and isset($_POST['pr_rep_time_from'])){
	$fromraw = str_replace(".","-",$_POST['pr_rep_time_from']);
	$tillraw = str_replace(".","-",$_POST['pr_rep_time_till']);

		if((strtotime($fromraw) == true) and (strtotime($tillraw) == true)){
			
		}else{
			die('Invalid Dates');
		}
	$from = (strtotime($fromraw));
	$till = (strtotime($tillraw));
	$productsql = "SELECT * FROM sw_products_list pl
	where
 pr_dnt <= ".($till +86400)." and pr_dnt >= ".($from)."
 order by pl.pr_code asc";

}else{
	$productsql = "SELECT * FROM sw_products_list pl
 order by pl.pr_code asc";

}






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

        <title>Item List</title>

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


    <body style="font-size:12px; height:920px">

            <div >

                <div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Item List Details</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style=" overflow:auto;
 position:relative;" class="row">
 <table id="datatable1" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th colspan="3">Sales Invoice<br> and QTY</th>
                                                    <th>Qty Sold</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$productres = $conn->query($productsql);

if ($productres->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	
	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
		$ttqty = 0;
		echo '<tr>
	<td>'.$con.'</td>
	<td>'.$productrw['pr_code'].'</td>
	<td>'.$productrw['pr_name'].'</td>
';
?>
<?php 
$innersql = "
select * from sw_proformas_items left join sw_proformas on pi_rel_po_id = po_id where po_valid =1 and pi_valid =1
and pi_rel_pr_id=  ".$productrw['pr_id'].' and po_cancel=0';

$inneres = $conn->query($innersql);
$ttqty = 0;
if ($inneres->num_rows > 0) {
		echo '<td colspan="3">';
		// output data of each row
		echo '<table class="table-bordered">
		<thead>
			<tr>
			<th>Ref</th>
			<th>Price</th>
			<th>Qty</th>
			<th>Date</th>
			</tr>
		</thead>
		<tbody>';
		while($innerw = $inneres->fetch_assoc()) {
			echo '<tr>';
					$proformaqty = $innerw['pi_qty'];
					echo '<td>'.$innerw['po_ref'].'</td>'; 
					echo '<td>'.$innerw['pi_price'].'</td>';
					echo '<td>'.$innerw['pi_qty'].'</td>';
					echo '<td>'.date('M ,Y',$innerw['po_dnt']).'</td>';
			echo '</tr>';
					$ttqty = $ttqty + $proformaqty;
		}
		echo '</tbody></table></td><td>'.$ttqty.'</td><td>'.date('d - M ,Y',$productrw['pr_dnt']).'</td>';
		
} else {
	
		echo "<td colspan='3'>-</td><td>0</td><td>".date('d - M ,Y',$productrw['pr_dnt'])."</td>";
}

echo'					</tr>';

	$con++;
	}

} else {
	echo "0 results";
}?>
                        </tbody>
                                        </table>
                                        <!-- -->
                                    </div>

                               </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div> <!-- End row -->
                    <div class="hidden-print">
                        <div align="right">
                            <a onClick="window.print()" href="#" class="btn btn-danger btn-lg" style="font-size:60px; margin-bottom:10px"><i class="fa fa-print"></i></a>
                        </div>
                    </div>

            </div>


    </body>
      <?php  
	  get_end_script();
	  ?>   

<script src="assets/datatables/jquery.dataTables.min.js"></script>
<script src="assets/datatables/dataTables.bootstrap.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dattable1').dataTable({
  "columnDefs": [
    { "searchable": false, "targets": 4 }
  ]
} );
    } );
</script>
</html>

