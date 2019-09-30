<?php 
include "config.php"; 
unset($_SESSION['page_name']);
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
<title>New Jobs - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/jquery-ui.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link href="fonts/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>
<!-- <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script> -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA_JUu2G9vlijX1UgNTylx55U1hZQqw6QI&sensor=true"></script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script type="text/javascript">
	function googleTranslateElementInit() {
	new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
	}
</script>

<!-- Script for Direct Apply for the Job -->
<script>
function applyForJob(jobId, userId, jobPrice){
	var sessionUser = <?php echo isset($_SESSION['user_id'])?$_SESSION['user_id']:0; ?>;
	if(sessionUser==0){
		window.location.href = "login.php";
		return false;
	}
	var applyJob = confirm("Do you want to apply for this job?");
	var jobId = jobId;
	var userId = userId;
	var jobPrice = jobPrice;
	
	if (applyJob == true) {
		if(jobId != "" && userId != "" && jobPrice != "") {
		$.ajax(
			{
				url: 'apply_for_job.php?jobId='+jobId+'&userId='+userId+'&jobPrice='+jobPrice,
				type: "get",
				datatype: "html",
				beforeSend: function()
				{
					$('#preloader').show();
				}
			})
			.done(function(data)
			{
				$('#preloader').hide();
				if(data==1)
				{
					alert("You have already bid for this job.");
					window.location.reload();
				}
				if(data==2)
				{
					if(!alert("Your bid has been successfully placed.")){window.location.reload();}
				}
				if(data==3)
				{
					alert("Something went wrong. Please try again.")
					window.location.reload();
				}			
			})
			.fail(function(jqXHR, ajaxOptions, thrownError)
			{
				alert("Something went wrong. Please try again.")
				return false;
			});
		}
	}
}
</script>

