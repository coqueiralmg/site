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

    <script type="text/javascript">
        $(function () {
           window.print();
        });
    </script>
</head>

<body style="width:21cm">
	<div class="wrapper">
	    <div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <table>
                                    <tr>
                                        <td style="width: 15%">
                                            <?= $this->Html->image('brasao_coqueiral.png', ['class' => 'img-responsive', 'style' => 'padding: 15px;', 'width' => '100px;', 'title' => 'Prefeitura Municipal de Coqueiral', 'alt' => 'Prefeitura Municipal de Coqueiral']); ?>
                                        </td>
                                        <td>
                                            <h4><b>Prefeitura Municipal de Coqueiral</b></h1>
                                            <span>Estado de Minas Gerais</span>
                                            <address>Rua Minas Gerais, 62 - Vila Sônia - Coqueiral - MG</address>
                                        </td>
                                        <td>
                                            <p></p>
                                            <p>Data de Impressão: <?= date('d/m/Y H:i:s') ?></p>
                                            <p>Impresso por: <?=$this->request->session()->read('UsuarioNome') ?></p>
                                        </td>
                                    </tr>
                                </table>
                                <?= $this->fetch('content') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
