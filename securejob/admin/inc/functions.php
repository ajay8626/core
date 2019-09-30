<?php
function deletecoockie()
	{
		foreach($_COOKIE as $key => $value)
		{		
			if($key!='PHPSESSID')
				$cookie=setcookie ($key,"", time() - 10000);
		}
	}


function SetValuesToCookie($pagename,$field,$concatString='_')
{
	if(isset($_POST) && count($_POST) > 0)
	{
		foreach ($_POST as $key=>$value)
		{
			if(isset($key) && in_array($key,$field))
			{
				setcookie($pagename.$concatString.$key, $value, time()+7200);
			}
			else
			{
				setcookie($pagename.$concatString.$key, '', time()-7200);
			}
		}
	}
	else if(isset($_GET) && count($_GET) > 0)
	{
		foreach ($_GET as $key=>$value)
		{
			if(isset($key) && in_array($key,$field))
			{
				setcookie($pagename.$concatString.$key, $value, time()+7200);
			}
			else
			{
				setcookie($pagename.$concatString.$key, '', time()-7200);
			}
		}
	}
	else
	{
		for($i=0;$i<count($field);$i++)
		{
			setcookie($pagename.$concatString.$field[$i], '', time()-7200);
		}
	}
}


/* mail send using smtp */
function sendMsg($to, $subject, $message) {
 
 if(!is_array($to)) {
  $to = explode(',', $to);
 }
 $mail = new PHPMailer;
 $mail->SMTPDebug = 0;

 $mail->isSMTP();
 $mail->Host = 'mail.on-linedemo.com';
 $mail->SMTPAuth = true;
 $mail->Username = 'smtp@on-linedemo.com';
 $mail->Password = 'Smtp!@98S@M@!';
 //$mail->SMTPSecure = 'tls';

 $mail->setFrom('info@mgtdemo.co.uk', 'Secure That Job');
 foreach($to as $address) {
  $mail->addAddress($address);
 }
 
 $mail->isHTML(true);

 $mail->Subject = $subject;
 $mail->Body    = $message;
 
 if(!$mail->send()) {
  return false;
 } else {
  return true;
 }

}


function userHasAccess($theSectionCode, $adminuserId){
	global $db;
	$sql = " 	SELECT adminroles.ID FROM adminroles 
				join menu on menu.ID = adminroles.menu_id and admin_id = {$adminuserId}
				where page_code = '{$theSectionCode}' 
				union all 
				Select ID from  administrators  where ID = {$adminuserId} and isSuper = 1 
			";
	$result = $db->Query($sql);
	if(mysql_num_rows($result) > 0){
		return true;
	}
	else
		return false;
}

function makeCode() {
    $pars = "13579";
    $impars = "24680";
    for ($x=0; $x < 6; $x++) {
	mt_srand ((double) microtime() * 1000000);
	$pars[$x] = substr($pars, mt_rand(0, strlen($pars)-1), 1);
	$impars[$x] = substr($impars, mt_rand(0, strlen($impars)-1), 1);
    }
    $coded = $pars[0] . $impars[0] .$pars[2] . $pars[1] . $impars[1] . $pars[3] . $impars[3] . $pars[4];
    return($coded);
}
	function isAdminLoggedIn(){
		$adminsessionstr = isset($_SESSION['adminsessionid'])?trim($_SESSION['adminsessionid']):"";
		if($adminsessionstr == "") {
			return false;
		}
		else{
			$parts = split(";",$adminsessionstr);
			if(count($parts) < 3){
				return false;
			}
			else{
				if($parts[2]!=session_id()){
					return false;
				}
			}
		}	
		return true;
	}

function getNewBounds($origWidth,$origHeight,$targWidth,$targHeight ){
	

		
		$width2HtRatio = $origWidth/$origHeight;

		$Ht2widthRatio = $origHeight/$origWidth;

			

			if($origWidth < $targWidth && $origHeight < $targHeight){

				$useWidth =$origWidth;

				$useHeight =$origHeight;
				

			}

			else if($origWidth > $targWidth){

				$useWidth = $targWidth;

				$useHeight = $useWidth * $Ht2widthRatio;								

					

			}			

			else if($origHeight > $targHeight){			

				$useHeight = $targHeight;											

				$useWidth = $useHeight * $width2HtRatio;

						

			}	

			else if($origWidth < $targWidth){

				$useWidth = $targWidth;

				$useHeight = $useWidth * $Ht2widthRatio;								

						

			}

			else if($origHeight < $targHeight){			

				$useHeight = $targHeight;											

				$useWidth = $useHeight * $width2HtRatio;

					

			}	

			else{

				$useWidth = $targWidth;

				$useHeight = $targHeight;												

				

			}

		
				
		$newDimensions = array (

			'width' => $useWidth,

			'height'=> $useHeight

		);
		return $newDimensions;
	}
 
			 