<script>
	//Script for Advance Search Start Date
	jQuery( function() {
		jQuery( "#datepickerstart" ).datepicker({dateFormat: 'dd/mm/yy'});
		$('.ui-datepicker').addClass('notranslate');
	});

	//Script for Advance Search End Date
	jQuery( function() {
		jQuery( "#datepickerend" ).datepicker({dateFormat: 'dd/mm/yy'});
		$('.ui-datepicker').addClass('notranslate');
	});
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
		var radius=[];
		var page=$('#current_page').val();
		$('.filter_category label.chk_lb .sj_chk').on('click', function(){
			var radius=[];
				$('.radiusdata').each(function(){  
					if($(this).is(":checked")){
						radius.push($(this).val());
					}			  
				});		
		
		if($(this).is(":checked")) {
			category.push($(this).val());
			$('#result').html('');
			$('#last_page').val(0);
			if($('#last_page').val()==0)
			{
				var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
				var page=1;
				document.cookie="pages="+page;
			load_more(getCookie('pages'),category,activesort,radius);
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
				document.cookie="pages="+page;
				load_more(getCookie('pages'),category,activesort,radius);
			}
			$(this).parent().removeClass("checked");
		}
	});
	
	
	$('.filter_radius label.chk_lb .sj_chk').on('click', function(){
			var category=[];
				$('.catdata').each(function(){
				if($(this).is(":checked")) {
				category.push($(this).val());
				}			  
				});	
		
		if($(this).is(":checked")) {
			radius.push($(this).val());
			$('#result').html('');
			$('#last_page').val(0);
			if($('#last_page').val()==0)
			{
				var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
				var page=1;
				document.cookie="postpage="+page;
			load_more(getCookie('postpage'),category,activesort,radius);
			}
			$(this).parent().addClass("checked");
		} else {
			var pos1 = radius.indexOf($(this).val());
			radius.splice(pos1, 1);
			$('#last_page').val(0);
			$('#result').html('');
			if($('#last_page').val()==0)
			{
				var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
				var page=1;
				document.cookie="postpage="+page;
			load_more(getCookie('postpage'),category,activesort,radius);
			}
			$(this).parent().removeClass("checked");
		}
	});
		
		$(".tab_content").hide(); 
		$("ul.tabs li:first").addClass("active").show();
		$(".tab_content:first").show();


		$("ul.tabs li").click(function() {

			$("ul.tabs li").removeClass("active");
			$(this).addClass("active"); 
			$(".tab_content").hide();
			
			var activeTab = $(this).find("a").attr("href"); 
			//location.replace("ongoing_bids.php");
			if(activeTab=='#tab1')
			{
			location.replace("jobs.php");
			}
			if(activeTab=='#tab2')
			{
			location.replace("ongoing_bids.php");
			}
			if(activeTab=='#tab3')
			{
			location.replace("confirmedjobs.php");
			}
			if(activeTab=='#tab4')
			{
			location.replace("ongoingjobs.php");
			}
			if(activeTab=='#tab5')
			{
			location.replace("completedjobs.php");
			}
			$(activeTab).fadeIn();
			
			return false;
		});
	$('.sj_chk').each(function(){  });

	$("ul.sort_ul li").click(function() {
		$('#last_page').val(0);
		var sorttab=$(this).find("a").attr("href");
		$("ul.sort_ul li").find("a").removeClass("active");
		$(this).find("a").addClass("active");
		var activesort=$(this).find("a").attr("data-sortby");
		var page=1;
		document.cookie="pages="+page;
			var radius=[];
				$('.radiusdata').each(function(){  
					if($(this).is(":checked")) {
						radius.push($(this).val());
					}			  
				});	

				var category=[];
				$('.catdata').each(function(){  
					if($(this).is(":checked")) {
						category.push($(this).val());
					}			  
				});	
				$('#result').html('');
		load_more(getCookie('pages'),category,activesort,radius);		
		});

	$("#new_srch").click(function() {
	if($('#srh_newjobs').val()!='')
	{
		$('#last_page').val(0);	
		var page=1;
		document.cookie="pages="+page;
		var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
		var category=[];
		$('.catdata').each(function(){  
		if($(this).is(":checked")) {
		category.push($(this).val());
		}			  
		});
		
			var radius=[];
				$('.radiusdata').each(function(){  
				if($(this).is(":checked")) {
				radius.push($(this).val());
				}			  
				});	

		$('#result').html('');
		load_more(getCookie('pages'),category,activesort,radius);
	}
	else
	{
		$('#last_page').val(0);	
		var page=1;
		document.cookie="pages="+page;
		
		var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
		var category=[];
		$('.catdata').each(function(){  
		if($(this).is(":checked")) {
		category.push($(this).val());
		}			  
		});
		var radius=[];
		$('.radiusdata').each(function(){  
		if($(this).is(":checked")) {
		radius.push($(this).val());
		}			  
		});	   
		
		$('#result').html('');
		load_more(getCookie('pages'),category,activesort,radius);
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
			document.cookie="pages="+page;
			var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
			var category=[];
			$('.catdata').each(function(){
			 if($(this).is(":checked")) {
			 category.push($(this).val());
			 }			  
			});
            var radius=[];
			$('.radiusdata').each(function(){  
			 if($(this).is(":checked")) {
			 radius.push($(this).val());
			 }			  
			});				
			$('#result').html('');
			load_more(getCookie('pages'),category,activesort,radius);
		}
		else
		{
			$('#last_page').val(0);	
			var page=1;
			document.cookie="pages="+page;
			
			var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
			var category=[];
			$('.catdata').each(function(){  
			 if($(this).is(":checked")) {
			 category.push($(this).val());
			 }			  
			});
            var radius=[];
			$('.radiusdata').each(function(){  
			 if($(this).is(":checked")) {
			 radius.push($(this).val());
			 }			  
			});				
			$('#result').html('');
			load_more(getCookie('pages'),category,activesort,radius);
		}	
	  }
	});   
	
	$(".a_as").click(function(){
		$('.stj_ad_srch_inner').slideToggle();
	});
	
});

var page = 1;
document.cookie="pages="+page;
var pagenumber=getCookie('pages');
var category = "";
var sort = "";
var radius = "";
//console.log(getCookie('pages'));
load_more(pagenumber,category,sort,radius);

$(window).scroll(function(){
	
	$('.stj_loader').hide();
	
	     if($('#last_page').val()==0)
		 {
		  if($(window).scrollTop() + $(window).height() + 200 >= $(document).height()) {
	    page++;
		
		
		var pages=getCookie('pages');
		    pages++;
		 var pagenumber=document.cookie="pages="+pages;
		   
			var category=[];
			$('.catdata').each(function(){  
			 if($(this).is(":checked")) {
			 category.push($(this).val());
			 //alert(category);
			 }			  
			});	
			var radius=[];
			$('.radiusdata').each(function(){  
			 if($(this).is(":checked")) {
			 radius.push($(this).val());
			 }			  
			});	
			
			
       var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");		
        load_more(getCookie('pages'),category,activesort,radius);
        $('#current_page').val(getCookie('pages'));		
		    }
		 }
 });
