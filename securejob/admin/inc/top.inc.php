<header class="main-header">
    
    <a href="" class="logo">
     <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img style="width:30px;" src="img/logo-white.png" alt=""/></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img style="width:150px;" src="img/logo-white.png" alt=""/></span> 
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
		<?php 
		$select_query = mysql_query("SELECT CONCAT(adminfname,' ',adminlname) as adminname from tbladmin where adminid=".$adminsessionstrid);
		list($adminname) = mysql_fetch_row($select_query);	
		?>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="img/img-profile.png" class="user-image" alt="User">
              <span class="hidden-xs"><?php echo $adminname;?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
               <!-- <li class="user-header">
                <img src="img/img-profile.png" class="img-circle" alt="User">

                <p>
                  <?php echo $adminname;?> - ADMIN
                 
                </p>
              </li>
             Menu Body 
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
               
              </li> -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo ADMIN_URL; ?>main.php?pg=modadmin&a_id=<?php echo $adminsessionstrid; ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo ADMIN_URL;?>main.php?pg=logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>