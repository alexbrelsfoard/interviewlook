@extends('layouts.main')

@section('title')
Home
@stop

@section('body')
<div id="loader"><i class="fa fa-cog fa-4x fa-spin"></i></div><input type="hidden" id="ajaxUrl" value="http://192.169.140.235/~cloridatech/dev/interviewlook/wp-admin/admin-ajax.php" name="">
<div class="fm-container container">
	<div class="menu">
		<div class="button-close text-right"><a class="fm-button"><i class="fa fa-close fa-2x"></i></a></div>
			<ul><li id="menu-item-529" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-254 current_page_item menu-item-529"><a href="http://192.169.140.235/~cloridatech/dev/interviewlook/">Home</a></li>
<li id="menu-item-445" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-445"><a href="http://192.169.140.235/~cloridatech/dev/interviewlook/select-role/">Register</a></li>
<li id="menu-item-225" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-225"><a href="http://192.169.140.235/~cloridatech/dev/interviewlook/contact-us/">Contact Us</a></li>
<li id="menu-item-224" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-224"><a href="http://192.169.140.235/~cloridatech/dev/interviewlook/demos/">Demos</a></li>
<li id="menu-item-221" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-221"><a href="http://192.169.140.235/~cloridatech/dev/interviewlook/login/">LOOK-in</a></li>
<li><a href="#" class="cjfm-show-login-form">Login</a></li></ul>
	</div>
</div>
<header id="header" class="menu_function">

	<!-- <div id="header-background"></div> -->
	
		<!-- munu by kalai-->
				<div id="mySidenav" class="sidenav" style="display: none;">
		  </div>
		  <a href="javascript:void(0)" class="closebtn"  style="display: none;">&times;</a>
		  <div id="main">
		  	<span style="font-size:30px;cursor:pointer" class="openebtn">&#9776;</span>
		  </div>
<div class="abc" style="display: none">
		 <!--  <a href="#">About</a>
		  <a href="#">Services</a>
		  <a href="#">Clients</a>
		  <a href="#">Contact</a> -->
		  						<!-- <div class="home_menu_single_item"> -->
											        	<a href="http://192.169.140.235/~cloridatech/dev/interviewlook/">Home</a>
				        <!-- </div> -->
				        						<!-- <div class="home_menu_single_item"> -->
											        	<a href="http://192.169.140.235/~cloridatech/dev/interviewlook/select-role/">Register</a>
				        <!-- </div> -->
				        						<!-- <div class="home_menu_single_item"> -->
											        	<a href="http://192.169.140.235/~cloridatech/dev/interviewlook/contact-us/">Contact Us</a>
				        <!-- </div> -->
				        						<!-- <div class="home_menu_single_item"> -->
											        	<a href="http://192.169.140.235/~cloridatech/dev/interviewlook/demos/">Demos</a>
				        <!-- </div> -->
				        						<!-- <div class="home_menu_single_item"> -->
											        	<a href="http://192.169.140.235/~cloridatech/dev/interviewlook/login/">LOOK-in</a>
				        <!-- </div> -->
				        	  </div>
		<div class="header-logo">
		<a href="http://192.169.140.235/~cloridatech/dev/interviewlook"><img src="http://192.169.140.235/~cloridatech/dev/interviewlook/wp-content/uploads/2017/04/Interview-Look.png" alt=""></a>
		</div>