var pagenumber=getCookie('pages');
function load_more(page,cat,sort,radius){
	
	var search=$('#srh_newjobs').val();
	var searchval='';
	if(search!='' && search!=undefined)
	{
		searchval='&search='+search;
	}
	if($('#last_page').val() != 1) {
      $.ajax(
            {
                url: 'get_jobs.php?page='+page+'&category='+cat+'&sort='+sort+searchval+'&radiuscat='+radius,
                type: "get",
                datatype: "html",
                beforeSend: function()
                {
					//$('#last_page').val('1');
					$('.stj_loader').html("Loading...");
                    $('.stj_loader').show();
                }
            })
            .done(function(data)
            {
                if(data.length == 0){
					//$('#last_page').val('1');
					//alert(data.length);
					//alert(search);
					//$('#current_page').val(1);
					$('#last_page').val('1');
					var pageNum = $('#last_page').val();
					
					
					if(search!=''  || page==1)
					{
						$('.stj_loader').show();
                    $('.stj_loader').html("No Jobs Available");
                    }
					else
					{
						$('.stj_loader').show();
						$('.stj_loader').html("No more Jobs Available");
					}
					return false;
                } else {
					$('.stj_loader').hide(); //hide loading animation once data is received
					var advanceSearchValue = readCookie('advanceSearchJobs');
					if(advanceSearchValue != 1){
						$("#result").append(data); //append data into #results element
					} 
					//$('#last_page').val('0');
				}				
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                  //alert('No response from server');
			});
		}
     }
</script>

