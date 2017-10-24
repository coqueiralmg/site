<section id="about-us">
    <div class="container">
        
        <div class="center wow fadeInDown">
            <h2><?= $this->Format->zeroPad($manifestacao->id) . ' : ' . $manifestacao->assunto ?></h2>
            <p class="lead">Data: <?= $this->Format->date($manifestacao->data, true) ?> | Prioridade: <?= $manifestacao->prioridade->nome ?> | Status: <?= $manifestacao->status->nome ?></p>
        </div>

        <div class="skill-wrap clearfix wow fadeInDown" style="margin: 0 0 60px 0">
            <div class="wow fadeInDown">
                <h2>Título da manifestação</h2>
            </div>
            <div class="col-md-12">
                <?= $manifestacao->assunto ?>
            </div>
        </div>

        <div class="skill-wrap clearfix wow fadeInDown" style="margin: 0 0 60px 0">
            <div class="wow fadeInDown">
                <h2>Texto da manifestação</h2>
            </div>
            <div class="col-md-12">
                <?= $manifestacao->texto ?>
            </div>
        </div>

        <section id="conatcat-info">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="media contact-info wow fadeInDown animated" data-wow-duration="1000ms" data-wow-delay="600ms" style="visibility: visible; animation-duration: 1000ms; animation-delay: 600ms; animation-name: fadeInDown;">
                            <div class="pull-left">
                                <i class="fa fa-info-circle"></i>
                            </div>
                            <div class="media-body">
                                <h2>Dados do manifestante</h2>
                                <p>
                                    <b>Nome: </b><?= $manifestacao->manifestante->nome ?><br/>
                                    <?php if($this->request->session()->check('ManifestanteID')): ?>
                                        <b>E-mail: </b><?= $manifestacao->manifestante->email ?><br/>
                                        <b>Endereço: </b><?= $manifestacao->manifestante->endereco ?><br/>
                                        <b>Telefone de Contato: </b><?= $manifestacao->manifestante->telefone ?><br/>
                                    <?php endif;?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php if($this->request->session()->check('ManifestanteID')): ?>
                        <div class="col-sm-4">
                            <div class="media contact-info wow fadeInDown animated" data-wow-duration="1000ms" data-wow-delay="600ms" style="visibility: visible; animation-duration: 1000ms; animation-delay: 600ms; animation-name: fadeInDown;">
                                <div class="media-body">
                                    <h2>Estatísticas do Manifestante</h2>
                                    <b>Manifestos enviados: </b>30<br/>
                                    <b>Manifestos ativos: </b>30<br/>
                                    <b>Manifestos atrasados: </b>30<br/>
                                    <b>Manifestos fechados: </b>30<br/>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
            </div><!--/.container-->    
        </section>
        <h1 id="comments_title">Histórico</h1>
        <?php foreach($historico as $item): ?>
            <div class="media comment_section">
                <div class="pull-left post_comments">
                    <?php if($item->resposta): ?>
                        <a href="#" style="font-size: xx-large; padding-top: 40px"><i class="fa fa-comment-o"></i></a>
                    <?php else:?>
                        <a href="#" style="font-size: xx-large; padding-top: 40px"><i class="fa fa-calendar-o"></i></a>
                    <?php endif;?>
                </div>
                <div class="media-body post_reply_comments">
                    <h4><?= $this->Format->date($item->data, true) ?></h4>
                    <p><?= $item->mensagem ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if($this->request->session()->check('ManifestanteID')): ?>
            <div id="contact-page clearfix">
                <div class="status alert alert-success" style="display: none"></div>
                <div class="message_heading">
                    <h4>Resposta</h4>
                    <p>Digite abaixo para enviar resposta a ouvidoria da prefeitura.</p>
                </div> 

                <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="sendemail.php" role="form">
                    <div class="row">
                        <div class="col-sm-12">                        
                            <div class="form-group">
                                <label>Mensagem de resposta</label>
                                <textarea name="message" id="message" required="required" class="form-control" rows="5"></textarea>
                            </div>                        
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg" style="float: right" required="required">Enviar</button>
                            </div>
                        </div>
                    </div>
                </form>     
            </div><!--/#contact-page-->
        <?php else: ?>
            <div id="contact-page clearfix">
                <div class="status alert alert-success" style="display: none"></div>
                <div class="message_heading">
                    <p>Se você é o próprio manifestante e pretende responder a este chamado, <?=$this->Html->Link('clique aqui', ['controller' => 'ouvidoria', 'action' => 'acesso'])?>.</p>
                </div> 

                
            </div><!--/#contact-page-->
        <?php endif;?>
    </div>
    <!--/.container-->
</section>