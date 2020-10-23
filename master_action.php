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
		if((strpos($_SERVER['HTTP_REFERER'],'http://stilewell.ddns.net') == '0') or (strpos($_SERVER['HTTP_HOST'],'http://localhost/') == '0') or (strpos($_SERVER['HTTP_REFERER'],'http://192.168.1.') == '0'))
	{
	  //only process operation here
	}else{
		die('Only tld process are allowed');
	}
	}

}else{
	
	die(header('Location: master-action.php'));
	
}
$_COMPANY = make_company_ar($conn);
/*
var_dump($_POST);
var_dump($_FILES);

foreach($_POST as $pkey=>$pval){
	echo '
	#---------------------------------------<br>
		if(isset($_POST[\''.$pkey.'\'])){<br>
		&nbsp;&nbsp;if(!is_string($_POST[\''.$pkey.'\'])){<br>
		&nbsp;&nbsp;die(\'Invalid Characters used in '.$pkey.'\');
		&nbsp;&nbsp;}<br>
		&nbsp;&nbsp;else{}<br>
		}else{<br>
		&nbsp;&nbsp;die(\'Enter '.$pkey.'\');<br>
		}<br>
	';
}
*/

if(isset($_POST['from_email']) and isset($_POST['from_name']) and isset($_POST['subj_ml']) and isset($_POST['message_ml'])){
	
	$email = $_POST['from_email'];
	$name = $_POST['from_name'];
	$subject = $_POST['subj_ml'];
	$message = $_POST['message_ml'];
	$hash = md5(sha1($_SERVER['REMOTE_ADDR']));
	$ip = $_SERVER['REMOTE_ADDR'];
	$timest = time();	
	
	
$sql = "INSERT INTO `mun_mails`(`ml_from_email`, `ml_from_name`, `ml_subject`, `ml_body`, `ml_hash`, `ml_from_ip`, `mun_time`) VALUES (
'".$email."',
'".$name."',
'".$subject."',
'".$message."',
'".$hash."',
'".$ip."',
'".$timest."'
)";

if ($conn->query($sql) === TRUE) {
    header('Location: home.php?mailsent');
} else {
  die('#ERRMASTACT1');
}

	
}
#
if(isset($_POST['ok'])){
if(!isset($_POST['usr_nm']) or !isset($_POST['usr_pass']) or !isset($_POST['usr_eml'])){
	die('Please Enter all the data');
}


$ip  = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
if(($ip=='::1') or (strpos($ip,'192.168.1.40') === true)){
	
}


$email = $_POST['usr_eml'];
$name =  $_POST['usr_nm'];
$pw = md5(md5(sha1($_POST['usr_pass'])));

########################################################################################################3
$ui = explode(' ',$name);
$fn = str_split($ui[0]);
$ln = str_split(end($ui));
$fncount = count($fn)-1;
$lncount = count($ln)-1;
$ujl=array();
for($sa=0;$sa<9;$sa++){
	$fr = rand(1,2);
	if($fr==1){
		$sr = rand(0,$fncount);
		$ujl[]=$fn[$sr];
	}else if($fr==2){
		$tr = rand(0,$lncount);
		$ujl[]=$ln[$tr];
	}else{
		die('ERROR#MA3');
	}
	
}
#######################################################################################################3


$usr = strtolower($ujl[0].$ujl[1].$ujl[3].$ujl[4].$ujl[5].$ujl[6].$ujl[7].$ujl[8].rand(1,10));

$iv = 1098541894 .rand(100000,999999);
$regtm = time();
$regip = $_SERVER['REMOTE_ADDR'];
$hash = gen_hash($pw,$email);
#pass and email and secret md5(sha1())


$sqla = "
INSERT INTO `sw_logins`(`lum_rel_tu_id`,`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`) VALUES (
'2',
'".$email."',
'".$usr."',
'".$pw."',
'".$hash."'
)
";


if ($conn->query($sqla) === TRUE) {
	
	$ltid = $conn->insert_id;
	$sqlb = "INSERT INTO `sb_users`(`usr_rel_sch_id`,`usr_name`, `usr_rel_lum_id`,  `usr_iv`, `usr_reg_dnt`, `usr_reg_ip`) VALUES (
'0',
'".$name."',
'".$ltid."',
'".$iv."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";

	if ($conn->query($sqlb) === TRUE) {
	
    header('Location: login.php');
} else {
    echo $conn->error."Error##ma55";
}
	
    } else {
    die($conn->error."Error###maa4");
}


}
#
if(isset($_POST['lo_eml']) and isset($_POST['lo_pass'])){
	
	$eml=$_POST['lo_eml'];
	$pas=md5(md5(sha1($_POST['lo_pass'])));
	$hash = gen_hash($pas,$eml);
	
	if(ctype_alnum($eml) or is_numeric($eml) or is_email($eml)){
	}else{
		die("Invalid Email");
	}
	 
	
	if(ctype_alnum($hash.$pas)){
	}else{
		die("Credentials Not valid");
	}
	
	
$selectusersfromdbsql = "SELECT * FROM sw_logins where 
lum_email= '".$eml."' and
lum_password = '".$pas."' and
lum_hash_mix= '".$hash."' and
lum_valid = 1

";
$usrres = $conn->query($selectusersfromdbsql);
if ($usrres->num_rows == 1) {
    // output data of each row
    while($usrrw = $usrres->fetch_assoc()) {
        session_regenerate_id();

			$selectusersdatafromdbsql = "
SELECT * FROM sw_users where 
usr_rel_lum_id = '".$usrrw['lum_id']."' and usr_valid =1";
echo $selectusersfromdbsql	;
$dataobbres = $conn->query($selectusersdatafromdbsql);

if ($dataobbres->num_rows == 1) {
    // output data of each row
    while($dataobbrw = $dataobbres->fetch_assoc()) {
		###
        session_regenerate_id();
		
		$_SESSION['STWL_SESS_ID'] = md5(sha1(md5(md5(sha1('SecrejtBall')).uniqid().time()).time()).uniqid());
		$_SESSION['STWL_LUM_DB_ID'] = $usrrw['lum_id'];
		$_SESSION['STWL_LUM_TU_ID'] = $usrrw['lum_rel_tu_id'];
		session_write_close();
			header('Location: home.php');
		
		###
	}
}else{
	die('User Mapping Not found, Please Ask Administrator for assistance');
}
		
		
		###big en
    }
} else {
	header('Location: login.php?notss');
    die();
}
	
		
}
#

	
	/**//**//**//**/ 
	#$serverdir = 'http://localhost/muncircuit/';
	$serverdir = 'http://stilewell.ddns.net/';
