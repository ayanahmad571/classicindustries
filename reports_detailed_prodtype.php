<?php
if(include('include.php')){
}else{
die('##errMASTERofUSErERROR');
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

        <link rel="shortcut icon" href="img/logo.jpg">

        <title>Stock Report</title>

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
                                <h3 class="panel-title">Inventory Detailed Ananlyis PRG</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style=" overflow:auto;
 position:relative;" class="row">
 <?php
 
 $totalvalueleft = 0;
 $sql = "SELECT * from sw_prod_types where prty_id not in (18,20,22,21,19,23,6,1) ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	$prodtypetotal = 0;
		
 ?>     
 <h3><?php echo $row['prty_name']; ?></h3>                              <table id="datatable1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>Type</th>
                                                    <th>Name</th>
                                                    <th>Desc</th>
                                                    <th colspan="3">Sales Invoice<br> and QTY</th>
                                                    <th>Qty Sold</th>
                                                    <th>Qty Left</th>
                                                    <th>Unit</th>
                                                    <th>Unit Cost</th>
                                                    <th>Total Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$productsql = "SELECT * FROM sw_products_list pl
left join sw_prod_types pt on pl.pr_rel_prty_id = pt.prty_id
left join sw_suppliers s on pl.pr_rel_sup_id = s.sup_id
 where pl.pr_valid= 1 and pl.pr_visible= 1 and pt.prty_valid =1 and pt.prty_id = ".$row['prty_id']." and s.sup_valid =1
 order by pl.pr_code asc";
$productres = $conn->query($productsql);

if ($productres->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	
	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
		$ttqty = 0;
		echo '<tr>
	<td>'.$con.'</td>
	<td>'.$productrw['pr_code'].'</td>
	<td>'.$productrw['prty_name'].'</td>
	<td>'.$productrw['pr_name'].'</td>
	<td><div>'.convert_desc($productrw['pr_desc']).'</div></td>

';
?>
<?php 
$innersql = "SELECT a.*
FROM (select * from sw_salesinvoices_items left join sw_salesinvoices on si_rel_so_id = so_id where so_valid =1 and si_valid =1) a
LEFT OUTER JOIN (select * from sw_salesinvoices_items left join sw_salesinvoices on si_rel_so_id = so_id where so_valid =1 and si_valid =1) b
ON a.so_revision_id = b.so_revision_id AND a.so_revision < b.so_revision
WHERE b.so_revision_id IS NULL
and a.si_rel_pr_id =".$productrw['pr_id'];

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
			</tr>
		</thead>
		<tbody>';
		while($innerw = $inneres->fetch_assoc()) {
			echo '<tr>';
					$proformaqty = $innerw['si_qty'];
					echo '<td>'.$innerw['so_ref'].'</td>'; 
					echo '<td>'.$innerw['si_price'].'</td>';
					echo '<td>'.$innerw['si_qty'].'</td>';
			echo '</tr>';
					$ttqty = $ttqty + $proformaqty;
		}
		echo '</tbody></table></td><td>'.$ttqty.'</td>';
		
} else {
	
		echo "<td colspan='3'>-</td><td>0</td>";
}
?>
<?php

echo '<td>'.($productrw['pr_qty'] - $ttqty).'</td>';
?>
<?php		
	$prodtypetotal = $prodtypetotal + ($productrw['pr_price'] * ($productrw['pr_qty'] - $ttqty));
	
	echo '
</td>
	<td>'.$productrw['prty_unit'].'</td>
	<td>'.$productrw['pr_price'].'</td>
	<td>'.number_format(($productrw['pr_price'] * ($productrw['pr_qty'] - $ttqty)),2).'</td>
					</tr>';

	$con++;
	}

	$totalvalueleft = $totalvalueleft + $prodtypetotal;



} else {
	echo "0 results";
}?>
                        </tbody>
                                        </table>
                                        <h4><?php echo number_format($prodtypetotal,2); ?></h4>
                                        <!-- -->

                               
 
 <?php
 
 
     }
} else {
    echo "0 results";
}

 ?>
                                        
                                 
                                        <!-- -->
                                    </div>
                                    <hr>
                                    <h1>Total Value Left: <?php echo $totalvalueleft; ?></h1>
                               </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div> <!-- End row -->

            </div>


    </body>
      <?php  
	  get_end_script();
	  ?>   

<script src="assets/datatables/jquery.dataTables.min.js"></script>
<script src="assets/datatables/dataTables.bootstrap.js"></script>

<?php 
for($i = 0;$i <25 ; $i++){
?><script type="text/javascript">
    $(document).ready(function() {
        $('#datastable<?php echo $i; ?>').dataTable();
    } );
</script>
<?php }
?>
</html>

