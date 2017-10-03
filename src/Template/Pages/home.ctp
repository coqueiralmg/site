<?php if(count($banners) > 0): ?>
    <section id="main-slider" class="no-margin">
        <div class="carousel slide">
            <ol class="carousel-indicators">
                <?php for($i = 0; $i < count($banners); $i++):?>
                    <?php if($i == 0):?>
                        <li data-target="#main-slider" data-slide-to="<?=$i?>" class="active"></li>
                    <?php else: ?>
                        <li data-target="#main-slider" data-slide-to="<?=$i?>"></li>
                    <?php endif;?>
                <?php endfor;?>
            </ol>
            <div class="carousel-inner">
                <?php for($i = 0; $i < count($banners); $i++):?>
                    <div class="<?=($i == 0) ? 'item active' : 'item'?>" style="background-image: url(<?=$banners[$i]->imagem?>)">
                        <div class="container">
                            <div class="row slide-margin">
                                <div class="col-sm-6">
                                    <div class="carousel-content">
                                        <h1 class="animation animated-item-1"><?=$banners[$i]->titulo?></h1>
                                        <h2 class="animation animated-item-2"><?=$banners[$i]->descricao?></h2>
                                        <?php if($banners[$i]->acao != ''): ?>
                                            <?php if($banners[$i]->blank):?>
                                                <a class="btn-slide animation animated-item-3" href="<?=$banners[$i]->destino?>" target="_blank"><?=$banners[$i]->acao?></a>
                                            <?php else: ?>
                                                <a class="btn-slide animation animated-item-3" href="<?=$banners[$i]->destino?>"><?=$banners[$i]->acao?></a>
                                            <?php endif;?>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                <?php endfor;?>
            </div>
            <!--/.carousel-inner-->
        </div>
        <!--/.carousel-->
        <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
            <i class="fa fa-chevron-left"></i>
        </a>
        <a class="next hidden-xs" href="#main-slider" data-slide="next">
            <i class="fa fa-chevron-right"></i>
        </a>
    </section>
    <!--/#main-slider-->
<?php endif; ?>

<section id="feature">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Serviços</h2>
            <p class="lead">Conheça os serviços que a prefeitura oferece ao cidadão coqueirense.</p>
        </div>
        <div class="row">
            <div class="features">
                <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                    <a href="https://e-gov.betha.com.br/cdweb/03109-000/contribuinte/main.faces" onclick="ga('send', 'event', 'Externo', 'Site', 'Serviços ao Cidadão');" target="_blank">
                        <div class="feature-wrap">
                            <i class="fa fa-users"></i>
                            <h2>Serviços ao Cidadão</h2>
                            <h3>2ª Via de IPTU e Consulta de Informações Cadastrais.</h3>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                    <a href="http://cloud.betha.com.br/" onclick="ga('send', 'event', 'Externo', 'Site', 'Serviços ao Servidor');" target="_blank">
                        <div class="feature-wrap">
                            <i class="fa fa-building-o"></i>
                            <h2>Serviços ao Servidor</h2>
                            <h3>Consultas de Holerites e Informações do Servidor</h3>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                    <a href="https://e-gov.betha.com.br/e-nota/login.faces" onclick="ga('send', 'event', 'Externo', 'Site', 'Nota Fiscal Eletrônica');" target="_blank">
                        <div class="feature-wrap">
                            <i class="fa fa-file-text"></i>
                            <h2>Nota Fiscal Eletrônica</h2>
                            <h3>Emissão e consulta de notas fiscais eletrônicas</h3>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                    <a href="/fale-conosco"  target="_blank">
                        <div class="feature-wrap">
                            <i class="fa fa-bullhorn"></i>
                            <h2>Ouvidoria</h2>
                            <h3>Um espaço aberto para a população</h3>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                    <a href="/licitacoes">
                        <div class="feature-wrap">
                            <i class="fa fa-briefcase"></i>
                            <h2>Licitações</h2>
                            <h3>Licitações em andamento</h3>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                    <a  href="https://e-gov.betha.com.br/transparencia/01030-015/recursos.faces?mun=_fV0IsqgT0A_livlamqEHrXhxsPXsJ0O" onclick="ga('send', 'event', 'Externo', 'Site', 'Portal de Transparência');" target="_blank">
                        <div class="feature-wrap">
                            <i class="fa fa-files-o"></i>
                            <h2>Transparência</h2>
                            <h3>informações sobre o município</h3>
                        </div>
                    </a>
                </div>
                
            </div>
            <!--/.services-->
        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>