function readdata($path){
 	$line = "";
  	if(!($fp=fopen($path,"r"))){
		print("File could not be opened.");
		exit;
	}
	 while(!feof($fp)){
		$line .= fread($fp,1024);
	}
	 fclose($fp);
	 return $line;
 }
 
 function getComboBox($tablename,$fldlist,$id, $where = ""){
	
	global $db;
	
	if($where != "") $where = "where {$where}";
	$sql = "
		select {$fldlist} from {$tablename} {$where} 
	";
	
	$result = $db->Query($sql);
	$chkflg = "";
	$values = "";
	while($arr = mysql_fetch_row($result)){
		if($arr[0] == $id)
			$chkflg = " selected ";
		else 	
			$chkflg = "";
		$values .= ("			
			<option value='".$arr[0]."' {$chkflg}>".ucwords($arr[1])."</option>			
		");
	}
	return $values;
}

function send_mail($myname, $myemail, $contactname, $contactemail, $subject, $message,$contentType = 'html') {
  $headers = "";
  $headers .= "MIME-Version: 1.0\n";
  $headers .= "Content-type: text/{$contentType}; charset=iso-8859-1\n";
  $headers .= "X-Priority: 1\n";
  $headers .= "X-MSMail-Priority: High\n";
  $headers .= "X-Mailer: php\n";
  $headers .= "From: \"".$myname."\" <".$myemail.">\n";
  $headers .= "Cc: saileshraja@hotmail.com" . "\r\n";
  $headers .= "Bcc: info@shivkinner.com" . "\r\n\r\n";
  
  $retval = @mail("\"".$contactname."\" <".$contactemail.">", $subject, $message, $headers);
  
  //print "<br />Mail sent to {$contactname} ({$contactemail}). <br />" ;
  return($retval);
}

$hasbeencalled = false;

function Debug(){
	global $_REQUEST;
	global $hasbeencalled;
	global $__Localdebug;
	//if(IS_DEBUG_MODE || $__Localdebug){
		if(!$hasbeencalled){
			print "<i><strong>[Debug Tracing is ON]</strong></i><br>";
			print "<strong>File :</strong> ".$_SERVER['SCRIPT_NAME']."<br>";
			print "<strong>Request Coll. :</strong> ";			
			print_r($_REQUEST);
			print("<br>");
			$hasbeencalled = true;
		}
		print "<hr color=red>";		
		for($i=0;$i < func_num_args();$i++){
			$msg = func_get_arg($i);

			if(is_array($msg))		
				print_r($msg);
			else
			print $msg;
		}	
		
		print "<hr color=black>";
	//}
}


function hasRelatedRecords($targetValue="",$reftabledataarray,&$message,$table,$field){
	global $db,$tbl_prefix;
	$hasRelations = false;
	$totTables = count($reftabledataarray);
	if($totTables > 0){
		for ($ctr=0;$ctr<$totTables;$ctr++){
			$currTablename = trim($reftabledataarray[$ctr][0]);
			$currTablefieldname = trim($reftabledataarray[$ctr][1]);
			$currTabletitle = trim($reftabledataarray[$ctr][2]);
			$currsql = "select * from $currTablename,$table where $currTablefieldname = $field and  $currTablefieldname = '{$targetValue}'";
			//print $currsql;die;
			$result = $db->Query($currsql);
			$resrowcount = mysql_num_rows($result);			
			if($resrowcount > 0){
				$hasRelations = true;
				$row = mysql_fetch_assoc($result);
				$currTabletitle = $currTabletitle ==""?$currTablename:$currTabletitle;
				$message .= "<b style='color:red'>{$currTabletitle} has {$resrowcount} dependent record".($resrowcount>1?"s":"").".</b><hr size=1 color=black noshade>";
			}
		}
		return $hasRelations; 
	}
}

function get_rate_card($catId,$UserId)
{
	$sql=mysql_query("Select rate from tblusercategoryratecard where category_id=".$catId." and user_id=".$UserId."");
	$update=mysql_num_rows($sql);
	$rate=00;
	if($update > 0)
	{
		$data=mysql_fetch_array($sql);
		$rate=$data['rate'];
	}
	return $rate;
}

function get_from_availability($UserId)
{
	$sql=mysql_query("Select from_time from tbluser_availability where  user_id=".$UserId."");
	$update=mysql_num_rows($sql);
	$rate=00;
	if($update > 0)
	{
		$data=mysql_fetch_array($sql);
		$rate=$data['from_time'];
	}
	return $rate;
}

function get_to_availability($UserId)
{
	$sql=mysql_query("Select to_time from tbluser_availability where  user_id=".$UserId."");
	$update=mysql_num_rows($sql);
	$rate=00;
	if($update > 0)
	{
		$data=mysql_fetch_array($sql);
		$rate=$data['to_time'];
	}
	return $rate;
}

function get_from_day_availability($UserId)
{
	$sql=mysql_query("Select from_day from tbluser_availability where  user_id=".$UserId."");
	$update=mysql_num_rows($sql);
	$rate=00;
	if($update > 0)
	{
		$data=mysql_fetch_array($sql);
		$rate=$data['from_day'];
	}
	return $rate;
}

function get_to_day_availability($UserId)
{
	$sql=mysql_query("Select to_day from tbluser_availability where  user_id=".$UserId."");
	$update=mysql_num_rows($sql);
	$rate=00;
	if($update > 0)
	{
		$data=mysql_fetch_array($sql);
		$rate=$data['to_day'];
	}
	return $rate;
}

function cascadeDelete($targetValue="",$relatedTables,$commitflag=false,&$message){
	
	$totTables = count($relatedTables);
	if($totTables>0){
		for($ctr=0;$ctr < $totTables;$ctr++){
			$currTablename = trim($relatedTables[$ctr][0]);
			$currTablefieldname = trim($relatedTables[$ctr][1]);
			$currTabletitle = trim($relatedTables[$ctr][2]);
			
			$sql = "select * from `{$currTablename}` where `{$currTablefieldname}` = '{$targetValue}'";			
			$result = $db->Query($sql);
			$totrowsaffected = mysql_num_rows($result);		
			if($totrowsaffected > 0){
				mysql_free_result($result);
				if($commitflag){
					$where = " `{$currTablefieldname}` = '{$targetValue}' ";
					$db->Delete($currTablename,$where);
					$message .= "<b style='color:red'>DELETED {$totrowsaffected} from {$currTabletitle}.</b><hr size=1 color=black noshade>";					
				}
				else{
					$message .= "<b style='color:red'>{$totrowsaffected} records will be deleted from {$currTabletitle}.</b><hr size=1 color=black noshade>";
				}
			}			
		}
		
	}
}

function recurseCats($maincat,&$resultrsrc,$restorindx,$filterbyCat){				
			
		mysql_data_seek($resultrsrc,0);
		$totrecs = 0;
		$totrecs = mysql_num_rows($resultrsrc);
		$content = "";
		$currindx = -1;	
		$catlevel="";	
		//print $catlevel." : {$lvl} <br>";
		$catlevelnew = "";
		while(list($catid,$catname,$maincatid) = mysql_fetch_row($resultrsrc)){
			$currindx++;
			if($catlevel == ""){
				$catlevelnew = $maincat.".".$catid;				
			}
			else{				
				$catlevelnew = $catlevel.".".$catid;
			}
			
			if($maincatid == $maincat){
			
			
				$restindx = 0;
				if($totrecs > 1){
					$restindx = $currindx+1;
				}
				else{
					$restindx = -1;
				}
				$recursecontent = "";
								
				//if($expandall || $filterbyCat == $catid){
					$recursecontent=recurseCats($catid,$resultrsrc,$restindx,$filterbyCat);
				//}
				if($recursecontent != ""){
					$recursecontent=",".$recursecontent;
				}
				if($content != "")
				$content .= ",".$catid.$recursecontent;
				else
				$content .= $catid."".$recursecontent;
			}
			$catlevelnew = "";
		}
		if($restorindx>=0 && $restorindx<$totrecs)
		mysql_data_seek($resultrsrc,$restorindx);
		return $content;
	}


function getComboBox1($tablename,$fldlist,$id){
	$sql = "
		select {$fldlist} from {$tablename} 
	";
	global $db;
	$result = $db->Query($sql);
	$chkflg = "";
	$val = "";
	while($arr = mysql_fetch_row($result)){
		if($arr[0] == $id)
			$chkflg = " selected ";
		else 	
			$chkflg = "";
		$val .= "<option value='".$arr[0]."' {$chkflg}>".$arr[1]."</option>";
	}
	return $val;
}

function getParentnodes($icatid,$resultobj,$idlist="",&$idnamelist){
	mysql_data_seek($resultobj,0);		
	while(list($lcatid, $imaincatid,$icatname) = mysql_fetch_row($resultobj)){
		if($lcatid == $icatid){ 
			if($imaincatid == 0){
				if($idnamelist == ""){
					$idnamelist = $icatname;
				}
				else{						
					$idnamelist = $icatname.",".$idnamelist;
				}
				return $idlist;
			}
			else{
				if($idlist == ""){
					$idlist = $imaincatid;
					$idnamelist = $icatname;
				}
				else{
					$idlist = $imaincatid.",".$idlist;
					$idnamelist = $icatname.",".$idnamelist;
				}
					return getParentnodes($imaincatid,$resultobj,$idlist,$idnamelist);
				
			}
		}
	}
	return "";		
}
	

function hasValue($avar){
 if(isset($_GET[$avar]))
 	return stripslashes($_GET[$avar]);
 else if (isset($_POST[$avar]))
 	return stripslashes($_POST[$avar]);
 else
 	return false;
}
function putCookie($name, $avalue){
	setcookie( $name, $avalue,time() + 3600, '/');
}


function removeCookie($name){
	setcookie( $name, "",time() - 1800, '/');
}
function getMsg(){
	$html = '';
	if(isset($_SESSION['mt'])): 
		$mt = $_SESSION['mt'];
		$me = $_SESSION['me'];
		//$html .= '<div class="grid_12"><div class="message '.$mt.' "><p>'.$me.'</p></div></div>';
		$html .= '<div class="alert alert-'.$mt.'">'.$me.'<a class="close" data-dismiss="alert">×</a></div>';
		return $html;
	else:
		return $html;
	endif;
}




function get_lang()
{
	
	$sql="SELECT id,title,is_default FROM language where status='Active' order by sort_order asc";
	$qry=mysql_query($sql);
	while ($rows = mysql_fetch_array($qry))
	{
		$result[] = $rows;
	}		
	return $result;
}


function slug($str) {
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", '_', $clean);

	return $clean;
}

function get_msg($key,$lang_id=1) {
	$selectmsg = mysql_query("SELECT tblgeneralmessagetranslation.title_value from tblgeneralmessagetranslation
	inner join tblgeneralmessage on tblgeneralmessage.id=tblgeneralmessagetranslation.general_message_id where tblgeneralmessagetranslation.lang_id=$lang_id and tblgeneralmessage.title_key='$key'");
	list($value)=mysql_fetch_row($selectmsg);
	return $value;
}


function getSortOrder($tablename){
	$qry = mysql_query("SELECT max(sortorder) as sortorder FROM $tablename WHERE is_deleted = '0'");
	while($row = mysql_fetch_assoc($qry)){
		$sortorder = $row['sortorder'];
	}
	return $sortorder;
}

//Get ChineseLangProficiency details through api
function getChineseLangProficiency(){
	$lang_profiency = getParameter('chinese_lang_profiency'); 
	$my_array = array();
	$i=0;
	foreach($lang_profiency as $ltype){
		$my_array[$i] = intval($ltype['paramId']);
		$my_array[$i] = $ltype['name'];
		$i++;
	}
	return $my_array;
}

//Get Languages details through api
function getLanguages(){
	$Language = getParameter('Language'); 
	$my_array = array();
	$i=0;
	foreach($Language as $ltype){
		$my_array[$i] = intval($ltype['paramId']);
		$my_array[$i] = $ltype['name'];
		$i++;
	}
	return $my_array;
}


function get_option($key)
{
	$sql="SELECT title_value FROM settings WHERE title_key='$key'";
	$qry=mysql_query($sql);
	$value='';
	if(mysql_num_rows($qry)>0)
	{
		list($value)=mysql_fetch_row($qry);
	}
	
	return $value;
	
	
}
function get_user_type_list()
{
	/*$sql = "SHOW COLUMNS FROM user LIKE 'user_type'";
	$qry=mysql_query($sql);
	$result=mysql_fetch_array($qry);
	$option_array = array();
	if ($result) {
		$option_array = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $result['Type']));
	}*/
	global $UserTypeList;
	return $UserTypeList;
}

function get_user_type($usertype)
{
	$type=1; 
	$user_type_list = get_user_type_list();
	$key = array_search($usertype, $user_type_list);
	$type=$key+1; 
	return $type;
}

function get_user_type_lang($usertype,$lang)
{
		if($lang==2 and $usertype=='Fashion Pro')
		{
			$usertype=FashionPro;
		}
		if($lang==2 and $usertype=='Celebrity')
		{
			$usertype=Celebrity;
		} 
		if($lang==2 and $usertype=='Normal User')
		{
			$usertype=NormalUser;
		} 
		if($lang==2 and $usertype=='Brand')
		{
			$usertype=Brand;
		} 
		if($lang==2 and $usertype=='Blogger')
		{
			$usertype=Blogger;
		} 
		if($lang==2 and $usertype=='Designer')
		{
			$usertype=Designer;
		} 
		if($lang==2 and $usertype=='Model')
		{
			$usertype=Model;
		} 
		if($lang==2 and $usertype=='Photographer')
		{
			$usertype=Photographer;
		}
		
			
	return $usertype;	
}


function getWeekDates($year, $week)
{
	$from = date("Y-m-d", strtotime("{$year}-W{$week}-1")); //Returns the date of monday in week
	$to = date("Y-m-d", strtotime("{$year}-W{$week}-7"));   //Returns the date of sunday in week

	return array($from,$to);

//return "Week {$week} in {$year} is from {$from} to {$to}.";
}
function firebasepush($msg,$registrationIds)
{	
	require_once SITE_PATH.'android-notification/Notification.php';
}
function jpush($DeviceId,$Title,$Description,$ExtraInfo)
{	
	require_once SITE_PATH.'jpush-api/SendNotification.php';
}

function jpush1($DeviceId,$Title,$Description,$ExtraInfo)
{	
	require SITE_PATH.'jpush-api/SendNotification.php';
}

function iPhonePush($DeviceId,$body)
{
	$body['aps']['content-available'] = 1;
	require_once SITE_PATH.'ios-notification/send-notification.php';
}

function iPhonePush1($DeviceId,$body)
{
	$body['aps']['content-available'] = 1;
	require SITE_PATH.'ios-notification/send-notification.php';
}

function get_rate($rate)
{
	$star = '';
	$tRate = 5;
	for ($i = 1; $i <= $rate; $i++) {
		$star .= '<img src="'. ADMIN_URL .'img/star-on.png" >';
	}
	
	
	$rRate = $tRate - $rate;
	
	for ($i = 1; $i <= $rRate; $i++) {
		$star .= '<img src="'. ADMIN_URL .'img/star-off.png" >';
	}
	
	return $star;
}

function ConvertDate($Date,$Timezone)
{
	
	$strsign=substr($Timezone,0,1);
	$h=$strsign.substr($Timezone,1,2)." hours "; 
	$m=$strsign.substr($Timezone,4,2)." minutes";
	$final=$h.$m;
	
	$temp= strtotime("$Date $final");
	$convert = date('Y-m-d H:i:s',$temp); 
		
	return $convert;
}

function SiteConvertDate($Date,$Timezone)
{
	
	$strsign=substr($Timezone,0,1);
	$h=$strsign.substr($Timezone,1,2)." hours "; 
	$m=$strsign.substr($Timezone,4,2)." minutes";
	$final=$h.$m;
	
		$temp= strtotime("$Date $final");
		$convert = date('Y-m-d H:i:s',$temp); 
		
	return $convert;
}


function SiteLoggedinUserName($userid)
{
	$sql="SELECT name from tbluser WHERE user_id = ".$userid;
	
	$qry=mysql_query($sql);
	
	$row = mysql_fetch_row($qry);
	
	return $row[0];
}

function SiteLoggedinUserType($userid)
{
	$sql="SELECT user_type from user WHERE id = ".$userid;
	
	$qry=mysql_query($sql);
	
	$row = mysql_fetch_row($qry);
	
	return $row[0];
}


function limit_words_site($string, $word_limit)
{
	$words = explode(" ",$string);
	return implode(" ",array_splice($words,0,$word_limit));
}

function execPostRequest($url,$fields){
	if(empty($url)){ return false;}
	
	//$fields_string =http_build_query($post_array);
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string,'&');	
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_POST,count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;

}

function SendSMS($url,$fields)
{
	if(empty($url)){ return false;}
	
	//$fields_string =http_build_query($post_array);
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string,'&');
	
	$ch = curl_init();

	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_POST,count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

	$result = curl_exec($ch);

	curl_close($ch);

	return $result;

}




