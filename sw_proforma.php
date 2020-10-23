<?php 

include('include.php');
?>
<?php 
include('page_that_has_to_be_included_for_every_user_visible_page.php');
?>

<?php

if($login == 1){
	if(trim($_USER['lum_ad']) == 1){
		$admin = 1;
	}else{
		$admin = 0;
	}
}else{
	$admin = 0;
	die('Login to View this page <a href="login.php"><button>Login</button></a>');
}

?>
<?php
$checkusereligibility = "SELECT * FROM `sw_modules` WHERE mo_valid =1 and FIND_IN_SET(".$_SESSION['STWL_LUM_TU_ID'].", mo_for) > 0 and mo_href = '".trim(basename($_SERVER['PHP_SELF']))."'";
if(is_array(getdatafromsql($conn,$checkusereligibility))){
}else{
	$cue1 = "SELECT * FROM `sw_submod` WHERE sub_valid =1 and sub_href = '".trim(basename($_SERVER['PHP_SELF']))."'";
	$cue1 = getdatafromsql($conn,$cue1);
	if(is_array($cue1)){
		$cue = "SELECT * FROM `sw_modules` WHERE mo_valid =1 and FIND_IN_SET(".$_SESSION['STWL_LUM_TU_ID'].", mo_for) > 0 and
		 mo_id = '".$cue1['sub_mo_rel_mo_id']."'";
		if(is_array(getdatafromsql($conn,$cue))){
		}else{
			die('<h1>503</h1><br>
			Access Denied');
		
		}
	}else{
		die('<h1>503</h1><br>
	Access Denied');
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

<?php get_head(); ?>
<link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
<link href="assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">
<link href="assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />  
        
    </head>


    <body>

        <!-- Aside Start-->
        <aside class="left-panel">

            
        <?php
		give_brand();
		?>
            <?php 
			get_modules($conn,$login,$admin);
			
			?>
                
        </aside>
        <!-- Aside Ends-->


        <!--Main Content Start -->
        <section class="content">
            
            <!-- Header -->
            <header class="top-head container-fluid">
                <button type="button" class="navbar-toggle pull-left">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <!-- Left navbar -->
                <nav class=" navbar-default" role="navigation">
                    

                    <!-- Right navbar -->
                    <?php
                    if($login==1){
						include('ifloginmodalsection.php');
					}
					?>
                    
                    <!-- End right navbar -->
                </nav>
                
            </header>
            <!-- Header Ends -->


            <!-- Page Content Start -->
            <!-- ================== -->

            <div class="wraper container-fluid">

                <div class="row">
                    

                    <div class="col-lg-12	">

                        <div class="panel panel-default"><!-- /primary heading -->
                            <div class="portlet-heading">
      
                            <div class="panel-heading">
                                <h3 class="panel-title">Bills</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
<div class="row">
    <div class="col-xs-12">
        <div class="col-xs-12"><h3 align="center">&nbsp; Generate Bill</h3></div>
        <div class="col-xs-12">
            <h4 align="center">New</h4>
            <div class="col-xs-12">
    <div align="center" class="col-xs-12"><button data-toggle="modal" data-target="#view-modal" id="getModalForWarehouse" class="btn btn-success" data-id="getit">Make New Bill</button></div>
            </div>
        </div>

        
        <div class="col-xs-12 hidden">
            <h4 align="center">From Existing Bill </h4>
            <div class="col-xs-12">
    <div align="center" class="col-xs-12"><input type="text" class="form-control" id="transferval" /><br><button data-toggle="modal" data-target="#view-modal" id="getModalForProPro" class="btn btn-warning" data-id="getit">Generate</button></div>
            </div>
        </div>
        
    </div>
    
</div>
        <hr>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div style=" overflow:auto;
 position:relative;" class="row">
                                    <table id="datatable1" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Ref</th>
                                                    <th>Client Name</th>
                                                    <th>Client State </th>
                                                    <th class="no-sort">Tax %</th>
                                                    <th class="no-sort">Total Tax</th>                                                    
													<th class="no-sort">Total Bil Amount</th>
													<th class="no-sort">Date Generated</th>
													<th class="no-sort">Action</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php /*
$productsql = "SELECT * FROM `sw_proformas` p
left join sw_clients c on p.po_rel_cli_id = c.cli_id
left join sw_master_states_gst on cli_rel_state_id = state_id
WHERE p.po_valid =1 and c.cli_valid =1 
order by po_ref desc
";
$productres = $conn->query($productsql);

if ($productres->num_rows > 0) {
	$taxarr = array('IGST','CGST','SGST');

	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
$totalbill = getdatafromsql($conn, "select sum(pi_qty * pi_price) as totals from sw_proformas_items where pi_valid =1 and pi_rel_po_id = ".$productrw['po_id']);
if($productrw['state_id'] !== $_COMPANY['cp_rel_state_id']){
		 $totaltax = $productrw['po_igst']*0.01*$totalbill['totals']; 
}else{
	$totaltax =  ( ($productrw['po_cgst']*0.01*$totalbill['totals']) + ($productrw['po_sgst']*0.01*$totalbill['totals']) );
	}
		echo '<tr>
	<td '.($productrw['po_cancel'] == '1' ? 'style="color:red"':'' ).' >'.$con.'</td>
	<td '.($productrw['po_cancel'] == '1' ? 'style="color:red"':'' ).' >'.$productrw['po_ref'].'</td>
	<td '.($productrw['po_cancel'] == '1' ? 'style="color:red"':'' ).' >'.$productrw['cli_name'].'</td>
	<td '.($productrw['po_cancel'] == '1' ? 'style="color:red"':'' ).' >'.$productrw['state_name'].' '.$productrw['state_code'].'</td>
	
	
	<td '.($productrw['po_cancel'] == '1' ? 'style="color:red"':'' ).' >'.($productrw['state_id'] !== $_COMPANY['cp_rel_state_id'] ? $taxarr[0].' @ '.$productrw['po_igst'].'%' : $taxarr[1].' @ '.$productrw['po_cgst'].'%<br>'.',
	 '.$taxarr[2].' @ '.$productrw['po_sgst'].'%').'</td>

	<td '.($productrw['po_cancel'] == '1' ? 'style="color:red"':'' ).' >INR '.number_format(( $totaltax),2).'</td>
	<td '.($productrw['po_cancel'] == '1' ? 'style="color:red"':'' ).' >INR '.number_format(($totalbill['totals'] + $totaltax),2).'</td>
	<td '.($productrw['po_cancel'] == '1' ? 'style="color:red"':'' ).' >'.date('d-M-Y',$productrw['po_dnt']).'</td>
	<td>
	
'.($productrw['po_cancel'] == '1' ? '<h3>Cancelled</h3>':'<button id="getPoEdit" data-toggle="modal" data-target="#view-modal" data-id="'.md5($productrw['po_id']).'" class="btn btn-sm btn-warning">Edit</button>' ).'
<hr>
<a href="sw_proforma_print.php?id='.md5($productrw['po_id']).'"><button class="btn btn-sm btn-success">View</button>
<hr>
'.($productrw['po_cancel'] == '1' ? '':'<button id="getPoCancel" data-toggle="modal" data-target="#view-modal" data-id="'.md5($productrw['po_id']).'" class="btn btn-sm btn-danger">Cancel Invoice</button>' ).'
	</td>
	</tr>';

	$con++;
	}

} else {
}
*/
?>
                        </tbody>
                                        </table>
                                        <!-- -->

                               
 
 
                                        
                                 
                                        <!-- -->
                                    </div>
                          </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    
                </div> <!-- End row -->


            </div> <!-- End row -->

            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->

            <!-- Footer Start -->
            


<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-full modal-dialog"> 
     <div class="modal-content">  
   
        <div class="modal-header"> 
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
           <h4 class="modal-title">Proforma</h4> 
        </div> 
            
        <div class="modal-body">                     
           <div id="modal-loader-b" style="display: none; text-align: center;">
           <!-- ajax loader -->
           <img width="100px" src="img/ajax-loader.gif">
           </div>
                            
           <!-- mysql data will be load here -->                          
           <div id="dynamic-content-b"></div>
        </div> 
                        
        <div class="modal-footer"> 
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
        </div> 
                        
    </div> 
  </div>
</div>


            
<!-- Footer Start -->
<footer class="footer">
	<?php auto_copyright(); // Current year?>

    Aforty
</footer>
<!-- Footer Ends -->



        </section>
        <!-- Main Content Ends -->
  


      <?php  
	  get_end_script();
	  ?>   
<script src="assets/datatables/jquery.dataTables.min.js"></script>
<script src="assets/datatables/dataTables.bootstrap.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
		$('.mobileSelectSpecial').mobileSelect({
			onClose: function(){
				var txt = $(this).val();
				$.post("master_action.php", {prname: txt}, function(result){
					result = $.parseJSON( result );
					$("#chageqty").html(result.qty);
					$("#chageprname").html(result.prname);
				});
			}
		});
    } );
</script>
<script type="text/javascript">
    $(document).ready(function() {
		$('.mobileSelect').mobileSelect();
    } );
</script>
           <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable1').dataTable({
					"processing": true,
					"serverSide": true,
					"order": [[ 0, "desc" ]],
					"ajax": "page_that_gives_datatable_to_pages.php?bills_get_table=1",
					 "columnDefs": [ {
						  "targets": 'no-sort',
						  "orderable": false,
					} ]
				});
            } );
        </script> 
        
