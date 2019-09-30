<?php 
include "config.php";
unset($_SESSION['request_user_id']);
$search_val = "";
if(isset($_POST["home_search"])){
	$search_val = $_POST["home_search"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="theme-color" content="#cf2027">
<meta name="msapplication-navbutton-color" content="#cf2027">
<meta name="apple-mobile-web-app-status-bar-style" content="#cf2027">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<title>Search Candidate - New Request - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="fonts/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA_JUu2G9vlijX1UgNTylx55U1hZQqw6QI&sensor=true"></script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>
<script>
function getCookie(name) {
   var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) 
                return c.substring(nameEQ.length,c.length);
    }
    return null;
}

jQuery(document).ready(function($) {
	
    var category=[];
    var page=$('#current_page').val();	
	$('label.chk_lb .sj_chk').on('click', function(){
    if($(this).is(":checked")) {
		category.push($(this).val());
		$('#result').html('');
		$('#last_page').val(0);
		
		if($('#last_page').val()==0)
		 {
			var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
			 var page=1;
			document.cookie="postpage="+page;
		load_more(getCookie('postpage'),category,activesort);
		 }
		
        $(this).parent().addClass("checked");
    } else {
		
		var pos = category.indexOf($(this).val());
		category.splice(pos, 1);
		$('#last_page').val(0);
		$('#result').html('');
        if($('#last_page').val()==0)
		{
			var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
			var page=1;
			document.cookie="postpage="+page;
		load_more(getCookie('postpage'),category,activesort);
		}
		
        $(this).parent().removeClass("checked");
    }
 });
	
	$(".tab_content").hide(); 
	$("ul.tabs li:first").addClass("active").show();
	$(".tab_content:first").show();

	$("ul.sort_ul li").click(function() {
	//equalheight('.newrequest ul li .rqstmain');
	$('#last_page').val(0);
	var sorttab=$(this).find("a").attr("href");
	$("ul.sort_ul li").find("a").removeClass("active");
	$(this).find("a").addClass("active");
	var activesort=$(this).find("a").attr("data-sortby");
	var page=1;
	document.cookie="postpage="+page;
	        var category=[];
			$('.catdata').each(function(){  
			 if($(this).is(":checked")) {
			 category.push($(this).val());
			 }			  
			});	
			$('#result').html('');
	load_more(getCookie('postpage'),category,activesort);		
	});

	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active");
		$(this).addClass("active"); 
		$(".tab_content").hide();

		var activeTab = $(this).find("a").attr("href");
        if(activeTab=='new-request.php')
		{
			location.replace("new-request.php");
		}
        if(activeTab=='requested.php')
		{
			location.replace("requested.php");
		}
        if(activeTab=='confirmed.php')
		{
			location.replace("confirmed.php");
		} 
        if(activeTab=='favourite_list.php')
		{
			location.replace("favourite_list.php");
		}            		   
     		
		$(activeTab).fadeIn();
		return false;
	});
	

  $("#new_srch").click(function() {
	  
if($('#srh_newjobs').val()!='')
{
	$('#last_page').val(0);	
	var page=1;
	document.cookie="postpage="+page;
	var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
	var category=[];
	$('.catdata').each(function(){  
	 if($(this).is(":checked")) {
	 category.push($(this).val());
	 }			  
	});
	$('#result').html('');
	load_more(getCookie('postpage'),category,activesort);
}
else
{
	$('#last_page').val(0);	
	var page=1;
	document.cookie="postpage="+page;
	
	var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
	var category=[];
	$('.catdata').each(function(){  
	 if($(this).is(":checked")) {
	 category.push($(this).val());
	 }			  
	});
	$('#result').html('');
	load_more(getCookie('postpage'),category,activesort);
}	
});

