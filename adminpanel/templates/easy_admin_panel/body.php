<section>
<!-- left side start-->
	<div class="left-side sticky-left-side">

		<!--logo and iconic logo start-->
		<div class="logo">
			<h1><a href="/adminpanel/">SWP <span>Admin</span></a></h1>
		</div>
		<div class="logo-icon text-center">
			<a href="/adminpanel/"><i class="lnr lnr-home"></i> </a>
		</div>

		<!--logo and iconic logo end-->
		<div class="left-side-inner">
			<? //Маленькие картиночки - https://linearicons.com/free?>
			<!--sidebar nav start-->
				<ul class="nav nav-pills nav-stacked custom-nav">
					<li class="active"><a href="/adminpanel/"><i class="lnr lnr-power-switch"></i><span>Adminpanel</span></a></li>
					<li class="menu-list">
						<a href="#"><i class="lnr lnr-cog"></i>
							<span>Настройки</span></a>
							<ul class="sub-menu-list">
								<li><a href="/adminpanel/?page=TeKcToBku">Системные сообщения</a></li>
								<li><a href="/adminpanel/?page=HACTPOuKu">Параметры системы</a></li>
								<? if($userrole=='root'){?><li><a href="/adminpanel/?page=3KCnopT">Экспорт кода и БД</a></li><?}?>
								<li><a href="/adminpanel/?page=O6HoBJleHue">Обновление SWP</a></li>
							</ul>
					</li>
					<li><a href="/adminpanel/?page=MoDyJlu"><i class="lnr lnr-dice"></i> <span>Модули</span></a></li>
					<li class="menu-list"><a href="/adminpanel/?page=noJlb3oBaTeJlu"><i class="lnr lnr-users"></i> <span>Пользователи</span></a>
						<ul class="sub-menu-list">
							<li><a href="/adminpanel/?page=CTPAHuUbI">Управление пользователями</a> </li>
							<li><a href="/adminpanel/?page=CTPAHuUbI">Управление компаниями</a></li>
							<li><a href="/adminpanel/?page=CTPAHuUbI">Управление группами</a> </li>
							<li><a href="/adminpanel/?page=CTPAHuUbI">Права групп</a></li>
							<li><a href="/adminpanel/?page=CTPAHuUbI">Участники групп</a></li>
						</ul>
					</li>              
					<li class="menu-list"><a href="/adminpanel/?page=CoobuuEHuR"><i class="lnr lnr-envelope"></i> <span>Сообщения</span></a>
						<!--ul class="sub-menu-list">
							<li><a href="inbox.html">Inbox</a> </li>
							<li><a href="compose-mail.html">Compose Mail</a></li>
						</ul-->
					</li>      
					
					<li><a href="/adminpanel/?page=KapTuHKu"><i class="lnr lnr-picture"></i> <span>Картинки</span></a></li>
					<li><a href="/adminpanel/?page=CTaTuCTuKa"><i class="lnr lnr-pie-chart"></i> <span>Статистика</span></a></li>
					<li class="menu-list"><a href="#">
					
					<i class="lnr lnr-book"></i>  <span>Страницы</span></a> 
						<ul class="sub-menu-list">
							<li><a href="/adminpanel/?page=CTPAHuUbI">Страницы</a> </li>
							<li><a href="/adminpanel/?page=CTPAHuUbI">Шаблоны</a></li>
						</ul>
					</li>
					<li class="menu-list"><a href="/adminpanel/?page=DokyMeHTbI"><i class="lnr lnr-question-circle"></i> <span>Документация</span></a></li>
				</ul>
			<!--sidebar nav end-->
		</div>
	</div>
	<!-- left side end-->

	<!-- main content start-->
	<div class="main-content">
		<!-- header-starts -->
		<div class="header-section">
		 
		<!--toggle button start-->
		<a class="toggle-btn  menu-collapsed"><i class="fa fa-bars"></i></a>
		<!--toggle button end-->

		<!--notification menu start -->
		<div class="menu-right">
			<div class="user-panel-top">  	
				<div class="profile_details_left">
					<ul class="nofitications-dropdown">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-envelope"></i><span class="badge">3</span></a>
								
									<ul class="dropdown-menu">
										<li>
											<div class="notification_header">
												<h3>You have 3 new messages</h3>
											</div>
										</li>
										<li><a href="#">
										   <div class="user_img"><img src="/adminpanel/templates/<?=$adminsitetemplate?>/images/1.png" alt=""></div>
										   <div class="notification_desc">
											<p>Lorem ipsum dolor sit amet</p>
											<p><span>1 hour ago</span></p>
											</div>
										   <div class="clearfix"></div>	
										 </a></li>
										 <li class="odd"><a href="#">
											<div class="user_img"><img src="/adminpanel/templates/<?=$adminsitetemplate?>/images/1.png" alt=""></div>
										   <div class="notification_desc">
											<p>Lorem ipsum dolor sit amet </p>
											<p><span>1 hour ago</span></p>
											</div>
										  <div class="clearfix"></div>	
										 </a></li>
										<li><a href="#">
										   <div class="user_img"><img src="/adminpanel/templates/<?=$adminsitetemplate?>/images/1.png" alt=""></div>
										   <div class="notification_desc">
											<p>Lorem ipsum dolor sit amet </p>
											<p><span>1 hour ago</span></p>
											</div>
										   <div class="clearfix"></div>	
										</a></li>
										<li>
											<div class="notification_bottom">
												<a href="#">See all messages</a>
											</div> 
										</li>
									</ul>
						</li>
						<li class="login_box" id="loginContainer">
								<div class="search-box">
									<div id="sb-search" class="sb-search">
										<form>
											<input class="sb-search-input" placeholder="Enter your search term..." type="search" id="search">
											<input class="sb-search-submit" type="submit" value="">
											<span class="sb-icon-search"> </span>
										</form>
									</div>
								</div>
									<!-- search-scripts -->
									<!--script src="js/classie.js"></script>
									<script src="js/uisearch.js"></script-->
										<script>
											new UISearch( document.getElementById( 'sb-search' ) );
										</script>
									<!-- //search-scripts -->
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue">3</span></a>
								<ul class="dropdown-menu">
									<li>
										<div class="notification_header">
											<h3>You have 3 new notification</h3>
										</div>
									</li>
									<li><a href="#">
										<div class="user_img"><img src="/adminpanel/templates/<?=$adminsitetemplate?>/images/1.png" alt=""></div>
									   <div class="notification_desc">
										<p>Lorem ipsum dolor sit amet</p>
										<p><span>1 hour ago</span></p>
										</div>
									  <div class="clearfix"></div>	
									 </a></li>
									 <li class="odd"><a href="#">
										<div class="user_img"><img src="/adminpanel/templates/<?=$adminsitetemplate?>/images/1.png" alt=""></div>
									   <div class="notification_desc">
										<p>Lorem ipsum dolor sit amet </p>
										<p><span>1 hour ago</span></p>
										</div>
									   <div class="clearfix"></div>	
									 </a></li>
									 <li><a href="#">
										<div class="user_img"><img src="/adminpanel/templates/<?=$adminsitetemplate?>/images/1.png" alt=""></div>
									   <div class="notification_desc">
										<p>Lorem ipsum dolor sit amet </p>
										<p><span>1 hour ago</span></p>
										</div>
									   <div class="clearfix"></div>	
									 </a></li>
									 <li>
										<div class="notification_bottom">
											<a href="#">See all notification</a>
										</div> 
									</li>
								</ul>
						</li>	
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-tasks"></i><span class="badge blue1">22</span></a>
								<ul class="dropdown-menu">
									<li>
										<div class="notification_header">
											<h3>You have 8 pending task</h3>
										</div>
									</li>
									<li><a href="#">
											<div class="task-info">
											<span class="task-desc">Database update</span><span class="percentage">40%</span>
											<div class="clearfix"></div>	
										   </div>
											<div class="progress progress-striped active">
											 <div class="bar yellow" style="width:40%;"></div>
										</div>
									</a></li>
									<li><a href="#">
										<div class="task-info">
											<span class="task-desc">Dashboard done</span><span class="percentage">90%</span>
										   <div class="clearfix"></div>	
										</div>
									   
										<div class="progress progress-striped active">
											 <div class="bar green" style="width:90%;"></div>
										</div>
									</a></li>
									<li><a href="#">
										<div class="task-info">
											<span class="task-desc">Mobile App</span><span class="percentage">33%</span>
											<div class="clearfix"></div>	
										</div>
									   <div class="progress progress-striped active">
											 <div class="bar red" style="width: 33%;"></div>
										</div>
									</a></li>
									<li><a href="#">
										<div class="task-info">
											<span class="task-desc">Issues fixed</span><span class="percentage">80%</span>
										   <div class="clearfix"></div>	
										</div>
										<div class="progress progress-striped active">
											 <div class="bar  blue" style="width: 80%;"></div>
										</div>
									</a></li>
									<li>
										<div class="notification_bottom">
											<a href="#">See all pending task</a>
										</div> 
									</li>
								</ul>
						</li>		   							   		
						<div class="clearfix"></div>	
					</ul>
				</div>
				<div class="profile_details">		
					<ul>
						<li class="dropdown profile_details_drop">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<div class="profile_img">	
									<span style="background:url(/adminpanel/templates/<?=$adminsitetemplate?>/images/1.jpg) no-repeat center"> </span> 
									 <div class="user-name">
										<p><?if($fullname) echo $fullname; elseif($nickname) echo $nickname; else echo $login;?><span><?=$userrole?></span></p>
									 </div>
									 <i class="lnr lnr-chevron-down"></i>
									 <i class="lnr lnr-chevron-up"></i>
									<div class="clearfix"></div>	
								</div>	
							</a>
							<ul class="dropdown-menu drp-mnu">
								<li> <a href="/adminpanel/?page=HACTPOuKu_noJlb3oBaTeJlR"><i class="fa fa-cog"></i>Настройки</a> </li> 
								<li> <a href="/adminpanel/?page=nPOopuJlb"><i class="fa fa-user"></i>Профиль</a> </li> 
								<li> <a href="/logout/" title="Выйти из Личного кабинета" onclick="logout('messageplace');return false;"><i class="fa fa-sign-out"></i> Выйти</a> </li>
							</ul>
						</li>
						<div class="clearfix"> </div>
					</ul>
				</div>		
				<!--div class="social_icons">
					<div class="col-md-4 social_icons-left">
						<a href="#" class="yui"><i class="fa fa-facebook i1"></i><span>300<sup>+</sup> Likes</span></a>
					</div>
					<div class="col-md-4 social_icons-left pinterest">
						<a href="#"><i class="fa fa-google-plus i1"></i><span>500<sup>+</sup> Shares</span></a>
					</div>
					<div class="col-md-4 social_icons-left twi">
						<a href="#"><i class="fa fa-twitter i1"></i><span>500<sup>+</sup> Tweets</span></a>
					</div>
					<div class="clearfix"> </div>
				</div-->            	
				<div class="clearfix"></div>
			</div>
		  </div>
		<!--notification menu end -->
		</div>
	<!-- //header-ends -->
	
	
	
	<? include($_SERVER['DOCUMENT_ROOT'].'/core/pagemanage.php');?>
	
	
	
		 <!--body wrapper end-->
	</div>
	<!--footer section start-->
		<footer>
		   <p>© Powered by SWP<img src="/files/shoes/Shoe512_yellow.png" height="30px" class="imgmiddle"></p>
		</footer>
	<!--footer section end-->

  <!-- main content end-->
</section>

<!--graph-->
	<link rel="stylesheet" href="/adminpanel/templates/<?=$adminsitetemplate?>/css/graph.css">
	<script src="/adminpanel/templates/<?=$adminsitetemplate?>/js/jquery.flot.min.js"></script>

<!-- search-scripts -->
<script src="/adminpanel/templates/<?=$adminsitetemplate?>/js/classie.js"></script>
<script src="/adminpanel/templates/<?=$adminsitetemplate?>/js/uisearch.js"></script>

<script src="/adminpanel/templates/<?=$adminsitetemplate?>/js/jquery.nicescroll.js"></script>
<script src="/adminpanel/templates/<?=$adminsitetemplate?>/js/scripts.js"></script>
<script src="/adminpanel/templates/<?=$adminsitetemplate?>/js/bootstrap.min.js"></script>
