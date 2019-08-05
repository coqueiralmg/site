<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Site oficial da Prefeitura Municipal de Coqueiral">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="7fEpE0IROydpIMxVfMVazAHHWbWeAH3t8RIHZVCLjFM" />
    <meta name="theme-color" content="#254C49">

    <?= $this->element('social_tags') ?>

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

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('font-awesome.css') ?>
    <?= $this->Html->css('animate.min.css') ?>
    <?= $this->Html->css('prettyPhoto.css') ?>
    <?= $this->Html->css('main.css') ?>
    <?= $this->Html->css('responsive.css') ?>
    <?= $this->Html->css('jquery-ui.css') ?>

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="img/favicon.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.js"></script>


    <div id="fb-root"></div>
    <?= $this->element('scriptsh') ?>
</head>
<!--/head-->

<body class="homepage">
    <header id="header">
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="top-number">
                            <p><a href="tel:+553538551517"><i class="fa fa-phone-square"></i><span class="sr-only">Telefone para contato:</span> (35) 3855-1517</a></p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="social">
                            <ul class="social-share">
                                <li><a href="https://www.facebook.com/prefeituradecoqueiral" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://www.instagram.com/prefeituradecoqueiral/" title="Instagram" target="_blank"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                            <div class="search">
                                <form id="formBusca" action="/busca" method="get" role="form">
                                    <input type="text" id="chave-topo" name="chave" class="search-form" autocomplete="off" placeholder="Pesquisar" onkeypress="return efetuarBusca(event)">
                                    <a href="#" onclick="return efetuarBusca()"><i class="fa fa-search"></i></a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.container-->
        </div>
        <!--/.top-bar-->
        <?= $this->element('menu') ?>

        <!--/nav-->

    </header>
    <!--/header-->

     <?= $this->fetch('content') ?>

    <section id="bottom">
        <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <a href="/">
                            <?= $this->Html->image('logo_footer.png', ['class' => 'img-responsive', 'alt' => 'Prefeitura Municipal de Coqueiral']); ?>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <?php if(count($secretarias) > 0): ?>
                        <div class="widget">
                            <h3>Secretarias</h3>
                            <ul>
                                <?php foreach ($secretarias as $secretaria): ?>
                                    <li><a href="<?= '/secretaria/' . $secretaria->slug . '-' . $secretaria->id ?>"><?=$secretaria->nome?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 col-sm-12">
                    <?php if(count($secretarias) > 0): ?>
                        <div class="widget">
                            <h3>Links</h3>
                            <ul>
                                <li><a href="http://camaracoqueiral.com.br/" target="_blank">Câmara Municipal</a></li>
                                <li><a href="http://saaecoqueiral.com.br/" target="_blank">SAAE</a></li>
                                <li><a href="http://portalamm.org.br/" target="_blank">Associação Mineira dos Municípios</a></li>
                                <li><a href="http://www.diariomunicipal.com.br/amm-mg/" target="_blank">Diário Oficial dos Municípios - AMM</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!--/#bottom-->

    <footer id="footer" class="midnight-blue">
        <div class="container">
            <?= $this->element('rodape') ?>
        </div>
    </footer>
    <!--/#footer-->


    <?= $this->Html->script('jquery.js') ?>
    <?= $this->Html->script('jquery-ui.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('jquery.prettyPhoto.js') ?>
    <?= $this->Html->script('jquery.isotope.min.js') ?>
    <?= $this->Html->script('main.js') ?>
    <?= $this->Html->script('wow.min.js') ?>
    <?= $this->fetch('scriptBottom') ?>

    <?= $this->element('scriptsf') ?>
</body>

</html>
