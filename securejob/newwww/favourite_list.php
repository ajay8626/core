<?php 
include "config.php";
unset($_SESSION['request_user_id']);
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
<title>Search Candidate - View Favourite - SECURE THAT JOB</title>

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
			document.cookie="favourite="+page;
		load_more(getCookie('favourite'),category,activesort);
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
			document.cookie="favourite="+page;
		load_more(getCookie('favourite'),category,activesort);
		}
		
        $(this).parent().removeClass("checked");
    }
 });
	
	$(".tab_content").hide(); 
	$("ul.tabs li:nth-child(4n)").addClass("active").show();
	$(".tab_content:first").show();

	$("ul.sort_ul li").click(function() {
	//equalheight('.newrequest ul li .rqstmain');
	$('#last_page').val(0);
	var sorttab=$(this).find("a").attr("href");
	$("ul.sort_ul li").find("a").removeClass("active");
	$(this).find("a").addClass("active");
	var activesort=$(this).find("a").attr("data-sortby");
	var page=1;
	document.cookie="favourite="+page;
	        var category=[];
			$('.catdata').each(function(){  
			 if($(this).is(":checked")) {
			 category.push($(this).val());
			 }			  
			});	
			$('#result').html('');
	load_more(getCookie('favourite'),category,activesort);		
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
	document.cookie="favourite="+page;
	var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
	var category=[];
	$('.catdata').each(function(){  
	 if($(this).is(":checked")) {
	 category.push($(this).val());
	 }			  
	});
	$('#result').html('');
	load_more(getCookie('favourite'),category,activesort);
}
else
{
	$('#last_page').val(0);	
	var page=1;
	document.cookie="favourite="+page;
	
	var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
	var category=[];
	$('.catdata').each(function(){  
	 if($(this).is(":checked")) {
	 category.push($(this).val());
	 }			  
	});
	$('#result').html('');
	load_more(getCookie('favourite'),category,activesort);
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
			document.cookie="favourite="+page;
			var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
			var category=[];
			$('.catdata').each(function(){  
			 if($(this).is(":checked")) {
			 category.push($(this).val());
			 }			  
			});
            			
			$('#result').html('');
			load_more(getCookie('favourite'),category,activesort);
		}
		else
		{
			$('#last_page').val(0);	
			var page=1;
			document.cookie="favourite="+page;
			
			var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");
			var category=[];
			$('.catdata').each(function(){  
			 if($(this).is(":checked")) {
			 category.push($(this).val());
			 }			  
			});
            			
			$('#result').html('');
			load_more(getCookie('favourite'),category,activesort);
		}	
	  }
	});   		
	
});

var page = 1;
document.cookie="favourite="+page;
var pagenumber=getCookie('favourite');
var category = "";
var sort = "";
load_more(pagenumber,category,sort);

$(window).scroll(function(){
	
	$('.stj_loader').hide();
	
	     if($('#last_page').val()==0)
		 {
		  if($(window).scrollTop() + $(window).height() + 200 >= $(document).height()) {
	    page++;
		
		
		var pages=getCookie('favourite');
		    pages++;
		 var pagenumber=document.cookie="favourite="+pages;
		   
			var category=[];
			$('.catdata').each(function(){  
			 if($(this).is(":checked")) {
			 category.push($(this).val());
			 }			  
			});	
			
       var activesort=$("ul.sort_ul li").find("a.active").attr("data-sortby");		
        load_more(getCookie('favourite'),category,activesort);
        $('#current_page').val(getCookie('favourite'));		
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
	if(search!='' && search!=undefined)
	{
		searchval='&search='+search;
	}
	
      $.ajax(
            {
                url: 'get_favourite_list.php?page='+page+'&category='+cat+'&sort='+sort+searchval,
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
                $("#result").append(data); //append data into #results element
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
				<?php echo getMsg(); ?>
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
                    				<input type="text" class="txt_srch" id="srh_newjobs" placeholder="Search" />
                    				<input type="button" class="btn_srch" id="new_srch" value="Go" />
                    			</div>
                    		</div>
                    		
                    		<div class="newrequest">
							<input type="hidden" name="last_page" id="last_page" value="0">	
                                     <input type="hidden" name="current_page" id="current_page" value="1">
							   <ul id="result">
							   </ul>
                    			
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
 
<?php include "footer.php"; ?>
</body>
</html>