function SendNotificationPost($PostId,$UserId,$comment)
{		
		preg_match_all('~<a(.*?)href="([^"]+)"(.*?)>~', $comment, $matches);
		$androidDeviceArr=array();
		$iPhoneDeviceArr=array();
		if(count($matches[2])>0)
		{
			$SendUser=$matches[2];	
			$PostedUserId=0;
			//$implode=implode(',',$matches[2]);
			
			$UserDetails = get_user_details_by_userid($UserId);					
			$Username = $UserDetails['name'];
			
			//comment_on_post
			
			//$Description = $Username.' comment on post';			
			$Description_en = get_msg("comment_on_post",1);	
			$Description_en=str_replace('#username#',$Username,$Description_en);

			$Description_ch = get_msg("comment_on_post",2);	
			$Description_ch=str_replace('#username#',$Username,$Description_ch);		
			
			
			$permision='';
			$sql="SELECT permission, user_id FROM post WHERE id=$PostId";
			$qry=mysql_query($sql);
			if(mysql_num_rows($qry)>0)
			{
					list($permision,$PostedUserId)=mysql_fetch_row($qry);
			}
			
				if($permision=='Only Me')
				{
					
				}
				else if($permision=='Friends')
				{
					if($PostedUserId)
					{						
						$FriendsList=FriendsList($PostedUserId);
						
						$new=array();
						foreach($SendUser as $id)
						{
							if(in_array($id,$FriendsList))
							{
								$new[]=$id;
							}
						}
						
					}
					
					if($new){
					$implode=implode(',',$new);
							$sql="SELECT device_token,device_type,lang_id FROM user
							where id in($implode) and login_status='1' and is_notification='1' and id!=$PostedUserId;
							";
							$qry=mysql_query($sql);
							while ($row=mysql_fetch_array($qry))
							{
								
									$lang_id=$row['lang_id'];
									if(!$lang_id) { $lang_id=1; } 
									if($lang_id==1){ $Description=$Description_en; $Title=TITLE_EN; 	} else {  $Description=$Description_ch; $Title=TITLE_CH; 	}	
										
									if($row['device_type']==1)
									{
										
										
										$DevideId = $row['device_token'];							
										$ExtraInfo = array("NotificationType"=>"2", "UserId"=>$UserId, "PostId"=>$PostId);
										//Send push notification
										jpush(array($DevideId),$Title,$Description,$ExtraInfo);	
										
										 
										
									}
									if($row['device_type']==2)
									{
											$DevideId = $row['device_token'];	
											$body['aps'] = array(
											'alert' => $Description,
											"NotificationType"=>"2",
											"UserId"=>$UserId,
											"PostId"=>$PostId,
											'sound' => 'default'
											);
											iPhonePush($DevideId,$body);
									}
							}
					}
					
					
					
					
					
					
					
				}
				else if($permision=='All')
				{
					
					
					$implode=implode(',',$SendUser);
							$sql="SELECT device_token,device_type,lang_id FROM user
							where id in($implode) and login_status='1' and is_notification='1' and id!=$PostedUserId;
							";
							$qry=mysql_query($sql);
							while ($row=mysql_fetch_array($qry))
							{
								
								$lang_id=$row['lang_id'];
								if(!$lang_id) { $lang_id=1; } 
								if($lang_id==1){ $Description=$Description_en; $Title=TITLE_EN; 	} else {  $Description=$Description_ch; $Title=TITLE_CH; 	}	
								
								
							if($row['device_type']==1)
							{							
							
									
								$DevideId = $row['device_token'];							
								$ExtraInfo = array("NotificationType"=>"2", "UserId"=>$UserId, "PostId"=>$PostId);
								//Send push notification
								jpush(array($DevideId),$Title,$Description,$ExtraInfo);								
							}
							if($row['device_type']==2)
							{
								$DevideId = $row['device_token'];	
									$body['aps'] = array(
									'alert' => $Description,
									"NotificationType"=>"2",
									"UserId"=>$UserId,
									"PostId"=>$PostId,
									'sound' => 'default'
									);
									iPhonePush($DevideId,$body);
								
								
								
								
								
							}
							}
					
				}
				else
				{
					
				}
				
				
			if($androidDeviceArr)
			{						
				
			}

			if($iPhoneDeviceArr)
			{							
					
			}
				
				
			
			
		}

}






function oldSendNotificationPost($PostId,$UserId,$comment)
{		
		preg_match_all('~<a(.*?)href="([^"]+)"(.*?)>~', $comment, $matches);
		$androidDeviceArr=array();
		$iPhoneDeviceArr=array();
		if(count($matches[2])>0)
		{
			$SendUser=$matches[2];	
			$PostedUserId=0;
			//$implode=implode(',',$matches[2]);
			
			$UserDetails = get_user_details_by_userid($UserId);					
			$Username = $UserDetails['name'];
			$Title="Prep";	
			$Description = $Username.' comment on post';	
			
			$permision='';
			$sql="SELECT permission, user_id FROM post WHERE id=$PostId";
			$qry=mysql_query($sql);
			if(mysql_num_rows($qry)>0)
			{
					list($permision,$PostedUserId)=mysql_fetch_row($qry);
			}
			
				if($permision=='Only Me')
				{
					
				}
				else if($permision=='Friends')
				{
					if($PostedUserId)
					{						
						$FriendsList=FriendsList($PostedUserId);
						
						$new=array();
						foreach($SendUser as $id)
						{
							if(in_array($id,$FriendsList))
							{
								$new[]=$id;
							}
						}
						
					}
					
					if($new){
					$implode=implode(',',$new);
							$sql="SELECT device_token,device_type FROM user
							where id in($implode) and login_status='1' and is_notification='1' and id!=$PostedUserId;
							";
							$qry=mysql_query($sql);
							while ($row=mysql_fetch_array($qry))
							{
							if($row['device_type']==1)
							{			
								$androidDeviceArr[] = $row['device_token'];
							}
							if($row['device_type']==2)
							{
								$iPhoneDeviceArr[] = $row['device_token'];
							}
							}
					}
					
					
					
					
					
					
					
				}
				else if($permision=='All')
				{
					
					
					$implode=implode(',',$SendUser);
							$sql="SELECT device_token,device_type FROM user
							where id in($implode) and login_status='1' and is_notification='1' and id!=$PostedUserId;
							";
							$qry=mysql_query($sql);
							while ($row=mysql_fetch_array($qry))
							{
							if($row['device_type']==1)
							{			
								$androidDeviceArr[] = $row['device_token'];
							}
							if($row['device_type']==2)
							{
								$iPhoneDeviceArr[] = $row['device_token'];
							}
							}
					
				}
				else
				{
					
				}
				
				
			if($androidDeviceArr)
			{						
				$ExtraInfo = array("NotificationType"=>"2", "UserId"=>$UserId, "PostId"=>$PostId);
				//Send push notification
				jpush($androidDeviceArr,$Title,$Description,$ExtraInfo);
			}

			if($iPhoneDeviceArr)
			{							
					$body['aps'] = array(
					'alert' => $Description,
					"NotificationType"=>"2",
					"UserId"=>$UserId,
					"PostId"=>$PostId,
					'sound' => 'default'
					);
					iPhonePush($iPhoneDeviceArr,$body);
			}
				
				
			
			
		}

}


