<!doctype html>
<html lang="pt">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

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

    <!-- Bootstrap core CSS     -->
    <?= $this->Html->css('bootstrap.min.css') ?>
    <!--  Material Dashboard CSS    -->
    <?= $this->Html->css('material-dashboard.css') ?>

	<!-- Bootstrap DatePicker -->
	<?= $this->Html->css('bootstrap-datepicker.css') ?>

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

	<?= $this->Html->script('jquery-3.1.0.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('material.min.js') ?>
    <?= $this->Html->script('chartlist.min.js') ?>
	<?= $this->Html->script('bootstrap-notify.js') ?>
	<?= $this->Html->script('bootstrap-datepicker.min.js') ?>
	<?= $this->Html->script('locales/bootstrap-datepicker.pt-BR.min.js') ?>
	<?= $this->Html->script('jquery.mask.min.js') ?>
	<?= $this->Html->script('ckeditor/ckeditor.js') ?>
    <?= $this->Html->script('material-dashboard.js') ?>
	<?= $this->Html->script('painel.js') ?>
</head>

<body>
	<div class="wrapper">
	    
		<?= $this->element('sidebar') ?>

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
						<a class="navbar-brand" href="#"><i class="material-icons"><?=$icon?></i> <?=$title?></a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="#" class="dropdown-toggle">
									<i class="material-icons">info</i>Último acesso: <?= date_format($ultimo_acesso, 'd/m/Y H:i:s') ?>
								</a>
							</li>

							<li>
								<a href="#" class="dropdown-toggle center" data-toggle="dropdown">
	 							   <i class="material-icons">schedule</i><span id="hora_atual"> Carregando a Hora Corrente</span>
		 						</a>
							</li>

							<li>
								<a href="#" class="dropdown-toggle center" data-toggle="dropdown">
	 							   <i class="material-icons">mail_outline</i> Mensagens
		 						</a>
							</li>
							
							<li>
								<a href="<?= $this->Url->build(['controller' => 'system', 'action' => 'logoff']) ?>" >
	 							   <i class="material-icons">power_settings_new</i> Sair
		 						</a>
							</li>
						</ul>

					</div>
				</div>
			</nav>

			 <?= $this->fetch('content') ?>

			<footer class="footer">
				<div class="container-fluid">
					<p class="copyright pull-left">
						Versão <?= \Cake\Core\Configure::read('system.version') ?>
					</p>
					<p class="copyright pull-right">
						&copy; 2017 Prefeitura Municipal de Coqueiral. Todos os Direitos Reservados.
					</p>
				</div>
			</footer>
		</div>
	</div>

	
</body>
	
	
</html>
