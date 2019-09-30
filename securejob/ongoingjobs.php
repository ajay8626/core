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
<title>Ongoing Jobs - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
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
			document.cookie="pages="+page;
		load_more(getCookie('pages'),category,activesort);
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
		load_more(getCookie('pages'),category,activesort);
		}
		$(this).parent().removeClass("checked");
    }
 });
	
	$(".tab_content").hide(); 
	$("ul.tabs li:nth-child(4n)").addClass("active").show();
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
	        var category=[];
			$('.catdata').each(function(){  
			 if($(this).is(":checked")) {
			 category.push($(this).val());
			 }			  
			});	
			$('#result').html('');
	load_more(getCookie('pages'),category,activesort);		
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
	$('#result').html('');
	load_more(getCookie('pages'),category,activesort);
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
	$('#result').html('');
	load_more(getCookie('pages'),category,activesort);
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
			$('#result').html('');
			load_more(getCookie('pages'),category,activesort);
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
			$('#result').html('');
			load_more(getCookie('pages'),category,activesort);
		}	
	  }
	});   	
	
});	




var page = 1;
document.cookie="pages="+page;
var pagenumber=getCookie('pages');
var category = "";
var sort = "";
//console.log(getCookie('pages'));
load_more(pagenumber,category,sort);

$(window).scroll(function(){
	
	$('.stj_loader').hide();
	
	     if($('#last_page').val()==0)
		 {
		  if($(window).scrollTop() + $(window).height() + 200 >= $(document).height()) {
	    page++;
		
		
		var pages=getCookie('pages');
		    pages++;
		 var pagenumber=document.cookie="pages="+pages;
		   //pages++;
		//document.cookie="pages="+page;
		
		//pages++;
		//document.cookie="pages="+page;
			var category=[];
			$('.catdata').each(function(){  
			 if($(this).is(":checked")) {
			 category.push($(this).val());
			 //alert(category);
			 }			  
			});	
			
       var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");		
        load_more(getCookie('pages'),category,activesort);
        $('#current_page').val(getCookie('pages'));		
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
	
      $.ajax(
            {
                url: 'get_ongoing_jobs.php?page='+page+'&category='+cat+'&sort='+sort+searchval,
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
				//alert(data);
                if(data.length == 0){
					//$('#current_page').val(1);
					$('#last_page').val('1');
                    if(search!='' || page==1)
					{
                    $('.stj_loader').html("NO JOBS AVAILABLE");
                    }
					else
					{
						$('.stj_loader').html("No More JOBS AVAILABLE");
					}
                    return false;
                }
                $('.stj_loader').hide(); //hide loading animation once data is received
                $("#result").append(data); //append data into #results element
                $('#last_page').val('1');				
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                  //alert('No response from server');
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
				<div class="stj_ctg">
					<h3>Filter By Radius</h3>
					<ul>
						<li>
							<label class="chk_lb"><input type="checkbox" class="sj_chk" />Less than 1 Mile</label>
						</li>
						<li>
							<label class="chk_lb"><input type="checkbox" class="sj_chk" />1 to 5 Miles</label>
						</li>
						<li>
							<label class="chk_lb"><input type="checkbox" class="sj_chk" />5 to 10 Miles</label>
						</li>
						<li>
							<label class="chk_lb"><input type="checkbox" class="sj_chk" />10 to 15 Miles</label>
						</li>
						<li>
							<label class="chk_lb"><input type="checkbox" class="sj_chk" />Greater than 15 Miles</label>
						</li>
					</ul>
				</div>
			 </div>
			</div>
			
			<div class="col-xs-12 col-md-8 stj_jb">
				<div class="stj_jb_inr">
				
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