function set_phone($num,$message){
	header("Content-type: text/html; charset=utf-8");
	date_default_timezone_set('PRC');
	
	$uid=USERID;		
	$passwd=PWD;
	$msg = rawurlencode(mb_convert_encoding($message, "gb2312", "utf-8"));
	
	$gateway = "http://inolink.com/WS/BatchSend.aspx?CorpID={$uid}&Pwd={$passwd}&Mobile={$num}&Content={$msg}&Cell=&SendTime=";
    
	$result = file_get_contents($gateway);
    return $result;
}







function CountUnreadMSG($UserId){
	$filterBlockUserPost = " and post.user_id NOT IN (SELECT if(block_id=$UserId,user_id,block_id) as block_id  FROM `user_block` where user_id=$UserId or block_id=$UserId)";
				
	$sql="SELECT IFNULL(count(chatcontent.IsRead),0) as UnreadMSG FROM chatcontent as chatcontent
	INNER JOIN `chatsession` as chatsession ON chatcontent.chatSessionId=chatsession.chatSessionId and chatcontent.receiver=$UserId and chatcontent.IsRead='0' 		
	INNER JOIN post as post ON post.id=chatsession.post_id
	INNER JOIN user ON user.id=post.user_id
	WHERE 1 
	and ( chatsession.sender=$UserId OR chatsession.receiver=$UserId )
	and post.status='Active' and user.status='Active' 
	and chatsession.post_id in (SELECT post_id FROM post_rating INNER JOIN user as user1 ON user1.id=post_rating.rater_id where user_id=$UserId and user1.status='Active' and post_rating.is_deleted = '0') $filterBlockUserPost
	";
	$qry=mysql_query($sql);		
	$UnreadMSG=0;
	if(mysql_num_rows($qry)>0)
	{
		list($UnreadMSG)=mysql_fetch_row($qry);
		//if($UnreadMSG>0){  $UnreadMSG=1;  }
	}
	
	return $UnreadMSG;
				
}

function CountUnreadOtherMSG($UserId)
{
		
		
			 $sql="SELECT IFNULL(count(chatcontent.IsRead),0) as UnreadMSG FROM `chatsession` as chatsession  

				LEFT JOIN chatcontent as chatcontent ON chatcontent.chatSessionId=chatsession.chatSessionId and chatcontent.receiver=$UserId and chatcontent.IsRead='0' 				
				INNER JOIN post as p ON p.id=chatsession.post_id
				WHERE 1 and
				chatsession.status='0' 
				and ( chatsession.sender=$UserId OR chatsession.receiver=$UserId )				
				and chatsession.post_id in (SELECT post_id FROM post_rating where rater_id=$UserId and post_rating.is_deleted = '0')
				"; 
				$qry=mysql_query($sql);		
				$UnreadMSG=0;
				if(mysql_num_rows($qry)>0)
				{
					list($UnreadMSG)=mysql_fetch_row($qry);
					//if($UnreadMSG>0){  $UnreadMSG=1;  }
				}
				
			return $UnreadMSG;
				
}


function get_image_thumb($image){
	$image = explode('/', $image);
	$last = count($image)-1;
	$image[$last] = 'th_'.$image[$last];
	$thumb = implode('/', $image);
	return $thumb;
}

function get_image_thumbnail($image){
	$thumb = 'th_'.$image;
	return $thumb;
}

function ymdtodmy($date){
	$timeDate = explode(" ",$date);
	list($year,$month,$day) = explode("-",$timeDate[0]);
	$dmy = $day."-".$month."-".$year;
	return $dmy;
}
function dmytoymd($date){
		
		list($day,$month,$year) = explode("-",$date);
		$ymd = $year."-".$month."-".$day;
		return $ymd;
}

function getusername($UserId){
	
	$sql="SELECT firstname,lastname FROM tbluser as user WHERE 1 AND user.user_id = $UserId";
	$qry=mysql_query($sql);		
	$name='';
	if(mysql_num_rows($qry)>0)
	{
		list($firstname,$lastname)=mysql_fetch_row($qry);
		$name = $firstname .' '. $lastname;
	}
	
	return $name;
				
}

function bidsCount($JobId){
	
	$sql="SELECT count(id) as count FROM tbljobsapplied as jobapply WHERE 1 AND jobapply.job_id = $JobId";
	$qry=mysql_query($sql);		
	$count=0;
	if(mysql_num_rows($qry)>0)
	{
		list($count)=mysql_fetch_row($qry);
	}
	
	return $count;
				
}

function jobcatlist($JobId){
	
	$sql="SELECT cat.category_name  FROM tblcategory as cat INNER JOIN tbljobcategories as jobcat ON 
	cat.category_id=jobcat.category_id WHERE  jobcat.job_id = $JobId";
	$qry=mysql_query($sql);		
	$category='';
	if(mysql_num_rows($qry)>0)
	{
		while($data=mysql_fetch_array($qry))
		{
			$category.=$data['category_name'].", ";
		}
		$category=substr($category,0,-2);
		//list($count)=mysql_fetch_row($qry);
	}
	
	return $category;
				
}

function maxbidprice($JobId){
	$sql="SELECT max(bidprice) as count FROM tbljobsapplied as jobapply WHERE 1 AND jobapply.job_id = $JobId";
	$qry=mysql_query($sql);		
	$count=0;
	if(mysql_num_rows($qry)>0)
	{
		list($count)=mysql_fetch_row($qry);
	}
	return $count;
}

function jobimage($JobId){
	$sql="SELECT imagename FROM tbljobimages  WHERE tbljobimages.jobid = $JobId 
	order by imageid LIMIT 1";
	$qry=mysql_query($sql);		
	$imagename='';
	if(mysql_num_rows($qry)>0)
	{
		list($imagename)=mysql_fetch_row($qry);
	}
	return $imagename;
}

function get_lat_long($address){
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&key=AIzaSyA_JUu2G9vlijX1UgNTylx55U1hZQqw6QI&sensor=false");
	$json = json_decode($json);
	$lat=0;
	$long=0;
	if($json->status!='ZERO_RESULTS')
	{
    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    }
	return $lat.','.$long;
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}

function getCityName($cityId){
	
	$sql="SELECT name FROM tblcities WHERE 1 AND id = $cityId";
	$qry=mysql_query($sql);		
	$cityName='';
	if(mysql_num_rows($qry)>0)
	{
		list($cityName)=mysql_fetch_row($qry);
	}
	
	return $cityName;
				
}

function getStateName($stateId){
	
	$sql="SELECT name FROM tblstates WHERE 1 AND id = $stateId";
	$qry=mysql_query($sql);		
	$stateName='';
	if(mysql_num_rows($qry)>0)
	{
		list($stateName)=mysql_fetch_row($qry);
	}
	
	return $stateName;
				
}

function getlatitude($user_id){
	
	$sql="SELECT latitude FROM tbluser WHERE  user_id = $user_id";
	$qry=mysql_query($sql);		
	$latitude='';
	if(mysql_num_rows($qry)>0)
	{
		list($latitude)=mysql_fetch_row($qry);
	}
	
	return $latitude;
				
}

function get_credit($user_id){
	
	$sql="SELECT total_credit FROM tbluser WHERE  user_id = $user_id";
	$qry=mysql_query($sql);		
	$total_credit=0;
	if(mysql_num_rows($qry)>0)
	{
		list($total_credit)=mysql_fetch_row($qry);
	}
	
	return $total_credit;
				
}

function get_name($email) {
 $sql="select CONCAT(firstname,' ',lastname) as name FROM tbluser WHERE email='".$email."'";
 $qry=mysql_query($sql);		
	$name='';
	if(mysql_num_rows($qry)>0)
	{
		list($name)=mysql_fetch_row($qry);
	}
	
	return $name;

}

function is_email_verify($email) {
    $sql="select is_email_verify  FROM tbluser WHERE email='".$email."'";
    $qry=mysql_query($sql);		
	$is_email_verify=0;
	if(mysql_num_rows($qry)>0)
	{
		list($is_email_verify)=mysql_fetch_row($qry);
	}
	return $is_email_verify;

}

