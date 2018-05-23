<section id="about-us">
    <div class="container">

        <div class="center wow fadeInDown">
            <h2><?= $this->Format->zeroPad($manifestacao->id) . ' : ' . $manifestacao->assunto ?></h2>
            <p class="lead">Data: <?= $this->Format->date($manifestacao->data, true) ?> | Prioridade: <?= $manifestacao->prioridade->nome ?> | Status: <?= $manifestacao->status->nome ?></p>
            <?php if($this->request->session()->check('ManifestanteID')): ?>
                <a class="btn btn-primary" href="/ouvidoria/andamento">Ver Andamentos</a>
                <a class="btn btn-primary" href="/ouvidoria/documento/<?=$manifestacao->id?>" target="_blank">Imprimir</a>
                <a class="btn btn-primary" href="/ouvidoria">Nova Manifestação</a>
                <a class="btn btn-primary" href="/ouvidoria/logoff">Sair</a>
            <?php else: ?>
                <a class="btn btn-primary" href="/ouvidoria/acesso">Acessar o sistema</a>
                <a class="btn btn-primary" href="/ouvidoria">Nova Manifestação</a>
            <?php endif;?>
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
                                    <b>Manifestos enviados: </b><?=$qenviados?><br/>
                                    <b>Manifestos respondidos: </b><?=$qrespondidos?><br/>
                                    <b>Manifestos atrasados: </b><?=$qatrasados?><br/>
                                    <b>Manifestos fechados: </b><?=$qfechados?><br/>
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
                    <h4><?= $this->Format->date($item->data, true) ?> | Status: <?=$item->status->nome?></h4>
                    <p><?= $item->mensagem ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if($manifestacao->status->id != $this->Data->setting('Ouvidoria.status.definicoes.recusado') && $manifestacao->status->id != $this->Data->setting('Ouvidoria.status.definicoes.novo') && $manifestacao->status->id != $this->Data->setting('Ouvidoria.status.definicoes.fechado')): ?>
            <?php if($this->request->session()->check('ManifestanteID')): ?>
                <div id="contact-page clearfix">
                    <div class="status alert alert-success" style="display: none"></div>
                    <div class="message_heading">
                        <h4>Resposta</h4>
                        <p>Digite abaixo para enviar resposta a ouvidoria da prefeitura.</p>
                    </div>

                    <?php
                    echo $this->Form->create("Ouvidoria", [
                        "url" => [
                            "controller" => "ouvidoria",
                            "action" => "resposta",
                            $id
                        ],
                        'id' => 'main-contact-form',
                        'class' => 'contact-form',
                        'name' => 'contact-form',
                        'role' => 'form',
                        'type' => 'post']);
                    ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?= $this->Form->label("resposta", "Mensagem de Resposta") ?>
                                    <?= $this->Form->textarea("resposta", ["id" => "resposta", "required" => true, "class" => "form-control", "rows" => "5", "class" => "form-control"]) ?>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg" style="float: right" required="required">Enviar</button>
                                </div>
                            </div>
                        </div>
                    <?php echo $this->Form->end(); ?>
                </div><!--/#contact-page-->
            <?php else: ?>
                <div id="contact-page clearfix">
                    <div class="status alert alert-success" style="display: none"></div>
                    <div class="message_heading">
                        <p>Se você é o próprio manifestante e pretende responder a este chamado, <?=$this->Html->Link('clique aqui', ['controller' => 'ouvidoria', 'action' => 'acesso'])?>.</p>
                    </div>
                </div><!--/#contact-page-->
            <?php endif;?>
        <?php else: ?>
                <?php
                    $mensagem = '';

                    switch($manifestacao->status->id)
                    {
                        case $this->Data->setting('Ouvidoria.status.definicoes.recusado'):
                            $mensagem = 'A manifestação foi recusada e você não pode responder. Caso tenha objeções e deseja criar novo chamado relacionado a este, ';
                            break;

                        case $this->Data->setting('Ouvidoria.status.definicoes.fechado'):
                            $mensagem = 'A manifestação foi fechada e você não pode mais responder. Caso deseja criar novo chamado relacionado a este, ';
                            break;

                        case $this->Data->setting('Ouvidoria.status.definicoes.novo'):
                            $mensagem = 'A manifestação ainda não foi atendida. Aguarde a nossa resposta. Caso deseja criar uma outra manifestação, ';
                            break;
                    }

                ?>
                <div id="contact-page clearfix">
                    <div class="status alert alert-success" style="display: none"></div>
                    <div class="message_heading">
                        <p><?=$mensagem?> <?=$this->Html->Link('clique aqui', ['controller' => 'pages', 'action' => 'faleconosco'])?>.</p>
                    </div>
                </div><!--/#contact-page-->
        <?php endif;?>
    </div>
    <!--/.container-->
</section>
