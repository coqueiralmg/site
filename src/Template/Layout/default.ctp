<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site oficial da Prefeitura Municipal de Coqueiral">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="7fEpE0IROydpIMxVfMVazAHHWbWeAH3t8RIHZVCLjFM" />
    <meta name="description" content="Site oficial da Prefeitura Municipal de Coqueiral">
    <meta name="theme-color" content="#254C49">

    <?php $this->fetch('metas') ?>
    <meta property="og:image" content="img/logotipo1.png"/>

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

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('font-awesome.min.css') ?>
    <?= $this->Html->css('animate.min.css') ?>
    <?= $this->Html->css('prettyPhoto.css') ?>
    <?= $this->Html->css('main.css') ?>
    <?= $this->Html->css('responsive.css') ?>

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="img/favicon.png">

    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.3";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <?= $this->Html->script('le.js') ?>
    <script>
        LE.init('04c497c0-786e-40ec-b62b-0dcff9b83765');
    </script>

    <!-- Piwik -->
    <script type="text/javascript">
    var _paq = _paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="//piwik.coqueiral.mg.gov.br/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', '1']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
    </script>
    <!-- End Piwik Code -->
</head>
<!--/head-->

<body class="homepage">
    <header id="header">
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-xs-5">
                        <div class="top-number">
                            <p><a href="tel:+553538551162"><i class="fa fa-phone-square"></i><span class="sr-only">Telefone para contato:</span> (35) 3855-1162</a></p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-7">
                        <div class="social">
                            <ul class="social-share">
                                <li><a href="https://www.facebook.com/prefeituradecoqueiral" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" title="LinkedIn"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                            <div class="search">
                                <form id="formBusca" action="/busca" method="get" role="form">
                                    <input type="text" id="busca" name="busca" class="search-form" autocomplete="off" placeholder="Pesquisar" minlength="3"  onkeypress="efetuarBusca(e)" required>
                                    <a href="#" onclick="efetuarBusca()"><i class="fa fa-search"></i></a>
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
                        <a href="index.html">
                            <img src="img/logo_footer.png" class="img-responsive" />
                        </a>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                </div>

                <div class="col-md-7 col-sm-6">
                    <div class="widget">
                        <h3>Secretarias</h3>
                        <ul>
                            <li><a href="#">Departamento de Meio Ambiente</a></li>
                            <li><a href="#">Secretaria Municipal de Educação e Cultura</a></li>
                            <li><a href="#">Secretaria Municipal de Saúde</a></li>
                            <li><a href="#">Departamento de Cultura</a></li>
                            <li><a href="#">Departamento de Obras e Serviços</a></li>
                            <li><a href="#">Secretaria Municipal de Obras</a></li>
                            <li><a href="#">Secretaria Municipal de Bem Estar e Ação Social</a></li>
                            <li><a href="#">Procuradoria Geral do Município</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/#bottom-->

    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; 2017 Prefeitura Municipal de Coqueiral. Todos os direitos reservados.
                </div>
                <div class="col-sm-6">
                    <ul class="pull-right">
                        <li><a href="index.html">Página Inicial</a></li>
                        <li><a href="http://www.transparencia.mg.gov.br/municipios/coqueiral" target="_blank">Transparência</a></li>
                        <li><a href="legislacao.html">Legislação</a></li>
                        <li><a href="publicacoes.html">Publicações</a></li>
                        <li><a href="contato.html">Contato</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!--/#footer-->

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/wow.min.js"></script>
</body>

</html>