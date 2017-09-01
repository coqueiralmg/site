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
                            <span oncopy="return false" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
                                <b>E-mail:</b> <?=$this->Html->link($secretaria->email, 'mailto:' . $secretaria->email)?>
                            </span>
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
            </aside>

        </div>
        <!--/.row-->

    </div>
    <!--/.blog-->

</section>