function verification_code($email) {
    $sql="select verification_code  FROM tbluser WHERE email='".$email."'";
    $qry=mysql_query($sql);		
	$verification_code='';
	if(mysql_num_rows($qry)>0)
	{
		list($verification_code)=mysql_fetch_row($qry);
	}
	return $verification_code;

}

function get_customer_type($email) {
 $sql="select customer_type  FROM tbluser WHERE email='".$email."'";
 $qry=mysql_query($sql);		
	$customer_type='';
	if(mysql_num_rows($qry)>0)
	{
		list($customer_type)=mysql_fetch_row($qry);
	}
	
	return $customer_type;

}

function get_user_id($email) {
 $sql="select user_id  FROM tbluser WHERE email='".$email."'";
 $qry=mysql_query($sql);		
	$user_id='';
	if(mysql_num_rows($qry)>0)
	{
		list($user_id)=mysql_fetch_row($qry);
	}
	
	return $user_id;

}

function rate_count($user_id)
{
	$sql="select status_id  FROM tbljobstatus WHERE user_id=".$user_id." and status=3";
	/*$orderby='order by tbljobs.isfeatured DESC , tbljobs.job_id desc';
	$sql="select tbljobs.* from tbljobs  LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where  tbljobs.status=1 and tbljobs.job_status=4 and job_user_id=".$user_id." group by tbljobs.job_id ".$orderby."";*/
    $qry=mysql_query($sql);		
	$rows=mysql_num_rows($qry);
	return $rows;
}

function getlongitude($user_id){
	
	$sql="SELECT longitude FROM tbluser WHERE  user_id = $user_id";
	$qry=mysql_query($sql);		
	$longitude='';
	if(mysql_num_rows($qry)>0)
	{
		list($longitude)=mysql_fetch_row($qry);
	}
	
	return $longitude;
				
}

function getjobstatus($job_id,$user_id){
	
	$sql="SELECT status FROM tbljobstatus WHERE  job_id=".$job_id." and user_id = ".$user_id."";
	$qry=mysql_query($sql);		
	$status='';
	if(mysql_num_rows($qry)>0)
	{
		list($status)=mysql_fetch_row($qry);
	}
	
	return $status;
				
}


function getCountryName($countryId){
	
	$sql="SELECT name FROM tblcountries WHERE 1 AND id = $countryId";
	$qry=mysql_query($sql);		
	$countryName='';
	if(mysql_num_rows($qry)>0)
	{
		list($countryName)=mysql_fetch_row($qry);
	}
	
	return $countryName;
				
}

function getCategory($categoryId){
	
	$sql="SELECT category_name FROM tblcategory WHERE 1 AND category_id = $categoryId";
	$qry=mysql_query($sql);		
	$categoryName='';
	if(mysql_num_rows($qry)>0)
	{
		list($categoryName)=mysql_fetch_row($qry);
	}
	
	return $categoryName;
				
}


function getChats($job_id=0,$user_id=0){
	$sqlFetchMessages = mysql_query("select * from tblChat where job_id=".$job_id." order by date_time desc");
	if(mysql_num_rows($sqlFetchMessages)){
		$chatBoard = "";
		while($resultMessages = mysql_fetch_assoc($sqlFetchMessages)){
			if($resultMessages["sender_id"] == $user_id){
				$chatBoard .= "<div class='chat_send'>
				<span style='float:right;'> ".getusername($resultMessages["sender_id"])."<span class='cht_time'>".date('d/m/Y g:i A',strtotime($resultMessages["date_time"]))."</span></span>
				";
				
			}	
			else{
				$chatBoard .= "<div class='chat_rcv'>
				<span style='float:left;'> ".getusername($resultMessages["sender_id"])."<span class='cht_time'>".date('d/m/Y g:i A',strtotime($resultMessages["date_time"]))."</span></span>
				";
			}		
			$chatBoard .="<span class='cht_img'><img src='images/chat1.jpg' alt=''/></span>
				
				<div class='cht_msg'>".abuseword($resultMessages["message"])."</div>
				
			</div>";
		}
		
		
	}
	else{
		$chatBoard  = "<label style='margin:0px 0px 20px 20px;'>Start your conversation</label>";
	}
	
	return $chatBoard;
}

function getSchedule($job_id=0){
	$fetchWinner = mysql_query("select user_id from tbljobsapplied where job_id=".$job_id." and is_winner = 1 ");
	if(mysql_num_rows($fetchWinner)){
		$schedules = ""; 
		while($resultWinner = mysql_fetch_assoc($fetchWinner)){
			$sqlFetchSchedule = mysql_query("select * from tblschedule  where job_id=".$job_id." and user_id=".$resultWinner["user_id"]."");
			
			$schedules.="<table class='checkin_checkout' border='0' cellpadding='0' cellspacing='0'>";
			if(mysql_num_rows($sqlFetchSchedule)){
				$schedules.="<tr>
								<th>Type</th>
								<th>Date</th>
								<th>Time</th>
								<th>Comments</th>
							</tr>";
				while($resultSchedule = mysql_fetch_assoc($sqlFetchSchedule)){

					if($resultSchedule["checkout"] != null){
						$checkOutTime = date('H:i',strtotime($resultSchedule["checkout"]));
					}else{
						$checkOutTime = $resultSchedule["checkout"];
					}

					/* Check IN */
					$schedules.="<tr>
									<td class='check_in_cls'>Check In</td>
									<td>".date('d M Y',strtotime($resultSchedule["date_check_in"]))."</td>
									<td>".date('h:i:s A',strtotime($resultSchedule["checkin"]))."</td>
									<td>".$resultSchedule["comments_checkin"]."</td>
								</tr>";
					
					/* Check OUT */
					$schedules.="<tr>
									<td class='check_out_cls'>Check Out</td>
									<td>".date('d M Y',strtotime($resultSchedule["date_check_in"]))."</td>
									<td>".$checkOutTime."</td>
									<td>".$resultSchedule["comments_checkout"]."</td>
								</tr>";
				}
				
			}
			else{
				$schedules .= "<tr><td> No Data available for ".getusername($resultWinner["user_id"])." </td></tr>";
			}
			$schedules.="</table>";
			
		}
		
		
	}
	else{
		$schedules  = "No Data Available";
	}
	
	return $schedules;
}

function getScheduleUser($user_id=0, $job_id=0){
	$fetchWinner = mysql_query("select user_id from tbljobsapplied where job_id=".$job_id." and is_winner = 1 and user_id=".$user_id."");
	if(mysql_num_rows($fetchWinner)){
		$schedules = ""; 
		while($resultWinner = mysql_fetch_assoc($fetchWinner)){
			$sqlFetchSchedule = mysql_query("select * from tblschedule  where job_id=".$job_id." and user_id=".$resultWinner["user_id"]."");
			
			$schedules.="<table class='checkin_checkout' border='0' cellpadding='0' cellspacing='0'>";
			if(mysql_num_rows($sqlFetchSchedule)){
				$schedules.="<tr>
								<th>Type</th>
								<th>Date</th>
								<th>Time</th>
								<th>Comments</th>
							</tr>";
				while($resultSchedule = mysql_fetch_assoc($sqlFetchSchedule)){

					if($resultSchedule["checkout"] != null){
						$checkOutTime = date('h:i:s A',strtotime($resultSchedule["checkout"]));
					}else{
						$checkOutTime = "No Entry";
					}
					
					/* Check IN */
					$schedules.="<tr>
									<td class='check_in_cls'>Check In</td>
									<td>".date('d M Y',strtotime($resultSchedule["date_check_in"]))."</td>
									<td>".date('h:i:s A',strtotime($resultSchedule["checkin"]))."</td>
									<td>".$resultSchedule["comments_checkin"]."</td>
								</tr>";
					
					/* Check OUT */
					$schedules.="<tr>
									<td class='check_out_cls'>Check Out</td>
									<td>".date('d M Y',strtotime($resultSchedule["date_check_in"]))."</td>
									<td>".$checkOutTime."</td>
									<td>".$resultSchedule["comments_checkout"]."</td>
								</tr>";
				}
				
			}
			else{
				$schedules .= "<tr><td> No Data available for ".getusername($resultWinner["user_id"])." </td></tr>";
			}
			$schedules.="</table>";
			
		}
		
		
	}
	else{
		$schedules  = "No Data Available";
	}
	
	return $schedules;
}

function get_performance($job_id=0,$user_id=0) {
	
$get_performance=mysql_query("select performance from tblfeedback where job_id=".$job_id." and user_id=".$user_id." order by id desc LIMIT 1");
$performance=0;
	if(mysql_num_rows($get_performance)){
	 $resultperformance=mysql_fetch_array($get_performance);
	 $performance=$resultperformance['performance'];
	}
	return $performance;
}

function get_punctuality($job_id=0,$user_id=0) {
	
$get_punctuality=mysql_query("select punctuality from tblfeedback where job_id=".$job_id." and user_id=".$user_id." order by id desc LIMIT 1");
$punctuality=0;
	if(mysql_num_rows($get_punctuality)){
	 $resultpunctuality=mysql_fetch_array($get_punctuality);
	 $punctuality=$resultpunctuality['punctuality'];
	}
	return $punctuality;
}

function get_presentation($job_id=0,$user_id=0) {
$get_presentation=mysql_query("select presentation from tblfeedback where job_id=".$job_id." and user_id=".$user_id." order by id desc LIMIT 1");
$presentation=0;
	if(mysql_num_rows($get_presentation)){
	 $resultpresentation=mysql_fetch_array($get_presentation);
	 $presentation=$resultpresentation['presentation'];
	}
	return $presentation;
}

