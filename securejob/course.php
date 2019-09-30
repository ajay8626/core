<?php include "config.php"; ?>
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
<title>Courses - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/jquery-ui.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="fonts/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA_JUu2G9vlijX1UgNTylx55U1hZQqw6QI&sensor=true"></script>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
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
	$('label.chk_lb .sj_chk').on('click', function(){
    if($(this).is(":checked")) {
        $(this).parent().addClass("checked");
    } else {
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
		$(activeTab).fadeIn();
		return false;
	});
	
	$("ul.sort_ul li").click(function() {
	$('#last_page').val(0);
	var sorttab=$(this).find("a").attr("href");
	$("ul.sort_ul li").find("a").removeClass("active");
	$(this).find("a").addClass("active");
	var activesort=$(this).find("a").attr("data-sortby");
	var page=1;
	document.cookie="course="+page;
	$('#result').html('');
	load_more(getCookie('course'),activesort);		
	});
	
	$("#new_srch").click(function() {
	if($('#srh_newjobs').val()!='')
	{
		$('#last_page').val(0);	
		var page=1;
		document.cookie="course="+page;
		var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
		$('#result').html('');
		load_more(getCookie('course'),activesort);
	}
	else
	{
		$('#last_page').val(0);
		var page=1;
		document.cookie="course="+page;
		var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
		$('#result').html('');
		load_more(getCookie('course'),activesort);
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
		document.cookie="course="+page;
		var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
		$('#result').html('');
		load_more(getCookie('course'),activesort);
	    }
		else
		{
			$('#last_page').val(0);
			var page=1;
			document.cookie="course="+page;
			var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
			$('#result').html('');
			load_more(getCookie('course'),activesort);
		}	
	  }
	}); 

    $(".a_as").click(function(){
		$('.stj_ad_srch_inner').slideToggle();
	});    
	
	
});

/*
jQuery(document).ready(function($) {	
$('label.chk_lb .sj_chk').on('click', function(){
	alert($(this).val());
});
});*/

var page=1;
document.cookie="course="+page;
var pagenumber=getCookie('course');
//alert(pagenumber);
var sort = "";
load_more(pagenumber,sort);
$(window).scroll(function(){
	$('.stj_loader').hide();
	if($('#last_page').val()==0)
		 {
		  if($(window).scrollTop() + $(window).height() + 200 >= $(document).height()) {
			  
			  var pages=getCookie('course');
		      pages++;
		      var pagenumber=document.cookie="course="+pages;
			  var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
			  
	    page++; //page number increment
        load_more(getCookie('course'),activesort); //load content   
		    }
		 }
 });    