if(isset($_POST['ch_pw'])){
			 if(isset($_SESSION['STWL_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['STWL_LUM_DB_ID']." and lum_valid = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}


	
	if(!isset($_POST['pw'])){
		die('Enter all fields');
	}

	if(!isset($_POST['npw'])){
		die('Enter all fields');
	}
	
	if($_POST['pw'] == $_POST['npw']){
		$lum = getdatafromsql($conn,'select * from sw_logins where lum_id = '.$_SESSION['STWL_LUM_DB_ID']);
		if(is_string($lum)){
			die('#ERRRMA39UET05G8T');
		}
		$pw = md5(md5(sha1($_POST['pw'])));
		$hash = gen_hash($pw,trim($lum['lum_email']));
		
		
		if($pw== $lum['lum_password']){
			die('The new password cant be same as the old one!');
		}else{
			$upsql = "UPDATE `sw_logins` SET `lum_password`='".trim($pw)."',`lum_hash_mix`='".trim($hash)."' WHERE lum_id = ".$_SESSION['STWL_LUM_DB_ID'];
			if($conn->query($upsql)){
						##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['STWL_LUM_DB_ID'],'sw_logins','update', $upsql ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%wsrhizuTGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




				session_destroy();
				if(count($_SESSION)>0){
					header('Location: login.php');
				}else{
					die('ERRMASESSND');
				}
			}else{
				die("#ERRRKJIOJTOJHB");
			}
			
		}
		
		
		
	}else{
		die('Passwords Dont Match');
	}


}
if(isset($_POST['re_pw'])){
	if(isset($_POST['rec_eml'])){
		if(is_email($_POST['rec_eml'])){
			$validemail = getdatafromsql($conn,"select * from sw_logins where lum_email = '".trim($_POST['rec_eml'])."'");
			
			if(is_array($validemail)){
				$hasho = gen_hash_pw('oi4jg9v 5g858r hgh587rhg85rhgvu85rht9gi vj98rjg984he98t hj4 9v8r hb9uirhbu');
			  $hasht = gen_hash_pw_2($validemail['lum_id'],'984j5t8gj48 g8 5hg085hr988rt09g409rhj 9borjh09oj58r hj094jh 98obh498toeihg');
			  
			  
			  
				$ins_pwrc = "INSERT INTO `sw_recover`(`rv_rel_lum_id`, `rv_hash`, `rv_valid_till`, `rv_hash_2`) VALUES (
'".$validemail['lum_id']."',
'".$hasho."',
'".(time()+10810)."',				
'".$hasht."'
)";
if($conn->query($ins_pwrc)){
			##### Insert Logs ##################################################################VV3###
		if(preplogs($validemail,"0",'sw_recover','insert', $ins_pwrc,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGweafTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	###eml
	$to = $validemail['lum_email'];
$subject = "Stilewell Password Recovery ";

$message = "
<html>
<head>
<title>Click on the Link below</title>
</head>
<body>
<h2>You have requested an option to recover your account's password</h2>
<p>You can either click on the link below or copy it and paste it in your browser to reset your accounts password</p>
<p>The link is only valid for 5hrs and is one time useable</p>
<a href='http://schoolvault.ddns.net/recover.php?id=".$hasho.$hasht."'>".$serverdir."recover.php?id=".$hasho.$hasht."</a>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <anonymous.code.anonymous@gmail.com>' . "\r\n";

if(mail($to,$subject,$message,$headers)){
header('Location: recover.php?newmade');
}else{
	die('#ERRMAjuigtuj');
}
	###eml
}else{
	die('#ERRMA9309399JG');
}
				
				
				
				
			}else{
				echo 'Dont know';
			}
			
		}else{
			die('Enter a Valid Email');
		}
	}else{
		die('Enter All fields');
	}
}
#
#
if(isset($_POST['rec_action_pw'])){
	if(isset($_POST['recover_npw']) and isset($_POST['rec_pw_u'])){
		if(ctype_alnum(trim(strtolower($_POST['rec_pw_u'])))){
			$usrh = $_POST['rec_pw_u'];
			$newp = $_POST['recover_npw'];
			$user_det = getdatafromsql($conn,"select * from sw_logins where md5(sha1(concat(lum_id,'3oijg9i3u8uh'))) = '".$usrh."' and lum_valid = 1");
			
			if(is_array($user_det)){
				$new_pw=md5(md5(sha1($newp)));
				$new_hash = gen_hash($new_pw,trim($user_det['lum_email']));

	


if($conn->query("update sw_logins set lum_password = '".$new_pw."', lum_hash_mix ='".$new_hash."' where lum_id = ".$user_det['lum_id']."")){




	session_destroy();
	header('Location: login.php');
	
}else{
	die("ERRMAUSRPWCHOI03J4");
}
	
			}else{
				die('Invalid User');
			}
		}else{
			die("Invalid hash");
		}
	}else{
		die("Enter all Values");
	}
}

if(isset($_POST['mod_add'])){
	if(isset($_SESSION['STWL_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['STWL_LUM_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	############################33333333
	if(isset($_POST['mod_a_long_name'])){
		$nm = $_POST['mod_a_long_name'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_href'])){
		$href = $_POST['mod_a_href'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_icon'])){
		$ico = $_POST['mod_a_icon'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_for'])){
		$mofor = $_POST['mod_a_for'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['mod_a_sub_menu']) and is_numeric($_POST['mod_a_sub_menu'])){
		if(in_range($_POST['mod_a_sub_menu'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 1');
		}
		$subm = $_POST['mod_a_sub_menu'];
	}else{
		die('Enter all Fields Correctly');
	}
	if(isset($_POST['mod_a_valid']) and is_numeric($_POST['mod_a_valid'])){
		if(in_range($_POST['mod_a_valid'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 6');
		}
		$vali_s = $_POST['mod_a_valid'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333

	if($conn->query("INSERT INTO `sw_modules`(`mo_name`, `mo_href`, `mo_for`, `mo_icon`,  `mo_sub_mod`, `mo_valid`) VALUES (
	'".$nm."',
	'".$href."',
	'".$mofor."',
	'".$ico."',
	".$subm.",
	".$vali_s."
	)")){
				##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['STWL_LUM_DB_ID'],'sw_modules','insert', "INSERT INTO `sw_modules`(`mo_name`, `mo_href`, `mo_for`, `mo_icon`,  `mo_sub_mod`, `mo_valid`) VALUES (
	'".$nm."',
	'".$href."',
	'".$mofor."',
	'".$ico."',
	".$subm.",
	".$vali_s."
	)",$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




		header('Location: admin_mods.php');
	}else{
		die('ERRMAGRTBRHR%Y$T%HTIEB(FD');
	}
}
if(isset($_POST['add_user'])){
	if(isset($_SESSION['STWL_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['STWL_LUM_DB_ID']." and lum_valid = 1 and lum_ad = 1 ");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}

	############################33333333
	if(isset($_POST['usr_f_name']) and trim($_POST['usr_f_name']) !== ''){
		$fnm = $_POST['usr_f_name'];
	}else{
		die('Enter usr_f_name Correctly1');
	}
	############################33333333
	if(isset($_POST['usr_l_name']) and trim($_POST['usr_l_name']) !== ''){
		$lnm = $_POST['usr_l_name'];
	}else{
		die('Enter usr_l_name Correctly1');
	}
	if(isset($_POST['usr_email'])){
		if(is_email($_POST['usr_email'])){
		$eml = $_POST['usr_email'];
		}else{
			die('Email not Valid');
		}
	}else{
		die('Enter Email Correctly');
	}
	############################33333333
	############################33333333
	if(isset($_POST['usr_type'])){
		if(is_numeric($_POST['usr_type']) and (($_POST['usr_type'] == 1) or ($_POST['usr_type'] == 2) or ($_POST['usr_type'] == 3))){
		$usr_type = $_POST['usr_type'];
		}else{
			die('User Type not Valid');
		}
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['usr_contact_no'])){
		if(is_numeric($_POST['usr_contact_no'])){
		$number = $_POST['usr_contact_no'];
		}else{
			die('Contact not Valid');
		}
	}else{
		die('Enter Contact Correctly');
	}
	############################33333333
	if(isset($_POST['usr_pw'])){
		$pw = md5(md5(sha1($_POST['usr_pw'])));
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['usr_dob']) and (strtotime($_POST['usr_dob']) == true)){
			$dob = $_POST['usr_dob'];
	}else{
		die('Enter DOB Correctly');
	}
	############################33333333
	if(isset($_POST['usr_validtill']) and is_numeric($_POST['usr_validtill'])){
		$vldtll = $_POST['usr_validtill'];
		if(trim($vldtll) == 0){
			$valid_till = 0;
			$defpw = '-';
		}else{
			$valid_till = (time()+ ($vldtll*60));
			$defpw=base64_encode($_POST['usr_pw']);
		}
	}else{
		die('Enter all Fields Correctly 1');
	}
	############################33333333


$usr = strtolower(rand(1,10).$fnm);
$hash = gen_hash($pw,$eml);

$checkusrnm = getdatafromsql($conn,"select * from sw_logins where lum_username = '".trim($usr)."'");
if(is_array($checkusrnm)){
	die("Please refresh the Page and resend the post values .");
}

#########################
	if($conn->query("INSERT INTO `sw_logins`(`lum_rel_tu_id`,`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`, `lum_ad`, `lum_ad_level`,`lum_pass_def`) VALUES 
	('".trim($usr_type)."','".trim($eml)."', '".trim($usr)."', '".trim($pw)."', '".trim($hash)."', '0', '0'
	,'".$_POST['usr_pw']."')")){





	##
		$ltid = $conn->insert_id;
		
						##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['STWL_LUM_DB_ID'],'sw_logins','insert', "INSERT INTO `sw_logins`(`lum_rel_tu_id`,`lum_email`, `lum_username`, `lum_password`, `lum_hash_mix`, `lum_ad`, `lum_ad_level`,`lum_pass_def`) VALUES 
	('".trim($usr_type)."','".trim($eml)."', '".trim($usr)."', '".trim($pw)."', '".trim($hash)."', '0', '0'
	,'".$_POST['usr_pw']."')" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###



	$sqlb = "INSERT INTO `sw_users`(`usr_fname`,`usr_lname`, `usr_dob`,`usr_contact_no`,`usr_rel_lum_id` , `usr_reg_dnt`, `usr_reg_ip`,`usr_validtill`) VALUES (
'".$fnm."',
'".$lnm."',
'".strtotime($dob)."',
'".$number."',
'".$ltid."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$valid_till."')";

	if ($conn->query($sqlb) === TRUE) {
				##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['STWL_LUM_DB_ID'],'sw_users','insert', $sqlb ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	
    header('Location: admin_users.php');
} else {
    die($conn->error."Error##rujioma");
}
	

	##
	
	}else{
		die($conn->error.'ERRMAIGOTURG');
	}
}
#_______________________________START MODULES_______________________
if(isset($_POST['hash_ac']) and isset($_POST['tab_act'])){
	if(ctype_alnum(trim($_POST['hash_ac']))){
		$checkit = getdatafromsql($conn,"select * from sw_modules where md5(md5(sha1(sha1(md5(md5(concat(mo_id,'njhifverkof2njbivjwj bfurhib2jw'))))))) = '".$_POST['hash_ac']."' and mo_valid =0");
		
		if(is_array($checkit)){
			if($conn->query("update sw_modules set mo_valid =1 where mo_id= ".$checkit['mo_id']."")){
				##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['STWL_LUM_DB_ID'],'sw_modules','update', "update sw_modules set mo_valid =1 where mo_id= ".$checkit['mo_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###

								header('Location: admin_mods.php');
			}else{
				die('ERRRMA!JOIrfedNJFO');
			}
		}else{
			die("No Modules\'s Found");
		}
	}else{
		die('Invalid Entries');
	}
}
if(isset($_POST['hash_inc']) and isset($_POST['tab_inact'])){
	if(ctype_alnum(trim($_POST['hash_inc']))){
		$checkit = getdatafromsql($conn,"select * from sw_modules where md5(md5(sha1(sha1(md5(md5(concat(mo_id,'hbujeio03ir94urghnjefr 309i4wef'))))))) = '".$_POST['hash_inc']."' and mo_valid =1");
		
		if(is_array($checkit)){
			if($conn->query("update sw_modules set mo_valid =0 where mo_id= ".$checkit['mo_id']."")){				
##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['STWL_LUM_DB_ID'],'sw_modules','update', "update sw_modules set mo_valid =0 where mo_id= ".$checkit['mo_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###


								header('Location: admin_mods.php');
			}else{
				die('ERRRMAjn4rifJOINJFWFEAO');
			}
		}else{
			die("No Modules\'s Found");
		}
	}else{
		die('Invalid Entries');
	}
}
#_______________________________START USER_______________________
if(isset($_POST['yh_com']) and isset($_POST['usr_make_ac'])){
	if(ctype_alnum(trim($_POST['yh_com']))){
		$checkit = getdatafromsql($conn,"select * from sw_logins where 
		md5(md5(sha1(sha1(md5(md5(concat(lum_id,'hir39efnewsfejirjeofkvjrjdnjjenfkvkijonreij3nj'))))))) = '".$_POST['yh_com']."' and lum_valid = 0");
		
		if(is_array($checkit)){
			if($checkit['lum_email'] == 'ayanzcap@hotmail.com'){
				die('Super user can\'t be modified');
			}
			if($conn->query("update sw_logins set lum_valid =1 where lum_id= ".$checkit['lum_id']."")){
								
##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['STWL_LUM_DB_ID'],'sw_logins','update', "update sw_logins set lum_valid =1 where lum_id= ".$checkit['lum_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###

								header('Location: admin_users.php');
			}else{
				die('ERRMA3jonkj34oirvfingj');
			}
		}else{
			die("No User Found");
		}
	}else{
		die('Invalid Entries');
	}
}
#
if(isset($_POST['yh_com']) and isset($_POST['usr_make_inac'])){
	if(ctype_alnum(trim($_POST['yh_com']))){
		$checkit = getdatafromsql($conn,"select * from sw_logins where 
		md5(md5(sha1(sha1(md5(md5(concat(lum_id,'hir39efnewsfejirjrjdnjjenfkv ijfkorkvnkorvfk'))))))) = '".$_POST['yh_com']."' and lum_valid = 1");
		
		if(is_array($checkit)){
			if($checkit['lum_email'] == 'ayanzcap@hotmail.com'){
				die('Super user can\'t be deleted');
			}
			if($conn->query("update sw_logins set lum_valid =0 where lum_id= ".$checkit['lum_id']."")){
				
##### Insert Logs ##################################################################VV3###
		if(preplogs($checkit,$_SESSION['STWL_LUM_DB_ID'],'sw_logins','update', "update sw_logins set lum_valid =0 where lum_id= ".$checkit['lum_id']."" ,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




				
								header('Location: admin_users.php');
			}else{
				die('ERRMA3joingj');
			}
		}else{
			die("No User Found");
		}
	}else{
		die('Invalid Entries');
	}
}
#
#_______________________________END USER_______________________
if(isset($_POST['edit_mod'])){
	if(isset($_SESSION['STWL_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['STWL_LUM_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	if(isset($_POST['hash_emmp__1i'])){
		if(ctype_alnum(trim($_POST['hash_emmp__1i']))){
			$editmun = getdatafromsql($conn,"select * from sw_modules where md5(md5(sha1(sha1(md5(md5(concat(mo_id,'lkoegnuifvh bnn njenjn'))))))) = '".$_POST['hash_emmp__1i']."'");
			#f0b9915082de5819bf562d53aa59b2d2
			
			if(is_string($editmun)){
				die('Hash Not Found');
			}
		}else{
			die('Invalid hash');
		}
	}else{
		die('Hash Not Valid');
	}
	############################33333333
	if(isset($_POST['edit_mod_lngnme'])){
		$nm = $_POST['edit_mod_lngnme'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_mod_shrtnme'])){
		$href = $_POST['edit_mod_shrtnme'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_mod_icon'])){
		$ico = $_POST['edit_mod_icon'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_mod_for'])){
		$mofor = $_POST['edit_mod_for'];
	}else{
		die('Enter all Fields Correctly');
	}
	############################33333333
	if(isset($_POST['edit_mod_sub']) and is_numeric($_POST['edit_mod_sub'])){
		if(in_range($_POST['edit_mod_sub'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 1');
		}
		$subm = $_POST['edit_mod_sub'];
	}else{
		die('Enter all Fields Correctly');
	}
	
	if(1==0){
		#You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes #
		die("You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes ");
	}else{
		if($conn->query("UPDATE `sw_modules` SET 
`mo_name`= '".$nm."',
`mo_href`='".$href."',
`mo_for` = '".$mofor."',
`mo_icon`='".$ico."',
`mo_sub_mod`='".$subm."'
where mo_id = ".trim($editmun['mo_id'])."")){
	
	
	##### Insert Logs ##################################################################VV3###
		if(preplogs($editmun,$_SESSION['STWL_LUM_DB_ID'],'sw_modules','update',"UPDATE `sw_modules` SET 
`mo_name`= '".$nm."',
`mo_href`='".$href."',
`mo_for` = '".$mofor."',
`mo_icon`='".$ico."',
`mo_sub_mod`='".$subm."'
where mo_id = ".trim($editmun['mo_id'])."",$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###




	header('Location: admin_mods.php');
		}else{
			die('ERRMAerskirore9njr3ei9jinj');
		}
	}

}
if(isset($_POST['edit_user'])){
	if(isset($_SESSION['STWL_LUM_DB_ID'])){
		$getdatus = getdatafromsql($conn,"select * from sw_logins where lum_id = ".$_SESSION['STWL_LUM_DB_ID']." and lum_valid = 1 and lum_ad = 1");
		if(is_string($getdatus)){
			die('Access Denied');
		}
	}else{
		die('Login to do this action');
	}
	if(isset($_POST['hash_chkr'])){
		if(ctype_alnum(trim($_POST['hash_chkr']))){
			$editmun = getdatafromsql($conn,"select * from sw_logins where md5(md5(sha1(sha1(md5(md5(concat(lum_id,'f2frbgbe 2fgtegrfr3gbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['hash_chkr']."'");
			#f0b9915082de5819bf562d53aa59b2d2
			
			if(is_string($editmun)){
				die('Hash Not Found');
			}
		}else{
			die('Invalid hash');
		}
	}else{
		die('Hash Not Valid');
	}
	
	if(isset($_POST['edit_f_nme'])){
		$fnm = trim($_POST['edit_f_nme']);
	}else{
		die('Enter  edit_f_nme');
	}
	if(isset($_POST['edit_l_nme'])){
		$lnm = trim($_POST['edit_l_nme']);
	}else{
		die('Enter  edit_l_nme');
	}
	if(isset($_POST['edit_us_contact']) and is_numeric($_POST['edit_us_contact'])  and (trim($_POST['edit_us_contact']) !=='')){
		$number = trim($_POST['edit_us_contact']);
	}else{
		die('Enter  edit_us_contact');
	}
	if(isset($_POST['edit_us_pw'])){
		$pt = trim($_POST['edit_us_pw']);
		if(trim($pt) == '-'){
			$pw = $editmun['lum_password'];
			$hash = $editmun['lum_hash_mix'];
		}else{
			$pw = md5(md5(sha1(trim($_POST['edit_us_pw']))));
			$hash = gen_hash($pw,trim($editmun['lum_email']));
		}
	}else{
		die('Enter  edit_us_pw');
	}
	
	if(isset($_POST['edit_us_adm']) and is_numeric($_POST['edit_us_adm'])){
		if(in_range($_POST['edit_us_adm'],0,1,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 1');
		}
		$admer = $_POST['edit_us_adm'];
	}else{
		die('Enter  edit_us_adm');
	}
	
	if(isset($_POST['edit_us_amdlvl']) and is_numeric($_POST['edit_us_amdlvl'])){
		if(in_range($_POST['edit_us_amdlvl'],0,10,true)){
		}else{
			die('Values other than 1 or 0 are not allowed 1');
		}
		$admlvl = $_POST['edit_us_amdlvl'];
	}else{
		die('Enter  edit_us_amdlvl');
	}
	

	
	if(isset($_POST['edit_us_prfpic'])){
		$nprofpic = trim($_POST['edit_us_prfpic']);
	}else{
		die('Enter  edit_us_prfpic');
	}
	
	
	
	if(isset($_POST['edit_us_till'])){
		$startday =trim($_POST['edit_us_till']);
		if(($startday == '0') or ($startday == 0)){
			$usrtill = 0;
		}else{
			$usrtill = time() + (60*$_POST['edit_us_till']);
		}
	}else{
		die('Enter edit_us_till ');
	}
		
	if(1==0){
		#You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes #
		die("You have not been authorised by MUNCIURCUIT but by trustee so the user has to grant your changes ");
	}else{
		$querytobeinserted = "
UPDATE 
	`sw_logins` a,
	`sw_users` b 
SET 
	a.lum_password='".trim($pw)."',
	a.lum_hash_mix='".$hash."',
	a.lum_ad='".$admer."',
	a.lum_ad_level='".$admlvl."',
	b.usr_fname='".$fnm."',
	b.usr_lname='".$lnm."',
	b.usr_contact_no='".$number."',
	b.usr_prof_pic='".$nprofpic."',
	b.usr_back_pic = 'img/circuit_def.jpg',
	b.usr_validtill='".trim($usrtill)."'
WHERE
	a.lum_id = b.usr_rel_lum_id and 
	a.lum_id = ".trim($editmun['lum_id'])."";
		if($conn->query($querytobeinserted)){
		
##### Insert Logs ##################################################################VV3###
		if(preplogs($getdatus,$_SESSION['STWL_LUM_DB_ID'],'sw_logins','update',$querytobeinserted,$conn,$_SESSION['SESS_USR_LOG_MS_VIEW_MD5_ID'])){
		}else{
			die('ERRINCMA%TGTBTR$WESDF');
		}
##### Insert Logs ##################################################################VV3###

	header('Location: admin_users.php');
		}else{
			die('EmrfuRRMAers');
		}
	}

}
##--------------------------------------------------------------------------------------///------------------------------
/*-------------------------------------------------------------------*/
if(isset($_POST['add_snippet_product'])){
#---------------------------------------
#---------------------------------------
if(isset($_POST['add_snippet_product_name'])){
  if(!is_string($_POST['add_snippet_product_name'])){
  die('Invalid Characters used in add_snippet_product_name');   }
  else{}
}else{
  die('Enter add_snippet_product_name');
}
#---------------------------------------
if(isset($_POST['add_snippet_product_code'])){
  if(!is_string($_POST['add_snippet_product_code'])){
  die('Invalid Characters used in add_snippet_product_code');   }
  else{}
}else{
  die('Enter add_snippet_product_code');
}
#---------------------------------------
if(isset($_POST['add_snippet_product_type'])){
  if(!is_string($_POST['add_snippet_product_type'])){
  die('Invalid Characters used in add_snippet_product_type');   }
  else{}
}else{
  die('Enter add_snippet_product_type');
}
#---------------------------------------
if(isset($_POST['add_snippet_product_supplier'])){
  if(!is_string($_POST['add_snippet_product_supplier'])){
  die('Invalid Characters used in add_snippet_product_supplier');   }
  else{}
}else{
  die('Enter add_snippet_product_supplier');
}
#---------------------------------------
if(isset($_POST['add_snippet_product_qty'])){
  if(!is_numeric($_POST['add_snippet_product_qty'])){
  die('Invalid Characters used in add_snippet_product_qty');   }
  else{}
}else{
  die('Enter add_snippet_product_qty');
}
#---------------------------------------
if(isset($_POST['add_snippet_product_ref_qty'])){
  if(!is_string($_POST['add_snippet_product_ref_qty'])){
  die('Invalid Characters used in add_snippet_product_ref_qty');   }
  else{}
}else{
  die('Enter add_snippet_product_ref_qty');
}
#---------------------------------------
if(isset($_POST['add_snippet_product_cost'])){
  if(!is_string($_POST['add_snippet_product_cost'])){
  die('Invalid Characters used in add_snippet_product_cost');   }
  else{}
}else{
  die('Enter add_snippet_product_cost');
}
#---------------------------------------
if(isset($_POST['add_snippet_product_desc'])){
  if(!is_string($_POST['add_snippet_product_desc'])){
  die('Invalid Characters used in add_snippet_product_desc');   }
  else{}
}else{
  die('Enter add_snippet_product_desc');
}
#---------------------------------------
if(isset($_POST['add_snippet_href'])){
  if(!is_string($_POST['add_snippet_href'])){
  die('Invalid Characters used in add_snippet_href');   }
  else{}
}else{
  die('Enter add_snippet_href');
}
#---------------------------------------

$getsupplierdetails = getdatafromsql($conn,"select * from sw_suppliers where md5(sha1(md5(concat('iuergeirjgvjioe',sup_id)))) = '".$_POST['add_snippet_product_supplier']."'");
if(!is_array($getsupplierdetails)){
	die('Supplier Not Found');
}

$getptypedetails = getdatafromsql($conn,"select * from sw_prod_types where md5(sha1(md5(concat('iuergejgvjioe',prty_id)))) = '".$_POST['add_snippet_product_type']."'");
if(!is_array($getptypedetails)){
	die('Product type Not Found');
}
$target_dir = "pr_imgs/";
if(isset($_FILES['add_snippet_product_img']) and ($_FILES['add_snippet_product_img']['size']==0)){
$target_file = $target_dir .'default.png';
$target_file_2 = $target_dir .'default.png';
$target_file_3 = $target_dir .'default.png';
}else if(isset($_FILES['add_snippet_product_img']) and ($_FILES['add_snippet_product_img']['size'] >0)){

					
					
$ext =  extension(basename($_FILES["add_snippet_product_img"]["name"]));
$fold_name =uniqid().'-'.$_POST['add_snippet_product_code'].$_POST['add_snippet_product_name'].$getptypedetails['prty_id'].'-'.$_POST['add_snippet_qty'].'/';
if(mkdir('pr_imgs/'.$fold_name)){
}

$target_file = $target_dir .$fold_name. $_POST['add_snippet_product_code'].''.$_POST['add_snippet_product_name'].'_1.'.$ext;
$target_file_2 = $target_dir .$fold_name. $_POST['add_snippet_product_code'].''.$_POST['add_snippet_product_name'].'_2.'.$ext;
$target_file_3 = $target_dir .$fold_name. $_POST['add_snippet_product_code'].''.$_POST['add_snippet_product_name'].'_3.'.$ext;

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["add_snippet_product_img"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["add_snippet_product_img"]["size"] > 10000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    die("Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["add_snippet_product_img"]["tmp_name"], $target_file) and
	    copy($target_file, $target_file_2) and  
		copy($target_file, $target_file_3) ) {
		

if(resize(120,$target_file_2,$target_file_2)){
	if(resize(300,$target_file_3,$target_file_3)){
}else{
		die('I c N R');
	}

}else{
	die('Images Could not be resized');
}

    } else {
        die( "Sorry, there was an error uploading your file.");
    }
}
}else{
$target_file = $target_dir .'default.png';
$target_file_2 = $target_dir .'default.png';
$target_file_3 = $target_dir .'default.png';	
}
$inssql = "INSERT INTO `sw_products_raw`(`pr_rel_prty_id`,`pr_rel_sup_id`,`pr_code`,`pr_img`,`pr_img_2`,`pr_img_3`,`pr_name`, `pr_desc`, `pr_price`,`pr_dnt`) VALUES (
'".$getptypedetails['prty_id']."',
'".$getsupplierdetails['sup_id']."',
'".$_POST['add_snippet_product_code']."',
'".$target_file."',
'".$target_file_2."',
'".$target_file_3."',
'".$_POST['add_snippet_product_name']."',
'".$_POST['add_snippet_product_desc']."',
'".$_POST['add_snippet_product_cost']."',
'".time()."'
)";



if ($conn->query($inssql) === TRUE) {
	$prraw = $conn->insert_id;
	
			$inserRt = "INSERT INTO `sw_products_qty`(`pq_rel_pr_id`, `pq_ref`, `pq_qty`, `pq_dnt`, `pq_ip`, `pq_rel_lum_id`) VALUES (
		'".$prraw."',
		'".$_POST['add_snippet_product_ref_qty']."',
		'".$_POST['add_snippet_product_qty']."',
		'".time()."',
		'".$_SERVER['REMOTE_ADDR']."',
		'".$_SESSION['STWL_LUM_DB_ID']."'
		)";

if ($conn->query($inserRt) === TRUE){header('Location: '.$_POST['add_snippet_href']);}else{die('No qty inserted');}


	
			
}else {
	die( "ERRMA(PA), Error Inserting Product");
}





}
/*-------------------------------------------------------------------*/
if(isset($_POST['add_client'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("You Must Login to continue");
	}
#---------------------------------------
if(isset($_POST['add_client_name'])){
  if(!is_string($_POST['add_client_name'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_name');
}
#---------------------------------------
if(isset($_POST['add_client_tax_code'])){
  if(!is_string($_POST['add_client_tax_code'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_tax_code');
}
#---------------------------------------
if(isset($_POST['add_client_code'])){
  if(!is_string($_POST['add_client_code'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_code');
}
#---------------------------------------
if(isset($_POST['add_client_bill_addr'])){
  if(!is_string($_POST['add_client_bill_addr'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_bill_addr');
}
#---------------------------------------
if(isset($_POST['add_client_phone'])){
  if(!is_string($_POST['add_client_phone'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_phone');
}
#---------------------------------------
if(isset($_POST['add_client_state'])){
  if(!ctype_alnum($_POST['add_client_state'])){
  die('Invalid Characters used');   }
  else{}
}else{
  die('Enter add_client_state');
}

#---------------------------------------

$checkstate = getdatafromsql($conn, "select * from sw_master_states_gst where md5(state_id) = '".$_POST['add_client_state']."'");
if(!is_array($checkstate)){
	die('Invalid State');
}

$ins_sql = "INSERT INTO `sw_clients`( `cli_rel_state_id`,`cli_name`, `cli_tax_code`, `cli_code`, `cli_bill_addr`, `cli_contact_no`, `cli_dnt`, `cli_ip`) VALUES 
(
'".$checkstate['state_id']."',
'".$_POST['add_client_name']."',
'".$_POST['add_client_tax_code']."',
'".$_POST['add_client_code']."',
'".$_POST['add_client_bill_addr']."',
'".$_POST['add_client_phone']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";

if($conn->query($ins_sql)){
	header('Location: sw_clients.php');
}else{
	die('ERRMA(#)TJ Inserting Client, Contact Admin');
}
	
}
if(isset($_POST['edit_client'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("You Must Login to continue");
	}
#---------------------------------------
if(isset($_POST['edit_client_name'])){
  if(!is_string($_POST['edit_client_name'])){
  die('Invalid Characters used in edit_client_name');   }
  else{}
}else{
  die('Enter edit_client_name');
}
#---------------------------------------
if(isset($_POST['edit_client_code'])){
  if(!is_string($_POST['edit_client_code'])){
  die('Invalid Characters used in edit_client_code');   }
  else{}
}else{
  die('Enter edit_client_code');
}
#---------------------------------------
if(isset($_POST['edit_client_state'])){
  if(!ctype_alnum($_POST['edit_client_state'])){
  die('Invalid Characters used in edit_client_state');   }
  else{}
}else{
  die('Enter edit_client_state');
}
#---------------------------------------
if(isset($_POST['edit_client_txcd'])){
  if(!is_string($_POST['edit_client_txcd'])){
  die('Invalid Characters used in edit_client_txcd');   }
  else{}
}else{
  die('Enter edit_client_txcd');
}
#---------------------------------------
if(isset($_POST['edit_us_contact'])){
  if(!is_string($_POST['edit_us_contact'])){
  die('Invalid Characters used in edit_us_contact');   }
  else{}
}else{
  die('Enter edit_us_contact');
}
#---------------------------------------
if(isset($_POST['edit_client_bill_addr'])){
  if(!is_string($_POST['edit_client_bill_addr'])){
  die('Invalid Characters used in edit_client_bill_addr');   }
  else{}
}else{
  die('Enter edit_client_bill_addr');
}
#---------------------------------------
if(isset($_POST['edit_client_hash'])){
  if(!ctype_alnum(trim($_POST['edit_client_hash']))){
  die('Invalid Characters used in edit_client_hash');   }
  else{}
}else{
  die('Enter edit_client_hash');
}
#---------------------------------------


$checkstate = getdatafromsql($conn, "select * from sw_master_states_gst where md5(state_id) = '".$_POST['edit_client_state']."'");
if(!is_array($checkstate)){
	die('Invalid State');
}
$getclient = getdatafromsql($conn,"select * from sw_clients  where cli_valid =1 and md5(md5(sha1(sha1(md5(md5(concat(cli_id,'kjwj 2fgtegrfr3gbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['edit_client_hash']."'");
if(is_array($getclient)){
}else{
	die('Client Not found');
}

$ins_sql = "UPDATE `sw_clients` SET 
`cli_name`='".$_POST['edit_client_name']."',
`cli_tax_code`='".$_POST['edit_client_txcd']."',
`cli_bill_addr`='".$_POST['edit_client_bill_addr']."',
`cli_contact_no`='".$_POST['edit_us_contact']."',
`cli_rel_state_id`='".$checkstate['state_id']."'

 WHERE cli_id = ".$getclient['cli_id']."
";

if($conn->query($ins_sql)){
	header('Location: sw_clients.php');
}else{
	die('ERRMA(#)TH Updating Client, Contact Admin');
}
	
}
/*-------------------------------------------------------------------*/
if(isset($_POST['add_product'])){
if(isset($_SESSION['STWL_LUM_DB_ID']) and (trim($_SESSION['STWL_LUM_DB_ID']) !== '')){
}else{
	die('Login to Continue.');
}
#---------------------------------------
if(isset($_POST['add_product_name'])){
  if(!is_string($_POST['add_product_name'])){
  die('Invalid Characters used in add_product_name');   }
  else{}
}else{
  die('Enter add_product_name');
}
#---------------------------------------
if(isset($_POST['add_product_hsn_code'])){
  if(!is_string($_POST['add_product_hsn_code'])){
  die('Invalid Characters used in add_product_hsn_code');   }
  else{}
}else{
  die('Enter add_product_hsn_code');
}
#---------------------------------------
if(isset($_POST['add_product_code'])){
  if(!is_string($_POST['add_product_code'])){
  die('Invalid Characters used in add_product_code');   }
  else{}
}else{
  die('Enter add_product_code');
}
#---------------------------------------
if(isset($_POST['add_product_idesc'])){
  if(!is_string($_POST['add_product_idesc'])){
  die('Invalid Characters used in add_product_idesc');   }
  else{}
}else{
  die('Enter add_product_idesc');
}
#---------------------------------------
if(isset($_POST['add_product_odesc'])){
  if(!is_string($_POST['add_product_odesc'])){
  die('Invalid Characters used in add_product_odesc');   }
  else{}
}else{
  die('Enter add_product_odesc');
}
#---------------------------------------
if(isset($_POST['add_product_remarks'])){
  if(!is_string($_POST['add_product_remarks'])){
  die('Invalid Characters used in add_product_remarks');   }
  else{}
}else{
  die('Enter add_product_remarks');
}
#---------------------------------------
if(isset($_POST['add_product_inner_cost'])){
  if(!is_numeric($_POST['add_product_inner_cost'])){
  die('Invalid Characters used in add_product_inner_cost');   }
  else{}
}else{
  die('Enter add_product_inner_cost');
}
#---------------------------------------
if(isset($_POST['add_product_outer_cost'])){
  if(!is_numeric($_POST['add_product_outer_cost'])){
  die('Invalid Characters used in add_product_outer_cost');   }
  else{}
}else{
  die('Enter add_product_outer_cost');
}
#---------------------------------------


$inssql = "INSERT INTO `sw_products_list`(`pr_code`, `pr_hsn_code`, `pr_name`, `pr_i_desc`, `pr_o_desc`, `pr_remarks`, `pr_inner_cost`, `pr_outer_cost`,`pr_dnt`) VALUES (
'".$_POST['add_product_code']."',
'".$_POST['add_product_hsn_code']."',
'".$_POST['add_product_name']."',
'".$_POST['add_product_idesc']."',
'".$_POST['add_product_odesc']."',
'".$_POST['add_product_remarks']."',
'".$_POST['add_product_inner_cost']."',
'".$_POST['add_product_outer_cost']."',
'".time()."'
)";
if ($conn->query($inssql) === TRUE) {
			header('Location: inven.php');
}else {
	die( $conn->error."ERRMA(PA), Error Inserting Product");
}

}
if(isset($_POST['edit_product'])){
if(isset($_SESSION['STWL_LUM_DB_ID']) and (trim($_SESSION['STWL_LUM_DB_ID']) !== '')){
}else{
	die('Login to Continue.');
}

#---------------------------------------
if(isset($_POST['edit_product_name'])){
  if(!is_string($_POST['edit_product_name'])){
  die('Invalid Characters used in edit_product_name');   }
  else{}
}else{
  die('Enter edit_product_name');
}
#---------------------------------------
if(isset($_POST['edit_product_idesc'])){
  if(!is_string($_POST['edit_product_idesc'])){
  die('Invalid Characters used in edit_product_idesc');   }
  else{}
}else{
  die('Enter edit_product_idesc');
}
#---------------------------------------
if(isset($_POST['edit_product_odesc'])){
  if(!is_string($_POST['edit_product_odesc'])){
  die('Invalid Characters used in edit_product_odesc');   }
  else{}
}else{
  die('Enter edit_product_odesc');
}
#---------------------------------------
if(isset($_POST['edit_product_remarks'])){
  if(!is_string($_POST['edit_product_remarks'])){
  die('Invalid Characters used in edit_product_remarks');   }
  else{}
}else{
  die('Enter edit_product_remarks');
}
#---------------------------------------
if(isset($_POST['edit_product_inner_cost'])){
  if(!is_numeric($_POST['edit_product_inner_cost'])){
  die('Invalid Characters used in edit_product_inner_cost');   }
  else{}
}else{
  die('Enter edit_product_inner_cost');
}

#---------------------------------------
if(isset($_POST['edit_product_outer_cost'])){
  if(!is_numeric($_POST['edit_product_outer_cost'])){
  die('Invalid Characters used in edit_product_outer_cost');   }
  else{}
}else{
  die('Enter edit_product_outer_cost');
}

#---------------------------------------
if(isset($_POST['edit_product_hash'])){
  if(!ctype_alnum($_POST['edit_product_hash'])){
  die('Invalid Characters used in edit_product_hash');   }
  else{}
}else{
  die('Enter edit_product_hash');
}
#---------------------------------------

$getproduct = getdatafromsql($conn,"select * from sw_products_list where md5(md5(sha1(sha1(md5(md5(concat(pr_id,'f2fkjwiuef0rjigbter 24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['edit_product_hash']."'");
if(!is_array($getproduct)){
	die('Product Not Found');
}


$inssql = "update `sw_products_list`
set `pr_name`='".$_POST['edit_product_name']."',
`pr_i_desc`='".$_POST['edit_product_idesc']."',
`pr_o_desc`='".$_POST['edit_product_odesc']."',
`pr_remarks`='".$_POST['edit_product_remarks']."',
`pr_inner_cost`='".$_POST['edit_product_inner_cost']."',
`pr_outer_cost`='".$_POST['edit_product_outer_cost']."'
where pr_id = ".$getproduct['pr_id']."
";
if ($conn->query($inssql) === TRUE) {
	header('Location: inven.php');
}else {
	die($conn->error. "ERRMA(PB), Error Updating Product");
}

}
if(isset($_POST['prcodee'])){
	if(!is_string($_POST['prcodee'])){
		die('0');
	}

	$checkpr = getdatafromsql($conn,"select * from sw_products_list where pr_valid=1 and pr_code = '".$_POST['prcodee']."'");
	if(is_array($checkpr)){
		echo '
		<strong>Code:</strong> <u>'.$checkpr['pr_code'].'</u><br>
		<strong>Name</strong>: <u>'.$checkpr['pr_name'].'</u><br>
		<strong>Inner Desc</strong>: <u>'.$checkpr['pr_i_desc'].'</u><br>
		<strong>Inner Cost</strong>:<u> '.$checkpr['pr_inner_cost'].'</u><br>
		<strong>Outer Desc:</strong> <u>'.$checkpr['pr_o_desc'].'</u><br>
		<strong>Outer Cost:</strong> <u>'.$checkpr['pr_outer_cost'].'</u><br>
		<strong>Remarks</strong>: <u>'.$checkpr['pr_remarks'].'</u><br>
		<strong>HSN Code:</strong> <u>'.$checkpr['pr_hsn_code'].'</u>
			';
	}else{
		echo trim('1');
	}
	
	die;
}
if(isset($_POST['del_pr_hash'])){
	if(!ctype_alnum($_POST['del_pr_hash'])){
		die('Invalid Hash');
	}	
	
	$checkpo = getdatafromsql($conn,"
	SELECT * FROM sw_products_list pl
 where pl.pr_valid= 1 
 and md5(concat(pr_id,'alphabeta'))=  '".$_POST['del_pr_hash']."'");
	if(!is_array($checkpo)){
		die('Invalid Product Hash');
	}
	
	
	$update = "
	UPDATE `sw_products_list` SET `pr_valid` = '0' WHERE `sw_products_list`.`pr_id` = ".$checkpo['pr_id'].";";
	if($conn->query($update)){
		header('Location: inven.php');
	}else{
		die($conn->error.'|Could not Remove Item');
	}
}
/*--------------------------------------------------------------------*/
if(isset($_POST['add_proforma_quotation'])){
	
if(!isset($_SESSION['STWL_LUM_DB_ID'])){
	die("Login");
}
	if(isset($_POST['add_proforma_quotation_hash']) and ctype_alnum($_POST['add_proforma_quotation_hash'])){
	}else{
		die("Invalid Hash");
	}
	$getquote = getdatafromsql($conn,"select * from sw_quotes where qo_valid =1 and md5(qo_id) = '".$_POST['add_proforma_quotation_hash']."'");
	
	if(is_array($getquote)){
	}else{
		die('Quote not found');
	}
	
	$checkprods = getdatafromsql($conn,"SELECT * FROM sw_quotes_items where qi_rel_qo_id = ".$getquote['qo_id']." and qi_valid =1");

if (!is_array($checkprods)) {
	die("No Products in quote");
}
	
$insert = "INSERT INTO `sw_proformas`(`po_rel_qo_id`, `po_rel_cli_id`, `po_rel_cur_id`, `po_cur_rate`, `po_ref`, `po_proj_name`, `po_subj`, `po_revision`, `po_revision_id`, `po_dnt`, `po_ip`, `po_rel_lum_id`) VALUES (
'".$getquote['qo_id']."',
'".$getquote['qo_rel_cli_id']."',
'".$getquote['qo_rel_cur_id']."',
'".$getquote['qo_cur_rate']."',
'0',
'".$getquote['qo_proj_name']."',
'".$getquote['qo_subj']."',
'0',
'0',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";
	$getlatestref = getdatafromsql($conn, "SELECT po_ref FROM `sw_proformas` where po_revision =0  order by `po_revision_id`   desc limit 1");
	if(is_array($getlatestref)){
		$latestrefstr = substr($getlatestref['po_ref'],4);
		if(is_numeric($latestrefstr)){
			$latestref = $latestrefstr * 1;
		}else{
			die('Latest Ref not numeric');
		}
	}else{
		$latestref = 0;
	}
 $latestref = $latestref + 1;

if($conn->query($insert)){
	$proid = $conn->insert_id;

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." added new proforma from quotation  with id =".$proid,$_SESSION['STWL_LUM_DB_ID'],'sw_proformas','INSERT',$insert,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

$insert = "UPDATE `sw_proformas` set
`po_ref` = 'SWPI".str_pad($latestref, 8, '0', STR_PAD_LEFT)."',
`po_revision_id`='".$proid."'
where `po_id`= '".$proid."'

";
	if($conn->query($insert)){
	
	}else{
		die("Unexpected Breakpoint at proforma updation");
	}
	
	
	$getcopyprods = "SELECT * FROM sw_quotes_items where qi_rel_qo_id = ".$getquote['qo_id']." and qi_valid =1";
$getcopyprods = $conn->query($getcopyprods);

if ($getcopyprods->num_rows > 0) {
    // output data of each row
    while($prod = $getcopyprods->fetch_assoc()) {
		if($conn->query("INSERT INTO `sw_proformas_items`( `pi_rel_po_id`, `pi_rel_pr_id`, `pi_qty`, `pi_cost`, `pi_price`, `pi_desc`) VALUES 
		('".$proid."',
		'".$prod['qi_rel_pr_id']."',
		'".$prod['qi_qty']."',
		'".$prod['qi_cost']."',
		'".$prod['qi_price']."',
		'".$prod['qi_desc']."')")){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." added proforma with id = ".$proid." and added item with id =".$conn->insert_id,$_SESSION['STWL_LUM_DB_ID'],'sw_proformas_items',"insert","INSERT INTO `sw_proformas_items`( `pi_rel_po_id`, `pi_rel_pr_id`, `pi_qty`, `pi_cost`, `pi_price`, `pi_desc`) VALUES 
		('".$proid."',
		'".$prod['qi_rel_pr_id']."',
		'".$prod['qi_qty']."',
		'".$prod['qi_cost']."',
		'".$prod['qi_price']."',
		'".$prod['qi_desc']."')",$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	
	}else{
		die("Unexpected Breakpoint at proforma product insertion");
	}
	
    }
} else {
    die("No Products");
}
	
	
}else{
	die($conn->error."Could Not Generate Proforma from Quote");
}
	
	header('Location: sw_proforma.php');
}
if(isset($_POST['add_revision_proforma'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');
	}
#---------------------------------------
if(isset($_POST['add_revision_proforma_proj_name'])){
  if(!is_string($_POST['add_revision_proforma_proj_name'])){
  die('Invalid Characters used in add_revision_proforma_proj_name');   }
  else{}
}else{
  die('Enter add_revision_proforma_proj_name');
}
#---------------------------------------
if(isset($_POST['add_revision_proforma_subj'])){
  if(!is_string($_POST['add_revision_proforma_subj'])){
  die('Invalid Characters used in add_revision_proforma_subj');   }
  else{}
}else{
  die('Enter add_revision_proforma_subj');
}
#---------------------------------------
if(isset($_POST['pro_nos'])){
  if(!is_numeric($_POST['pro_nos']) or ($_POST['pro_nos'] > 1000)){
  die('Invalid Characters used in pro_nos');   }
  else{}
}else{
  die('Enter pro_nos');
}
#---------------------------------------
if(isset($_POST['add_revision_p_hash'])){
  if(!ctype_alnum($_POST['add_revision_p_hash'])){
  die('Invalid Characters used in add_revision_p_hash');   }
  else{}
}else{
  die('Enter add_revision_p_hash');
}
#---------------------------------------

$getqo = getdatafromsql($conn,"select * from sw_proformas where md5(po_id) = '".$_POST['add_revision_p_hash']."' and po_valid =1");
if(!is_array($getqo)){
	die('proforma not found');
}

$getitems = getdatafromsql($conn,"select count(pi_id) as nom from sw_proformas_items where pi_rel_po_id = ".$getqo['po_id']." and pi_valid =1");
if(!is_array($getqo)){
	die('Items not found');
}
for($i = 1;$i < ($getitems['nom'] + 1);$i++){
	if(isset($_POST['add_revision_proforma_product_already_'.$i])){
					  if(!ctype_alnum($_POST['add_revision_proforma_product_already_'.$i])){
						  die('Invalid' .'add_revision_proforma_product_already_'.$i);
					  }
						if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_revision_proforma_product_already_'.$i]."' and pr_valid =1 "))){
						}else{
							die('Invalid Product');
						}
					
						#---------------------------------------
						if(isset($_POST['add_revision_proforma_desc_already_'.$i])){
						  if(!is_string($_POST['add_revision_proforma_desc_already_'.$i])){
						  die('Invalid Characters used in add_revision_proforma_desc_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_proforma_desc_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_proforma_cost_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_proforma_cost_already_'.$i])){
						  die('Invalid Characters used in add_revision_proforma_cost_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_proforma_cost_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_proforma_price_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_proforma_price_already_'.$i])){
						  die('Invalid Characters used in add_revision_proforma_price_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_proforma_price_already_'.$i);
						}
						#---------------------------------------
						if(isset($_POST['add_revision_proforma_qty_already_'.$i])){
						  if(!is_numeric($_POST['add_revision_proforma_qty_already_'.$i])){
						  die('Invalid Characters used in add_revision_proforma_qty_already_'.$i);   }
						  else{}
						}else{
						  die('Enter add_revision_proforma_qty_already_'.$i);
						}
	}
}


for($c = 1;$c < ($_POST['pro_nos'] + 1);$c++){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
				#---------------------------------------
				if(isset($_POST['add_revision_proforma_product_a'.$numi])){
				  if(ctype_alnum($_POST['add_revision_proforma_product_a'.$numi]) or ($_POST['add_revision_proforma_product_a'.$numi] === '0') ){
					  
if($_POST['add_revision_proforma_product_a'.$numi] === '0'){
	
}else{
						if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['add_revision_proforma_product_a'.$numi]."' and pr_valid =1 "))){
						}else{
							die('Invalid Product');
						}
	
}
						
						
				  }else{
					  				  die('Invalid Characters used in add_revision_proforma_product_a'.$numi);   
				  }
				}else{
				  die('Enter add_revision_proforma_product_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_proforma_desc_a'.$numi])){
				  if(!is_string($_POST['add_revision_proforma_desc_a'.$numi])){
				  die('Invalid Characters used in add_revision_proforma_desc_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_proforma_desc_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_proforma_cost_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_proforma_cost_a'.$numi])){
				  die('Invalid Characters used in add_revision_proforma_cost_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_proforma_cost_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_proforma_price_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_proforma_price_a'.$numi])){
				  die('Invalid Characters used in add_revision_proforma_price_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_proforma_price_a'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['add_revision_proforma_qty_a'.$numi])){
				  if(!is_numeric($_POST['add_revision_proforma_qty_a'.$numi])){
				  die('Invalid Characters used in add_revision_proforma_qty_a'.$numi);   }
				  else{}
				}else{
				  die('Enter add_revision_proforma_qty_a'.$numi);
				}
				
}

$geporef = getdatafromsql($conn,"select * from sw_proformas where po_id = ".$getqo['po_revision_id']." and po_valid = 1 ");
if(!is_array($geporef)){
	die("Could not find main proforma");
}
$insertproforma = "
INSERT INTO `sw_proformas`(`po_rel_qo_id`,`po_rel_cli_id`, `po_ref`, `po_proj_name`, `po_subj`, `po_revision`, `po_revision_id`, `po_dnt`, `po_ip`, `po_rel_lum_id`) VALUES (
'".$getqo['po_rel_qo_id']."',
'".$getqo['po_rel_cli_id']."',
'".$geporef['po_ref'].'/'.(($getqo['po_revision'] + 1))."',
'".$_POST['add_revision_proforma_proj_name']."',
'".$_POST['add_revision_proforma_subj']."',
'".($getqo['po_revision'] + 1)."',
'".$getqo['po_revision_id']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";
if($conn->query($insertproforma)){
	$proformaid = $conn->insert_id;
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID'].' added new proforma revision with id ='.$proformaid,$_SESSION['STWL_LUM_DB_ID'],'sw_proformas','INSERT',$insertproforma,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	
for($i = 1;$i < ($getitems['nom'] + 1);$i++){
	if(isset($_POST['add_revision_proforma_product_already_'.$i])){
						$pr = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_revision_proforma_product_already_'.$i]."'");
						if(!is_array($pr)){
							die("A big error has occured in product after proforma insert");
						}
$insertqitem = "INSERT INTO `sw_proformas_items`(`pi_rel_po_id`, `pi_rel_pr_id`, `pi_qty`, `pi_cost`, `pi_price`, `pi_desc`) VALUES 
(
'".$proformaid."',
'".$pr['pr_id']."',
'".$_POST['add_revision_proforma_qty_already_'.$i]."',
'".$_POST['add_revision_proforma_cost_already_'.$i]."',
'".$_POST['add_revision_proforma_price_already_'.$i]."',
'".$_POST['add_revision_proforma_desc_already_'.$i]."'
)";

if($conn->query($insertqitem)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID'].' added proforma revision to id ='.$proformaid." and new product id =".$conn->insert_id,$_SESSION['STWL_LUM_DB_ID'],'sw_proformas_items','INSERT',$insertqitem,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

}else{
	die("Item Insertion Failed");
}
	}
}

for($c = 1;$c < ($_POST['pro_nos'] + 1);$c++){
	if($_POST['add_revision_proforma_product_a'.$numi] !== '0'){
	if($c == 1){
		$numi = '';
	}else{
		$numi = $c;
	}
$pra = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_revision_proforma_product_a'.$numi]."'");
if(!is_array($pra)){
die("A big error has occured in product-2  after proforma insert");
}
$insertq2item = "INSERT INTO `sw_proformas_items`(`pi_rel_po_id`, `pi_rel_pr_id`, `pi_qty`, `pi_cost`, `pi_price`, `pi_desc`) VALUES 
(
'".$proformaid."',
'".$pra['pr_id']."',
'".$_POST['add_revision_proforma_qty_a'.$numi]."',
'".$_POST['add_revision_proforma_cost_a'.$numi]."',
'".$_POST['add_revision_proforma_price_a'.$numi]."',
'".$_POST['add_revision_proforma_desc_a'.$numi]."'
)";


if($conn->query($insertq2item)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID'].' added proforma revision to id ='.$proformaid." and new product id =".$conn->insert_id,$_SESSION['STWL_LUM_DB_ID'],'sw_proformas_items','INSERT',$insertq2item,$conn)){
}else{
	die("Only log not generated ");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

}else{
	die("Item-2 Insertion Failed");
}
				
				
	}
				
}


	
}else{
	die($conn->error.'Could not insert proforma');
}

	header('Location: sw_proforma.php');

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
		$checklast = 1;
		if(($_POST['add_proforma_product'.$numi] !== '0') and ($_POST['add_proforma_product'.$numi] !== '987654321987654321')){
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



if($checklast == 0){
	die('No Items Chosen');
}
	$getlatestref = getdatafromsql($conn, "SELECT po_ref FROM `sw_proformas`  order by `po_ref`   desc limit 1");
	if(is_array($getlatestref)){
		$latestrefstr = ($getlatestref['po_ref']);
		if(is_numeric($latestrefstr)){
			$latestref = $latestrefstr * 1;
		}else{
			die('Latest Ref not numeric');
		}
	}else{
		$latestref = 0;
	}
 $latestref = $latestref + 1;

$insertproforma = "
INSERT INTO `sw_proformas`(`po_lpo`,`po_rel_cli_id`,`po_rel_ship_cli_id`, `po_ref`, `po_igst`, `po_cgst`, `po_sgst`,  `po_dnt`, `po_ip`, `po_rel_lum_id` ,`po_reverse_charge` ,`po_transport` ,`po_vehicle`,
`po_bill_to_name`, `po_bill_to_addr1`, `po_bill_to_addr2`, `po_bill_to_addr3`, `po_bill_to_gstin`, `po_bill_to_state`, `po_ship_to_name`, `po_ship_to_addr1`, `po_ship_to_addr2`,
 `po_ship_to_addr3`, `po_ship_to_gstin`, `po_ship_to_state`, `po_dapos`) 
 VALUES (
'".$_POST['add_po_ref']."',
'".$getclient['cli_id']."',
'".$getclient2['cli_id']."',
'".$latestref."',
'".$_POST['add_proforma_igst']."',
'".$_POST['add_proforma_cgst']."',
'".$_POST['add_proforma_sgst']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."',
'".$_POST['add_po_reverse']."',
'".$_POST['add_po_transport']."',
'".$_POST['add_po_car']."',
'".$_POST['add_po_bill_name']."',
'".$_POST['add_po_bill_addr1']."',
'".$_POST['add_po_bill_addr2']."',
'".$_POST['add_po_bill_addr3']."',
'".$_POST['add_po_bill_gstin']."',
'".$_POST['add_po_bill_state']."',
'".$_POST['add_po_ship_name']."',
'".$_POST['add_po_ship_addr1']."',
'".$_POST['add_po_ship_addr2']."',
'".$_POST['add_po_ship_addr3']."',
'".$_POST['add_po_ship_gstin']."',
'".$_POST['add_po_ship_state']."',
'".$_POST['add_po_supply']."'
)";
if($conn->query($insertproforma)){
	$proformaid = $conn->insert_id;
for($c = 1;$c < 101;$c++){
	$numi = $c;
	if(isset($_POST['add_proforma_product'.$numi])){


		if(($_POST['add_proforma_product'.$numi] !== '0') and ($_POST['add_proforma_product'.$numi] !== '987654321987654321')){
			$pra = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['add_proforma_product'.$numi]."'");
			if(!is_array($pra)){die("A big error has occured in product-2  after proforma insert");}
				$insertq2item = "INSERT INTO `sw_proformas_items`(`pi_rel_po_id`, `pi_rel_pr_id`, `pi_io`, `pi_qty`, `pi_cost`, `pi_price`, `pi_desc`, `pi_remarks`, `pi_hsn_code`) VALUES 
				(
				'".$proformaid."',
				'".$pra['pr_id']."',
				'".$_POST['add_proforma_innerouter'.$numi]."',
				'".$_POST['add_proforma_product_qty'.$numi]."',
				'".$_POST['add_proforma_product_cost'.$numi]."',
				'".$_POST['add_proforma_product_price'.$numi]."',
				'".$_POST['add_proforma_product_desc'.$numi]."',
				'".$_POST['add_proforma_product_remarks'.$numi]."',
				'".$_POST['add_proforma_product_hsn'.$numi]."'
				)";
				if($conn->query($insertq2item)){}else{ die("Item-2 Insertion Failed");}
				
				}
		if(($_POST['add_proforma_product'.$numi] == '987654321987654321')){
			
$insertnewpr = "INSERT INTO `sw_products_list`(`pr_code`, `pr_name`, `pr_i_desc`, `pr_o_desc`, `pr_remarks`, `pr_inner_cost`, `pr_outer_cost`, `pr_hsn_code`, `pr_dnt`) VALUES 
(
'".$_POST['add_proforma_add_new_pr_code'.$numi]."',
'".$_POST['add_proforma_add_new_pr_name'.$numi]."',
'3 ply inner box',
'7 ply outer box',
'".$_POST['add_proforma_product_remarks'.$numi]."',
'".$_POST['add_proforma_add_new_pr_inner_cost'.$numi]."',
'".$_POST['add_proforma_add_new_pr_outer_cost'.$numi]."',
'".$_POST['add_proforma_product_hsn'.$numi]."',
'".time()."'
)";
			if($conn->query($insertnewpr)){
				$pr_id = $conn->insert_id;			
				$insertq2item = "INSERT INTO `sw_proformas_items`(`pi_rel_po_id`, `pi_rel_pr_id`, `pi_io`, `pi_qty`, `pi_cost`, `pi_price`, `pi_desc`, `pi_remarks`, `pi_hsn_code`) VALUES 
				(
				'".$proformaid."',
				'".$pr_id."',
				'".$_POST['add_proforma_innerouter'.$numi]."',
				'".$_POST['add_proforma_product_qty'.$numi]."',
				'".$_POST['add_proforma_product_cost'.$numi]."',
				'".$_POST['add_proforma_product_price'.$numi]."',
				'".$_POST['add_proforma_product_desc'.$numi]."',
				'".$_POST['add_proforma_product_remarks'.$numi]."',
				'".$_POST['add_proforma_product_hsn'.$numi]."'
				)";
				if($conn->query($insertq2item)){}else{ die("Item-2 Insertion Failed");}
				
				}else{
					die(base64_encode($conn->error).'|New pr not inserted');
				}
				
				}

		}
}

	
}else{
	die($conn->error.'Could not insert proforma');
} 
 $return = array('url'=>'sw_proforma_print.php?id='.md5($proformaid));
	echo json_encode($return);

}
if(isset($_POST['edit_proforma'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die('Login');
	}
	
#---------------------------------------
if(isset($_POST['edit_po_id'])){
  if(!ctype_alnum($_POST['edit_po_id'])){
  die('Invalid Characters used in edit_po_id');   }
  else{}
}else{
  die('Enter edit_po_id');
}

$getpo = getdatafromsql($conn  , "select * from sw_proformas 
left join sw_clients ci on po_rel_cli_id = ci.cli_id
left join sw_master_states_gst on cli_rel_state_id = state_id
	where md5(md5(concat('jihfeudbjsu39herinvh u3infr 3un gf893h9 83hfuh eushfer', po_id)))= '".$_POST['edit_po_id']."' and po_valid =1");
	
	if(!is_array($getpo)){
		die('Bill not Found');
	}
#---------------------------------------
if(isset($_POST['edit_proforma_client'])){
  if(!ctype_alnum($_POST['edit_proforma_client'])){
  die('Invalid Characters used in edit_proforma_client');   }
  else{}
}else{
  die('Enter edit_proforma_client');
}
#---------------------------------------
if(isset($_POST['edit_proforma_client_ship'])){
  if(!ctype_alnum($_POST['edit_proforma_client_ship'])){
  die('Invalid Characters used in edit_proforma_client_ship');   }
  else{}
}else{
  die('Enter edit_proforma_client_ship');
}
#---------------------------------------
if(isset($_POST['edit_po_ref'])){
  if(!is_string($_POST['edit_po_ref'])){
  die('Invalid Characters used in edit_po_ref');   }
  else{}
}else{
  die('Enter edit_po_ref');
}
#---------------------------------------
if(isset($_POST['edit_proforma_igst'])){
  if(!is_numeric($_POST['edit_proforma_igst']) or !in_range($_POST['edit_proforma_igst'],0,100,true)){
  die('Invalid Characters used in edit_proforma_igst');   }
  else{}
}else{
  die('Enter edit_proforma_igst');
}
#---------------------------------------
if(isset($_POST['edit_proforma_cgst'])){
  if(!is_numeric($_POST['edit_proforma_cgst']) or !in_range($_POST['edit_proforma_cgst'],0,100,true)){
  die('Invalid Characters used in edit_proforma_cgst');   }
  else{}
}else{
  die('Enter edit_proforma_cgst');
}
#---------------------------------------
if(isset($_POST['edit_proforma_sgst'])){
  if(!is_numeric($_POST['edit_proforma_sgst']) or !in_range($_POST['edit_proforma_sgst'],0,100,true)){
  die('Invalid Characters used in edit_proforma_sgst');   }
  else{}
}else{
  die('Enter edit_proforma_sgst');
}
#---------------------------------------
if(isset($_POST['edit_po_car'])){
  if(!is_string($_POST['edit_po_car'])){
  die('Invalid Characters used in edit_po_car');   }
  else{}
}else{
  die('Enter edit_po_car');
}
#---------------------------------------
if(isset($_POST['edit_po_transport'])){
  if(!is_string($_POST['edit_po_transport'])){
  die('Invalid Characters used in edit_po_transport');   }
  else{}
}else{
  die('Enter edit_po_transport');
}
#---------------------------------------
if(isset($_POST['edit_po_reverse'])){
  if(!is_numeric($_POST['edit_po_reverse'])  or !in_range($_POST['edit_po_reverse'],1,2,true) ){
  die('Invalid Characters used in edit_po_reverse');   }
  else{}
}else{
  die('Enter edit_po_reverse');
}
#---------------------------------------
if(isset($_POST['edit_po_supply'])){
  if(!is_string($_POST['edit_po_supply'])){
  die('Invalid Characters used in edit_po_supply');   }
  else{}
}else{
  die('Enter edit_po_supply');
}
#---------------------------------------
if(isset($_POST['edit_po_bill_name'])){
  if(!is_string($_POST['edit_po_bill_name'])){
  die('Invalid Characters used in edit_po_bill_name');   }
  else{}
}else{
  die('Enter edit_po_bill_name');
}
#---------------------------------------
if(isset($_POST['edit_po_bill_addr1'])){
  if(!is_string($_POST['edit_po_bill_addr1'])){
  die('Invalid Characters used in edit_po_bill_addr1');   }
  else{}
}else{
  die('Enter edit_po_bill_addr1');
}
#---------------------------------------
if(isset($_POST['edit_po_bill_addr2'])){
  if(!is_string($_POST['edit_po_bill_addr2'])){
  die('Invalid Characters used in edit_po_bill_addr2');   }
  else{}
}else{
  die('Enter edit_po_bill_addr2');
}
#---------------------------------------
if(isset($_POST['edit_po_bill_addr3'])){
  if(!is_string($_POST['edit_po_bill_addr3'])){
  die('Invalid Characters used in edit_po_bill_addr3');   }
  else{}
}else{
  die('Enter edit_po_bill_addr3');
}
#---------------------------------------
if(isset($_POST['edit_po_bill_gstin'])){
  if(!is_string($_POST['edit_po_bill_gstin'])){
  die('Invalid Characters used in edit_po_bill_gstin');   }
  else{}
}else{
  die('Enter edit_po_bill_gstin');
}
#---------------------------------------
if(isset($_POST['edit_po_bill_state'])){
  if(!is_string($_POST['edit_po_bill_state'])){
  die('Invalid Characters used in edit_po_bill_state');   }
  else{}
}else{
  die('Enter edit_po_bill_state');
}
#---------------------------------------
if(isset($_POST['edit_po_ship_name'])){
  if(!is_string($_POST['edit_po_ship_name'])){
  die('Invalid Characters used in edit_po_ship_name');   }
  else{}
}else{
  die('Enter edit_po_ship_name');
}
#---------------------------------------
if(isset($_POST['edit_po_ship_addr1'])){
  if(!is_string($_POST['edit_po_ship_addr1'])){
  die('Invalid Characters used in edit_po_ship_addr1');   }
  else{}
}else{
  die('Enter edit_po_ship_addr1');
}
#---------------------------------------
if(isset($_POST['edit_po_ship_addr2'])){
  if(!is_string($_POST['edit_po_ship_addr2'])){
  die('Invalid Characters used in edit_po_ship_addr2');   }
  else{}
}else{
  die('Enter edit_po_ship_addr2');
}
#---------------------------------------
if(isset($_POST['edit_po_ship_addr3'])){
  if(!is_string($_POST['edit_po_ship_addr3'])){
  die('Invalid Characters used in edit_po_ship_addr3');   }
  else{}
}else{
  die('Enter edit_po_ship_addr3');
}
#---------------------------------------
if(isset($_POST['edit_po_ship_gstin'])){
  if(!is_string($_POST['edit_po_ship_gstin'])){
  die('Invalid Characters used in edit_po_ship_gstin');   }
  else{}
}else{
  die('Enter edit_po_ship_gstin');
}
#---------------------------------------
if(isset($_POST['edit_po_ship_state'])){
  if(!is_string($_POST['edit_po_ship_state'])){
  die('Invalid Characters used in edit_po_ship_state');   }
  else{}
}else{
  die('Enter edit_po_ship_state');
}
#---------------------------------------



$getclient = getdatafromsql($conn,"select * from sw_clients where md5(cli_id) = '".$_POST['edit_proforma_client']."' and cli_valid =1");
if(!is_array($getclient)){
	die('Client not found');
}


$getclient2 = getdatafromsql($conn,"select * from sw_clients where md5(cli_id) = '".$_POST['edit_proforma_client_ship']."' and cli_valid =1");
if(!is_array($getclient2)){
	die('Client not found');
}
$checklast = 0;
for($c = 1;$c < 101 ;$c++){
	$numi = $c;
		if(isset($_POST['edit_proforma_product'.$numi]) ){
		#---------------------------------------
	if(isset($_POST['edit_proforma_product'.$numi]) and !is_array($_POST['edit_proforma_product'.$numi])){
		if($_POST['edit_proforma_product'.$numi] !== '0'){
			if(ctype_alnum($_POST['edit_proforma_product'.$numi])){
				$checklast = 1;
					if(is_array(getdatafromsql($conn,"select * from sw_products_list where md5(pr_id)='".$_POST['edit_proforma_product'.$numi]."' and pr_valid =1"))){
					}else{
						die('Invalid Product');
						}
				}else{
					die('Invalid Characters used in edit_proforma_product'.$numi);   
				}
				
				#---------------------------------------
				if(isset($_POST['edit_proforma_product_desc'.$numi])){
				  if(!is_string($_POST['edit_proforma_product_desc'.$numi])){
				  die('Invalid Characters used in edit_proforma_product_desc'.$numi);   }
				  else{}
				}else{
				  die('Enter edit_proforma_product_desc'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['edit_proforma_product_remarks'.$numi])){
				  if(!is_string($_POST['edit_proforma_product_remarks'.$numi])){
				  die('Invalid Characters used in edit_proforma_product_remarks'.$numi);   }
				  else{}
				}else{
				  die('Enter edit_proforma_product_remarks'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['edit_proforma_product_cost'.$numi])){
				  if(!is_numeric($_POST['edit_proforma_product_cost'.$numi])){
				  die('Invalid Characters used in edit_proforma_product_cost'.$numi);   }
				  else{}
				}else{
				  die('Enter edit_proforma_product_cost'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['edit_proforma_product_hsn'.$numi])){
				  if(!is_numeric($_POST['edit_proforma_product_hsn'.$numi])){
				  die('Invalid Characters used in edit_proforma_product_hsn'.$numi);   }
				  else{}
				}else{
				  die('Enter edit_proforma_product_hsn'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['edit_proforma_product_price'.$numi])){
				  if(!is_numeric($_POST['edit_proforma_product_price'.$numi])){
				  die('Invalid Characters used in edit_proforma_product_price'.$numi);   }
				  else{}
				}else{
				  die('Enter edit_proforma_product_price'.$numi);
				}
				#---------------------------------------
				if(isset($_POST['edit_proforma_product_qty'.$numi])){
				  if(!is_numeric($_POST['edit_proforma_product_qty'.$numi])){
				  die('Invalid Characters used in edit_proforma_product_qty'.$numi);   }

				  else{}
				}else{
				  die('Enter edit_proforma_product_qty'.$numi);
				}
				
		}
	}
}
}
if($checklast == 0){
	die('No Item Selected');
}

$insertproforma = "
INSERT INTO `sw_proformas`(`po_lpo`,`po_rel_cli_id`,`po_rel_ship_cli_id`, `po_ref`, `po_igst`, `po_cgst`, `po_sgst`,  `po_dnt`, `po_ip`, `po_rel_lum_id` ,`po_reverse_charge` ,`po_transport` ,`po_vehicle`,
`po_bill_to_name`, `po_bill_to_addr1`, `po_bill_to_addr2`, `po_bill_to_addr3`, `po_bill_to_gstin`, `po_bill_to_state`, `po_ship_to_name`, `po_ship_to_addr1`, `po_ship_to_addr2`,
 `po_ship_to_addr3`, `po_ship_to_gstin`, `po_ship_to_state`, `po_dapos`) 
 VALUES (
 '".$_POST['edit_po_ref']."',
'".$getclient['cli_id']."',
'".$getclient2['cli_id']."',
'".$getpo['po_ref']."',
'".$_POST['edit_proforma_igst']."',
'".$_POST['edit_proforma_cgst']."',
'".$_POST['edit_proforma_sgst']."',
'".$getpo['po_dnt']."',
'".$getpo['po_ip']."',
'".$getpo['po_rel_lum_id']."',
'".$_POST['edit_po_reverse']."',
'".$_POST['edit_po_transport']."',
'".$_POST['edit_po_car']."',
'".$_POST['edit_po_bill_name']."',
'".$_POST['edit_po_bill_addr1']."',
'".$_POST['edit_po_bill_addr2']."',
'".$_POST['edit_po_bill_addr3']."',
'".$_POST['edit_po_bill_gstin']."',
'".$_POST['edit_po_bill_state']."',
'".$_POST['edit_po_ship_name']."',
'".$_POST['edit_po_ship_addr1']."',
'".$_POST['edit_po_ship_addr2']."',
'".$_POST['edit_po_ship_addr3']."',
'".$_POST['edit_po_ship_gstin']."',
'".$_POST['edit_po_ship_state']."',
'".$_POST['edit_po_supply']."'
)";
if($conn->query($insertproforma)){
	$proformaid = $conn->insert_id;
for($c = 1;$c < 101;$c++){
	$numi = $c;
	if(isset($_POST['edit_proforma_product'.$numi])){
		if($_POST['edit_proforma_product'.$numi] !== '0'){
			$pra = getdatafromsql($conn,"select * from sw_products_list where md5(pr_id) = '".$_POST['edit_proforma_product'.$numi]."'");
			if(!is_array($pra)){die("A big error has occured in product-2  after proforma insert");}
				$insertq2item = "INSERT INTO `sw_proformas_items`(`pi_rel_po_id`, `pi_rel_pr_id`, `pi_io`, `pi_qty`, `pi_cost`, `pi_price`, `pi_desc`, `pi_remarks`, `pi_hsn_code`) VALUES 
				(
				'".$proformaid."',
				'".$pra['pr_id']."',
				'".$_POST['edit_proforma_innerouter'.$numi]."',
				'".$_POST['edit_proforma_product_qty'.$numi]."',
				'".$_POST['edit_proforma_product_cost'.$numi]."',
				'".$_POST['edit_proforma_product_price'.$numi]."',
				'".$_POST['edit_proforma_product_desc'.$numi]."',
				'".$_POST['edit_proforma_product_remarks'.$numi]."',
				'".$_POST['edit_proforma_product_hsn'.$numi]."'
				)";
				if($conn->query($insertq2item)){}else{ die("Item-2 Insertion Failed");}
				
				}
		}
}

	
}else{
	die($conn->error.'Could not insert proforma');
}

$remoldpo = "UPDATE `sw_proformas` SET `po_valid` = '0' WHERE `sw_proformas`.`po_id` = ".$getpo['po_id'];
if($conn->query($remoldpo)){
 $return = array('url'=>'sw_proforma_print.php?id='.md5($proformaid));
	echo json_encode($return);
}else{
	die('Could not remove old proforma');
}

}
if(isset($_POST['del_po_hash'])){
	if(!ctype_alnum($_POST['del_po_hash'])){
		die('Invalid Hash');
	}
	
	$checkpo = getdatafromsql($conn,"select * from sw_proformas where po_valid =1 and md5(po_id) = '".$_POST['del_po_hash']."'");
	if(!is_array($checkpo)){
		die('Invalid Proforma Hash');
	}
	
	
	$update = "UPDATE `sw_proformas` SET `po_cancel` = 1 WHERE `po_id` = ".$checkpo['po_id'].";";
	if($conn->query($update)){
		header('Location: sw_proforma.php');
	}else{
		die($conn->error.'|Could not cancel Bill');
	}
}
/*--------------------------------------------------------------------*/
if(isset($_POST['add_costing'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("Login to continue");
	}
	#---------------------------------------
if(isset($_POST['costing_head'])){
  if(!is_string($_POST['costing_head'])){
  die('Invalid Characters used in costing_head');   }
  else{}
}else{
  die('Enter costing_head');
}
#---------------------------------------
if(isset($_POST['costing_value'])){
  if(!is_numeric($_POST['costing_value'])){
  die('Invalid Characters used in costing_value');   }
  else{}
}else{
  die('Enter costing_value');
}
#---------------------------------------
if(isset($_POST['costing_hash'])){
  if(!ctype_alnum($_POST['costing_hash'])){
  die('Invalid Characters used in costing_hash');   }
  else{}
}else{
  die('Enter costing_hash');
}

$getpro = getdatafromsql($conn,"select * from sw_proformas where md5(po_id) ='".$_POST['costing_hash']."' and po_valid =1");
if(!is_array($getpro)){
	die("Proforma not found");
}


$insert = "INSERT INTO `sw_costing`( `cost_rel_po_id`, `cost_name`, `cost_val`, `cost_dnt`, `cost_ip`) VALUES (
'".$getpro['po_id']."',
'".$_POST['costing_head']."',
'".$_POST['costing_value']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";


if($conn->query($insert)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." user added ".$_POST['costing_value']." aed costing to  proforma id".$getpro['po_id'],$_SESSION['STWL_LUM_DB_ID'],'sw_costing','INSERT',$insert,$conn)){
}else{
	die("Only log not generated ");
}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	header("Location: sw_costing.php");
}else{
	die("Could not insert cost");
}

}
if(isset($_POST['payment_add'])){
	if(!isset($_SESSION['STWL_LUM_DB_ID'])){
		die("Login to continue");
	}
#---------------------------------------
if(isset($_POST['payment_add_hash'])){
  if(!ctype_alnum($_POST['payment_add_hash'])){
  die('Invalid Characters used in payment_add_hash');   }
  else{}
}else{
  die('Enter payment_add_hash');
}
#---------------------------------------
if(isset($_POST['payment_add_method'])){
  if(!ctype_alnum($_POST['payment_add_method'])){
  die('Invalid Characters used in payment_add_method');   }
  else{}
}else{
  die('Enter payment_add_method');
}
#---------------------------------------
if(isset($_POST['payment_add_c_no'])){
  if(!is_string($_POST['payment_add_c_no'])){
  die('Invalid Characters used in payment_add_c_no');   }
  else{}
}else{
  die('Enter payment_add_c_no');
}
#---------------------------------------
if(isset($_POST['payment_add_date'])){
  if(!is_string($_POST['payment_add_date'])){
  die('Invalid Characters used in payment_add_date');   }
  else{}
}else{
  die('Enter payment_add_date');
}
#---------------------------------------
if(isset($_POST['payment_add_val'])){
  if(!is_numeric($_POST['payment_add_val'])){
  die('Invalid Characters used in payment_add_val');   }
  else{}
}else{
  die('Enter payment_add_val');
}
#---------------------------------------

$getpro = getdatafromsql($conn,"select * from sw_proformas where md5(po_id) ='".$_POST['payment_add_hash']."' and po_valid =1");
if(!is_array($getpro)){
	die("Proforma not found");
}

$getmethod = getdatafromsql($conn,"select * from sw_payments_methods where md5(method_id) ='".$_POST['payment_add_method']."'");
if(!is_array($getmethod)){
	die("Method not found");
}
if($getmethod['method_id'] === '2'){
	$obj_date= '0';
	$_POST['payment_add_c_no'] = '0';
}else{
$obj_date = strtotime($_POST['payment_add_date']);
if($obj_date === false){
	die('Invalid Date');
}
}
$pval = ($_POST['payment_add_val'] * $getpro['po_cur_rate']);
$insert1 = "INSERT INTO `sw_payments`( pt_rel_po_id	, `pt_rel_method_id`, `pt_cheque_number`, `pt_cheque_date`, `pt_val`, `pt_dnt`, `pt_ip`) VALUES (
'".$getpro['po_id']."',
'".$getmethod['method_id']."',
'".$_POST['payment_add_c_no']."',
'".$obj_date."',
'".$pval."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."'
)";

if($conn->query($insert1)){
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
/*--------------------------------------------------------------------PREPLOGS------------------------------------------------------------------------------------*/	

if(preplogs_track($_SESSION['STWL_LUM_DB_ID']." user addded payment of amount: ".$pval." in favour of ".$getpro['po_id']." proforma",$_SESSION['STWL_LUM_DB_ID'],'sw_payments','INSERT',$insert1,$conn)){
}else{
	die("Only log not generated ");
}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/	

	header("Location: sw_payments.php");
}else{
	die($conn->error."Could not insert Payment");
}

}
if(isset($_POST['add_qty_product'])){
	if(isset($_SESSION['STWL_LUM_DB_ID'])){
	}else{
		die('Login to continue');
	}
	
	if(isset($_POST['add_invref_prod'])){
  if(!is_string($_POST['add_invref_prod'])){
  die('Invalid Characters used in add_invref_prod');   }
  else{}
}else{
  die('Enter add_invref_prod');
}
#---------------------------------------
if(isset($_POST['add_qty_prod'])){
  if(!is_numeric($_POST['add_qty_prod'])){
  die('Invalid Characters used in add_qty_prod');   }
  else{}
}else{
  die('Enter add_qty_prod');
}
#---------------------------------------
if(isset($_POST['add_qty_product_hash'])){
  if(!is_string($_POST['add_qty_product_hash'])){
  die('Invalid Characters used in add_qty_product_hash');   }
  else{}
}else{
  die('Enter add_qty_product_hash');
}
#---------------------------------------

$checkprod = getdatafromsql($conn, "select * from sw_products_raw where md5(md5(sha1(sha1(md5(md5(concat(pr_id,'24rfgr324frgtr3f 3gr32fgr32f4gr'))))))) = '".$_POST['add_qty_product_hash']."' and pr_valid =1");

if(!is_array($checkprod)){
	die('Product not found');
}

$insert = "INSERT INTO `sw_products_qty`(`pq_rel_pr_id`, `pq_ref`, `pq_qty`, `pq_dnt`, `pq_ip`, `pq_rel_lum_id`) VALUES (
'".$checkprod['pr_id']."',
'".$_POST['add_invref_prod']."',
'".$_POST['add_qty_prod']."',
'".time()."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SESSION['STWL_LUM_DB_ID']."'
)";

if($conn->query($insert)){
	header('Location: inven.php');
}else{
	die('Unable to insert Qty');
}

}
/*--------------------------------------------------------------------*/
if(isset($_POST['cli_id']) and ctype_alnum($_POST['cli_id'])){
	
	$checkcli = getdatafromsql($conn, "SELECT * FROM sw_clients where cli_valid =1 and md5(cli_id) = '".$_POST['cli_id']."'");
	if(!is_array($checkcli)){
		die("Invalid Client");
	}
	
	if($checkcli['cli_rel_state_id'] == $_COMPANY['cp_rel_state_id']){
	#cgst and sgst
	echo '
	<input  name="add_proforma_igst" type="hidden" required class="required form-control" placeholder="IGST %" value="0">

<label class="col-lg-2 control-label" for="name"> CGST  %</label>
	<input name="add_proforma_cgst" type="text" required class=" form-control" placeholder="CGST %" value="6">
<br>
<label class="col-lg-2 control-label" for="name"> SGST  %</label>
	<input name="add_proforma_sgst" type="text" required class="required form-control" placeholder="SGST %" value="6">
';
	
	
	}else{
	
#only igst
	echo '
<label class="col-lg-2 control-label" for="name"> IGST  %</label>
	<input name="add_proforma_igst" type="text" required class="required form-control" placeholder="IGST %" value="12">

	<input name="add_proforma_cgst" type="hidden" required class="required form-control" placeholder="CGST %" value="0">
	<input name="add_proforma_sgst" type="hidden" required class="required form-control" placeholder="SGST %" value="0">
';	
	
	}




}
if(isset($_POST['prid'])){
	$prll = array('cost'=>'0','desc'=>'Not Good','rem'=>'Not Good','hsn'=>'0000');
	if(is_numeric($_POST['prid'])){
		$prok = getdatafromsql($conn,"select * from sw_products_list where pr_id = '".trim($_POST['prid'])."' and pr_valid =1");	
		if(is_array($prok)){
			$prll['cost']=$prok['pr_inner_cost'];
			$prll['desc']=$prok['pr_i_desc'];
			$prll['rem']=$prok['pr_remarks'];
			$prll['hsn']=$prok['pr_hsn_code'];
			echo json_encode($prll);
		}
	}
}
if(isset($_POST['innerouter'])){
	if($_POST['innerouter'] == '1' or $_POST['innerouter'] == '2'){
	}else{
		die();
	}
	
	$prll = array('cost'=>'0','desc'=>'-');
	if(is_numeric($_POST['priid'])){
		$prok = getdatafromsql($conn,"select * from sw_products_list where pr_id = '".trim($_POST['priid'])."' and pr_valid =1");	
		if(is_array($prok)){
			if($_POST['innerouter'] == '1'){
			$prll['cost']=$prok['pr_inner_cost'];
			$prll['desc']=$prok['pr_i_desc'];
				
			}else{
						$prll['cost']=$prok['pr_outer_cost'];
						$prll['desc']=$prok['pr_o_desc'];
	
			}
			echo json_encode($prll);
		}
	}
}
if(isset($_POST['clii_id']) and ctype_alnum($_POST['clii_id'])){
	
	$checkcli = getdatafromsql($conn, "SELECT * FROM sw_clients 
	left join sw_master_states_gst on cli_rel_state_id = state_id
	where cli_valid =1 and md5(cli_id) = '".$_POST['clii_id']."'
");
	if(!is_array($checkcli)){
		die("Invalid Client");
	}
	$prll = array();
		if(is_array($checkcli)){
			$prll['name']=$checkcli['cli_name'];
			$prll['a1']=$checkcli['cli_bill_addr'];
			$prll['a2']='-';
			$prll['a3']='-';
			$prll['gstin']=$checkcli['cli_tax_code'];
			$prll['state']=$checkcli['state_name'].' - '.str_pad($checkcli['state_code'], 2, '0', STR_PAD_LEFT);
			echo json_encode($prll);
		}




}





























?>







