<section id="blog" class="container">
    <div class="blog">
        <div class="row">
            <div class="col-md-8">
                <div class="blog-item">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 blog-content">
                            <h2><?= $secretaria->nome ?></h2>
                            <?= $secretaria->descricao ?>
                        </div>
                    </div>
                </div>
                <!--/.blog-item-->

                <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox"></div>
            </div>
            <!--/.col-md-8-->

            <aside class="col-md-4">
                
                <div class="widget categories">
                    <h3>Responsáel</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <?=$secretaria->responsavel?><br/>
                            <small><i><?=$secretaria->descricao_responsavel?></i></small>
                        </div>
                    </div>
                </div>
                <div class="widget categories">
                    <h3>Informações de Contato</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <?=$secretaria->endereco?><br/>
                            <b>Telefone:</b> <?=$this->Format->phone($secretaria->telefone)?><br/>
                        </div>
                    </div>
                </div>
                <div class="widget categories">
                    <h3>Expediente</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <?=$secretaria->expediente?><br/>
                        </div>
                    </div>
                </div>
                <div class="widget categories">
                    <h3>Facebook</h3>
                    <div class="row">
                        <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fprefeituradecoqueiral&tabs=timeline%2Cevents&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="340"
                            height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                    </div>
                </div>
                <!--/.recent comments-->

                <div class="widget categories">
                    <h3>Previsão do Tempo</h3>
                    <div class="row tempo">
                        <div id="cont_972a24ab5d627921d59657e47563b214"><script type="text/javascript" async src="https://www.tempo.com/wid_loader/972a24ab5d627921d59657e47563b214"></script></div>
                    </div>
                </div>
            </aside>

        </div>
        <!--/.row-->

    </div>
    <!--/.blog-->

</section>