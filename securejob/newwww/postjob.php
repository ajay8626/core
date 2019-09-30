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
<title>New Jobs - SECURE THAT JOB</title>

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


	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active");
		$(this).addClass("active"); 
		$(".tab_content").hide();
        
		var activeTab = $(this).find("a").attr("href"); 
		
		if(activeTab=='#tab1')
		{
		location.replace("postjob.php");
		}
		if(activeTab=='#tab2')
		{
		location.replace("pending_post_job.php");
		}
		if(activeTab=='#tab3')
		{
		location.replace("confirmed_post_job.php");
		}
		if(activeTab=='#tab4')
		{
		location.replace("ongoing_post_job.php");
		}
		if(activeTab=='#tab5')
		{
		location.replace("completed_post_job.php");
		}
		if(activeTab=='add-new-job.php')
		{
			location.replace("add-new-job.php");
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
var category='';
		var sort='';
document.cookie="postpage="+page;
var pagenumber=getCookie('postpage');
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
			 $('.stj_loader').html("No more Jobs Available");
			 }
		 }
});    

function load_more(page,cat,sort){
	
	var search=$('#srh_newjobs').val();
	var searchval='';
	if(search!='' && search!=undefined)
	{
		searchval='&search='+search;
	}
	
	if($('#last_page').val() != 1) {
		$.ajax(
				{
					url: 'get_post_job.php?page='+page+'&category='+cat+'&sort='+sort+searchval,
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
							$('.stj_loader').html("No Jobs Available");
						} else if((search=='' || search==undefined) && $('#current_page').val()==1) {
							$('.stj_loader').html("No Jobs Available");	
						}
						else
						{
							$('.stj_loader').html("No more Jobs Available");
						}
						return false;
					}
					$('#last_page').val('0');
					$('.stj_loader').hide(); //hide loading animation once data is received
					$("#result").append(data); //append data into #results element          
				})
				.fail(function(jqXHR, ajaxOptions, thrownError)
				{
					
					//alert('No response from server');
			});
		}
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
				
			 </div>
			</div>
			
			<div class="col-xs-12 col-md-8 stj_jb">
				<div class="stj_jb_inr">
				
					<ul class="tabs tabs_anj">
                      <li><a href="#tab1">New Jobs</a></li>
                      <li><a href="#tab2">Pending Payments</a></li>
                      <li><a href="#tab3">Confirmed Jobs</a></li>
                      <li><a href="#tab4">Ongoing Jobs</a></li>
                      <li><a href="#tab5">Completed Jobs</a></li>
                      <li class="anj_li"><a href="add-new-job.php">Add New job</a></li>
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
 
<?php include "footer.php"; ?>
</body>
</html>