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
 $mail->Host = 'mail.webtechsystem.com';
 $mail->SMTPAuth = true;
 $mail->Username = 'mark@webtechsystem.com';
 $mail->Password = 'm@Rak!iL6@';
 //$mail->SMTPSecure = 'tls';

 $mail->setFrom('info@mgtdemo.co.uk', 'cleaner');
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
?>