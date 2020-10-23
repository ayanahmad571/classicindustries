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
                                <h3 class="panel-title">Manage Clients</h3>
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
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th>Info</th>
                                                    <th>Phone</th>
                                            	    <th>Client Since</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
<?php

$boxsql = "SELECT * FROM `sw_clients`
left join sw_master_states_gst on cli_rel_state_id = state_id 
where cli_valid =1 order by cli_name asc";
$boxres = $conn->query($boxsql);

if ($boxres->num_rows > 0) {
    // output data of each row
	$cc =1;
    while($boxrw = $boxres->fetch_assoc()) {
		#firts loop begins
		
			$give = '<a data-toggle="modal" data-target="#'.md5(md5(sha1($boxrw['cli_id']))).'" class="btn btn-sm btn-warning m-t-20 ion-edit"></a></form>';
		echo '
		<tr>
<td>'.$cc.'</td>
<td>'.$boxrw['cli_code'].'</td>
<td>'.$boxrw['cli_name'].'</td>
<td>
	<strong>Address:</strong> '.$boxrw['cli_bill_addr'].'<br>
	<strong>State:</strong> '.$boxrw['state_name'].'<br>
	<strong>State Code:</strong> '.str_pad($boxrw['state_code'], 2, '0', STR_PAD_LEFT).'<br>
	<strong>GSTIN:</strong> '.$boxrw['cli_tax_code'].'<br>
</td>
<td>'.$boxrw['cli_contact_no'].'</td>
<td>'.date('j-M, Y',$boxrw['cli_dnt']).'</td>
<td class="no-sort">'.$give.'</td>
</tr>';
	$cc++;
	#first loop ends
	$stus = 'None';
    }
} else {
    echo  "0 results";
}
 ?>                                                  
                                            </tbody>
                                        </table>
                                        <!-- -->

                               
 
 
                                        
                                 
                                        <!-- -->
                                    </div>
                                    <hr>
                                    <div class="row">
                                    <form action="master_action.php" method="post">
                                    <h4>&nbsp; Add Client</h4>
                                     <div class="col-md-12">
	<div class="panel panel-color panel-inverse">
            <div class="panel-heading"> 
        </div>

		<div class="panel-body"> 
        <div class="col-sm-4">
<p>Name:<input required class="form-control "  name="add_client_name" type="text" placeholder="Alpha Beta" /></p>
        </div>

        <div class="col-sm-4">
<p>Code:<input required class="form-control "  name="add_client_code" type="text" placeholder="AB" /></p>
        </div>

        <div class="col-sm-4">
<p>Phone: <input required class="form-control "  name="add_client_phone" type="text" placeholder="contact Details" /></p> 
        </div>

<br>
<br>
<hr>
<div class="col-sm-12">
<p>Bill to </p>
        <div class="col-sm-4">
<p>GSTIN:<input required class="form-control "  name="add_client_tax_code" type="text" placeholder="GSTIN " /></p>
        </div>

        <div class="col-sm-4">
<p>State:
<select class="form-control" name="add_client_state" required>
			<?php
	$sql = "SELECT * FROM sw_master_states_gst order by state_name asc";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if(trim($row['state_id']) == '34'){
            echo '<option selected value="'.md5($row['state_id']).'">'.$row['state_name'].'</option>';
            }else{
            echo '<option value="'.md5($row['state_id']).'">'.$row['state_name'].'</option>';
            }
        }
    } else {
    }
            ?>
    </select>
</p>        </div>

        <div class="col-sm-4">
<p>Address: <input required name="add_client_bill_addr" class="form-control"  type="text"/></p> 
        </div>
</div>


<br>
<hr>
<br><br>
<br>




<p><input class="btn btn-success " name="add_client" type="submit" value="Add Client"/></p> 
		</div> 
	</div>
</div>

</form>


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
            
       
 <?php
	$msql = "SELECT * FROM `sw_clients` where cli_valid =1 ";
$mres = $conn->query($msql );

if ($mres->num_rows > 0) {
    // output data of each row

    while($mrw = $mres->fetch_assoc()) {
		#firts loop begins
		foreach($mrw as $me=>$m){
			$mrw[$me] = trim($m);
		}
		echo '
<div id="'.md5(md5(sha1($mrw['cli_id']))).'" class="modal fade" role="dialog">
  <div class="modal-full modal-dialog">

    <!-- Modal content-->
   <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editing '.$mrw['cli_name'].'</h4>
      </div>
      <div class="modal-body">
        <form action="master_action.php" method="post">
		
<div class="form-group">
	<label>Name : </label>
	<input name="edit_client_name" type="text" class="form-control" value="'.$mrw['cli_name'].'"/>
</div>

<div class="form-group">
	<label>Code : </label>
	<input name="edit_client_code" type="text" class="form-control" value="'.$mrw['cli_code'].'"/>
</div>

<div class="form-group">
	<label>State : </label>
';
?>
<select class="form-control" name="edit_client_state" required>
			<?php
	$sql = "SELECT * FROM sw_master_states_gst order by state_name asc";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if(trim($row['state_id']) == $mrw['cli_rel_state_id']){
            echo '<option selected value="'.md5($row['state_id']).'">'.$row['state_name'].'</option>';
            }else{
            echo '<option value="'.md5($row['state_id']).'">'.$row['state_name'].'</option>';
            }
        }
    } else {
    }
            ?>
    </select>
<?php
echo '
</div>


<div class="form-group">
	<label>GSTIN: </label>
	<input name="edit_client_txcd"  type="text" class="form-control" value="'.$mrw['cli_tax_code'].'"/>
</div>
		
<div class="form-group">
	<label>Contact Number: </label>
	<input name="edit_us_contact" type="text" class="form-control" value="'.$mrw['cli_contact_no'].'"/>
</div>
	
<div class="form-group">
	<label>Address: </label>
	<input name="edit_client_bill_addr"  type="text" class="form-control" value="'.$mrw['cli_bill_addr'].'"/>
</div>
			


<div class="row">
	<div class="col-xs-6">
	<input type="hidden" value="'.md5(md5(sha1(sha1(md5(md5($mrw['cli_id'].'kjwj 2fgtegrfr3gbter 24rfgr324frgtr3f 3gr32fgr32f4gr')))))).'" name="edit_client_hash" />
		<input style="float:right" type="submit" class="btn btn-success" name="edit_client" value="Save">
	</div>
	<div class="col-xs-6">
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
</div>
	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>


  </div>
</div>
		
	';
	
	#first loop ends
    }
} else {
    echo "0 results";
}
 ?>             
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
		        <script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
        <script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script>
$(document).ready(function(){
		  $(".wysihtml5").wysihtml5();
});
</script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable1').dataTable();
            } );
        </script>
      
           </body>

</html>