$('#srh_newjobs').keypress(function (e) {
	 var key = e.which;
	 if(key == 13)  // the enter key code
	  {
		if($('#srh_newjobs').val()!='')
        {
			$('#last_page').val(0);	
			var page=1;
			document.cookie="postpage="+page;
			var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
			var category=[];
			$('.catdata').each(function(){  
			 if($(this).is(":checked")) {
			 category.push($(this).val());
			 }			  
			});
            			
			$('#result').html('');
			load_more(getCookie('postpage'),category,activesort);
		}
		else
		{
			$('#last_page').val(0);	
			var page=1;
			document.cookie="postpage="+page;
			
			var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
			var category=[];
			$('.catdata').each(function(){  
			 if($(this).is(":checked")) {
			 category.push($(this).val());
			 }			  
			});
            			
			$('#result').html('');
			load_more(getCookie('postpage'),category,activesort);
		}	
	  }
	});   		
	
});

var page = 1;
document.cookie="postpage="+page;
var pagenumber=getCookie('postpage');
var category = "";
var sort = "";
load_more(pagenumber,category,sort);

$(window).scroll(function(){
	
	$('.stj_loader').hide();
	
	     if($('#last_page').val()==0)
		 {
		  if($(window).scrollTop() + $(window).height() + 200 >= $(document).height()) {
	    page++;
		
		
		var pages=getCookie('postpage');
		    pages++;
		 var pagenumber=document.cookie="postpage="+pages;
		   
			var category=[];
			$('.catdata').each(function(){  
			 if($(this).is(":checked")) {
			 category.push($(this).val());
			 }			  
			});	
			
       var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");		
        load_more(getCookie('postpage'),category,activesort);
        $('#current_page').val(getCookie('postpage'));		
		    }
		 }
		 else
		 {
			 if($('#current_page').val()>=3)
			 {
			  $('.stj_loader').show();
			 $('.stj_loader').html("No More User Available");
			 }
		 }
 });    
function load_more(page,cat,sort){
	
	var search=$('#srh_newjobs').val();
	var searchval='';
	var xsearch = "<?php echo $search_val;?>";
	if(search!='' && search!=undefined)
	{
		searchval='&search='+search;
	}
	if((xsearch!="") && (searchval =="")){
		searchval='&search='+xsearch;
	}
	
	//alert(searchval);
      $.ajax(
            {
                url: 'get_new_request.php?page='+page+'&category='+cat+'&sort='+sort+searchval,
                type: "get",
                datatype: "html",
                beforeSend: function()
                {
					$('#last_page').val('1');
					$('.stj_loader').html("Loading...");
                    $('.stj_loader').show();
                }
            })
            .done(function(data)
            {
				
                if(data.length == 0){
					$('.stj_loader').show();
					//$('#current_page').val(1);
					$('#last_page').val('1');
                    if((search!='' && search!=undefined))
					{
						
						$('.stj_loader').html("No User Available");
                    
                    } else if(search=='' || search==undefined) {
						
					 $('.stj_loader').html("No User Available.");	
					}
					else
					{
						
						$('.stj_loader').html("No More User AVAILABLE");
					}
                    return false;
                }
				$('#last_page').val('0');
                $('.stj_loader').hide(); //hide loading animation once data is received
                /* Below variable is to stop scroll for advance search */
				var advanceSearchValue = readCookie('advanceSearchCandidate');
				if(advanceSearchValue != 1){
					$("#result").append(data); //append data into #results element
				}
		    $( ".newrequest ul li .addwsh .fa.fa-heart-o" ).click(function() {
				var userid=$( this ).attr("id");
				if(userid!='')
				{
					$.post("get_favourite.php",
					{
						userid:userid
					},
					function(data) {
					});
					
					
				}
            $( this ).toggleClass( "like" );
            });
                equalheight('.newrequest ul li .rqstmain');				
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
				
                  //alert('No response from server');
            });
     }	
</script>

<script>
$( document ).ready(function() {
	eraseCookie("advanceSearchCandidate");
});
/* Cookie Defination for create, call and erase */
function createCookie(name, value, days) {
  var expires;

  if (days) {
      var date = new Date();
	  /* date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); */
	  date.setTime(date.getTime() + (days * 20000));
      expires = "; expires=" + date.toGMTString();
  } else {
      expires = "";
  }
  document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function readCookie(name) {
  var nameEQ = encodeURIComponent(name) + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) === ' ')
          c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) === 0)
          return decodeURIComponent(c.substring(nameEQ.length, c.length));
  }
  return null;
}