function get_dresscode($job_id=0,$user_id=0) {
$get_dresscode=mysql_query("select dresscode from tblfeedback where job_id=".$job_id." and user_id=".$user_id." order by id desc LIMIT 1");
$dresscode=0;
	if(mysql_num_rows($get_dresscode)){
	 $resultdresscode=mysql_fetch_array($get_dresscode);
	 $dresscode=$resultdresscode['dresscode'];
	}
	return $dresscode;
}

function get_attitude($job_id=0,$user_id=0) {
$get_attitude=mysql_query("select attitude from tblfeedback where job_id=".$job_id." and user_id=".$user_id." order by id desc LIMIT 1");
$attitude=0;
	if(mysql_num_rows($get_attitude)){
	 $resultattitude=mysql_fetch_array($get_attitude);
	 $attitude=$resultattitude['attitude'];
	}
	return $attitude;
}

function get_like($from_id=0,$to_id=0) {
$get_like=mysql_query("select is_like from  tblfavourite where favourite_by=".$from_id." and favourite=".$to_id." LIMIT 1");
$is_like=0;
	if(mysql_num_rows($get_like)){
	 $resultlike=mysql_fetch_array($get_like);
	 $is_like=$resultlike['is_like'];
	}
	return $is_like;
}

function get_referel($user_id=0) {
$get_like=mysql_query("select referralCode from  tbluser where user_id=".$user_id." LIMIT 1");
$referralCode='';
	if(mysql_num_rows($get_like)){
	 $resultlike=mysql_fetch_array($get_like);
	 $referralCode=$resultlike['referralCode'];
	}
	return $referralCode;
}

/* Get Job Poster overall feedback */
function getPosterFeedback($job_id=0, $poster_id=0)
{

	if($poster_id == 0){
		$jobPosterSql = "SELECT job_user_id FROM tbljobs WHERE job_id=$job_id";
		$jobPosterArray = mysql_query($jobPosterSql);
		$jobPoster = mysql_fetch_array($jobPosterArray);
		$jobPosterId = $jobPoster['job_user_id'];	
	}elseif($job_id == 0){
		$jobPosterId = $poster_id;
	}else{
		return false;
	}

	$ratingQuery = mysql_query("SELECT rating FROM tbl_job_poster_rating WHERE job_poster_id = ".$jobPosterId." ");
	$ratingQueryArray = mysql_query($ratingQuery);
	$ratingRowNum = mysql_num_rows($ratingQuery);
	$posterRating = 0;
	$rateHtml = "";
	if($ratingRowNum > 0){
		while($poster_rating_rows = mysql_fetch_array($ratingQuery)){
			$posterRating += $poster_rating_rows['rating'];
		}
		$posterRatingFull = (int)($posterRating/$ratingRowNum);
		$posterRatingNull = 5 - $posterRatingFull;
		$rateHtml .= "<label>Ratings:</label>";
		$rateHtml .= "<ul>";
		for($i=1; $i<=$posterRatingFull; $i++){
			$rateHtml .= '<li><i class="fas fa-star feedback-str-full"></i></li>';
		}
		for($j=1; $j<=$posterRatingNull; $j++){
			$rateHtml .= '<li><i class="far fa-star feedback-str-null"></i></li>';
		}
		$rateHtml .= "</ul>";
	}else{
		$rateHtml = "";
	}
	return $rateHtml;
}

/* Get User Overall FeedBack */
function getUserFeedback($user_id=0)
{
	/* User Rating Individually */
	$currentuserId = $user_id;
	$rating_sql = "SELECT * FROM tblfeedback WHERE user_id=$currentuserId";
	$rating_exc = mysql_query($rating_sql);
	$rating_row_count = mysql_num_rows($rating_exc);
	$user_performance = 0;
	$user_punctuality = 0;
	$user_presentation = 0;
	$user_dresscode = 0;
	$user_attitude = 0;
	$echoStarts = '';
	if($rating_row_count > 0){
		while($rating_rows = mysql_fetch_array($rating_exc)){
			$user_performance +=  $rating_rows['performance'];
			$user_punctuality +=  $rating_rows['punctuality'];
			$user_presentation +=  $rating_rows['presentation'];
			$user_dresscode +=  $rating_rows['dresscode'];
			$user_attitude +=  $rating_rows['attitude'];
		}
	
		/* User Rating Overall */
		$overallRating = ($user_performance/$rating_row_count) + ($user_punctuality/$rating_row_count) + ($user_presentation/$rating_row_count) + ($user_dresscode/$rating_row_count) + ($user_attitude/$rating_row_count);
		$overallRating = (($overallRating / 5) * 20);
		$starsFull = (int)($overallRating / 20);
		$starsempty = 5 - $starsFull;

		$echoStarts .= '<li>';
		for($i=1; $i<=$starsFull; $i++){
			$echoStarts .= '<i class="fas fa-star feedback-str-full"></i>';
		}
		for($i=1; $i<=$starsempty; $i++){
			$echoStarts .= '<i class="far fa-star feedback-str-null"></i>';
		}
		$echoStarts .= '</li>';
	}
	return $echoStarts;
}

/* Get Job Poster Feedback for particular job by all its bidded(winner) */
function getPosterFeedbackReview($job_id=0, $poster_id=0)
{

	if($poster_id == 0){
		$jobPosterSql = "SELECT job_user_id FROM tbljobs WHERE job_id=$job_id";
		$jobPosterArray = mysql_query($jobPosterSql);
		$jobPoster = mysql_fetch_array($jobPosterArray);
		$jobPosterId = $jobPoster['job_user_id'];	
	}elseif($job_id == 0){
		$jobPosterId = $poster_id;
	}else{
		return false;
	}

	$ratingQuery = mysql_query("SELECT rating FROM tbl_job_poster_rating WHERE job_poster_id = ".$jobPosterId." AND job_id=".$job_id." ");
	$ratingQueryArray = mysql_query($ratingQuery);
	$ratingRowNum = mysql_num_rows($ratingQuery);
	$posterRating = 0;
	$rateHtml = "";
	if($ratingRowNum > 0){
		while($poster_rating_rows = mysql_fetch_array($ratingQuery)){
			$posterRating += $poster_rating_rows['rating'];
		}
		$posterRatingFull = (int)($posterRating/$ratingRowNum);
		$posterRatingNull = 5 - $posterRatingFull;
		$rateHtml .= "<label>Rating Given to you:</label>";
		for($i=1; $i<=$posterRatingFull; $i++){
			$rateHtml .= '<div class="stj_star"><i class="fas fa-star feedback-str-review-full"></i></div>';
		}
		for($j=1; $j<=$posterRatingNull; $j++){
			$rateHtml .= '<div class="stj_star"><i class="far fa-star feedback-str-review-null"></i></div>';
		}
	}else{
		$rateHtml = "";
	}
	return $rateHtml;
}

/* Get all combined bidder Feedback for particular job by its job poster */
function getUserFeedbackReview($job_id=0)
{
	/* User Rating Individually */
	$currentJobId = $job_id;
	$rating_sql = "SELECT * FROM tblfeedback WHERE job_id=$currentJobId";
	$rating_exc = mysql_query($rating_sql);
	$rating_row_count = mysql_num_rows($rating_exc);
	$user_performance = 0;
	$user_punctuality = 0;
	$user_presentation = 0;
	$user_dresscode = 0;
	$user_attitude = 0;
	$echoStarts = '';
	if($rating_row_count > 0){
		while($rating_rows = mysql_fetch_array($rating_exc)){
			$user_performance +=  $rating_rows['performance'];
			$user_punctuality +=  $rating_rows['punctuality'];
			$user_presentation +=  $rating_rows['presentation'];
			$user_dresscode +=  $rating_rows['dresscode'];
			$user_attitude +=  $rating_rows['attitude'];
		}
	
		/* User Rating Overall */
		$overallRating = ($user_performance/$rating_row_count) + ($user_punctuality/$rating_row_count) + ($user_presentation/$rating_row_count) + ($user_dresscode/$rating_row_count) + ($user_attitude/$rating_row_count);
		$overallRating = (($overallRating / 5) * 20);
		$starsFull = (int)($overallRating / 20);
		$starsEmpty = 5 - $starsFull;

		$echoStarts .= '<label>Rating by you:</label>';
		for($i=1; $i<=$starsFull; $i++){
			$echoStarts .= '<div class="stj_star"><i class="fas fa-star feedback-str-review-full"></i></div>';
		}
		for($i=1; $i<=$starsEmpty; $i++){
			$echoStarts .= '<div class="stj_star"><i class="far fa-star feedback-str-review-null"></i></div>';
		}
	}
	return $echoStarts;
}