function load_more(page,sort){
	
	var search=$('#srh_newjobs').val();
	var searchval='';
	if(search!='' && search!=undefined)
	{
		searchval='&search='+search;
	}
	if($('#last_page').val() != 1) {
      $.ajax({
			url: 'get_course.php?page=' +page+'&sort='+sort+searchval,
			type: "get",
			datatype: "html",
			beforeSend: function()
			{
				$('.stj_loader').html("Loading...");
				$('.stj_loader').show();
			}
        })
		.done(function(data)
		{
			if(data.length == 0){
				$('#last_page').val('1');
				//notify user if nothing to load
				$('.stj_loader').html("No Course Available.");
				return;
			}
			$('.stj_loader').show(); //hide loading animation once data is received
			
			/* Below variable is to stop scroll for advance search */
			var advanceSearchValue = readCookie('advanceSearchCourse');
			if(advanceSearchValue != 1){
				$("#result").append(data); //append data into #results element
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
	eraseCookie("advanceSearchCourse");
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
<?php include "header-inner.php"; ?>
<div class="stj_job_wrap stj_course_wrap">
	<div class="container">
		<div class="row">
			
			<div class="col-xs-12 col-md-2 stj_filter">
			 <div class="stj_filter_inn">
				
			 </div>
			</div>
			
			<div class="col-xs-12 col-md-8 stj_crs_dv">
				<h2>Courses</h2>
				
				<div class="stj_crs_inn">
				  <div class="stj_sort">
						<ul class="sort_ul">
							<li><label>Sort By</label></li>
							<li><a class="active" data-sortby="priceh" href="javascript:void(0);">Price-High to Low </a></li>
							<li><a data-sortby="pricel" href="javascript:void(0);">Price-Low to High</a></li>
						</ul>
						<div class="srch_dv">
							<input class="txt_srch" name="srh_newjobs" id="srh_newjobs" placeholder="Search" type="text">
							<input class="btn_srch" id="new_srch" value="Go" type="button">
						</div>
                  </div>
                  
                    <!-- ADVANCE FILTER START -->
                    		<div class="stj_ad_srch">
                    			<a class="a_as" href="javascript:void(0)">Advanced Search</a>
                    			<div class="stj_ad_srch_inner">
                    				<ul>
										<form>
										<!-- COURSE TITLE START -->
                    					<li>
                    						<label>Course Title</label>
                    						<input name="course_title" id="course_title" class="txt_lg" placeholder="Enter Course Title" type="text">
										</li>
										<!-- COURSE TITLE END -->
										
										<!-- COURSE LOCATION START -->
                                        <li>
                    						<label>Course Location</label>
                    						<input name="course_location" id="course_location" class="txt_lg" placeholder="Enter Course Location" type="text">
										</li>
                                        <!-- COURSE LOCATION END -->
                                        
                                        <!-- COURSE DURATION START -->
                                        <li>
                    						<label>Course Duration</label>
                    						<input name="course_duration" id="course_duration" class="txt_lg" placeholder="Enter Course Duration" type="text">
										</li>
                                        <!-- COURSE DURATION END -->
										
                                        <!-- PRICE START -->
                    					<li>
                    						<label>Price</label>
                    						<input name="course_price" id="course_price" class="txt_lg" placeholder="Enter Price" type="text">
										</li>
										<!-- PRICE END -->
                                        
										<!-- COURSE DATE START (START) -->
                    					<li>
                    						<label>Between Dates (Start)</label>
                    						<input class="txt_lg datepicker" name="startofdate" value="" id="datepickerstart" type="text">
										</li>
										<!-- COURSE DATE END (START) -->

										<!-- COURSE DATE START (END) -->
                    					<li>
                    						<label>Between Dates (End)</label>
                    						<input class="txt_lg datepicker" name="endofdate" value="" id="datepickerend" type="text">
										</li>
										<!-- COURSE DATE END (END) -->

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
                  
                  <div class="crs_list">
				  	<input type="hidden" name="last_page" id="last_page" value="0">	
                  	<ul id="result"></ul>
                  </div>
                </div>
                
                <div class="stj_loader">Loading...</div>
                
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
        //alert(address);
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
		var courseTitle = $('#course_title').val();
		var courseLocation = $('#course_location').val();
		var courseDuration = $('#course_duration').val();
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

		var zipCode = $('#zip_code').val();
		var coursePrice = $('#course_price').val();
				
		if(zipMiles != '' && zipCode == ""){
			alert("Please enter the postcode.");
			return false;
		}
        
        if(zipMiles == ""){
            var zipMiles = 2;
        }
        

		$('.stj_ad_srch_inner').slideToggle();

        $.ajax({
			type: 'GET',
			url: 'get_courses_advance.php?courseTitle='+courseTitle+'&courseDuration='+courseDuration+'&courseLocation='+courseLocation+'&longi='+longitude+'&lati='+latitude+'&zipMiles='+zipMiles+'&coursePrice='+coursePrice+'&startDate='+startDate+'&endDate='+endDate,
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
			createCookie('advanceSearchCourse', '1', 1);
			//alert(data);
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

<?php include "footer.php"; ?>

</body>
</html>