function eraseCookie(name) {
  createCookie(name, "", -1);
}
</script>

<script>
jQuery(document).ready(function($) {
	$(".a_as").click(function(){
		$('.stj_ad_srch_inner').slideToggle();
	});
});

getCities(<?php echo $state_id; ?>);
function getCities(val) {
	$.ajax({
		type: "POST",
		url: "<?php echo ADMIN_URL ?>phpajax/get_city.php",
		data:'state_id='+val+'&city_id=<?php echo $city_id; ?>',
		success: function(data){
			$("#city_id").html(data);	
		}
	});
}
</script>
</head>
<?php if(isset($_SESSION['user_id'])){
	$link='login.php';
	if(isset($_SESSION['user_id']) && $_SESSION['customer_type']==1)
	{
		$profileCLass = 'business-profile-class';
	}
	if(isset($_SESSION['user_id']) && $_SESSION['customer_type']==2)
	{
		$profileCLass = 'individual-profile-class';
	}
}
?>

<body class="<?php echo $profileCLass; ?>">
<?php include "header-inner.php"; ?>

<div class="stj_job_wrap">
	<div class="container">
		<div class="row">
			
			<div class="col-xs-12 col-md-2 stj_filter">
			 <div class="stj_filter_inn">
				<h2>Filters</h2>
				<div class="stj_ctg">
					<h3>Categories</h3>
					<ul>
						 <?php 
						 $sql=mysql_query("select category_id,category_name from tblcategory where isactive=1 order by category_name");
						 $rows=mysql_num_rows($sql);
						 if($rows > 0)
						 {
							 while($catdata=mysql_fetch_array($sql))
							 {
						 ?>
						<li>
							<label class="chk_lb"><input type="checkbox" name="catdata[]" value="<?php echo $catdata['category_id']; ?>" class="sj_chk catdata" /><?php echo $catdata['category_name']; ?></label>
						</li>
						<?php 
							 }
						 }
						 ?>
					</ul>
				</div>

				<div class="stj_ctg side_loc_filt">
					<h3>Job Location</h3>
			
					<label>Within</label>
					<select name="zip_miles_item_location" id="zip_miles_item_location" class="btn-sle-pc">
						<option value="">Select</option>
						<option value="2">2 Miles</option>
						<option value="5">5 Miles</option>
						<option value="10">10 Miles</option>
						<option value="15">15 Miles</option>
						<option value="20">20 Miles</option>
						<option value="30">30 Miles</option>
						<option value="50">50 Miles</option>
						<option value="75">75 Miles</option>
						<option value="100">100 Miles</option>
						<option value="125">125 Miles</option>
						<option value="150">150 Miles</option>
						<option value="175">175 Miles</option>
						<option value="200">200 Miles</option>
						<option value="500">500 Miles</option>
					</select>

					
                    <input name="zip_code_item_location" id="zip_code_item_location" class="txt_lg btn-ent-pc" placeholder="Enter Postcode" type="text">
					<input type="button" name="zip_search" class="btn btn-srch-pc" value="Search" onclick="javascript:return itemLocationSearch();">
				</div>
				
			 </div>
			</div>
			
			<div class="col-xs-12 col-md-8 stj_jb">
				<div class="stj_jb_inr">
				<?php /* echo getMsg(); */ ?>
					<ul class="tabs">
                      <li><a href="new-request.php">Find Candidate</a></li>
                      <li><a href="requested.php">Requested</a></li>
					  <li><a href="confirmed.php">Confirmed</a></li> 
					  <li class="anj_li"><a href="favourite_list.php">View Favourites</a></li>
                    </ul>
                    
                    <div class="tab_container">
                    	<div id="tab1" class="tab_content">
                    		
                    		<div class="stj_sort">
                    			<ul class="sort_ul">
                    				<li><label>Sort By</label></li>
                    				<li><a class="active" data-sortby="newest" href="javascript:void(0);">Newest First</a></li>
                    				<li><a data-sortby="oldest" href="javascript:void(0);">Oldest First</a></li>
                    				
                    			</ul>
                    			<div class="srch_dv">
                    				<input type="text" class="txt_srch" id="srh_newjobs" placeholder="Search" value="<?php echo $search_val;?>" />
                    				<input type="button" class="btn_srch" id="new_srch" value="Go" />
                    			</div>
							</div>
							
							<!-- ADVANCE FILTER START -->
                    		<div class="stj_ad_srch">
                    			<a class="a_as" href="javascript:void(0)">Advanced Search</a>
                    			<div class="stj_ad_srch_inner">
                    				<ul>
										<form>
											
										<!-- CANDIDATE NAME START -->
                    					<li>
                    						<label>Candidate Name</label>
                    						<input name="candidate_name" id="candidate_name" class="txt_lg" placeholder="Enter The Name" type="text">
										</li>
										<!-- CANDIDATE NAME END -->
										
										<!-- OPENING TYPE START -->
                    					<li>
											<label>Gender</label>
											<div class="radio">
												<div class="rdrow">
													<input  id="rd0" class="rd_chk" value="" name="candidate_gender" checked type="radio">
													<label for="rd0">All</label>
												</div>
												<div class="rdrow">
													<input  id="rd1" class="rd_chk" value="1" name="candidate_gender" type="radio">
													<label for="rd1">Male</label>
												</div>
												<div class="rdrow">
													<input  id="rd2" class="rd_chk" value="2" name="candidate_gender" type="radio">
													<label for="rd2">Female</label>
												</div>
											</div>
										</li>
										<!-- OPENING TYPE END -->
										
										<!-- STATE START -->
                    					<li>
                    						<label>County</label>
											<!-- <label>State </label> -->
											<select name="state_id" id="state_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Select State" onchange="getCities(this.value)">
												<option value="">Select County</option>
												<?php 
												$sql = mysql_query("SELECT * FROM tblstates  ORDER By name ASC");
												$rows = mysql_num_rows($sql);
												if($rows > 0)
												{
													while($locationdata=mysql_fetch_array($sql))
													{
												?>
												<option value="<?php echo $locationdata['id']; ?>"><?php echo $locationdata['name']; ?></option>
														<?php 
													}
												}
												?>
											</select>
										</li>
										<!-- STATE END -->
										
										<!-- CITY START -->
										<li>
											<label>Town / City</label>
											<select id="city_id" name="city_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select city">
												<option value="">Select City</option>
											</select>
										</li>
										<!-- CITY END -->

										<!-- NATIONALITY START -->
										<li>
											<label>Nationality</label>
											<select name="nationality" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Nationality" id="nationality">
												<option value="">Select Nationality</option>
											<?php 
												$select_query = mysql_query("SELECT * FROM tblnationality where status=1 ORDER By name ASC"); 
												while($row = mysql_fetch_assoc($select_query)) {
											?>
											<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
											<?php } ?>
											</select>
										</li>
										<!-- NATIONALITY END -->

										<!-- MILITRY BACKGROUND START -->
                    					<li>
											<label>Militry Background </label>
											<select name="militry_background" id="militry_background">
												<option value="">Select</option>
												<option value="1">Yes</option>
												<option value="2">No</option>
											</select>
										</li>
										<!-- MILITRY BACKGROUND END -->

										<!-- FIRST AID START -->
                    					<li>
											<label>First aid </label>
											<select name="first_aid" id="first_aid">
												<option value="">Select</option>
												<option value="1">Yes</option>
												<option value="2">No</option>
											</select>
										</li>
										<!-- FIRST AID END -->

										<!-- PARAMEDIC TRAINING START -->
                    					<li>
											<label>Paramedic Training </label>
											<select name="paremedic_training" id="paremedic_training">
												<option value="">Select</option>
												<option value="1">Yes</option>
												<option value="2">No</option>
											</select>
										</li>
										<!-- PARAMEDIC TRAINING END -->

										<!-- TATTOO START -->
                    					<li>
											<label>Visible Tattoos </label>
											<select name="tattoo" id="tattoo">
												<option value="">Select</option>
												<option value="1">Yes</option>
												<option value="2">No</option>
											</select>
										</li>
										<!-- TATTOO END -->

										<!-- PIERCING START -->
                    					<li>
											<label>Visible Piercings </label>
											<select name="piercing" id="piercing">
												<option value="">Select</option>
												<option value="1">Yes</option>
												<option value="2">No</option>
											</select>
										</li>
										<!-- PIERCING END -->

										<!-- SIA BADGE START -->
                    					<li>
											<label>SIA Badge </label>
											<select name="sia_badge" id="sia_badge">
												<option value="">Select</option>
												<option value="1">Yes</option>
												<option value="2">No</option>
											</select>
										</li>
										<!-- SIA BADGE END -->
										
										<!-- BUILD START -->
										<li>
											<label>Build</label>
											<select name="build" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Build"  id="build">
												<option value="">Select Build</option>
												<?php 
												$select_query = mysql_query("SELECT * FROM tblbuild where status=1 ORDER By name ASC"); 
												while($row = mysql_fetch_assoc($select_query)) {
												?>
													<option value="<?php echo $row['name']; ?>" <?php if($build==$row['name']){ ?> selected <?php } ?>><?php echo $row['name']; ?></option>
													<?php } ?>
											</select>
										</li>
										<!-- BUILD END -->
										
										<!-- POSTCODE START -->
                    					<li>
                    						<label>Postcode</label>
                    						<input name="zip_code" id="zip_code" class="txt_lg" placeholder="Enter Postcode" type="text">
										</li>
										<!-- POSTCODE END -->

										<!-- Miles START -->
                    					<li>
                    						<label>Within</label>
											<select name="zip_miles" id="zip_miles">
												<option value="">Select</option>
												<option value="2">2 Miles</option>
												<option value="5">5 Miles</option>
												<option value="10">10 Miles</option>
												<option value="15">15 Miles</option>
												<option value="20">20 Miles</option>
												<option value="30">30 Miles</option>
												<option value="50">50 Miles</option>
												<option value="75">75 Miles</option>
												<option value="100">100 Miles</option>
												<option value="125">125 Miles</option>
												<option value="150">150 Miles</option>
												<option value="175">175 Miles</option>
												<option value="200">200 Miles</option>
												<option value="500">500 Miles</option>
											</select>
										</li>
										<!-- Miles END -->

										<li class="full_li">
											<input value="Close" id="close_filetr" name="close_filetr" onclick="javascript:return closeToggle();" class="btn_lg" type="button">
										</li>
										
                    					<li class="full_li">
                    						<input value="Filter" id="submit_filetr" name="submit_filetr" onclick="javascript:return advanceSearch();" class="btn_lg" type="button">
										</li>
										</form>
                    				</ul>
                    			</div>
							</div>
							<!-- ADVANCE FILTER END -->
                    		
                    		<div class="newrequest">
								<input type="hidden" name="last_page" id="last_page" value="0">	
                            	<input type="hidden" name="current_page" id="current_page" value="1">
							   	<ul id="result"></ul>
							</div>

                    		
                    	</div>
                    </div>
				</div>
                    <div class="stj_loader"  style="display:none;">Loading...</div>
			</div>
			
			<?php include "advert-section.php"; ?>
			
		</div>
	</div>