<script>
$(document).ready(function(){

$(document).on('click', '#getModalForWarehouse', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'add_proforma_warehouse='+uid,
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script>
<script>
$(document).ready(function(){

$(document).on('click', '#getModalForQuoteProAdd', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'add_proforma_quotation='+uid,
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script>
<script>
$(document).ready(function(){

$(document).on('click', '#getModalForProPro', function(e){  
     e.preventDefault();
  
     var uid = $('#transferval').val(); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'add_proforma_proforma='+uid,
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script>
<script>
$(document).ready(function(){

$(document).on('click', '#getPoEditSup', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'edit_proforma_supplier='+uid,
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script>

<script>
$(document).ready(function(){

$(document).on('click', '#getPoEdit', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'proforma_edit='+uid,
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script>
<script>
$(document).ready(function(){

$(document).on('click', '#getPrintView', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'proformas_print_view='+uid,
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script>
<script>
$(document).ready(function(){

$(document).on('click', '#getPoCancel', function(e){  
     e.preventDefault();
  
     var uid = $(this).data('id'); // get id of clicked row
  
     $('#dynamic-content-b').html(''); // leave this div blank
     $('#modal-loader-b').show();      // load ajax loader on button click
 
     $.ajax({
          url: 'page_that_gives_modal_popups_to_pages.php',
          type: 'POST',
          data: 'proforma_cancel_view='+uid,
          dataType: 'html'
     })
     .done(function(data){
          console.log(data); 
          $('#dynamic-content-b').html(''); // blank before load.
          $('#dynamic-content-b').html(data); // load here
          $('#modal-loader-b').hide(); // hide loader  
     })
     .fail(function(){
          $('#dynamic-content-b').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
          $('#modal-loader-b').hide();
     });

    });
});
</script>



     <script>
$(document).ready(function(e) {
    $('.thistoh').addClass('hidden');
	var iddf =$('#select_can').val();
	var pela =document.getElementById(iddf);
	$(pela).removeClass('hidden');
});
$('#select_can').change(function(e) {

	$('.thistoh').addClass('hidden');
	var ider = $(this).val();
	var pel =document.getElementById(ider);
	$(pel).removeClass('hidden');

});
</script>
<script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script>
$(document).ready(function(){
		  $(".wysihtml5").wysihtml5();
});
</script>
           </body>

</html>
