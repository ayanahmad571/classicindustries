<?php
include('include.php');
if(!isset($_SERVER['HTTP_REFERER'])){
	header('Location: page_that_gives_model_popups_to_pages.php');
}
$_COMPANY = make_company_ar($conn);

?>
<?php

if(isset($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID']) and trim($_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID']) != ''){
}else{
	die('Login to continue <a href="login.php">Login	</a>');
}

?><?php
if(isset($_POST['admin_prod_get'])){
	$msql = "SELECT * FROM `sw_products_list`
where pr_valid  =1 and  md5(pr_id)= '".$_POST['admin_prod_get']."'";
$mres = $conn->query($msql );

if ($mres->num_rows > 0) {
    // output data of each row

    while($mrw = $mres->fetch_assoc()) {
		#firts loop begins
		foreach($mrw as $me=>$m){
			$mrw[$me] = trim($m);
		}
		echo '
<form action="master_action.php" method="post">
<h1 align="center">
'.$mrw['pr_code'].'-'.$mrw['pr_name'].'
</h1>
<br>
<div class="col-sm-4">
<div class="form-group">
	<label>Product Name: </label>
	<input required  name="edit_product_name" type="text" class="form-control" value="'.$mrw['pr_name'].'"/>
</div>

</div>
<div class="col-sm-4">
	<div class="form-group">
		<label>Inner Cost: </label>
		<input required  name="edit_product_inner_cost" type="number" step="0.0001" class="form-control" value="'.$mrw['pr_inner_cost'].'"/>
	</div>
</div>
<div class="col-sm-4">
<div class="form-group">
	<label>Outer Cost: </label>
	<input required  name="edit_product_outer_cost" type="number" step="0.0001" class="form-control" value="'.$mrw['pr_outer_cost'].'"/>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
	<label>Inner Description: </label>
	<textarea name="edit_product_idesc" class="form-control" rows="9">'.$mrw['pr_i_desc'].'</textarea>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
	<label>Outer Description: </label>
	<textarea name="edit_product_odesc" class="form-control" rows="9">'.$mrw['pr_o_desc'].'</textarea>
</div>
</div>

<div class="col-sm-4">

<div class="form-group">
	<label>Remarks: </label>
	<textarea name="edit_product_remarks" class="form-control" rows="9">'.$mrw['pr_remarks'].'</textarea>
</div>
</div>






<div class="row">
	<div class="col-xs-6">
	<input required  type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($mrw['pr_id'].'f2fkjwiuef0rjigbter 24rfgr324frgtr3f 3gr32fgr32f4gr')))))).'" name="edit_product_hash" />
		<input required  style="float:right" type="submit" class="btn btn-success" name="edit_product" value="Save">
	</div>
	<div class="col-xs-6">
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
</div>
	</form>
		        <script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
        <script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script>
