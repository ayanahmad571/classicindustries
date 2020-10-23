
<?php 
include('include.php');
?>
<!DOCTYPE html>
<html lang="en">
    
<!-- the manform-wizard.htmlby ayan ahmad 07:30:41 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="img/favicon_1.ico">

        <title>Invoice Creation</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">

        <!--Animation css-->
        <link href="css/animate.css" rel="stylesheet">

        <!--Icon-fonts css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

        <!--Form Wizard-->
        <link rel="stylesheet" type="text/css" href="assets/form-wizard/jquery.steps.css" />



        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/helper.css" rel="stylesheet">
        

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->

   

    </head>


    <body>

            <div class="wraper container-fluid">
                <div class="page-title"> 
                    <h3 class="title">Form Wizard</h3> 
                </div>

                <!-- Basic Form Wizard -->
                <div class="row">
                    <div class="col-md-12">

                        <div class="panel panel-default">
                            <div class="panel-heading"> 
                                <h3 class="panel-title">Make New Bill</h3> 
                            </div> 
                            <div class="panel-body"> 
                                <form id="basic-form" action="#">
                                    <div>
                                        <h3>Client</h3>
                                        <section>
<select id="select22" class="form-control input-lg" name="edit_client_state" required>
<option selected>Select Client</option>
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

                                        
                                        </section>
                                        <h3>Tax</h3>
                                        <section>
                                            <div class="form-group clearfix" id="togetdatafrom">
								<p>Select Client to Enable Tax</p>
                                            </div>
                                        </section>
                                        <h3>Items</h3>
                                        <section>
                                            <div class="form-group clearfix">
                                                <div class="col-lg-12">
                                                    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Product Desc</th>
                <th>Cost Price</th>
                <th>Sale Price</th>
                <th>Qty</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
<tr id="proformaadd1" class="PerfclonedInput">
            <td><select class="form-control add_proforma_product" id="add_proforma_product" name="add_proforma_product">
<?php 
$sql = "SELECT * FROM sw_products_list p
left join sw_prod_types t on p.pr_rel_prty_id = t.prty_id
where p.pr_valid =1 and t.prty_valid=1 and p.pr_id 
order by pr_code,pr_name asc";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// output data of each row
	echo '<option data-id="0" value="0">Select Product </option>';
	while($row = $result->fetch_assoc()) {
		   echo '<option  data-id="'.$row['pr_id'].'" value="'.md5($row['pr_id']).'">'.$row['pr_code'].'-'.$row['pr_name'].'</option>';
	}
} else {
	echo "0 results";
}
?>
            </select></td>
            
            <td><textarea name="add_proforma_product_desc" class="form-control add_proforma_product_desc" id="add_proforma_product_desc" required>-</textarea></td>
            <td><input name="add_proforma_product_cost"  type="number" step="0.01" class="form-control add_proforma_product_cost" id="add_proforma_product_cost" required value="0" placeholder="Cost Price"  /></td>
            <td><input name="add_proforma_product_price" type="text" class="form-control add_proforma_product_price" id="add_proforma_product_price" required value="0" placeholder="Sale Price"  /></td>
            <td><input name="add_proforma_product_qty" type="text" class="form-control add_proforma_product_qty" id="add_proforma_product_qty" required value="0" placeholder="Qty"  /></td>
            <td><div class="add_proforma_product_script" id="add_proforma_product_script"></div></td>

	    </tr>
        
        </tbody>
</table>
<hr>
<div class="row">
    <div align="left" class=" col-xs-12 ">
        <div id="addDelButtons6">
          <input style="border-radius:10px" type="button" id="btnAdd6" value="Add More" class="btn btn-info" >
          <input style="border-radius:10px" type="button" id="btnDel6" value="Remove" class="btn btn-danger">
        </div> 
    </div>
        <input required  value="1" id="per_nos" class="form-control" type="hidden" name="per_nos"  />
</div> 



                                                </div>
                                            </div>
                                        </section>
                                        <h3>Over View</h3>
                                        <section>
                                            <div class="form-group clearfix">
                                                <div class="col-lg-12">
                                                    <label class="cr-styled">
                                                        <input type="checkbox">
                                                        <i class="fa"></i> 
                                                        I agree with the Terms and Conditions.
                                                    </label>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </form> 
                            </div>  <!-- End panel-body -->
                        </div> <!-- End panel -->

                    </div> <!-- end col -->

                </div> <!-- End row -->
            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->




        </section>
        <!-- Main Content Ends -->
        


        <!-- js placed at the end of the document so the pages load faster -->
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/pace.min.js"></script>
        <script src="js/wow.min.js"></script>
        <script src="js/jquery.nicescroll.js" type="text/javascript"></script>


        <!--Form Validation-->
        <script src="assets/form-wizard/bootstrap-validator.min.js" type="text/javascript"></script>

        <!--Form Wizard-->
        <script src="assets/form-wizard/jquery.steps.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="assets/jquery.validate/jquery.validate.min.js"></script>

        <!--wizard initialization-->
        <script src="assets/form-wizard/wizard-init.js" type="text/javascript"></script>


        <script src="js/jquery.app.js"></script>
<script type="text/javascript"  src="assets/clone/clone-form-td.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#add_proforma_product').change(function(){
		var tx = $(this).children('option:selected').data('id');
				$.post("master_action.php", {prid: tx}, function(result){
					result = $.parseJSON( result );
					$("#add_proforma_product_desc").val(result.desc);
					$("#add_proforma_product_cost").val(result.cost);
				});
	} );
} );
		
</script>
<script>
$('#select22').change(function() {
     
	   $.post("master_action.php",
    {
        cli_id: $(this).val()
    },
    function(data, status){
		$("#togetdatafrom").html(data);
		
    });
	 
});
</script>
    </body>

<!-- the manform-wizard.htmlby ayan ahmad 07:30:43 GMT -->
</html>
