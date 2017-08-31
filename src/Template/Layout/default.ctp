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
                                    <input type="text" id="chave" name="chave" class="search-form" autocomplete="off" placeholder="Pesquisar" minlength="3"  onkeypress="efetuarBusca(e)" required>
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
                        <a href="/">
                            <?= $this->Html->image('logo_footer.png', ['class' => 'img-responsive', 'alt' => 'Prefeitura Municipal de Coqueiral']); ?>
                        </a>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                </div>

                <div class="col-md-7 col-sm-6">
                    <?php if(count($secretarias) > 0): ?>
                        <div class="widget">
                            <h3>Secretarias</h3>
                            <ul>
                                <?php foreach ($secretarias as $secretaria): ?>
                                    <li><a href="<?= 'secretaria/' . $secretaria->slug . '-' . $secretaria->id ?>"><?=$secretaria->nome?></a></li>
                                <?php endforeach; ?>
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
            <div class="row">
                <div class="col-sm-7">
                    &copy; <?=$this->Data->release()?> <?=$this->Data->setting('Author.company')?>. Desenvolvido por <a href="<?=$this->Data->setting('Author.developer.site')?>" target="_blank"><?=$this->Data->setting('Author.developer.name')?></a>.
                </div>
                <div class="col-sm-5">
                    <ul class="pull-right">
                        <li><a href="/">Inicial</a></li>
                        <li><a href="https://e-gov.betha.com.br/transparencia/01030-015/recursos.faces?mun=_fV0IsqgT0A_livlamqEHrXhxsPXsJ0O" target="_blank">Transparência</a></li>
                        <li><a href="/licitacoes">Licitações</a></li>
                        <li><a href="/contato">Contato</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!--/#footer-->

    
    <?= $this->Html->script('jquery.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('jquery.prettyPhoto.js') ?>
    <?= $this->Html->script('jquery.isotope.min.js') ?>
    <?= $this->Html->script('main.js') ?>
    <?= $this->Html->script('wow.min.js') ?>

    <!-- Go to www.addthis.com/dashboard to customize your tools --> 
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5692cd67b91382fb"></script>

    <script>
        function efetuarBusca(e) {
            LE.info("O usuário buscou " + $("#busca").val() + " no site.");
            $("#formBusca").submit();
        }

    </script>

    <script>
        var data = {
            url: window.location.href,
            navigator: navigator.appName,
            language: navigator.language,
            version: navigator.appVersion,
            codification: navigator.appCodeName,
            platform: navigator.platform,
            agent: navigator.userAgent,
            resolution: screen.width + " x " + screen.height
        };

        LE.log(JSON.stringify(data));
    </script>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-98408659-1', 'auto');
        ga('send', 'pageview');

   </script>
</body>

</html>