$(document).ready(function(){
		  $(".wysihtml5").wysihtml5();
});
</script>
	';
	
	#first loop ends
    }
} else {
    echo "0 results";
}
}
if(isset($_POST['add_prod_give_modal'])){
	
?>  
<h3 id="boxofviewdet">

</h3>
      <form class="" action="master_action.php" method="post" >

<div class="row">
        <div class="col-sm-12">
    <div class="form-group">
    <label>Code: <em class="hidden" id="iteminuse" style="color:red">Item Code Already exists</em>
    <em class="hidden" id="itemok"  style="color:green">Item Code OK</em> </label>
    <input id="add_product_code" required  name="add_product_code" type="text" class="form-control" placeholder="Code"/>
     
  </div>
        </div>


        <div class="col-sm-6">
    <div class="form-group hidemyh">
    <label>HSN Code: </label>
    <input required value="4819"  name="add_product_hsn_code" type="text" class="form-control" placeholder="Code"/>
    </div>
        </div>

        <div class="col-sm-6">
    <div class="form-group hidemyh">
    <label>Product Name: </label>
    <input required  name="add_product_name" type="text" class="form-control" placeholder="Name" value="Box"/>
    </div>
        </div>

        <div class="col-sm-4">
    <div class="form-group hidemyh">
    <label>Inner Cost: </label>
    <input required  name="add_product_inner_cost" type="text" class="form-control" placeholder="only value no unit"/>
    </div>
    </div>

        <div class="col-sm-4">
    <div class="form-group hidemyh">
    <label>Outer Cost: </label>
    <input required  name="add_product_outer_cost" type="text" class="form-control" placeholder="only value no unit"/>
    </div>
    </div>
</div>

        <div class="col-sm-4">
    <div class="form-group hidemyh">
	<label>Inner Description: </label>
	<textarea name="add_product_idesc" class=" form-control" rows="9">3 ply inner</textarea>
</div>
</div>

        <div class="col-sm-4">
    <div class="form-group hidemyh">
	<label>Outer Description: </label>
	<textarea name="add_product_odesc" class=" form-control" rows="9">5 ply outer</textarea>
</div>
</div>

        <div class="col-sm-4">
    <div class="form-group hidemyh">
	<label>Remarks: </label>
	<textarea name="add_product_remarks" class=" form-control" rows="9">-</textarea>
</div>
</div>










<div class="row">
	<div class="col-xs-6">
    <input id="formsubmitcontrol" class="hidden" name="add_inven_dupe" value="" required />
		<input required  style="float:right" type="submit" class="btn btn-success" name="add_product" value="Add">
	</div>
	<div class="col-xs-6">
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
</div>
	</form>
<script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script>
$(document).ready(function(){
		  $(".wysihtml5").wysihtml5();
});

</script>
<script type="text/javascript">
$(document).ready(function() {
	$('#add_product_code').keyup(function(){
		var tx = $(this).val();
				$.post("master_action.php", {prcodee: tx}, function(result){
if(result.trim() == '1'){
	$('#itemok').removeClass('hidden');
	$('#iteminuse').addClass('hidden');
	$("#formsubmitcontrol ").val("d6qa53d42635q4f");
	$("#boxofviewdet").html("");
	$('.hidemyh').removeClass('hidden');
}else{
	$('#itemok').addClass('hidden');
	$('#iteminuse').removeClass('hidden');
	$("#formsubmitcontrol ").val("");
	$("#boxofviewdet").html(result);
	$('.hidemyh').addClass('hidden');
}

				});
						
	} );
} );
		
		$(document).keydown(function(e) {

  // Set self as the current item in focus
  var self = $(':focus'),
      // Set the form by the current item in focus
      form = self.parents('form:eq(0)'),
      focusable;

  // Array of Indexable/Tab-able items
  focusable = form.find('input,a,select,button,textarea,div[contenteditable=true]').filter(':visible');

  function enterKey(){
    if (e.which === 13 && !self.is('textarea,div[contenteditable=true]')) { // [Enter] key

      // If not a regular hyperlink/button/textarea
      if ($.inArray(self, focusable) && (!self.is('a,button'))){
        // Then prevent the default [Enter] key behaviour from submitting the form
        e.preventDefault();
      } // Otherwise follow the link/button as by design, or put new line in textarea

      // Focus on the next item (either previous or next depending on shift)
      focusable.eq(focusable.index(self) + (e.shiftKey ? -1 : 1)).focus();

      return false;
    }
  }
  // We need to capture the [Shift] key and check the [Enter] key either way.
  if (e.shiftKey) { enterKey() } else { enterKey() }
});
</script>


	<?php
}
if(isset($_POST['item_cancel_view'])){
	if(ctype_alnum($_POST['item_cancel_view'])){
	}else{
		die('Invalid Hash Is Being Passed');
	}
	$getqoid  = getdatafromsql($conn, "	
SELECT * FROM sw_products_list pl
 where pl.pr_valid= 1 
 and md5(pr_id)= '".$_POST['item_cancel_view']."'");
	if(is_array($getqoid)){
	}else{
		die('No Item Found for this hash');
	}
	?>
	<div class="row">
        <div class="col-xs-4 col-xs-offset-4">
			<form action="master_action.php" method="post">
            <h3 style="text-align:center">Are you sure you want to Remove this Item?<br>
Once Cancelled, this can't be undone.</h3>
<p style="text-align:center"><input type="hidden" name="del_pr_hash" value="<?php echo md5($getqoid['pr_id']."alphabeta"); ?>" required /> <br>

<button type="submit" class="btn btn-danger btn-lg" style="font-size:40px; padding:20px; border-radius:12px">Remove Item</button></p>
            </form>
        </div>
    </div>
                                <?php
}
if(isset($_POST['item_list_print'])){
	
?>  
<div class="row">
<div class="col-xs-6" style="border-right:1px solid black">
      <form class="" action="rep_gen_items.php" method="post" >
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">From</label>
                    <input name="pr_rep_time_from" class="form-control" required placeholder="12.02.2017" type="text" value="<?php echo date('d.m.Y',(time()- 2592000)); ?>">
                  </div>
                  </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Till</label>
                    <input name="pr_rep_time_till" class="form-control" required placeholder="12.02.2017" type="text" value="<?php echo date('d.m.Y',(time())); ?>">
                  </div>
                </div>
              </div>

<div class="row">
	<div class="col-xs-6">
		<input required  style="float:right" type="submit" class="btn btn-success" name="" value="Generate Item Report By Date">
	</div>
</div>

	</form>
    
    </div>

<div class="col-xs-6" >
      <form class="" action="rep_gen_items.php" method="post" >
<div class="row">
	<div class="col-xs-6"><br>
<br>
<br>
<br>

		<input required  style="float:right" type="submit" class="btn btn-warning"  value="Generate Report For all Items">
	</div>
</div>

	</form>
    
    </div>

    </div>


	<?php
}
/*-------------------------------------------*/
if(isset($_POST['get_inv_show'])){
	$msql = "
SELECT * FROM `sw_products_list_show` sh 
left join sw_products_list pl on sh.sh_rel_pr_id = pl.pr_id 
left join sw_showrooms sw on sh.sh_rel_shw_id = sw.shw_id 
WHERE pl.pr_valid = 1 and sh.sh_valid=1 and  md5(sh.sh_id)= '".$_POST['get_inv_show']."'
 ";
$mres = $conn->query($msql );

if ($mres->num_rows == 1) {
    // output data of each row

    while($mrw = $mres->fetch_assoc()) {
		#firts loop begins
		foreach($mrw as $me=>$m){
			$mrw[$me] = trim($m);
		}
		echo '
<form action="master_action.php" method="post">
<div class="form-group">
	<label>Quantity: </label>
	<input required  name="edit_showroomproduct_qty" type="number" step="0.01" class="form-control" value="'.$mrw['sh_qty'].'"/>
</div>

<div class="row">
	<div class="col-xs-6">
	<input required  type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($mrw['sh_id'].'ws f2fkjwiuef0rjigbter 24rfgr324frgtr3f 3gr32fgr32f4gr')))))).'" name="edit_showroomproduct_hash" />
		<input required  style="float:right" type="submit" class="btn btn-success" name="edit_showroomproduct" value="Save">
	</div>
	<div class="col-xs-6">
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
</div>
	</form>

	';
	
	#first loop ends
    }
} else {
    echo "0 results";
}
}
if(isset($_POST['get_mock_modal'])){
	$msql = "
SELECT * FROM `sw_mockups` where md5(mock_id) = '".$_POST['get_mock_modal']."'
 ";
$mres = $conn->query($msql );

if ($mres->num_rows == 1) {
    // output data of each row

    while($mrw = $mres->fetch_assoc()) {
		#firts loop begins
		foreach($mrw as $me=>$m){
			$mrw[$me] = trim($m);
		}
		echo '
<form action="master_action.php" method="post">
<div class="form-group">
	<label>Given Qty: </label>
	<input required  name="edit_mock_qty" type="number" step="0.01" class="form-control" value="'.$mrw['mock_qty'].'"/>
</div>
<div class="form-group">
	<label>Returned: </label>
<select class="form-control" required name="edit_mock_returned">
		'.($mrw['mock_returned'] == 0 ? '<option value="0" selected>No</option> <option value="1">Yes</option>':'<option value="0">No</option><option selected value="1">Yes</option>').'
	</select>
</div>
<div class="form-group">
	<label>Remarks: </label>
	<input required  name="edit_mock_remarks" type="text" class="form-control" value="'.$mrw['mock_remarks'].'"/>
</div>

<div class="row">
	<div class="col-xs-6">
	<input required  type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($mrw['mock_id'].'dedws f2fkjwiuef0rjigbter 24rfgr324frgtr3f 3gr32fgr32f4gr')))))).'" name="edit_mock_hash" />
		<input required  style="float:right" type="submit" class="btn btn-success" name="edit_mock" value="Save">
	</div>
	<div class="col-xs-6">
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
</div>
	</form>

	';
	
	#first loop ends
    }
} else {
    echo "0 results";
}
}
/*---------------------------------------------*/
if(isset($_POST['proforma_cancel_view'])){
	if(ctype_alnum($_POST['proforma_cancel_view'])){
	}else{
		die('Invalid Hash Is Being Passed');
	}
	$getqoid  = getdatafromsql($conn, "	select * from sw_proformas 

left join sw_clients ci on po_rel_cli_id = ci.cli_id
left join sw_master_states_gst on cli_rel_state_id = state_id

	 where md5(po_id)= '".$_POST['proforma_cancel_view']."' and po_valid =1");
	if(is_array($getqoid)){
	}else{
		die('No proforma Found for this hash');
	}
	?>
	<div class="row">
        <div class="col-xs-4 col-xs-offset-4">
			<form action="master_action.php" method="post">
            <h3 style="text-align:center">Are you sure you want to Cancel this Bill?<br>
Once Cancelled, this can't be undone.</h3>
<p style="text-align:center"><input type="hidden" name="del_po_hash" value="<?php echo $_POST['proforma_cancel_view']; ?>" required /> <br>

<button type="submit" class="btn btn-danger btn-lg" style="font-size:40px; padding:20px; border-radius:12px">Cancel Bill</button></p>
            </form>
        </div>
    </div>
                                <?php
}
if(isset($_POST['proforma_detailed_view'])){
	if(ctype_alnum($_POST['proforma_detailed_view'])){
	}else{
		die('Invalid Hash Is Being Passed');
	}
	$getqoid  = getdatafromsql($conn, "select * from sw_proformas
	left join sw_currency on po_rel_cur_id = cur_id
	left join sw_clients on po_rel_cli_id = cli_id
	 where md5(po_id)= '".$_POST['proforma_detailed_view']."' and po_valid =1");
	if(is_array($getqoid)){
	}else{
		die('No proforma Found for this hash');
	}
	?>
	<div class="row">
    <div class="col-xs-4">
        <p><div class="text-muted">Proforma Ref:</div><?php echo $getqoid['po_ref']; ?></p>
        <p><div class="text-muted">Date:</div><?php echo date('d-m-Y',$getqoid['po_dnt']); ?></p>
        <p><div class="text-muted">Currency:</div><?php echo $getqoid['cur_name']; ?></p>
    </div>
    <div class="col-xs-4">
        <p><div class="text-muted">Project:</div><?php echo $getqoid['po_proj_name']; ?></p>
        <p><div class="text-muted">Sub:</div><?php echo $getqoid['po_subj']; ?></p>
	    </div>
    
    <div class="col-xs-4">
        <p><div class="text-muted">Billing Address:</div><br><?php echo '<strong>'.$getqoid['cli_name'].'</strong><br>'.$getqoid['cli_bill_addr']; ?></p>
    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div  class="row">
                                        <hr>

                                    <table id="datatable_in" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <?php if($_SESSION['STWL_LUM_TU_ID'] ==1){ ?><th>Cost AED <br>per Unit</th><?php }?>                                                   <?php if($_SESSION['STWL_LUM_TU_ID'] ==1){ ?> <th>Markup</th><?php }?>
                                                    <th>Sale Price AED<br>per Unit </th>
                                                    <th>Qty</th>
                                                    <th>Total</th>
                                                    <th>-</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
<?php

$boxsql = "SELECT * FROM `sw_proformas_items` q 
left join sw_products_list p on q.pi_rel_pr_id = p.pr_id
left join sw_prod_types t on p.pr_rel_prty_id = t.prty_id
where q.pi_rel_po_id =".$getqoid['po_id']."  and pi_valid =1 and p.pr_valid =1
and t.prty_valid =1

";
$boxres = $conn->query($boxsql);
$total = 0;
if ($boxres->num_rows > 0) {
    // output data of each row
	$cc =1;
    while($boxrw = $boxres->fetch_assoc()) {
		#firts loop begins
		$init = round(($boxrw['pi_qty'] * $boxrw['pi_price'] * $getqoid['po_cur_rate']),2);
		echo '
		<tr>
<td>'.$cc.'</td>
<td>'.$boxrw['pr_code'].'</td>
<td>'.$boxrw['pr_name'].'<br>
'.convert_desc($boxrw['pi_desc']).'</td>
'; if($_SESSION['STWL_LUM_TU_ID'] ==1){ echo '<td>AED '.$boxrw['pi_cost'].'</td>'; }echo'
'; if($_SESSION['STWL_LUM_TU_ID'] ==1){ echo '<td>'.round((($boxrw['pi_price']/$boxrw['pi_cost'])),3).'</td>'; }echo'
<td>AED '.$boxrw['pi_price'].'</td>
<td>'.$boxrw['pi_qty'].' '.$boxrw['prty_unit'].'</td>
<td>'.$getqoid['cur_name'].' '.number_format($init,2).'</td>
<td>'.($boxrw['prty_pr_hidden'] == '1' ? '<i style="color:red">This product will not be visible in the print view. <br> And total will not be added in the Sub-Total</i>' : '').'</td>

</tr>';
	$cc++;
	#first loop ends
	if($boxrw['prty_pr_hidden'] == '0'){
	$total = $total + ($init);
	}
    }
} else {
    echo "0 results";
}
 ?>                       

 						                          
                                            </tbody>
                                        </table>
                                        
                                        <?php 
							echo '<h4 align="right"> '.$getqoid['cur_name'].' '.number_format(($total),2).' </h4>'; 
							echo '<h4 align="right"> '.$getqoid['cur_name'].' '.strtoupper(convert_number_to_words(($total))).' </h4>'; 
							
							?>
                                        <!-- -->

                               
 
 
                                        
                                 
                                        <!-- -->
                                    </div>
                                    <hr>
                                     </div>
                                </div>
                                <script type="text/javascript">
    $(document).ready(function() {
        $('#datatable_in').dataTable();
    } );
</script>
                                <?php
}
if(isset($_POST['add_proforma_warehouse'])){
	
	?>
     <link rel="stylesheet" type="text/css" href="assets/select2/select2.css" />
     <form id="add_proforma_warehouse" action="master_action.php" method="post" enctype="multipart/form-data">
          <div style="max-height:60vh; overflow: scroll">

<div class="row">
	<div class="col-sm-6">
         <div class="form-group">
	<label>Bill to Client: </label>
<select id="select22" class="form-control input-lg" name="add_proforma_client" required>
<option selected>Select Bill to Client</option>
			<?php
	$sql = "SELECT * FROM sw_clients where cli_valid =1 order by cli_name asc";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.md5($row['cli_id']).'">'.$row['cli_name'].'</option>';
        }
    } else {
    }
            ?>
</select>

</div>

    </div>
	<div class="col-sm-6">
 <div class="form-group">
	<label>Ship to Client: </label>
<select id="cli_ship" class="form-control input-lg" name="add_proforma_client_ship" required>
<option selected>Select Ship to Client</option>
			<?php
	$sql = "SELECT * FROM sw_clients where cli_valid =1 order by cli_name asc";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.md5($row['cli_id']).'">'.$row['cli_name'].'</option>';
        }
    } else {
    }
            ?>
</select>

</div>
    </div>
</div>


<div class="form-group" id="togetdatafrom">
	<label>Tax: </label>
    Select Client to Enable Tax
</div>

<hr>

<p align="center">Order Ref:</p>
<div class="row">
	<div class="col-sm-12">
        <div class="form-group">
            <label>Ref: </label>
			<input required type="text" name="add_po_ref" class="form-control input-lg" value="-" />
        </div>
    </div>
</div>
<hr>
<div class="row">
	<div class="col-sm-12">
        <div class="form-group">
            <label>Reverse Charge: </label>
<select  class="form-control input-lg" name="add_po_reverse" required>
<option selected value="1">No</option>
<option value="2">Yes</option>
</select>
        </div>
    </div>
</div>
<hr>
<p align="center">Transport</p>
<div class="row">
	<div class="col-sm-6">
        <div class="form-group">
            <label>Transportation Mode: </label>
			<input required type="text" name="add_po_transport" class="form-control input-lg" value="-" />
        </div>
    </div>
	<div class="col-sm-6">
        <div class="form-group">
            <label>Vehicle Number: </label>
			<input required type="text" name="add_po_car" class="form-control input-lg" value="-" />
        </div>
    </div>
</div>
<hr>
<p align="center">Supply</p>
<div class="row">
	<div class="col-sm-12">
        <div class="form-group">
            <label>Date and Place of Supply: </label>
			<input required type="text" name="add_po_supply" class="form-control input-lg" value="-" />
        </div>
    </div>