</div>

<!-- Advance Search Script Start -->
<script>
	function advanceSearch(){
		var geocoder = new google.maps.Geocoder();
        var address = document.getElementById("zip_code").value;
        if (address != "") {
            geocoder.geocode({ 'address': address }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();
                    searchData(latitude,longitude);
					//alert(latitude+','+longitude);
					//return false;
                }
            });
            
        } else {
            searchData('', '');
        }
	}
    
    function searchData(latitude,longitude) {
		var candidateName = $('#candidate_name').val();
		var candidateGender = $("input[name~='candidate_gender']:checked").val();
		var stateId = $("select[name~='state_id'] option:selected").val();
		var cityId = $("select[name~='city_id'] option:selected").val();
		var nationality = $("select[name~='nationality'] option:selected").val();
		var militryBackground = $("select[name~='militry_background'] option:selected").val();
		var firstAid = $("select[name~='first_aid'] option:selected").val();
		var paremedicTraining = $("select[name~='paremedic_training'] option:selected").val();
		var tattoo = $("select[name~='tattoo'] option:selected").val();
		var piercing = $("select[name~='piercing'] option:selected").val();
		var siaBadge = $("select[name~='sia_badge'] option:selected").val();
		var build = $("select[name~='build'] option:selected").val();
		var zipMiles = $("select[name~='zip_miles'] option:selected").val();
		var zipCode = $('#zip_code').val();
		// alert(siaBadge);
		// return false;
		
		if(zipMiles != '' && zipCode == ""){
			alert("Please enter the postcode.");
			return false;
		}

		$('.stj_ad_srch_inner').slideToggle();

        $.ajax({
			type: 'GET',
			url: 'get_candidates_advance.php?candidateName='+candidateName+'&candidateGender='+candidateGender+'&stateId='+stateId+'&cityId='+cityId+'&nationality='+nationality+'&militryBackground='+militryBackground+'&firstAid='+firstAid+'&paremedicTraining='+paremedicTraining+'&longi='+longitude+'&lati='+latitude+'&tattoo='+tattoo+'&piercing='+piercing+'&siaBadge='+siaBadge+'&build='+build+'&zipMiles='+zipMiles+'&zipCode='+zipCode,
			datatype: "html",
			beforeSend: function()
			{
				$('.stj_loader').html("Loading...");
				$('.stj_loader').show();
			}
		})
		.success(function(data){
			$('.stj_loader').hide();
			$('#result').html(data);
			/* Cookie to stop the scroll event */
			createCookie('advanceSearchCandidate', '1', 1);
			equalheight('.newrequest ul li .rqstmain');	
		})
		.fail(function(jqXHR, ajaxOptions, thrownError){
			alert('No response from server');
		});
    }

