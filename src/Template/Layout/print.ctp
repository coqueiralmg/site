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
                echo $title . " | " . $this->Data->setting('System.name');
            }
            else
            {
                echo $this->Data->setting('System.name');
            }
        ?>
    </title>

    <!-- Bootstrap core CSS     -->
    <?= $this->Html->css('bootstrap.min.css') ?>
    <!--  Material Dashboard CSS    -->
    <?= $this->Html->css('material-dashboard.css') ?>

    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

	<?= $this->Html->script('jquery.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('material-dashboard.js') ?>

    <script type="text/javascript">
        $(function () {
           window.print();
        });
    </script>
</head>

<body style="width:21cm; background: white;">
	<div class="wrapper">
	    <div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                <tr>
                                    <td style="width: 15%">
                                        <?= $this->Html->image('brasao_coqueiral.png', ['class' => 'img-responsive', 'style' => 'padding: 15px;', 'title' => 'Prefeitura Municipal de Coqueiral', 'alt' => 'Prefeitura Municipal de Coqueiral']); ?>
                                    </td>
                                    <td>
                                        <h4><b>Prefeitura Municipal de Coqueiral</b></h1>
                                        <span><b>Estado de Minas Gerais</b></span><br/>
                                        <span>Rua Minas Gerais, 62 - Vila Sônia - Coqueiral - MG</span><br/>
                                        <span>Telefone: (35) 3855-1162 | (35) 3855-1166</span><br/>
                                        <span>CNPJ: 18.239.624/0001-21</span>
                                    </td>
                                </tr>
                            </table>
                            <?= $this->fetch('content') ?>
                        </div>
                    </div>
                </div>
            </div>

		</div>
	</div>
</body>
	
	
</html>