</div>
<hr>
<p align="center">Address</p>
<div class="row">
	<div class="col-sm-6">
    <p align="center">Bill To</p>
        <div class="form-group">
            <label>Name: </label>
			<input id="add_po_bill_name" required type="text" name="add_po_bill_name" class="form-control input-lg" value="<?php echo '-'; ?>" />
            <label>Address 1: </label>
			<input id="add_po_bill_addr1"  required type="text" name="add_po_bill_addr1" class="form-control input-lg" value="<?php echo '-'; ?>" />
            <label>Address 2: </label>
			<input id="add_po_bill_addr2"  required type="text" name="add_po_bill_addr2" class="form-control input-lg" value="<?php echo '-'; ?>" />
            <label>Address 3: </label>
			<input id="add_po_bill_addr3"  required type="text" name="add_po_bill_addr3" class="form-control input-lg" value="<?php echo '-'; ?>" />
            <label>GSTIN: </label>
			<input id="add_po_bill_gstin"  required type="text" name="add_po_bill_gstin" class="form-control input-lg" value="<?php echo '-'; ?>" />
            <label>State And Code: </label>
			<input id="add_po_bill_state"  required type="text" name="add_po_bill_state" class="form-control input-lg" value="<?php echo '-'; ?>" />
        </div>
    </div>
	<div class="col-sm-6">
    <p align="center">Ship To</p>
        <div class="form-group">
            <label>Name: </label>
			<input id="add_po_ship_name" required type="text" name="add_po_ship_name" class="form-control input-lg" value="<?php echo '-'; ?>" />
            <label>Address 1: </label>
			<input id="add_po_ship_addr1"  required type="text" name="add_po_ship_addr1" class="form-control input-lg" value="<?php echo '-'; ?>" />
            <label>Address 2: </label>
			<input id="add_po_ship_addr2"  required type="text" name="add_po_ship_addr2" class="form-control input-lg" value="<?php echo '-'; ?>" />
            <label>Address 3: </label>
			<input id="add_po_ship_addr3"  required type="text" name="add_po_ship_addr3" class="form-control input-lg" value="<?php echo '-'; ?>" />
            <label>GSTIN: </label>
			<input id="add_po_ship_gstin"  required type="text" name="add_po_ship_gstin" class="form-control input-lg" value="<?php echo '-'; ?>" />
            <label>State And Code: </label>
			<input id="add_po_ship_state"  required type="text" name="add_po_ship_state" class="form-control input-lg" value="<?php echo '-'; ?>" />
        </div>
    </div>
</div>
<hr>


<br>


<table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Type</th>
                <th>Item Desc</th>
                <th>Item Remarks</th>
                <th>HSN Code</th>
                <th></th>
                <th>Selling Price</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
                
        <?php
		
		$sql = "SELECT * FROM sw_products_list p
where p.pr_valid =1 and p.pr_id 
order by pr_code asc";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$storedprlist[] =$row;
	}
} else {
	echo "0 results";
}
		?>
        <?php 
		for($i = 1;$i < 101 ; $i++){
		?>
<tr >
<td><?php echo $i ?></td>
            <td><select class="select2 add_proforma_product<?php echo $i; ?>" id="add_proforma_product<?php echo $i; ?>" name="add_proforma_product<?php echo $i; ?>">
<?php 
$sql = "SELECT * FROM sw_products_list p
where p.pr_valid =1 and p.pr_id 
order by pr_code asc";
$result = $conn->query($sql);
	echo '<option selected data-id="0" value="0">Select Product </option>';
	echo '<option data-id="987654321987654321" value="987654321987654321">New Item</option>';
foreach($storedprlist as $row){
		   echo '<option  data-id="'.$row['pr_id'].'" value="'.md5($row['pr_id']).'">'.$row['pr_code'].'-'.$row['pr_name'].'</option>';
	}
?>
<?php echo $i; ?>
            </select>
<hr class="theaddnewfields<?php echo $i ?> hidden" style=" border-bottom:#4F4E4E thin solid">
<p class="theaddnewfields<?php echo $i ?> hidden">Item Code</p>
<input id="add_proforma_add_new_pr_code<?php echo $i ?>" class="theaddnewfields<?php echo $i ?> hidden form-control" name="add_proforma_add_new_pr_code<?php echo $i; ?>" type="text" value="-" required /><br>
<p class="theaddnewfields<?php echo $i ?> hidden">Item Name</p>
<input id="add_proforma_add_new_pr_name<?php echo $i ?>" class="theaddnewfields<?php echo $i ?> hidden form-control" name="add_proforma_add_new_pr_name<?php echo $i; ?>" type="text" value="Box" required />
</td>

            <td><select class="form-control add_proforma_innerouter<?php echo $i; ?>" id="add_proforma_innerouter<?php echo $i; ?>" name="add_proforma_innerouter<?php echo $i; ?>">
					<option data-id="1" value="1" selected>Inner</option>
                    <option data-id="2" value="2">Outer</option>
            </select></td>

            
<td><input name="add_proforma_product_desc<?php echo $i; ?>" type="text" class="form-control " id="add_proforma_product_desc<?php echo $i; ?>" required value="-" placeholder="Desc"  /></td>

<td><input name="add_proforma_product_remarks<?php echo $i; ?>" type="text" class="form-control " id="add_proforma_product_remarks<?php echo $i; ?>" required value="-" placeholder="Remarks"  /></td>

<td><input name="add_proforma_product_hsn<?php echo $i; ?>"  type="number" class="form-control " id="add_proforma_product_hsn<?php echo $i; ?>" required value="0000" placeholder="HSN"  /></td>

<td><input name="add_proforma_product_cost<?php echo $i; ?>"  type="number" step="0.01" class="hidden form-control " id="add_proforma_product_cost<?php echo $i; ?>" required value="0" placeholder="Cost Price"  />

<hr class="theaddnewfields<?php echo $i ?> hidden" style=" border-bottom:#4F4E4E thin solid">
<p class="theaddnewfields<?php echo $i ?> hidden">Inner Cost</p>
<input id="add_proforma_add_new_pr_inner_cost<?php echo $i; ?>" class=" theaddnewfields<?php echo $i ?> hidden form-control" name="add_proforma_add_new_pr_inner_cost<?php echo $i; ?>" type="number" step="0.01" value="0" required /><br>
<p class="theaddnewfields<?php echo $i ?> hidden">Outer Cost</p>
<input id="add_proforma_add_new_pr_outer_cost<?php echo $i; ?>" class="theaddnewfields<?php echo $i ?> hidden form-control" name="add_proforma_add_new_pr_outer_cost<?php echo $i; ?>" type="number" step="0.01" value="0" required />
</td>

<td><input name="add_proforma_product_price<?php echo $i; ?>" type="text" class="form-control remzonfocus" id="add_proforma_product_price<?php echo $i; ?>" required value="0" placeholder="Sale Price"  /></td>

<td><input name="add_proforma_product_qty<?php echo $i; ?>" type="text" class="form-control remzonfocus " id="add_proforma_product_qty<?php echo $i; ?>" required value="0" placeholder="Qty"  /></td>

<script type="text/javascript">
$(document).ready(function() {
	$('#add_proforma_product<?php echo $i; ?>').change(function(){
		var tx = $(this).children('option:selected').data('id');
		
		if(tx == '987654321987654321'){
			$('.theaddnewfields<?php echo $i ?>').removeClass('hidden');
					$("#add_proforma_product_desc<?php echo $i; ?>").val("-");
					$("#add_proforma_product_cost<?php echo $i; ?>").val("0");
					$("#add_proforma_product_hsn<?php echo $i; ?>").val("4819");
					$("#add_proforma_product_remarks<?php echo $i; ?>").val("-");

		}else{
			$('.theaddnewfields<?php echo $i ?>').addClass('hidden');
				$.post("master_action.php", {prid: tx}, function(result){
					$("#add_proforma_add_new_pr_name<?php echo $i; ?>").val("Box");
					$("#add_proforma_add_new_pr_code<?php echo $i; ?>").val("-");
					$("#add_proforma_add_new_pr_inner_cost<?php echo $i; ?>").val("0");
					$("#add_proforma_add_new_pr_outer_cost<?php echo $i; ?>").val("0");

					result = $.parseJSON( result );
					$("#add_proforma_product_desc<?php echo $i; ?>").val(result.desc);
					$("#add_proforma_product_cost<?php echo $i; ?>").val(result.cost);
					$("#add_proforma_product_price<?php echo $i; ?>").val(result.cost);
					$("#add_proforma_product_hsn<?php echo $i; ?>").val(result.hsn);
					$("#add_proforma_product_remarks<?php echo $i; ?>").val(result.rem);
				});
		}
	} );
} );
		
</script>


<script type="text/javascript">
$(document).ready(function() {
	$('#add_proforma_innerouter<?php echo $i; ?>').change(function(){
		var tx = $(this).children('option:selected').data('id');
				$.post("master_action.php", {innerouter:tx, priid: $('#add_proforma_product<?php echo $i; ?>').children('option:selected').data('id')}, function(result){
					result = $.parseJSON( result );
					$("#add_proforma_product_cost<?php echo $i; ?>").val(result.cost);
					$("#add_proforma_product_price<?php echo $i; ?>").val(result.cost);
					$("#add_proforma_product_desc<?php echo $i; ?>").val(result.desc);
				});
	} );
} );
	
	  
</script>


	    </tr>
        <?php }?>
                <script src="assets/select2/select2.min.js" type="text/javascript"></script>

        <script>
		jQuery(".select2").select2({
		   width: '100%'
		  });	
		</script>
        <script>
		$(document).ready(function(){
    var Input = $('.remzonfocus');
    var default_value = Input.val();

    $(Input).focus(function() {
        if($(this).val() == default_value)
        {
             $(this).val("");
        }
    }).blur(function(){
        if($(this).val().length == 0) /*Small update*/
        {
            $(this).val(default_value);
        }
    });
})
		</script>
        </tbody>
</table>
<hr>

<hr>



    
    
</div>
    <hr>
            <input type="text" required name="pl_" class="form-control" placeholder="Please Enter 1" /><br>
<hr>
    <div class="row">
        <div class="col-xs-6 ">
                <input required  style="float:right" type="submit" class="btn btn-success" name="" value="Make New Bill">
                <input required type="hidden" name="add_proforma" value="Make New Bill">
        </div>
    </div>
    	</form>

<script>
$('#select22').change(function() {
     
	   $.post("master_action.php",
    {
        cli_id: $(this).val()
    },
    function(data, status){
		$("#togetdatafrom").html(data);
		
    });
	
		   $.post("master_action.php",
    {
        clii_id: $(this).val()
    },
    function(result, status){
					result = $.parseJSON( result );
					$("#add_po_bill_name").val(result.name);
					$("#add_po_bill_addr1").val(result.a1);
					$("#add_po_bill_addr2").val(result.a2);
					$("#add_po_bill_addr3").val(result.a3);
					$("#add_po_bill_gstin").val(result.gstin);
					$("#add_po_bill_state").val(result.state);
		
    });


	 
});
</script>