<!--/#feature-->

<section id="partner">
        <div class="container">
                <div class="center wow fadeInDown">
                    <video onplay="registrarEventoVideo()" poster="videos/tour_coqueiral/tour_coqueiral.jpg" controls="controls">
                        <source src="videos/tour_coqueiral/tour_coqueiral.webm" type="video/webm">
                        <source src="videos/tour_coqueiral/tour_coqueiral.ogv" type="video/ogg">
                        <source src="videos/tour_coqueiral/tour_coqueiral.mp4" type="video/mp4">
                        <source src="videos/tour_coqueiral/tour_coqueiral_mobile.mp4" type="video/mp4">
                        <source src="videos/tour_coqueiral/tour_coqueiral_mobile.3gp" type="video/3gpp; codecs='mp4v.20.8, samr''">
                        <iframe src="https://player.vimeo.com/video/209560023" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </video>
                </div>    
        </div><!--/.container-->
    </section><!--/#partner-->

<section id="recent-works">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Últimas Notícias</h2>
            <p class="lead">Novidades Recentes no município</p>
        </div>

        <div class="row">

             <?php if(count($noticias) > 0): ?>
                <?php foreach($noticias as $noticia):?>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="fh5co-blog wow fadeInDown">
                            <a href="<?= 'noticias/noticia/' . $noticia->post->slug . '-' . $noticia->id ?>">
                                <img class="img-responsive" src="<?= $noticia->foto ?>" alt="<?= $noticia->post->titulo ?>">
                            </a>
                            <div class="blog-text"> 
                                <div class="prod-title">
                                    <h3 style="text-transform: uppercase;">
                                        <a href="<?= 'noticias/noticia/' . $noticia->post->slug . '-' . $noticia->id ?>">
                                            <?= $noticia->post->titulo ?>
                                        </a>
                                    </h3>
                                    <span class="posted_by"><?= $this->Format->date($noticia->post->dataPostagem) ?></span>
                                    <p><?= $noticia->resumo ?></p>
                                    <p><a href="<?= 'noticias/noticia/' . $noticia->post->slug . '-' . $noticia->id ?>">Veja Mais...</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
             <?php else: ?>
                <p>Nenhuma notícia disponível no momento!</p>
             <?php endif; ?>
            
            <div class="clearfix visible-md-block"></div>
        </div>

        <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center wow fadeInDown">
                <a href="/noticias" class="btn btn-primary btn-lg">Mais notícias</a>
            </div>
        </div>
    </div>
    <!--/.container-->
</section>
<!--/#recent-works-->

<section id="services" class="service-item">
    <div class="container">

        <div class="row">

            <div class="col-sm-12 col-md-12">
                <div class="media services-wrap wow fadeInDown">
                    <div class="media-body">
                        <div class="col-md-5 col-sm-6">
                            <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fprefeituradecoqueiral&tabs=timeline%2C%20events&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
                                width="500" height="600" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                        </div>
                        <div class="col-md-7  col-sm-6">
                            <h3 class="media-heading">Licitações Recentes</h3>
                            <?php if(count($licitacoes) > 0): ?>
                                <?php foreach($licitacoes as $licitacao): ?>
                                    <div class="list-group">
                                        <a href="<?= 'licitacoes/licitacao/' . $licitacao->slug . '-' . $licitacao->id ?>" class="list-group-item">
                                            <h4 class="list-group-item-heading" style="text-transform: uppercase;"><?= $licitacao->titulo ?></h4>
                                            <p class="list-group-item-text">Início: <?= $this->Format->date($licitacao->dataInicio, true) ?></p>
                                            <p class="list-group-item-text">Término: <?= $this->Format->date($licitacao->dataTermino, true) ?></p>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Nenhuma licitação disponível no momento!</p>
                            <?php endif; ?>
                            <div class="list-group">
                                <a href="/licitacoes" class="mais-publicacoes list-group-item active">
                                    <h4 class="list-group-item-heading">Veja mais</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--/.row-->
        </div>
        <!--/.container-->
</section>