<script>
$( document ).ready(function() {
	eraseCookie("advanceSearchJobs");
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
<div id="preloader" style="display:none"></div>
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
						<li class="filter_category">
							<label class="chk_lb"><input type="checkbox" name="catdata[]" value="<?php echo $catdata['category_id']; ?>" class="sj_chk catdata" /><?php echo $catdata['category_name']; ?></label>
						</li>
						<?php 
							 }
						 }
						 ?>
					</ul>
				</div>
				
					<?php if(isset($_SESSION['user_id'])){ ?>
					<div class="stj_ctg">
					<h3>Filter By Radius</h3>
					<ul>
						<li class="filter_radius">
							<label class="chk_lb"><input type="checkbox" name="radiusdata[]" value="1" class="sj_chk radiusdata" />Less than 1 Mile</label>
						</li>
						<li class="filter_radius">
							<label class="chk_lb"><input type="checkbox" name="radiusdata[]" value="2" class="sj_chk radiusdata" />1 to 5 Miles</label>
						</li>
						<li class="filter_radius">
							<label class="chk_lb"><input type="checkbox" name="radiusdata[]" value="3" class="sj_chk radiusdata" />5 to 10 Miles</label>
						</li>
						<li class="filter_radius">
							<label class="chk_lb"><input type="checkbox" name="radiusdata[]" value="4" class="sj_chk radiusdata" />10 to 15 Miles</label>
						</li>
						<li class="filter_radius">
							<label class="chk_lb"><input type="checkbox" name="radiusdata[]" value="5" class="sj_chk radiusdata" />Greater than 15 Miles</label>
						</li>
					</ul>
					</div>
					<?php } ?>
				

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
                      <li><a href="#tab1">New Jobs</a></li>
                      <li><a href="#tab2">Ongoing Bids</a></li>
                      <li><a href="#tab3">Confirmed Jobs</a></li>
                      <li><a href="#tab4">Ongoing Jobs</a></li>
                      <li><a href="#tab5">Completed Jobs</a></li>
                    </ul>
                    
                    <div class="tab_container">
                    	<div id="tab1" class="tab_content">
                    		
                    		<div class="stj_sort">
                    			<ul class="sort_ul">
                    				<li><label>Sort By</label></li>
                    				<li><a class="active" data-sortby="newest" href="javascript:void(0);">Newest First</a></li>
                    				<li><a  data-sortby="oldest" href="javascript:void(0);">Oldest First</a></li>
                    				<li><a data-sortby="priceh" href="javascript:void(0);">Price-High to Low</a></li>
                    				<li><a data-sortby="pricel" href="javascript:void(0);">Price-Low to High</a></li>
                    			</ul>
                    			<div class="srch_dv">
                    				<input type="text" name="srh_newjobs" id="srh_newjobs" class="txt_srch" placeholder="Search" />
                    				<input type="button" class="btn_srch" id="new_srch" value="Go" />
                    			</div>
                    		</div>
							
							<!-- ADVANCE FILTER START -->
                    		<div class="stj_ad_srch">
                    			<a class="a_as" href="javascript:void(0)">Advanced Search</a>
                    			<div class="stj_ad_srch_inner">
                    				<ul>
										<form>
										<!-- JOB TITLE START -->
                    					<li>
                    						<label>Job Title</label>
                    						<input name="job_title" id="job_title" class="txt_lg" placeholder="Enter Job Title" type="text">
										</li>
										<!-- JOB TITLE END -->
										
										<!-- OPENING TYPE START -->
                    					<li>
											<label>Opening Type </label>
											<div class="radio">
												<div class="rdrow">
													<input  id="rd0" class="rd_chk" value="" name="opening_type" checked type="radio">
													<label for="rd0">All</label>
												</div>
												<div class="rdrow">
													<input  id="rd1" class="rd_chk" value="1" name="opening_type" type="radio">
													<label for="rd1">Single</label>
												</div>
												<div class="rdrow">
													<input  id="rd2" class="rd_chk" value="2" name="opening_type" type="radio">
													<label for="rd2">Multiple</label>
												</div>
											</div>
										</li>
										<!-- OPENING TYPE END -->
										
										<!-- JOB LOCATION START -->
                    					<li>
											<label>Job Location </label>
											<select name="job_location" data-validation-engine="validate[required]" data-errormessage-value-missing="Select job location" placeholder="Select Job Location">
												<option value="">Select job location</option>
												<?php 
												$sql=mysql_query("select location_id,locationname from tbllocation where status=1 order by locationname");
												$rows=mysql_num_rows($sql);
												if($rows > 0)
												{
													while($locationdata=mysql_fetch_array($sql))
													{
												?>
												<option value="<?php echo $locationdata['locationname']; ?>"><?php echo $locationdata['locationname']; ?></option>
														<?php 
													}
												}
												?>
											</select>
										</li>
										<!-- JOB LOCATION END -->
										
										<!-- JOB CATEGORIES START -->
                    					<li>
											<label>Job Category</label>
												<select name="job_categories" data-validation-engine="validate[required]" data-errormessage-value-missing="Select job categories" placeholder="Select Job category">
												<option value="">Select job category</option>
												<?php 
												$sql=mysql_query("select category_id,category_name from tblcategory where isactive=1 order by category_name");
												$rows=mysql_num_rows($sql);
												if($rows > 0)
												{
													while($catdata=mysql_fetch_array($sql))
													{
												?>
													<option value="<?php echo $catdata['category_id']; ?>"><?php echo $catdata['category_name']; ?></option>
													<?php }
												}
												?>						 
											</select>
										</li>
										<!-- JOB CATEGORIES END -->
										
										<!-- RISK METER START -->
                    					<li>
											<label>Risk Meter</label>
											<select name="riskmeter" id="riskmeter">
												<option value="">Select</option>
												<option value="1">Low</option>
												<option value="2">Medium</option>
												<option value="3">High</option>
												<option value="4">Very High</option>
											</select>
										</li>
										<!-- RISK METER END -->

                    					<!-- FEATURED LISTING START -->
                    					<li>
											<label>Featured Job </label>
											<select name="featured" id="featured">
												<option value="">Select</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
											</select>
										</li>
										<!-- FEATURED LISTING END -->

										<!-- NEAREST TRANSPORT LINK START -->
										<li>
                    						<label>Transport Link</label>
                    						<input name="transportlink" id="transportlink" class="txt_lg" placeholder="Enter Transport Link" type="text">
										</li>
										<!-- NEAREST TRANSPORT LINK END -->


										<!-- DRESS CODE START -->
										<li>
                    						<label>Dress Code</label>
                    						<input name="dresscode" id="dresscode" class="txt_lg" placeholder="Enter Dress Code" type="text">
										</li>
										<!-- DRESS CODE END -->
										
										<!-- PRICE START -->
                    					<li>
                    						<label>Price</label>
                    						<input name="job_price" id="job_price" class="txt_lg" placeholder="Enter Price" type="text">
										</li>
										<!-- PRICE END -->

										<!-- JOB DAYS START -->
                    					<li>
                    						<label>Job Days</label>
                    						<input name="job_days" id="job_days" class="txt_lg" placeholder="Job Days" type="text">
										</li>
										<!-- JOB DAYS END -->

										<!-- JOB DATE START (START) -->
                    					<li>
                    						<label>Between Dates (Start)</label>
                    						<input class="txt_lg datepicker" name="startofdate" value="" id="datepickerstart" type="text">
										</li>
										<!-- JOB DATE END (START) -->

										<!-- JOB DATE START (END) -->
                    					<li>
                    						<label>Between Dates (End)</label>
                    						<input class="txt_lg datepicker" name="endofdate" value="" id="datepickerend" type="text">
										</li>
										<!-- JOB DATE END (END) -->
										
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
                    		
                    		<div class="stj_job_list">
								<input type="hidden" name="last_page" id="last_page" value="0">	
                                <input type="hidden" name="current_page" id="current_page" value="1">		
                    			<ul id="result">
                                </ul>
                    		</div>
                    		
                    	</div>
                    </div>
                    
				</div>
					<div class="stj_loader" style="display:none;">Loading...</div>
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
                }
            });
            
        } else {
            searchData('', '');
        }
	}
    
    function searchData(latitude,longitude) {
		var jobTitle = $('#job_title').val();
		var openingType = $("input[name~='opening_type']:checked").val();
		var jobLocation = $("select[name~='job_location'] option:selected").val();
		var jobCategory = $("select[name~='job_categories'] option:selected").val();
		var riskMeter = $("select[name~='riskmeter'] option:selected").val();
		var featuredJob = $("select[name~='featured'] option:selected").val();
		var zipMiles = $("select[name~='zip_miles'] option:selected").val();
		var startDateString = $("#datepickerstart").val().split('/');
		var endDateString = $("#datepickerend").val().split('/');

		if(startDateString != ''){
			var startDate =  startDateString[2]+'-'+startDateString[1]+'-'+startDateString[0];
		}else{
			var startDate =  '';
		}

		if(endDateString != ''){
			var endDate = endDateString[2]+'-'+endDateString[1]+'-'+endDateString[0];
		}else{
			var endDate = '';
		}

		var transportLink = $('#transportlink').val();
		var dressCode = $('#dresscode').val();
		var zipCode = $('#zip_code').val();
		var jobPrice = $('#job_price').val();
		var jobDays = $('#job_days').val();
		
		if(zipMiles != '' && zipCode == ""){
			alert("Please enter the postcode.");
			return false;
		}

		$('.stj_ad_srch_inner').slideToggle();

        $.ajax({
			type: 'GET',
			url: 'get_jobs_advance.php?jobTitle='+jobTitle+'&openingType='+openingType+'&jobLocation='+jobLocation+'&jobCategory='+jobCategory+'&riskMeter='+riskMeter+'&featuredJob='+featuredJob+'&transportLink='+transportLink+'&dressCode='+dressCode+'&longi='+longitude+'&lati='+latitude+'&zipMiles='+zipMiles+'&jobPrice='+jobPrice+'&jobDays='+jobDays+'&startDate='+startDate+'&endDate='+endDate,
			datatype: "html",
			beforeSend: function()
			{
				$('#preloader').show();
			}
		})
		.success(function(data){
			$('#preloader').hide();
			$('#result').html(data);
			createCookie('advanceSearchJobs', '1', 1);
		})
		.fail(function(jqXHR, ajaxOptions, thrownError){
			alert('No response from server');
		});
    }

</script>
<!-- Advance Search Script End -->

<!-- Close Toggle Start -->
<script>
	function closeToggle() {
		$('.stj_ad_srch_inner').slideToggle();
	}
</script>
<!-- Close Toggle End -->


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
			url: 'get_jobs_advance.php?longi='+longitude+'&lati='+latitude+'&zipMiles='+zipMiles,
			datatype: "html",
			beforeSend: function()
			{
				$('#preloader').show();
			}
		})
		.success(function(data){
			$('#preloader').hide();
			$('#result').html(data);
			createCookie('advanceSearchJobs', '1', 1);
		})
		.fail(function(jqXHR, ajaxOptions, thrownError){
			alert('No response from server');
		});
    }

</script>
<!-- Item Location Script End -->
<?php include "footer.php"; ?>
</body>
</html>