<script>
$('#cli_ship').change(function() {
     
		   $.post("master_action.php",
    {
        clii_id: $(this).val()
    },
    function(result, status){
					result = $.parseJSON( result );
					$("#add_po_ship_name").val(result.name);
					$("#add_po_ship_addr1").val(result.a1);
					$("#add_po_ship_addr2").val(result.a2);
					$("#add_po_ship_addr3").val(result.a3);
					$("#add_po_ship_gstin").val(result.gstin);
					$("#add_po_ship_state").val(result.state);
    });


	 
});
</script> 	

<script>
function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

$('#add_proforma_warehouse').submit(function (evt) {
    evt.preventDefault();
	 $.ajax({
         type: 'POST',
         url: "master_action.php",
         data: $('#add_proforma_warehouse').serialize(), 
         success: function(response) {
			 if(IsJsonString(response)){
				 var json = $.parseJSON(response);
				$('#add_proforma_warehouse').html("<h2>Form Submitted Succesfully</h2>");
				window.location.href = json.url;
				 
			 }else{
				alert(response);

			 }
         },
        error: function() {
             //$("#commentList").append($("#name").val() + "<br/>" + $("#body").val());
            alert("There was an error submitting comment");
        }
     });
	 
});
</script>

    <?php
}
if(isset($_POST['proforma_edit'])){
		if(ctype_alnum($_POST['proforma_edit'])){
	}else{
		die('Invalid Hash Is Being Passed');
	}
	$getqoid  = getdatafromsql($conn, "
	select * from sw_proformas 
left join sw_clients ci on po_rel_cli_id = ci.cli_id
left join sw_master_states_gst on cli_rel_state_id = state_id
	where md5(po_id)= '".$_POST['proforma_edit']."' and po_valid =1");
	if(is_array($getqoid)){
	}else{
		die('No bill Found for this hash');
	}
	?>
     <link rel="stylesheet" type="text/css" href="assets/select2/select2.css" />
     <form  id="edit_po_wh" action="master_action.php" method="post" enctype="multipart/form-data">
     <div style="max-height:60vh; overflow: scroll">
     <div class="row">
	<div class="col-sm-6">
         <div class="form-group">
	<label>Bill to Client: </label>
<select id="select22" class="form-control input-lg" name="edit_proforma_client" required>
<option >Select Client</option>
			<?php
	$sql = "SELECT * FROM sw_clients where cli_valid =1 order by cli_name asc";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
			
			if($row['cli_id'] == $getqoid['po_rel_cli_id']){
            echo '<option selected value="'.md5($row['cli_id']).'">'.$row['cli_name'].'</option>';
			}else{
            echo '<option value="'.md5($row['cli_id']).'">'.$row['cli_name'].'</option>';
			}
        }
    } else {
    }
            ?>
</select>


</div>

    </div>
	<div class="col-sm-6">
 <div class="form-group">
	<label>Ship to Client: </label>
<select id="cli_ship" class="form-control input-lg" name="edit_proforma_client_ship" required>
<option selected>Select Ship to Client</option>
			<?php
	$sql = "SELECT * FROM sw_clients where cli_valid =1 order by cli_name asc";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
			if($row['cli_id'] == $getqoid['po_rel_cli_id']){
            echo '<option selected value="'.md5($row['cli_id']).'">'.$row['cli_name'].'</option>';
			}else{
            echo '<option value="'.md5($row['cli_id']).'">'.$row['cli_name'].'</option>';
			}
        }
    } else {
    }
            ?>
</select>

</div>
    </div>
</div>


<div class="form-group" id="togetdatafrom">
<?php

	if($getqoid['cli_rel_state_id'] == $_COMPANY['cp_rel_state_id']){
	#cgst and sgst
	echo '
	<input  name="edit_proforma_igst" type="hidden" required class="required form-control" placeholder="IGST %" value="0">

<label class="col-lg-2 control-label" for="name"> CGST  %</label>
	<input name="edit_proforma_cgst" type="text" required class=" form-control" placeholder="CGST %" value="'.$getqoid['po_cgst'].'">
<br>
<label class="col-lg-2 control-label" for="name"> SGST  %</label>
	<input name="edit_proforma_sgst" type="text" required class="required form-control" placeholder="SGST %" value="'.$getqoid['po_sgst'].'">
';
	
	
	}else{
	
#only igst
	echo '
<label class="col-lg-2 control-label" for="name"> IGST  %</label>
	<input name="edit_proforma_igst" type="text" required class="required form-control" placeholder="IGST %" value="'.$getqoid['po_igst'].'">

	<input name="edit_proforma_cgst" type="hidden" required class="required form-control" placeholder="CGST %" value="0">
	<input name="edit_proforma_sgst" type="hidden" required class="required form-control" placeholder="SGST %" value="0">
';	
	
	}

?>
</div>

<hr>




<p align="center">Order Ref:</p>
<div class="row">
	<div class="col-sm-12">
        <div class="form-group">
            <label>Ref: </label>
			<input required type="text" name="edit_po_ref" class="form-control input-lg" value="<?php echo $getqoid['po_lpo'] ?>" />
        </div>
    </div>
</div>
<hr>
<div class="row">
	<div class="col-sm-12">
        <div class="form-group">
            <label>Reverse Charge: </label>
<select  class="form-control input-lg" name="edit_po_reverse" required>
<?php 

if($getqoid['po_reverse_charge'] == '1'){
	echo '<option selected value="1">No</option>
	<option value="2">Yes</option>
';
}else{
	echo '<option  value="1">No</option>
	<option selected value="2">Yes</option>
';
}?>
</select>
        </div>
    </div>
</div>
<hr>
<p align="center">Transport</p>
<div class="row">
	<div class="col-sm-6">
        <div class="form-group">
            <label>Transportation Mode: </label>
			<input required type="text" name="edit_po_transport" class="form-control input-lg" value="<?php echo $getqoid['po_transport'] ?>" />
        </div>
    </div>
	<div class="col-sm-6">
        <div class="form-group">
            <label>Vehicle Number: </label>
			<input required type="text" name="edit_po_car" class="form-control input-lg" value="<?php echo $getqoid['po_vehicle'] ?>" />
        </div>
    </div>
</div>
<hr>

<p align="center">Supply</p>
<div class="row">
	<div class="col-sm-12">
        <div class="form-group">
            <label>Date and Place of Supply: </label>
			<input required type="text" name="edit_po_supply" class="form-control input-lg" value="<?php echo $getqoid['po_dapos'] ?>" />
        </div>
    </div>
</div>
<hr>
<p align="center">Address</p>
<div class="row">
	<div class="col-sm-6">
    <p align="center">Bill To</p>
        <div class="form-group">

            <label>Name: </label>
			<input id="edit_po_bill_name" required type="text" name="edit_po_bill_name" class="form-control input-lg" value="<?php echo $getqoid['po_bill_to_name']; ?>" />
            <label>Address 1: </label>
			<input id="edit_po_bill_addr1"  required type="text" name="edit_po_bill_addr1" class="form-control input-lg" value="<?php echo $getqoid['po_bill_to_addr1']; ?>" />
            <label>Address 2: </label>
			<input id="edit_po_bill_addr2"  required type="text" name="edit_po_bill_addr2" class="form-control input-lg" value="<?php echo $getqoid['po_bill_to_addr2']; ?>" />
            <label>Address 3: </label>
			<input id="edit_po_bill_addr3"  required type="text" name="edit_po_bill_addr3" class="form-control input-lg" value="<?php echo $getqoid['po_bill_to_addr3']; ?>" />
            <label>GSTIN: </label>
			<input id="edit_po_bill_gstin"  required type="text" name="edit_po_bill_gstin" class="form-control input-lg" value="<?php echo $getqoid['po_bill_to_gstin']; ?>" />
            <label>State And Code: </label>
			<input id="edit_po_bill_state"  required type="text" name="edit_po_bill_state" class="form-control input-lg" value="<?php echo $getqoid['po_bill_to_state']; ?>" />
        </div>
    </div>
	<div class="col-sm-6">
    <p align="center">Ship To</p>
        <div class="form-group">
            <label>Name: </label>
			<input id="edit_po_ship_name" required type="text" name="edit_po_ship_name" class="form-control input-lg" value="<?php echo $getqoid['po_ship_to_name']; ?>" />
            <label>Address 1: </label>
			<input id="edit_po_ship_addr1"  required type="text" name="edit_po_ship_addr1" class="form-control input-lg" value="<?php echo $getqoid['po_ship_to_addr1']; ?>" />
            <label>Address 2: </label>
			<input id="edit_po_ship_addr2"  required type="text" name="edit_po_ship_addr2" class="form-control input-lg" value="<?php echo $getqoid['po_ship_to_addr2']; ?>" />
            <label>Address 3: </label>
			<input id="edit_po_ship_addr3"  required type="text" name="edit_po_ship_addr3" class="form-control input-lg" value="<?php echo $getqoid['po_ship_to_addr3']; ?>" />
            <label>GSTIN: </label>


			<input id="edit_po_ship_gstin"  required type="text" name="edit_po_ship_gstin" class="form-control input-lg" value="<?php echo $getqoid['po_ship_to_gstin']; ?>" />
            <label>State And Code: </label>
			<input id="edit_po_ship_state"  required type="text" name="edit_po_ship_state" class="form-control input-lg" value="<?php echo $getqoid['po_ship_to_state']; ?>" />
        </div>
    </div>
</div>
<hr>


<br>


<table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Type</th>
                <th>Item Desc</th>
                <th>Item Remarks</th>
                <th>HSN Code</th>
                <th>Cost</th>
                <th>Selling Price</th>
                <th>Qty</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        
        <?php
		
		$sql = "SELECT * FROM sw_products_list p
where p.pr_valid =1 and p.pr_id 
order by pr_code asc";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$storedprlist[] =$row;
	}
} else {
	echo "0 results";
}
		?>
        <?php 
		$getprods = "SELECT * FROM `sw_proformas_items` where pi_valid =1 and pi_rel_po_id = ".$getqoid['po_id'];
		$loopmin = 1;
$getprods = $conn->query($getprods);

