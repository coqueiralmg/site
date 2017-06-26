<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>
        <?php
            if(isset($title))
            {
                echo $title . " | " . \Cake\Core\Configure::read('system.name');
            }
            else
            {
                echo \Cake\Core\Configure::read('system.name');
            }
        ?>
    </title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <?= $this->Html->css('bootstrap.min.css') ?>
    <!--  Material Dashboard CSS    -->
    <?= $this->Html->css('material-dashboard.css') ?>
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <?= $this->Html->css('demo.css') ?>
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
</head>

<body>

	<div class="wrapper">

	    <div class="sidebar" data-background-color="white" data-color="green">
			<!--
		        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

		        Tip 2: you can also add an image using data-image tag
		    -->

			<div class="logo">
				<a href="#" class="simple-text">
					Prefeitura de Coqueiral
				</a>
			</div>
			
			<div class="user">
				
				<div class="info">
					<a data-toggle="collapse" href="#collapseExample" class="collapsed" aria-expanded="false">
						Tania Andrew
						<b class="caret"></b>
					</a>
					<div class="collapse" id="collapseExample" aria-expanded="false" style="height: auto;">
						<ul class="nav">
							<li>
								<a href="#">My Profile</a>
							</li>
							<li>
								<a href="#">Edit Profile</a>
							</li>
							<li>
								<a href="#">Settings</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
	    	<div class="sidebar-wrapper">
	            <ul class="nav">
	                <li class="active">
	                    <a href="dashboard.html">
	                        <i class="material-icons">dashboard</i>
	                        <p>Painel</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="user.html">
	                        <i class="material-icons">person</i>
	                        <p>Usuários</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="table.html">
	                        <i class="material-icons">group_work</i>
	                        <p>Grupo de Usuários</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="typography.html">
	                        <i class="material-icons">library_books</i>
	                        <p>Publicações</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="icons.html">
	                        <i class="material-icons">work</i>
	                        <p>Licitações</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="maps.html">
	                        <i class="material-icons">style</i>
	                        <p>Notícias</p>
	                    </a>
	                </li>
	                
	            </ul>
	    	</div>
	    </div>

	    <div class="main-panel">
			<nav class="navbar navbar-transparent navbar-absolute">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">Painel Principal</a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							
							
							<li>
								<a href="#pablo" class="dropdown-toggle center" data-toggle="dropdown">
	 							   <i class="material-icons">power_settings_new</i>
	 							   <p>Sair</p>
		 						</a>
							</li>
						</ul>

					</div>
				</div>
			</nav>

			 <?= $this->fetch('content') ?>

			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						<ul>
							<li>
								<a href="#">
									Home
								</a>
							</li>
							<li>
								<a href="#">
									Company
								</a>
							</li>
							<li>
								<a href="#">
									Portfolio
								</a>
							</li>
							<li>
								<a href="#">
								   Blog
								</a>
							</li>
						</ul>
					</nav>
					<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
					</p>
				</div>
			</footer>
		</div>
	</div>

</body>

	<?= $this->Html->script('jquery-3.1.0.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('material.min.js') ?>
    <?= $this->Html->script('chartlist.min.js') ?>
    <?= $this->Html->script('bootstrap-notify.js') ?>
    <?= $this->Html->script('material-dashboard.js') ?>
    <?= $this->Html->script('demo.js') ?>

	<script type="text/javascript">
    	$(document).ready(function(){

			// Javascript method's body can be found in assets/js/demos.js
        	demo.initDashboardPageCharts();

    	});
	</script>

</html>