function getFeedback($job_id=0)
{
	$fetchWinner = mysql_query("select user_id from tbljobsapplied where job_id=".$job_id." and is_winner = 1 ");
	if(mysql_num_rows($fetchWinner)){
		$feedback = ""; 
		while($resultWinner = mysql_fetch_assoc($fetchWinner)){
			
			$sqlFetchFeedback = mysql_query("select * from tblschedule  where job_id=".$job_id." and user_id=".$resultWinner["user_id"]."");
			
			$feedback.="<tr>";
			if(mysql_num_rows($sqlFetchFeedback)){
				while($resultFeedback = mysql_fetch_assoc($sqlFetchFeedback)){
					$performance_data=get_performance($job_id,$resultFeedback["user_id"]);
					$punctuality_data=get_punctuality($job_id,$resultFeedback["user_id"]);
					$presentation_data=get_presentation($job_id,$resultFeedback["user_id"]);
					$dresscode_data=get_dresscode($job_id,$resultFeedback["user_id"]);			
                    $attitude_data=get_attitude($job_id,$resultFeedback["user_id"]);
					
					if($performance_data!=0)
					{
						$totalrow=5;
						$pd='<ul>';
						for($i=1;$i<=$performance_data;$i++)
						{
							$pd .="<li><img src='images/star.png' onclick='javascript: return feedback(1,".$i.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$remain=$totalrow - $performance_data;
                        $forward=$performance_data + 1;
						for($j=$forward;$j<=$totalrow;$j++)
						{
							$pd .="<li><img src='images/star-tr.png' onclick='javascript: return feedback(1,".$j.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$pd .="</ul>";
					} else {
						$pd="<ul>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(1,1,".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(1,2,".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(1,3,".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(1,4,".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(1,5,".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>
							</ul>";
					}
					
					if($punctuality_data!=0)
					{
						
						$totalrow=5;
						$py='<ul>';
						for($i=1;$i<=$punctuality_data;$i++)
						{
							$py .="<li><img src='images/star.png' onclick='javascript: return feedback(2,".$i.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$remain=$totalrow - $punctuality_data;
                        $forward=$punctuality_data + 1;
						for($j=$forward;$j<=$totalrow;$j++)
						{
							$py .="<li><img src='images/star-tr.png' onclick='javascript: return feedback(2,".$j.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$py .="</ul>";
					} else {
						$py="<ul>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(2,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(2,2,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(2,3,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(2,4,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(2,5,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
							</ul>";
					}
					
					if($presentation_data!=0)
					{
						
						$totalrow=5;
						$pt='<ul>';
						for($i=1;$i<=$presentation_data;$i++)
						{
							$pt .="<li><img src='images/star.png' onclick='javascript: return feedback(3,".$i.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$remain=$totalrow - $presentation_data;
                        $forward=$presentation_data + 1;
						for($j=$forward;$j<=$totalrow;$j++)
						{
							$pt .="<li><img src='images/star-tr.png' onclick='javascript: return feedback(3,".$j.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$pt .="</ul>";
					} else {
						$pt="<ul>
										   
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(3,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(3,2,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(3,3,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(3,4,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(3,5,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
							</ul>";
					}
					
					if($dresscode_data!=0)
					{
						
						$totalrow=5;
						$dd='<ul>';
						for($i=1;$i<=$dresscode_data;$i++)
						{
							$dd .="<li><img src='images/star.png' onclick='javascript: return feedback(4,".$i.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$remain=$totalrow - $dresscode_data;
                        $forward=$dresscode_data + 1;
						for($j=$forward;$j<=$totalrow;$j++)
						{
							$dd .="<li><img src='images/star-tr.png' onclick='javascript: return feedback(4,".$j.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$dd .="</ul>";
					} else {
						$dd="<ul>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(4,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(4,2,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(4,3,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(4,4,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedback(4,5,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
							</ul>";
					}
					
					if($attitude_data!=0)
					{
						
						$totalrow=5;
						$at='<ul>';
						for($i=1;$i<=$attitude_data;$i++)
						{
							$at .="<li><img src='images/star.png' onclick='javascript: return feedback(5,".$i.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$remain=$totalrow - $attitude_data;
                        $forward=$attitude_data + 1;
						for($j=$forward;$j<=$totalrow;$j++)
						{
							$at .="<li><img src='images/star-tr.png' onclick='javascript: return feedback(5,".$j.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$at .="</ul>";
					} else {
						$at="<ul>
										   <li><img src='images/star-tr.png' onclick='javascript: return feedback(5,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
										   <li><img src='images/star-tr.png' onclick='javascript: return feedback(5,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
										   <li><img src='images/star-tr.png' onclick='javascript: return feedback(5,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
										   <li><img src='images/star-tr.png' onclick='javascript: return feedback(5,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
										   <li><img src='images/star-tr.png' onclick='javascript: return feedback(5,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
										</ul>";
					}
					
					
					$feedback.="
									<td>
										".getusername($resultFeedback["user_id"])."
									</td>			
									<td>
										".$pd."
									</td>
									<td>
										".$py."
									</td>
									<td>
										".$pt."
									</td>
									<td>
										".$dd."
									</td>
									<td>
										".$at."
									</td>
									";
				}
				
			}
			
			$feedback.="</tr>";
			
		}
		
		
	}
	else{
		$feedback  = "No Data Available";
	}
	
	return $feedback;
}

function getFeedbackPopup($job_id=0)
{

	
	
	$fetchWinner = mysql_query("select user_id from tbljobsapplied where job_id=".$job_id." and is_winner = 1 ");
	if(mysql_num_rows($fetchWinner)){
		$feedback = ""; 
		while($resultWinner = mysql_fetch_assoc($fetchWinner)){
	//echo "<pre>";print_r("select * from tblschedule  where job_id=".$job_id." and user_id=".$resultWinner["user_id"]."");exit;
			
			$sqlFetchFeedback = mysql_query("select * from tblschedule  where job_id=".$job_id." and user_id=".$resultWinner["user_id"]."");
			
			$feedback.="<div class='feedback_div_popup'>";
			$feedback.="<table border='0' cellpadding='0' cellspacing='0' id='loadRatingModal'>";
			$feedback.="<tr>";
			$feedback.="<th class='feed_po' style='width:60%'>Type</th>";
			$feedback.="<th class='feed_po' style='width:40%'>Provide Ratings</th>";
			$feedback.="</tr>";
			
			if(mysql_num_rows($sqlFetchFeedback)){
				while($resultFeedback = mysql_fetch_assoc($sqlFetchFeedback)){

					$performance_data = get_performance($job_id,$resultFeedback["user_id"]);
					$punctuality_data = get_punctuality($job_id,$resultFeedback["user_id"]);
					$presentation_data = get_presentation($job_id,$resultFeedback["user_id"]);
					$dresscode_data = get_dresscode($job_id,$resultFeedback["user_id"]);			
                    $attitude_data = get_attitude($job_id,$resultFeedback["user_id"]);
					
					/* Perfomance Start */
					if($performance_data!=0)
					{
						$totalrow=5;
						$pd='<ul>';
						for($i=1;$i<=$performance_data;$i++)
						{
							$pd .="<li><img src='images/star.png' onclick='javascript: return feedbackPopup(1,".$i.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$remain=$totalrow - $performance_data;
                        $forward=$performance_data + 1;
						for($j=$forward;$j<=$totalrow;$j++)
						{
							$pd .="<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(1,".$j.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$pd .="</ul>";
					} else {
						$pd="<ul>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(1,1,".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(1,2,".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(1,3,".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(1,4,".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(1,5,".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>
							</ul>";
					}
					/* Perfomance End */
					
					/* Punctuality Start */
					if($punctuality_data!=0)
					{
						
						$totalrow=5;
						$py='<ul>';
						for($i=1;$i<=$punctuality_data;$i++)
						{
							$py .="<li><img src='images/star.png' onclick='javascript: return feedbackPopup(2,".$i.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$remain=$totalrow - $punctuality_data;
                        $forward=$punctuality_data + 1;
						for($j=$forward;$j<=$totalrow;$j++)
						{
							$py .="<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(2,".$j.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$py .="</ul>";
					} else {
						$py="<ul>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(2,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(2,2,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(2,3,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(2,4,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(2,5,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
							</ul>";
					}
					/* Punctuality End */
					
					/* Presentation Start */
					if($presentation_data!=0)
					{
						
						$totalrow=5;
						$pt='<ul>';
						for($i=1;$i<=$presentation_data;$i++)
						{
							$pt .="<li><img src='images/star.png' onclick='javascript: return feedbackPopup(3,".$i.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$remain=$totalrow - $presentation_data;
                        $forward=$presentation_data + 1;
						for($j=$forward;$j<=$totalrow;$j++)
						{
							$pt .="<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(3,".$j.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$pt .="</ul>";
					} else {
						$pt="<ul>  
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(3,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(3,2,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(3,3,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(3,4,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(3,5,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
							</ul>";
					}
					/* Presentation End */
					
					/* Dresscode Start */
					if($dresscode_data!=0)
					{
						
						$totalrow=5;
						$dd='<ul>';
						for($i=1;$i<=$dresscode_data;$i++)
						{
							$dd .="<li><img src='images/star.png' onclick='javascript: return feedbackPopup(4,".$i.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$remain=$totalrow - $dresscode_data;
                        $forward=$dresscode_data + 1;
						for($j=$forward;$j<=$totalrow;$j++)
						{
							$dd .="<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(4,".$j.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$dd .="</ul>";
					} else {
						$dd="<ul>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(4,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(4,2,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(4,3,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(4,4,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(4,5,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
							</ul>";
					}
					/* Presentation End */
					
					/* Attitude Start */
					if($attitude_data!=0)
					{
						
						$totalrow=5;
						$at='<ul>';
						for($i=1;$i<=$attitude_data;$i++)
						{
							$at .="<li><img src='images/star.png' onclick='javascript: return feedbackPopup(5,".$i.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$remain=$totalrow - $attitude_data;
                        $forward=$attitude_data + 1;
						for($j=$forward;$j<=$totalrow;$j++)
						{
							$at .="<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(5,".$j.",".$resultFeedback["user_id"].",".$job_id.")' alt=''/></li>";
						}
						$at .="</ul>";
					} else {
						$at="<ul>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(5,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(5,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(5,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(5,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
								<li><img src='images/star-tr.png' onclick='javascript: return feedbackPopup(5,1,".$resultFeedback["user_id"].",".$job_id.");' alt=''/></li>
							</ul>";
					}
					/* Attitude End */


					$uName = getusername($resultFeedback['user_id']);
					$feedback.= "<span class='uName'>".$uName."</span>";
					$feedback.="<tr>";
					$feedback.="<td>
									Perfomance
								</td>			
								<td>
									".$pd."
								</td>";
					$feedback.="</tr>";
					
					$feedback.="<tr>";
					$feedback.="<td>
									Punctuality
								</td>			
								<td>
									".$py."
								</td>";
					$feedback.="</tr>";

					$feedback.="<tr>";
					$feedback.="<td>
									Presentation
								</td>			
								<td>
									".$pt."
								</td>";
					$feedback.="</tr>";

					$feedback.="<tr>";
					$feedback.="<td>
									Dresscode
								</td>			
								<td>
									".$dd."
								</td>";
					$feedback.="</tr>";

					$feedback.="<tr>";
					$feedback.="<td>
									Attitude to work
								</td>			
								<td>
									".$at."
								</td>";
					$feedback.="</tr>";
				}
				
			}
			
			$feedback.="</table>";
			$feedback.="</div>";
			
		}
		
		
	}
	else{
		$feedback  = "No Data Available";
	}
	
	return $feedback;
}


function getFeedbackUser($user_id=0, $job_id=0)
{
	$feedbackSql = mysql_query("SELECT performance, punctuality, presentation, dresscode, attitude FROM  tblfeedback WHERE job_id=".$job_id." and user_id=".$user_id." ");
	$feedback = mysql_fetch_array($feedbackSql);
	
	$performance = $feedback['performance'];
	$punctuality = $feedback['punctuality'];
	$presentation = $feedback['presentation'];
	$dresscode = $feedback['dresscode'];
	$attitude = $feedback['attitude'];

	$content = '';
	$content .= '<div class="feed_wrap">
				<h4>Feedback</h4>
				<br/>
				<br/>
				<h6>(Provide Ratings)</h6>';
	//Perfomance
	$content .=	'<div class="feed_star">
					<label>Performance</label>
					<div class="feed_star_rt">';
					for($loop = 1; $loop<=5; $loop++){
						if($loop<=$performance){
							$content .= '<img src="images/big-star-full.png" alt="">';
						}else{
							$content .= '<img src="images/big-star-null.png" alt="">';
						}
					}
	$content .=		'</div>
				</div>';

	//Punctuality
	$content .=	'<div class="feed_star">
					<label>Punctuality</label>
					<div class="feed_star_rt">';
					for($loop = 1; $loop<=5; $loop++){
						if($loop<=$punctuality){
							$content .= '<img src="images/big-star-full.png" alt="">';
						}else{
							$content .= '<img src="images/big-star-null.png" alt="">';
						}
					}
	$content .=		'</div>
				</div>';

	//Presentation
	$content .=	'<div class="feed_star">
					<label>Presentation</label>
					<div class="feed_star_rt">';
					for($loop = 1; $loop<=5; $loop++){
						if($loop<=$presentation){
							$content .= '<img src="images/big-star-full.png" alt="">';
						}else{
							$content .= '<img src="images/big-star-null.png" alt="">';
						}
					}
	$content .=		'</div>
				</div>';

	//Dresscode
	$content .=	'<div class="feed_star">
					<label>Dresscode</label>
					<div class="feed_star_rt">';
					for($loop = 1; $loop<=5; $loop++){
						if($loop<=$dresscode){
							$content .= '<img src="images/big-star-full.png" alt="">';
						}else{
							$content .= '<img src="images/big-star-null.png" alt="">';
						}
					}
	$content .=		'</div>
				</div>';

	//Attitude
	$content .=	'<div class="feed_star">
					<label>Attitude</label>
					<div class="feed_star_rt">';
					for($loop = 1; $loop<=5; $loop++){
						if($loop<=$attitude){
							$content .= '<img src="images/big-star-full.png" alt="">';
						}else{
							$content .= '<img src="images/big-star-null.png" alt="">';
						}
					}
	$content .=		'</div>
				</div>';


	$content .=		'</div>';
			echo $content;
}

//Function to Generate Referral Code
function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; 
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; 
    $bits = (int) $log + 1; 
    $filter = (int) (1 << $bits) - 1; 
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter;
    } while ($rnd > $range);
    return $min + $rnd;
}

/* Generate and Return referral code */
function getReferralCode($length)
{
    $referralCode = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "012345678935768";
    $max = strlen($codeAlphabet);

    for ($i=0; $i < $length; $i++) {
        $referralCode .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $referralCode; // will return Referral Code
}

function dayDropdown($name="day", $selected=null, $for, $availRow)
{
		if($availRow){
			$ar = $availRow;
		}else{
			$ar = "";
		}
        $wd = '<select name="'.$name.'" class="'.$name.'" id="'.$name."_".$for.'">';
		if($for == 'start'){
			$forDay = "From Day";
		}elseif($for == 'end'){
			$forDay = "To Day";
		}else{
			$forDay = "Select Day";
		}
        $days = array(
				0 => $forDay,
				1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
                6 => 'Saturday',
                7 => 'Sunday');
        /*** the current day ***/
        $selected = is_null($selected) ? date('N', time()) : $selected;

        for ($i = 0; $i <= 7; $i++)
        {
				if($i == 0){
					$wd .= '<option value=""';
				}else{
					$wd .= '<option data-dayid="'.$i.'" '.(($ar == $i)?'selected="selected"':"").' disabled value="'.strtolower($days[$i]).'"';
				}
                
                /* if ($i == $selected)
                {
                    $wd .= ' selected';
                } */
                /*** get the day ***/
                $wd .= '>'.$days[$i].'</option>';
        }
        $wd .= '</select>';
        return $wd;
}

function distanceBetweenLangLonk($lat1, $lon1, $lat2, $lon2, $unit) {

	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);

	if ($unit == "K") {
		return ($miles * 1.609344);
	} else if ($unit == "N") {
		return ($miles * 0.8684);
		} else {
			return $miles;
		}
}

/* Check Abusing Words and Contact number*/
function abuseword($data)
{
	$pattern = '/(^|\D)\d{7,}($|\D)/';
	$replacement = ' ';
	$data = preg_replace($pattern, $replacement, $data);
 	$qry = mysql_query("SELECT * from tblwords");
 	$badwords = array();
	while($row=mysql_fetch_array($qry))
	{ 
		$badwords[] = $row['name'];  
	}
 
	$replaceChar = '*';
		return preg_replace_callback(
			array_map(function($w) { 
	
	return '/\b' . preg_quote($w, '/') . '\b/i'; 
	}, $badwords),
			function($match) use ($replaceChar) 
	{
	//$reaplace_override = substr($match[0],0,1) . str_repeat($replaceChar, strlen($match[0])-1) ;
		$reaplace_override = substr($match[0],0,0) . str_repeat($replaceChar, strlen($match[0])) ;
		return $reaplace_override;
	},
			$data
		);
}

function dobSelect($year = 1910, $dobDate, $dobMonth, $dobYear){
	// lowest year wanted
    $cutoff = $year;

    // current year
	$now = date('Y');
	
	// build days menu
	echo '<div class="dob_div">';
    echo '<select id="dobday" name="dobday" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Date">' . PHP_EOL;
	echo '  <option value="">Select Date</option>' . PHP_EOL;
	for ($d=1; $d<=31; $d++) {
		if($dobDate == $d){ 
			$selected = "selected"; 
		}else{
			$selected = ""; 
		}
        echo '<option value="' . $d . '" '.$selected.'>' . $d . '</option>' . PHP_EOL;
    }
    echo '</select></div>' . PHP_EOL;

	// build months menu
	echo '<div class="dob_div">';
	echo '<select id="dobmonth" name="dobmonth" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Month">' . PHP_EOL;
	echo '  <option value="">Select Month</option>' . PHP_EOL;
    for ($m=1; $m<=12; $m++) {
		if($dobMonth == $m){ 
			$selected = "selected"; 
		}else{
			$selected = ""; 
		}
        echo '  <option value="' . date('m', mktime(0,0,0,$m)) . '" '.$selected.'>' . date('F', mktime(0,0,0,$m)) . '</option>' . PHP_EOL;
    }
	echo '</select></div>' . PHP_EOL;
	
	// build years menu
	echo '<div class="dob_div">';
	echo '<select id="dobyear" name="dobyear" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Year">' . PHP_EOL;
	echo '  <option value="">Select Year</option>' . PHP_EOL;
    for ($y=$now; $y>=$cutoff; $y--) {
		if($dobYear == $y){ 
			$selected = "selected"; 
		}else{
			$selected = ""; 
		}
        echo '  <option value="' . $y . '" '.$selected.'>' . $y . '</option>' . PHP_EOL;
    }
    echo '</select></div>' . PHP_EOL;

}

?>