if ($getprods->num_rows > 0) {
    // output data of each row
    while($prods = $getprods->fetch_assoc()) {
		?>
        
        <tr >
<td><?php echo $loopmin ?></td>
            <td><select class="select2 edit_proforma_product<?php echo $loopmin; ?>" id="edit_proforma_product<?php echo $loopmin; ?>" name="edit_proforma_product<?php echo $loopmin; ?>">
<?php 
	echo '<option data-id="0" value="0">Select Product </option>';
foreach($storedprlist as $row){
		if($row['pr_id'] == $prods['pi_rel_pr_id']){
		   echo '<option selected data-id="'.$row['pr_id'].'" value="'.md5($row['pr_id']).'">'.$row['pr_code'].'-'.$row['pr_name'].'</option>';
		}else{
		   echo '<option  data-id="'.$row['pr_id'].'" value="'.md5($row['pr_id']).'">'.$row['pr_code'].'-'.$row['pr_name'].'</option>';
		}
		
	}
?>
<?php echo $loopmin; ?>
            </select></td>

            <td><select class="form-control edit_proforma_innerouter<?php echo $loopmin; ?>" id="edit_proforma_innerouter<?php echo $loopmin; ?>" name="edit_proforma_innerouter<?php echo $loopmin; ?>">
            	<?php 
					if($prods['pi_io'] == '1'){
						?>
  					<option data-id="1" value="1" selected>Inner</option>
                      <option data-id="2" value="2">Outer</option>
                      <?php
					}else{
						?>
  					<option  data-id="1" value="1" >Inner</option>
                      <option selected data-id="2" value="2">Outer</option>
                      <?php
					}
				?>
            </select></td>

            
<td><input name="edit_proforma_product_desc<?php echo $loopmin; ?>" type="text" class="form-control " id="edit_proforma_product_desc<?php echo $loopmin; ?>" required value="<?php echo $prods['pi_desc'] ?>" placeholder="Desc"  /></td>
<td><input name="edit_proforma_product_remarks<?php echo $loopmin; ?>" type="text" class="form-control " id="edit_proforma_product_remarks<?php echo $loopmin; ?>" required value="<?php echo $prods['pi_remarks'] ?>" placeholder="Remarks"  /></td>
<td><input name="edit_proforma_product_hsn<?php echo $loopmin; ?>"  type="number" class="form-control " id="edit_proforma_product_hsn<?php echo $loopmin; ?>" required value="<?php echo $prods['pi_hsn_code'] ?>" placeholder="HSN"  /></td>
<td><input name="edit_proforma_product_cost<?php echo $loopmin; ?>"  type="number" step="0.01" class="hidden form-control " id="edit_proforma_product_cost<?php echo $loopmin; ?>" required value="<?php echo $prods['pi_cost'] ?>" placeholder="Cost Price"  /></td>
<td><input name="edit_proforma_product_price<?php echo $loopmin; ?>" type="text" class="form-control " id="edit_proforma_product_price<?php echo $loopmin; ?>" required value="<?php echo $prods['pi_price'] ?>" placeholder="Sale Price"  /></td>
<td><input name="edit_proforma_product_qty<?php echo $loopmin; ?>" type="text" class="form-control " id="edit_proforma_product_qty<?php echo $loopmin; ?>" required value="<?php echo $prods['pi_qty'] ?>" placeholder="Qty"  /></td>

	<td><button type="button" class="btn btn-danger" onClick="$(this).closest('tr').remove();">Delete</button></td>
<script type="text/javascript">
$(document).ready(function() {
	$('#edit_proforma_product<?php echo $loopmin; ?>').change(function(){
		var tx = $(this).children('option:selected').data('id');
				$.post("master_action.php", {prid: tx}, function(result){
					result = $.parseJSON( result );
					$("#edit_proforma_product_desc<?php echo $loopmin; ?>").val(result.desc);
					$("#edit_proforma_product_cost<?php echo $loopmin; ?>").val(result.cost);
					$("#edit_proforma_product_price<?php echo $loopmin; ?>").val(result.cost);
					$("#edit_proforma_product_hsn<?php echo $loopmin; ?>").val(result.hsn);
					$("#edit_proforma_product_remarks<?php echo $loopmin; ?>").val(result.rem);
				});
	} );
} );
		
</script>

<script type="text/javascript">
$(document).ready(function() {
	$('#edit_proforma_innerouter<?php echo $loopmin; ?>').change(function(){
		var tx = $(this).children('option:selected').data('id');

				$.post("master_action.php", {innerouter:tx, priid: $('#edit_proforma_product<?php echo $loopmin; ?>').children('option:selected').data('id')}, function(result){
					result = $.parseJSON( result );
					$("#edit_proforma_product_cost<?php echo $loopmin; ?>").val(result.cost);
					$("#edit_proforma_product_price<?php echo $loopmin; ?>").val(result.cost);
					$("#edit_proforma_product_desc<?php echo $loopmin; ?>").val(result.desc);
				});
	} );
} );
		
</script>


	    </tr>
        <?php
	$loopmin++;
    }
} else {
	$loopmin = 1;
}
		
		for($i = $loopmin;$i < 101 ; $i++){
		?>
<tr >
<td><?php echo $i ?></td>
            <td><select class="select2 edit_proforma_product<?php echo $i; ?>" id="edit_proforma_product<?php echo $i; ?>" name="edit_proforma_product<?php echo $i; ?>">
<?php 
$sql = "SELECT * FROM sw_products_list p
where p.pr_valid =1 and p.pr_id 
order by pr_code asc";
$result = $conn->query($sql);
echo '<option data-id="0" value="0">Select Product </option>';
	foreach($storedprlist as $row){
		   echo '<option  data-id="'.$row['pr_id'].'" value="'.md5($row['pr_id']).'">'.$row['pr_code'].'-'.$row['pr_name'].'</option>';
	}
?>

<?php echo $i; ?>
            </select></td>

            <td><select class="form-control edit_proforma_innerouter<?php echo $i; ?>" id="edit_proforma_innerouter<?php echo $i; ?>" name="edit_proforma_innerouter<?php echo $i; ?>">
					<option data-id="1" value="1" selected>Inner</option>
                    <option data-id="2" value="2">Outer</option>
            </select></td>

            
            <td><input name="edit_proforma_product_desc<?php echo $i; ?>" type="text" class="form-control " id="edit_proforma_product_desc<?php echo $i; ?>" required value="-" placeholder="Desc"  /></td>
            <td><input name="edit_proforma_product_remarks<?php echo $i; ?>" type="text" class="form-control " id="edit_proforma_product_remarks<?php echo $i; ?>" required value="-" placeholder="Remarks"  /></td>
            <td><input name="edit_proforma_product_hsn<?php echo $i; ?>"  type="number" class="form-control " id="edit_proforma_product_hsn<?php echo $i; ?>" required value="0000" placeholder="HSN"  /></td>
            <td><input name="edit_proforma_product_cost<?php echo $i; ?>"  type="number" step="0.01" class="hidden form-control " id="edit_proforma_product_cost<?php echo $i; ?>" required value="0" placeholder="Cost Price"  /></td>
            <td><input name="edit_proforma_product_price<?php echo $i; ?>" type="text" class="remzonfocus form-control " id="edit_proforma_product_price<?php echo $i; ?>" required value="0" placeholder="Sale Price"  /></td>
            <td><input name="edit_proforma_product_qty<?php echo $i; ?>" type="text" class="remzonfocus form-control " id="edit_proforma_product_qty<?php echo $i; ?>" required value="0" placeholder="Qty"  /></td>
			<td></td>
<script type="text/javascript">
$(document).ready(function() {
	$('#edit_proforma_product<?php echo $i; ?>').change(function(){
		var tx = $(this).children('option:selected').data('id');
				$.post("master_action.php", {prid: tx}, function(result){
					result = $.parseJSON( result );
					$("#edit_proforma_product_desc<?php echo $i; ?>").val(result.desc);
					$("#edit_proforma_product_cost<?php echo $i; ?>").val(result.cost);
					$("#edit_proforma_product_price<?php echo $i; ?>").val(result.cost);
					$("#edit_proforma_product_hsn<?php echo $i; ?>").val(result.hsn);
					$("#edit_proforma_product_remarks<?php echo $i; ?>").val(result.rem);
				});
	} );
} );
		
</script>

<script type="text/javascript">
$(document).ready(function() {
	$('#edit_proforma_innerouter<?php echo $i; ?>').change(function(){
		var tx = $(this).children('option:selected').data('id');

				$.post("master_action.php", {innerouter:tx, priid: $('#edit_proforma_product<?php echo $i; ?>').children('option:selected').data('id')}, function(result){
					result = $.parseJSON( result );
					$("#edit_proforma_product_cost<?php echo $i; ?>").val(result.cost);
					$("#edit_proforma_product_price<?php echo $i; ?>").val(result.cost);
					$("#edit_proforma_product_desc<?php echo $i; ?>").val(result.desc);
				});
	} );
} );
		
</script>


	    </tr>
        <?php }?>
         <script src="assets/select2/select2.min.js" type="text/javascript"></script>

        <script>
		jQuery(".select2").select2({
		   width: '100%'
		  });	
		</script>

        <script>
		$(document).ready(function(){
    var Input = $('.remzonfocus');
    var default_value = Input.val();

    $(Input).focus(function() {
        if($(this).val() == default_value)
        {
             $(this).val("");
        }
    }).blur(function(){
        if($(this).val().length == 0) /*Small update*/
        {
            $(this).val(default_value);
        }
    });
})
		</script>
        </tbody>
</table>
<hr>

<hr>


</div>
<hr>
<input type="text" class="form-control" required placeholder="Enter 1 to submit" />
<input type="hidden" name="edit_proforma" value="Save Changes" />

    <hr>
<div class=" row">
	<div class="col-xs-6">
    <input type="hidden" name="edit_po_id" value="<?php echo md5(md5('jihfeudbjsu39herinvh u3infr 3un gf893h9 83hfuh eushfer'.$getqoid['po_id'] )) ?>" />
		<input required  style="float:right" type="submit" class="btn btn-success" name="edit_proforma" value="Edit Bill">
	</div>
</div>
	</form>

<script>
$('#select22').change(function() {
     
	   $.post("master_action.php",
    {
        cli_id: $(this).val()
    },
    function(data, status){
		$("#togetdatafrom").html(data);
		
    });
	
		   $.post("master_action.php",
    {
        clii_id: $(this).val()
    },
    function(result, status){
					result = $.parseJSON( result );
					$("#edit_po_bill_name").val(result.name);
					$("#edit_po_bill_addr1").val(result.a1);
					$("#edit_po_bill_addr2").val(result.a2);
					$("#edit_po_bill_addr3").val(result.a3);
					$("#edit_po_bill_gstin").val(result.gstin);
					$("#edit_po_bill_state").val(result.state);
		
    });


	 
});
</script>





<script>
$('#cli_ship').change(function() {
     

	
		   $.post("master_action.php",
    {
        clii_id: $(this).val()
    },
    function(result, status){
					result = $.parseJSON( result );
					$("#edit_po_ship_name").val(result.name);
					$("#edit_po_ship_addr1").val(result.a1);
					$("#edit_po_ship_addr2").val(result.a2);
					$("#edit_po_ship_addr3").val(result.a3);
					$("#edit_po_ship_gstin").val(result.gstin);
					$("#edit_po_ship_state").val(result.state);
		
    });


	 
});
</script>

<script>
function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