</script>
<!-- Advance Search Script End -->

<!-- Item Location Script Start -->
<script>
	function itemLocationSearch(){
		
		var geocoder = new google.maps.Geocoder();
        var address = document.getElementById("zip_code_item_location").value;
        if (address != "") {
            geocoder.geocode({ 'address': address }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();
                    searchDataByItemLocation(latitude,longitude);
                }
            });
            
        } else {
            searchDataByItemLocation('', '');
        }
	}
    
    function searchDataByItemLocation(latitude,longitude) {
		var zipMiles = $("select[name~='zip_miles_item_location'] option:selected").val();
		var zipCode = $('#zip_code_item_location').val();
		
		if(zipMiles != '' && zipCode == ""){
			alert("Please enter the postcode.");
			return false;
		}

		$('.stj_ad_srch_inner').slideUp();

        $.ajax({
			type: 'GET',
			url: 'get_candidates_advance.php?longi='+longitude+'&lati='+latitude+'&zipMiles='+zipMiles,
			datatype: "html",
			beforeSend: function()
			{
				$('.stj_loader').html("Loading...");
				$('.stj_loader').show();
			}
		})
		.success(function(data){
			$('.stj_loader').hide(); //hide loading animation once data is received
			$('#result').html(data);
			createCookie('advanceSearchCandidate', '1', 1);
			equalheight('.newrequest ul li .rqstmain');
		})
		.fail(function(jqXHR, ajaxOptions, thrownError){
			alert('No response from server');
		});
    }

</script>
<!-- Item Location Script End -->

<!-- Close Toggle Start -->
<script>
	function closeToggle() {
		$('.stj_ad_srch_inner').slideToggle();
	}
</script>
<!-- Close Toggle End -->
 
<?php include "footer.php"; ?>
</body>
</html>