</header>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
	
	<script type="text/javascript">


	jQuery(document).ready(function(){


		// jQuery(".apply_job_videos .list_videos_thumbnail").click(function () {
		// 			// body...
		// 			console.log('one');
		// 			alert();
		// 			jQuery(".apply_job_videos .list_videos_thumbnail").removeClass('active-video');
		// 			jQuery(this).addClass('active-video');
		// 	});



		
		jQuery(".menu_function").click(function(e){
			 e.stopPropagation();
			// alert();
		});
		jQuery(".abc").hide();
		jQuery(".openebtn").click(function(){

			jQuery(".closebtn").show();

		
			jQuery(".openebtn").hide();
	// function openNav() 
	// {
		jQuery("#mySidenav").hide();
	    // jQuery("#mySidenav").show();
	    jQuery("#mySidenav").delay(0).slideDown(500);
		jQuery(".abc").show();
	    document.getElementById("mySidenav").style.width = "250px";
	    document.getElementById("main").style.marginLeft = "250px";
	    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
	// }
});


		jQuery('#mySidenav').click(function(){


		jQuery(".openebtn").show();
//     document.getElementById("mySidenav").style.width = "0";
//     document.getElementById("main").style.marginLeft= "0";
	jQuery('body').css('overflow', 'visible');
    document.body.style.backgroundColor = "white";
    jQuery(".closebtn").hide();



		jQuery("#mySidenav").hide();
// 	    document.getElementById("mySidenav").style.width = "250px";
// 	    document.getElementById("main").style.marginLeft = "250px";
// 	    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
// 	    jQuery("#mySidenav").show();
		jQuery(".abc").hide();

		});
// function closeNav() {
	jQuery(".closebtn").click(function(){
	
		jQuery(".openebtn").show();
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
    document.body.style.backgroundColor = "white";
    jQuery(".abc").hide();
    jQuery("#mySidenav").hide();
    jQuery(".closebtn").hide();
});



	if (jQuery("h3").hasClass("success_msg")) {
    jQuery("body").addClass("form-success-page");
}

// }
});

	(function() {

	var bodyEl = document.body,
		// content = document.querySelector( '.content-wrap' ),
		content = document.querySelector( '.container' ),
		openbtn = document.getElementById( 'open-button' ),
		closebtn = document.getElementById( 'close-button' ),
		isOpen = false;

	function init() {
		initEvents();
	}

	function initEvents() {
		openbtn.addEventListener( 'click', toggleMenu );
		if( closebtn ) {
			closebtn.addEventListener( 'click', toggleMenu );
		}

		// close the menu element if the target it´s not the menu element or one of its descendants..

	setTimeout (function () {
		// body...
		content.addEventListener( 'click', function(ev) {
			var target = ev.target;
			if( isOpen && target !== openbtn ) {
				toggleMenu();
			}
		});
	}, 1000);
	}

	function toggleMenu() {
		if( isOpen ) {
			classie.remove( bodyEl, 'show-menu' );
		}
		else {
			classie.add( bodyEl, 'show-menu' );
		}
		isOpen = !isOpen;
	}

	init();

})();
</script>

	<section id="title" class="page-title-sec">
		<div class="container">
			<h1>Welcome to interviewLOOK</h1>
					</div>
	</section>


<section id="content">
<div class="container">				<div class="guest_user_home_search_main">
		  <form id="form" action="http://192.169.140.235/~cloridatech/dev/interviewlook/search" method="post">
      <!-- <div class="search_by_role">
        <input type="radio" name="search_by" id="aaa" value="looker">search by looker
        <input type="radio" name="search_by" id="bbb" value="lookie">search by lookie
        
      </div> -->
            <div class="search_input">
      		 <select class="postform" name="search_by" id="fields_by_role">
          <option value="looker">Looker</option>
          <option value="lookie">Lookie</option>
        </select>
                  <input type='text' id='ser_designation_looker' name="nser_designation_looker" placeholder="Job Title" value="" class="postform auto_com_desi">
          <input type='text' id='ser_location_looker' name="ser_location_looker" placeholder='Location' value="" class="postform auto_com_location">
      
        <!-- <div class="search_bylookie" style="display: none">
          <input type='text' id='ser_jobtitle_lookie' name="nser_jobtitle_lookie" placeholder="Job Title" class="postform">
          <input type='text' id='ser_location_lookie' name="ser_location_lookie" placeholder='Location' class="postform">
        </div> -->
        <select name="job_type" id="job_type" class="postform">
         <option value="">Select Job Type</option>
         <option value='Freelance'>Freelance</option><option value='Full Time'>Full Time</option><option value='Internship'>Internship</option><option value='Part Time'>Part Time</option><option value='Temporary'>Temporary</option>         
        </select>
      <button type="submit" name=""><i class="fa fa-search" aria-hidden="true"></i></button>
          </div>
      </div>
      <!-- <input type="submit" name=""> -->
    </form>
    <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="YourJquery source path"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>

    <script type="text/javascript">
		$(".auto_com_desi").autocomplete({

source: 'http://192.169.140.235/~cloridatech/dev/interviewlook/wp-content/themes/jobseek/include/designation.php',
 minLength:1

});
$(".auto_com_location").autocomplete({

source: 'http://192.169.140.235/~cloridatech/dev/interviewlook/wp-content/themes/jobseek/include/location.php',
 minLength:1

});	</script>	<!-- <button class="button_nxt">NEXT</button> -->
		</div>
	

	</div>
</section>
@stop