$('#edit_po_wh').submit(function (evt) {
    evt.preventDefault();
	 $.ajax({
         type: 'POST',
         url: "master_action.php",
         data: $('#edit_po_wh').serialize(), 
         success: function(response) {
			 if(IsJsonString(response)){
				 var json = $.parseJSON(response);
				$('#edit_po_wh').html("<h2>Form Submitted Succesfully</h2>");
				window.location.href = json.url;
				 
			 }else{
				alert(response);

			 }
         },
        error: function() {
             //$("#commentList").append($("#name").val() + "<br/>" + $("#body").val());
            alert("There was an error submitting comment");
        }
     });
	 
});
</script>


    <?php
}
/*-----------------------------------------------*/
if(isset($_POST['costing_add'])){
	$getpo  = getdatafromsql($conn,"select * from sw_proformas where po_valid =1 and md5(po_id) = '".$_POST['costing_add']."'");
	if(!is_array($getpo)){
		die('No Purchase Order Found');
	}
	?>

<form action="master_action.php" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-xs-6">
        <label>Cost Reason</label>
        <input type="text"  name="costing_head" value="-" class="form-control" placeholder="Labour Food"/>
    </div>
    <div class="col-xs-6">                
        <label>Cost Value(AED)</label>
        <input  type="number" step="0.01"  name="costing_value" min="1" value="0" class="form-control" placeholder="Enter AED"/>
    </div>
</div>
<div class="row"><br>

    <input type="hidden"  name="costing_hash" class="form-control" value="<?php echo md5($getpo['po_id']) ?>"/>
    <input type="submit"  name="add_costing" class="btn btn-success" value="Add Addition Cost"/>

</div>
</form>



    <?php
}
if(isset($_POST['costing_view'])){
		$getpro  = getdatafromsql($conn,"select * from sw_proformas where po_valid =1 and md5(po_id) = '".$_POST['costing_view']."'");
	if(!is_array($getpro)){
		die('No Proforma Found');
	}

	?>
<p>Costing Tracking</p>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Cost Name</th>
                    <th>Cost Value</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
            <?php
			
			
			
$gsql = "SELECT * FROM `sw_costing` 
WHERE cost_valid =1 and `cost_rel_po_id` = ".$getpro['po_id']." order by cost_dnt desc";
$gsql = $conn->query($gsql);

if ($gsql->num_rows > 0) {
    // output data of each row
    while($grow = $gsql->fetch_assoc()) {
       echo '
	   <tr>
	   	<td>'.$grow['cost_name'].'</td>
	   	<td>'.$grow['cost_val'].'</td>
	   	<td>'.date('D, j/n/y @ H:i:s',$grow['cost_dnt']).'</td>
	   </tr>
	   
	   
	   ';
    }
} else {
    echo "<tr><td colspan='3'> None Added</td></tr>";
}
			
			?>
            </tbody>
</table>

    <?php
}
/*-----------------------------------------------*/
if(isset($_POST['payment_add'])){
	$getpo  = getdatafromsql($conn,"select * from sw_proformas left join sw_currency on po_rel_cur_id = cur_id
 where po_valid =1 and md5(po_id) = '".$_POST['payment_add']."'");
	if(!is_array($getpo)){
		die('No Proforma Found');
	}
	?>
<table id="datatable1" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Total Price <br>
                            (Including Vat and Discout)</th>
                          <th>Amount Paid</th>
                          <th>Amount Left</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
$productsql = "SELECT * FROM `sw_proformas` 
WHERE po_id = '".$getpo['po_revision_id']."'
";
$productres = $conn->query($productsql);

/*
select * from sw_purchaseorders where pco_valid =1 and pco_revision_id = '".$_POST['add_salesinvoice_proforma_hash']."' order by pco_revision desc limit 1 
*/
if ($productres->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	$con = 1;
	while($productrw = $productres->fetch_assoc()) {
	$getmax = getdatafromsql($conn,"
select * from sw_proformas p
left join sw_clients c on p.po_rel_cli_id = c.cli_id
left join sw_currency cy on p.po_rel_cur_id = cy.cur_id
where po_valid =1 and cli_valid =1 and po_revision_id = '".$productrw['po_id']."' order by po_revision desc limit 1");
$getsales = getdatafromsql($conn, "
select * from `sw_salesinvoices` s
left join sw_proformas pk on s.so_rel_po_id = pk.po_id
 where po_valid=1 and so_valid =1 and po_revision_id = ".$productrw['po_id']." order by so_revision desc limit 1");
 
			if(is_array($getsales)){
				$salesref = $getsales['so_ref'];

$gettotalprice = getdatafromsql($conn,"select sum(si_qty * si_price) as total from sw_salesinvoices_items left join sw_products_list on si_rel_pr_id = pr_id left join sw_prod_types on pr_rel_prty_id = prty_id where si_rel_so_id = ".$getsales['so_id']." and si_valid =1 and prty_pr_hidden = 0");
			$gettotalpricegen = getdatafromsql($conn,"select sog_discount as sog_discount,
			((sog_vat * ".$gettotalprice['total'].")/100) as sog_vat,
			(sog_extra_price) from sw_salesinvoices_gen where sog_rel_so_id = ".$getsales['so_id']." and sog_valid =1 order by sog_dnt desc limit 1");
			
			$getamountpaid = getdatafromsql($conn,"select sum(pt_val) as total from sw_payments where pt_rel_po_id = ".$productrw['po_id']." and pt_valid =1");
			$getinstallments = getdatafromsql($conn,"select count(pt_id) as total from sw_payments where pt_rel_po_id = ".$productrw['po_id']." and pt_valid =1");
			
			
			$checkgen = getdatafromsql($conn,"select * from sw_salesinvoices_gen where sog_rel_so_id = ".$getsales['so_id']." and sog_valid =1 ");				
			}else{

				$salesref = '-';

$gettotalprice = getdatafromsql($conn,"select sum(pi_qty * pi_price) as total from sw_proformas_items left join sw_products_list on pi_rel_pr_id = pr_id left join sw_prod_types on pr_rel_prty_id = prty_id where pi_rel_po_id = ".$getmax['po_id']." and pi_valid =1 and prty_pr_hidden = 0");
			$gettotalpricegen = getdatafromsql($conn,"select pog_discount as pog_discount,
			((pog_vat * ".$gettotalprice['total'].")/100) as pog_vat,
			(pog_extra_price) from sw_proformas_gen where pog_rel_po_id = ".$getmax['po_id']." and pog_valid =1 order by pog_dnt desc limit 1");
			
			$getamountpaid = getdatafromsql($conn,"select sum(pt_val) as total from sw_payments where pt_rel_po_id = ".$productrw['po_id']." and pt_valid =1");
			$getinstallments = getdatafromsql($conn,"select count(pt_id) as total from sw_payments where pt_rel_po_id = ".$productrw['po_id']." and pt_valid =1");
			
			
			$checkgen = getdatafromsql($conn,"select * from sw_proformas_gen where pog_rel_po_id = ".$getmax['po_id']." and pog_valid =1 ");
			}
			

			
			
			
			if(is_array($checkgen)){
	if(trim($salesref) !== '-'){
				$total = (($gettotalprice['total'] - $gettotalpricegen['sog_discount'] + $gettotalpricegen['sog_extra_price']+ $gettotalpricegen['sog_vat']));
echo '<tr>
	<td>'.$con.'</td>
	<td>'.$getmax['cur_name'].' '.number_format($total ,2).'</td>
	<td>'.$getmax['cur_name'].' '.number_format((($getamountpaid['total']  * $getsales['so_cur_rate'])) ,2).'</td>
	<td>'.$getmax['cur_name'].' '.number_format(($total - ($getamountpaid['total']) * $getsales['so_cur_rate'] ),2).'</td>
	</tr>';

				
				}else{
				$total = (($gettotalprice['total'] - $gettotalpricegen['pog_discount'] + $gettotalpricegen['pog_extra_price']+ $gettotalpricegen['pog_vat']));
echo '<tr>
	<td>'.$con.'</td>
	<td>'.$getmax['cur_name'].' '.number_format($total ,2).'</td>
	<td>'.$getmax['cur_name'].' '.number_format((($getamountpaid['total']  * $getmax['po_cur_rate'])) ,2).'</td>
	<td>'.$getmax['cur_name'].' '.number_format(($total - ($getamountpaid['total']) * $getmax['po_cur_rate'] ),2).'</td>
	</tr>';

				

				}
			}else{
				
	if(trim($salesref) == '-'){
			echo('<tr>
	<td>	'.$con.'</td>
<td style="border-right-width: 0px;">Generate Print View for Proforma Ref:<strong>'.$getmax['po_ref'].' </strong>to Manage Payments</td>
	<td style="border-right-width: 0px;">	</td>
	<td style="border-right-width: 0px;">	</td>
	<td>	</td>
	</tr>');
	}else{
			echo('<tr>
	<td>	'.$con.'</td>
<td style="border-right-width: 0px;">Generate Print View for SalesInvoice Ref:<strong>'.$getsales['so_ref'].' </strong>to Manage Payments</td>
	<td style="border-right-width: 0px;">	</td>
	<td style="border-right-width: 0px;">	</td>
	<td>	</td>
	</tr>');
		}
	
	
			}
				$con++;

	}

} else {
}?>
                      </tbody>
                    </table>
                    <hr><br>
<form action="master_action.php" method="post" enctype="multipart/form-data">
<input type="hidden" value="<?php echo $_POST['payment_add'] ?>" name="payment_add_hash"/>  
<div class="row">
    <div class="col-xs-6">
        <label>Method</label>
        <select name="payment_add_method" class="form-control" onchange="getval(this);">
<?php
$sql = "SELECT * from sw_payments_methods";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<option value="'.md5($row['method_id']).'">'.$row['method_name'].'</option>';
    }
} else {
}


?>
        </select>
    </div>
    <div class="col-xs-6 tohide">                
        <label>Cheque Number</label>
        <input type="text"  name="payment_add_c_no"  value="0" class="form-control" placeholder="Enter Cheque Number"/>
    </div>
    <div class="col-xs-6 tohide">                
        <label>Cheque Date(Enter 0 if not cheque)</label>
        <input type="text"  name="payment_add_date" placeholder="" value="0" class="form-control">
        <span class="help-inline">dd-mm-yyyy</span>
    </div>
    <div class="col-xs-6">                
        <label>Payment Value(<?php echo $getpo['cur_name'] ?>)</label>
        <input  type="number" step="0.01"  name="payment_add_val" min="1" value="0" max="<?php echo round(($total - ($getamountpaid['total']) * $getmax['po_cur_rate'] ),2); ?>" class="form-control" placeholder="Enter AED"/>
    </div>
</div>
<div class="row"><br>

    <input type="submit"  name="payment_add" class="btn btn-success" value="Add Payment"/>

</div>
</form>
<script>
function getval(sel)
{
    if((sel.value) == 'c81e728d9d4c2f636f067f89cc14862c'){
		$(".tohide").hide();
	}else{
		$(".tohide").show();
	}
}
</script>
        <script src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>


    <?php
}
if(isset($_POST['payment_view'])){
	if(!ctype_alnum($_POST['payment_view'])){
		die('Proforma Not Found');
	}
		$getpro  = getdatafromsql($conn,"select * from sw_proformas
		left join sw_currency on po_rel_cur_id = cur_id
 where po_valid =1 and md5(po_id) = '".$_POST['payment_view']."' ");
	if(!is_array($getpro)){
		die('No Proforma Found');
	}

	?>
<p>Currency and Rate: <strong><?php echo $getpro['cur_name'] ?> @ <?php echo $getpro['po_cur_rate'] ?></strong></p>
                                    <table id="datatable9" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Client </th>
                                                    <th>Method</th>
                                                    <th>Cheque Number</th>
                                                    <th>Cheque Dated</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$bproductsql = "SELECT * FROM `sw_payments`
left join sw_payments_methods on pt_rel_method_id = method_id 
left join sw_proformas on pt_rel_po_id = po_id
left join sw_clients on po_rel_cli_id = cli_id
WHERE po_valid=1 and pt_rel_po_id = ".$getpro['po_id']."
order by pt_dnt desc
";
$bproductsql = $conn->query($bproductsql);

/*
select * from sw_purchaseorders where pco_valid =1 and pco_revision_id = '".$_POST['add_salesinvoice_proforma_hash']."' order by pco_revision desc limit 1 
*/
if ($bproductsql->num_rows > 0) {
	//'.md5(md5(sha1(md5($productrw['pr_id'])))).'_primga output data of each row
	$con = 1;
	while($prodrow = $bproductsql->fetch_assoc()) {
		echo '<tr>
	<td>'.$con.'</td>
	<td>'.$prodrow['cli_name'].'</td>
	<td>'.$prodrow['method_name'].'</td>
	<td>'.($prodrow['method_id'] =='2' ? '-': $prodrow['pt_cheque_number']).'</td>
	<td>'.($prodrow['method_id'] =='2' ? '-': date('j-n-Y',$prodrow['pt_cheque_date'])).'</td>
	<td>'.$getpro['cur_name'].' '.number_format(($prodrow['pt_val'] * $getpro['po_cur_rate']),2).'</td>
	</tr>';
	$con++;
	}

} else {
}?>
                        </tbody>
                                        </table>
                                        <script type="text/javascript">
    $(document).ready(function() {
        $('#datatable9').dataTable();
    } );
</script>


    <?php
}
if(isset($_POST['past_pay'])){
				$foryesterday = "SELECT t.*, p.po_ref, c.cli_name FROM 
sw_payments t
left join sw_proformas p on pt_rel_po_id = po_id
left join sw_clients c on po_rel_cli_id = cli_id 
WHERE pt_valid = 1 and cli_valid =1 and po_valid =1 and
 ((from_unixtime(`pt_cheque_date`, '%d') *1 )  = ".(date('j',(time()-86400))).") and 
 ((from_unixtime(`pt_cheque_date`, '%m') *1 )  = ".(date('n',(time()-86400))).") and 
 ((from_unixtime(`pt_cheque_date`, '%Y') *1 )  = ".(date('Y',(time()-86400))).")";

?>
                    <table id="datatable2" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Proforma Ref</th>
                          <th>Client </th>
                          <th>Cheque Number</th>
                          <th>Cheque Dated</th>
                          <th>Value</th>
                        </tr>
                      </thead>
                      <tbody>

<?php
$foryesterday = $conn->query($foryesterday);

if ($foryesterday->num_rows > 0) {
    // output data of each row
    while($foryesterdayrow = $foryesterday->fetch_assoc()) {
		echo '<tr>
		<td>'.$foryesterdayrow['po_ref'].'</td>
		<td>'.$foryesterdayrow['cli_name'].'</td>
		<td>'.$foryesterdayrow['pt_cheque_number'].'</td>
		<td>'.date('j-n-Y',$foryesterdayrow['pt_cheque_date']).'</td>
		<td>'.$foryesterdayrow['pt_val'].'</td>
		</tr>';
    }
} else {
    echo "0 results";
}
?>
</tbody></table>
<?php
}
/*-------------------------------*/
if(isset($_POST['today_pay'])){

			$fortoday ="SELECT t.*, p.po_ref, c.cli_name FROM 
sw_payments t
left join sw_proformas p on pt_rel_po_id = po_id
left join sw_clients c on po_rel_cli_id = cli_id 
WHERE pt_valid = 1 and cli_valid =1 and po_valid =1 and
 ((from_unixtime(`pt_cheque_date`, '%d') *1 )  = ".(date('j',(time()))).") and 
 ((from_unixtime(`pt_cheque_date`, '%m') *1 )  = ".(date('n',(time()))).") and 
 ((from_unixtime(`pt_cheque_date`, '%Y') *1 )  = ".(date('Y',(time()))).")";
?>
                    <table id="datatable2" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Proforma Ref</th>
                          <th>Client </th>
                          <th>Cheque Number</th>
                          <th>Cheque Dated</th>
                          <th>Value</th>
                        </tr>
                      </thead>
                      <tbody>

<?php
$fortoday = $conn->query($fortoday);

if ($fortoday->num_rows > 0) {
    // output data of each row
    while($foryesterdayrow = $fortoday->fetch_assoc()) {
		echo '<tr>
		<td>'.$foryesterdayrow['po_ref'].'</td>
		<td>'.$foryesterdayrow['cli_name'].'</td>
		<td>'.$foryesterdayrow['pt_cheque_number'].'</td>
		<td>'.date('j-n-Y',$foryesterdayrow['pt_cheque_date']).'</td>
		<td>'.$foryesterdayrow['pt_val'].'</td>
		</tr>';
    }
} else {
    echo "0 results";
}
?>
</tbody></table>
<?php

}
if(isset($_POST['tomorrow_pay'])){

			$fortom = "SELECT t.*, p.po_ref, c.cli_name FROM 
sw_payments t
left join sw_proformas p on pt_rel_po_id = po_id
left join sw_clients c on po_rel_cli_id = cli_id 
WHERE pt_valid = 1 and cli_valid =1 and po_valid =1 and
 ((from_unixtime(`pt_cheque_date`, '%d') *1 )  = ".(date('j',(time()+86400))).") and 
 ((from_unixtime(`pt_cheque_date`, '%m') *1 )  = ".(date('n',(time()+86400))).") and 
 ((from_unixtime(`pt_cheque_date`, '%Y') *1 )  = ".(date('Y',(time()+86400))).")";
?>
                    <table id="datatable2" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Proforma Ref</th>
                          <th>Client </th>
                          <th>Cheque Number</th>
                          <th>Cheque Dated</th>
                          <th>Value</th>
                        </tr>
                      </thead>
                      <tbody>

<?php
$fortom = $conn->query($fortom);

if ($fortom->num_rows > 0) {
    // output data of each row
    while($foryesterdayrow = $fortom->fetch_assoc()) {
		echo '<tr>
		<td>'.$foryesterdayrow['po_ref'].'</td>
		<td>'.$foryesterdayrow['cli_name'].'</td>
		<td>'.$foryesterdayrow['pt_cheque_number'].'</td>
		<td>'.date('j-n-Y',$foryesterdayrow['pt_cheque_date']).'</td>
		<td>'.$foryesterdayrow['pt_val'].'</td>
		</tr>';
    }
} else {
    echo "0 results";
}
?>
</tbody></table>
<?php

}
if(isset($_POST['dayaftertomorrow_pay'])){
			$fordayaftertom = "SELECT t.*, p.po_ref, c.cli_name FROM 
sw_payments t
left join sw_proformas p on pt_rel_po_id = po_id
left join sw_clients c on po_rel_cli_id = cli_id 
WHERE pt_valid = 1 and cli_valid =1 and po_valid =1 and
 ((from_unixtime(`pt_cheque_date`, '%d') *1 )  = ".(date('j',(time()+(86400*2)))).") and 
 ((from_unixtime(`pt_cheque_date`, '%m') *1 )  = ".(date('n',(time()+(86400*2)))).") and 
 ((from_unixtime(`pt_cheque_date`, '%Y') *1 )  = ".(date('Y',(time()+(86400*2)))).")";
 
?>
                    <table id="datatable2" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Proforma Ref</th>
                          <th>Client </th>
                          <th>Cheque Number</th>
                          <th>Cheque Dated</th>
                          <th>Value</th>
                        </tr>
                      </thead>
                      <tbody>

<?php
$fordayaftertom = $conn->query($fordayaftertom);

if ($fordayaftertom->num_rows > 0) {
    // output data of each row
    while($foryesterdayrow = $fordayaftertom->fetch_assoc()) {
		echo '<tr>
		<td>'.$foryesterdayrow['po_ref'].'</td>
		<td>'.$foryesterdayrow['cli_name'].'</td>
		<td>'.$foryesterdayrow['pt_cheque_number'].'</td>
		<td>'.date('j-n-Y',$foryesterdayrow['pt_cheque_date']).'</td>
		<td>'.$foryesterdayrow['pt_val'].'</td>
		</tr>';
    }
} else {
    echo "0 results";
}
?>
</tbody></table>
<?php
 
 
 
}
/*-------------------------------*/
if(isset($_POST['home_qty_sold'])){
	if(!ctype_alnum($_POST['home_qty_sold'])){
		die('Product Not Found');
	}
		$getpro  = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['home_qty_sold']."' ");
	if(!is_array($getpro)){
		die('No Product Found');
	}

	?>

<?php 

}
if(isset($_POST['home_qty_stored'])){
	if(!ctype_alnum($_POST['home_qty_stored'])){
		die('Product Not Found');
	}
		$getwarehouse  = getdatafromsql($conn,"select * from sw_products_list where md5(concat(123, pr_id)) = '".$_POST['home_qty_stored']."' ");
	if(!is_array($getwarehouse)){
		die('No Product Found');
	}
/*
		$getmockup  = getdatafromsql($conn,"select * from sw_mockups where mock_rel_pr_id = '".$getwarehouse['pr_id']."' ");
	if(!is_array($getmockup)){
		die('No Product Found');
	}

*/
	?>
    
    <div class="row">
    	<div style="border:1px solid black " class="col-lg-3 col-md-8 col-xs-12">
        <h4 align="center">Samples Sent for Approval</h4>
      <table class="table">
		<thead>
			<tr>
				<th>Client Name</th>
				<th>Sent From</th>
				<th>Address</th>
				<th>Qty</th>
			</tr>
		</thead>
		<tbody>
<?php	
$showroommock =array();	
$clisql = "select *, sum(mock_qty) as qty  from sw_mockups 
left join sw_clients on mock_rel_cli_id = cli_id
left join sw_showrooms on mock_rel_shw_id = shw_id
left join sw_suppliers on mock_rel_sup_id = sup_id
where mock_rel_pr_id = ".$getwarehouse['pr_id']." and mock_returned =0
group by mock_rel_cli_id";
$clisql = $conn->query($clisql);
	$mqty = 0;
if ($clisql->num_rows > 0) {
    // output data of each row
	
    while($clisqlrow = $clisql->fetch_assoc()) {
		$mocksqty = $clisqlrow['qty'];
		
		
if($clisqlrow['mock_rel_shw_id'] > 0){
	if(isset($showroommock[$clisqlrow['mock_rel_shw_id']])){
		$showroommock[$clisqlrow['mock_rel_shw_id']] = $showroommock[$clisqlrow['mock_rel_shw_id']] + $clisqlrow['qty'];	
	}else{
		$showroommock[$clisqlrow['mock_rel_shw_id']] = $clisqlrow['qty'];	
	}
}


       ?>
<tr>
	<td><?php echo $clisqlrow['cli_name']; ?></td>

<?php

if($clisqlrow['mock_rel_shw_id'] > 0){
	echo '<td>'.$clisqlrow['shw_name'].' Showroom</td>';
}else if($clisqlrow['mock_rel_sup_id'] > 0){
	echo '<td>'.$clisqlrow['sup_name'].' Supplier</td>';
}else{
	echo '<td>Warehouse</td>';
}

?>	
	<td><?php echo $clisqlrow['cli_bill_addr']; ?></td>

	<td><?php echo $mocksqty; ?></td>
</tr>
       <?php
		$mqty = $mqty +$mocksqty;
    }
} else {
    echo "<tr><td colspan='3'>No Mockups</td></tr>";
}		
?>


</tbody>
</table>
        </div>
    	<div style="border:1px solid black " class="col-lg-2 col-md-4 col-xs-12">
        <h4 align="center">Showroom</h4>
      <table class="table">
		<thead>
			<tr>
				<th>Showroom Name</th>
				<th>Qty</th>
			</tr>
		</thead>
		<tbody>
<?php		
$shwsql = "select * , sum(sh_qty) as qty from sw_products_list_show left join sw_showrooms on sh_rel_shw_id = shw_id where sh_rel_pr_id = '".$getwarehouse['pr_id']."' group by shw_id ";
$shwsql = $conn->query($shwsql);
	$shqty = 0;
if ($shwsql->num_rows > 0) {
    // output data of each row
    while($shwsqlrow = $shwsql->fetch_assoc()) {
				$showroomqty = $shwsqlrow['qty'];

	if(isset($showroommock[$shwsqlrow['sh_rel_shw_id']])){
		$showroomqty = $showroomqty - $showroommock[$shwsqlrow['sh_rel_shw_id']] ;	
	}

		

       ?>
<tr>
	<td><?php echo $shwsqlrow['shw_name']; ?></td>
	<td><?php echo $showroomqty; ?></td>
</tr>
       <?php
		$shqty = $shqty +$showroomqty;
    }
} else {
    echo "<tr><td colspan='2'>No Showroom Product</td></tr>";
}		
?>



</tbody>
</table></div>
    	<div style="border:1px solid black " class="col-lg-7 col-md-12 col-xs-12">
<h4 align="center">Sold</h4>
<?php 
echo '
      <table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Sales Invoice Ref</th>
				<th>Client Name</th>
				<th>Qty</th>
				';if($_SESSION['STWL_LUM_TU_ID'] == '1'){echo'<th>Cost</th>';} echo '
				<th>Price</th>
				';if($_SESSION['STWL_LUM_TU_ID'] == '1'){echo'<th>Markup</th>';}
				echo '
			</tr>
		</thead>
		<tbody>
		
		
		';

		
			$innersql = "SELECT a.*
FROM (select * from sw_proformas_items left join sw_proformas on pi_rel_po_id = po_id where po_valid =1 and pi_valid =1) a
LEFT OUTER JOIN (select * from sw_proformas_items left join sw_proformas on pi_rel_po_id = po_id where po_valid =1 and pi_valid =1) b
    ON a.po_revision_id = b.po_revision_id AND a.po_revision < b.po_revision
WHERE b.po_revision_id IS NULL
and a.pi_rel_pr_id =".$getwarehouse['pr_id'];

			$innersql = "SELECT a.*
FROM (select * from sw_salesinvoices_items left join sw_salesinvoices on si_rel_so_id = so_id where so_valid =1 and si_valid =1) a
LEFT OUTER JOIN (select * from sw_salesinvoices_items left join sw_salesinvoices on si_rel_so_id = so_id where so_valid =1 and si_valid =1) b
    ON a.so_revision_id = b.so_revision_id AND a.so_revision < b.so_revision
WHERE b.so_revision_id IS NULL
and a.si_rel_pr_id =".$getwarehouse['pr_id'];

			$inneres = $conn->query($innersql);
				$ttqty = 0;

			if ($inneres->num_rows > 0) {
			// output data of each row
			$placce = 1;
			while($innerw = $inneres->fetch_assoc()) {
								$proformaqty = $innerw['si_qty'];

			#2nd loop start

				$getclient = getdatafromsql($conn,"SELECT * from sw_clients where cli_valid =1 and cli_id='".$innerw['so_rel_cli_id']."'");


if(!is_array($getclient)){
	die('No Client Found');
}
								
								echo '<tr>';
								echo '
								<td>'.$placce.'</td>
								<td>'.$innerw['so_ref'].'</td>
								<td>'.$getclient['cli_name'].'</td>
								<td>'.$proformaqty.'</td>';
								if($_SESSION['STWL_LUM_TU_ID'] == '1'){echo'<td>AED '.$innerw['si_cost'].'</td>';}
								echo '
								<td>AED '.$innerw['si_price'].'</td>';
								
								if($_SESSION['STWL_LUM_TU_ID'] == '1'){echo'
								<td>'.round($innerw['si_price']/$innerw['si_cost'],4).'</td>
									';}
								echo '</tr>';
		$ttqty = $ttqty + $proformaqty;
						$placce++;
	
			
			
		#2nd loop end	
			}
		} else {
			echo "<tr><td colspan='4'>No Orders</td></tr>";
		}
		
	
	echo '
	</tbody>
	</table>
 ';
?></div>
    </div>
    <div class="row">
    	<div style="border:1px solid black" class="col-xs-12">
		<?php $totalbusy = $mqty + $shqty +$ttqty; ?>
<h4 align="center">Warehouse</h4>
      <table class="table">
		<thead>
			<tr>
				<th>Invoice Ref</th>
				<th>Qty</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
        
        <?php 
		
		$abc = "SELECT * FROM sw_products_qty where pq_valid =1 and pq_rel_pr_id = ".$getwarehouse['pr_id'];
$abc = $conn->query($abc);

if ($abc->num_rows > 0) {
    // output data of each row
    while($abca = $abc->fetch_assoc()) {
        ?>
        <tr>
        	<td><?php echo $abca['pq_ref']; ?></td>
        	<td><?php echo $abca['pq_qty']; ?></td>
        	<td><?php echo date('D, j M, Y',$abca['pq_dnt']); ?></td>
        </tr>
        <?php
    }
} else {
    echo "0 results";
}
		?>
<tr>
	<td colspan="3"><?php echo '('.$getwarehouse['pr_qty'].' - '.$mqty.' - '.$shqty.' - '.$ttqty.')=' ?><br><h3 style="color:red"><?php echo $getwarehouse['pr_qty'] - $totalbusy; ?></h3></td>
</tr>
</tbody>
</table>

</div>
    </div>





<?php

}
if(isset($_POST['home_qty_stored_sp'])){
	if(!ctype_alnum($_POST['home_qty_stored_sp'])){
		die('Product Not Found');
	}
		$getwarehouse  = getdatafromsql($conn,"select * from sw_products_list where md5(concat(123, pr_id)) = '".$_POST['home_qty_stored_sp']."' ");
	if(!is_array($getwarehouse)){
		die('No Product Found');
	}
/*
		$getmockup  = getdatafromsql($conn,"select * from sw_mockups where mock_rel_pr_id = '".$getwarehouse['pr_id']."' ");
	if(!is_array($getmockup)){
		die('No Product Found');
	}

*/
	?>
    
<div class="row">
	<div style="border:1px solid black " class="col-lg-7 col-md-12 col-xs-12">
		<h4 align="center">Sold</h4>
<?php 
echo '
      <table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Sales Invoice Ref</th>
				<th>Client Name</th>
				<th>Qty</th>
				';if($_SESSION['STWL_LUM_TU_ID'] == '1'){echo'<th>Cost</th>';} echo '
				<th>Price</th>
				';if($_SESSION['STWL_LUM_TU_ID'] == '1'){echo'<th>Markup</th>';}
				echo '
			</tr>
		</thead>
		<tbody>
		
		
		';

		
			$innersql = "SELECT a.*
FROM (select * from sw_proformas_items left join sw_proformas on pi_rel_po_id = po_id where po_valid =1 and pi_valid =1) a
LEFT OUTER JOIN (select * from sw_proformas_items left join sw_proformas on pi_rel_po_id = po_id where po_valid =1 and pi_valid =1) b
    ON a.po_revision_id = b.po_revision_id AND a.po_revision < b.po_revision
WHERE b.po_revision_id IS NULL
and a.pi_rel_pr_id =".$getwarehouse['pr_id'];


			$inneres = $conn->query($innersql);
				$ttqty = 0;

			if ($inneres->num_rows > 0) {
			// output data of each row
			$placce = 1;
			while($innerw = $inneres->fetch_assoc()) {
				$getsalesinvoice= getdatafromsql($conn,"SELECT * from sw_salesinvoices where so_rel_po_id = '".$innerw['po_id']."' and so_valid =1 LIMIT 1");


if(!is_array($getsalesinvoice)){


								$proformaqty = $innerw['pi_qty'];

			#2nd loop start

				$getclient = getdatafromsql($conn,"SELECT * from sw_clients where cli_valid =1 and cli_id='".$innerw['po_rel_cli_id']."'");


if(!is_array($getclient)){
	die('No Client Found');
}

				
								
								echo '<tr>';
								echo '
								<td>'.$placce.'</td>
								<td>'.$innerw['po_ref'].'</td>
								<td>'.$getclient['cli_name'].'</td>
								<td>'.$proformaqty.'</td>';
								if($_SESSION['STWL_LUM_TU_ID'] == '1'){echo'<td>AED '.$innerw['pi_cost'].'</td>';}
								echo '
								<td>AED '.$innerw['pi_price'].'</td>';
								
								if($_SESSION['STWL_LUM_TU_ID'] == '1'){echo'
								<td>'.round($innerw['pi_price']/$innerw['pi_cost'],4).'</td>
									';}
								echo '</tr>';
		$ttqty = $ttqty + $proformaqty;
						$placce++;
	
			
			
		#2nd loop end	
	}
		}
		} else {
			echo "<tr><td colspan='4'>No Standalone Proformas</td></tr>";
		}
		
	
	echo '
	</tbody>
	</table>
 ';
?></div>
    </div>
    <div class="row">
<tr>
	<td colspan="3"><br>Total In orders: <h3 style="color:green"><?php echo $ttqty ; ?></h3></td>
</tr>
</tbody>
</table>

</div>
    </div>





<?php

}








































?>