<?= $this->Html->script('controller/noticias.general.js', ['block' => 'scriptBottom']) ?>
<section id="blog" class="container">
    <div class="center">
        <h2>Notícias</h2>
        <p class="lead">Notícias recentes do município.</p>
    </div>

    <div class="blog">
        <div class="row">
            <div class="col-md-8">
                 <?php if(count($noticias) > 0): ?>
                     <?php foreach($noticias as $noticia): ?>
                        <div class="blog-item">
                            <div class="row">
                                <div class="col-xs-12 col-sm-2 text-center">
                                    <div class="entry-meta">
                                        <span id="publish_date"><?= $this->Format->date($noticia->post->dataPostagem) ?></span>
                                        <span><i class="fa fa-user"></i> <a href="#"><?= $noticia->post->autor->pessoa->nome ?></a></span>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-10 blog-content">
                                    <a href="<?= 'noticias/noticia/' . $noticia->post->slug . '-' . $noticia->id ?>"><img class="img-responsive img-blog" src="<?= '../' . $noticia->foto ?>" width="100%" alt="<?= $noticia->post->titulo ?>" /></a>
                                    <h2><a href="<?= 'noticias/noticia/' . $noticia->post->slug . '-' . $noticia->id ?>"><?= $noticia->post->titulo ?></a></h2>
                                    <h3><?= $noticia->parte ?></h3>
                                    <a class="btn btn-primary readmore" href="<?= 'noticias/noticia/' . $noticia->post->slug . '-' . $noticia->id ?>">Leia mais</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>


                    <?=$this->element('pagination') ?>

                <?php else: ?>
                    <p>Nenhuma notícia publicada até o momento! Volte mais tarde</p>
                 <?php endif; ?>
            </div>
            <!--/.col-md-8-->


            <aside class="col-md-4">
                <div class="widget search">
                    <h3>Busca</h3>
                     <?php
                        echo $this->Form->create("Noticia", [
                            "url" => [
                                "controller" => "noticias",
                                "action" => "index"
                            ],
                            'idPrefix' => 'pesquisar-noticias',
                            'id' => 'pesquisar-noticias',
                            'type' => 'get',
                            'role' => 'form']);

                    ?>

                    <?= $this->Form->search('chave', ['class' => 'form-control search_box', 'placeholder' => 'Digite aqui para buscar e pressione ENTER']) ?>

                    <?php echo $this->Form->end(); ?>

                </div>
                <!--/.search-->

                <div class="widget categories">
                    <h3>Facebook</h3>
                    <div class="row">
                        <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fprefeituradecoqueiral&tabs=timeline%2Cevents&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="340"
                            height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                    </div>
                </div>
                <!--/.recent comments-->

                <div class="widget archieve">
                    <h3>Revista Digital</h3>
                    <div class="row">
                        <div class="col-sm-12 tempo">
                            <?= $this->Html->image("revista.png", ["width" => "320px", "alt" => "Clique aqui para ler a nossa revista digital gratuitamente", "title" => "Clique aqui para ler a nossa revista digital gratuitamente", 'url' => ['controller' => 'Pages', 'action' => 'revista']]); ?>
                        </div>
                    </div>
                </div>

                <div class="widget archieve">
                    <h3>Previsão do Tempo</h3>
                    <div class="row">
                        <div class="col-sm-12 tempo">
                            <div id="cont_972a24ab5d627921d59657e47563b214"><script type="text/javascript" async src="https://www.tempo.com/wid_loader/972a24ab5d627921d59657e47563b214"></script></div>
                        </div>
                    </div>
                </div>

            </aside>
        </div>
        <!--/.row-->
    </div>
</section>
