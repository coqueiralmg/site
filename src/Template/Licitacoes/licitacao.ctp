<?= $this->Html->script('controller/licitacoes.licitacao.js', ['block' => 'scriptBottom']) ?>
<section id="about-us">
    <div class="container">

        <div class="center wow fadeInDown">
            <h2><?= $title ?></h2>
            <p class="lead">Data da Publicação: <?= $this->Format->date($licitacao->dataPublicacao, true) ?> | Data da Última Atualização: <?= $this->Format->date($licitacao->dataAtualizacao, true) ?></p>
        </div>
        <div class="wow fadeInDown">
            <div class="col-md-9">
                <?= $licitacao->descricao ?>
                <?php if(count($atualizacoes) > 0):?>
                    <hr/>
                    <h4>Extratos e Atualizações</h4>
                    <?php foreach($atualizacoes as $atualizacao): ?>
                        <?php if($atualizacao->ativo): ?>
                            <div class="row">
                                <div class="item col-md-12" style="padding-bottom: 15px">
                                    <h5 class="media-heading"><?= $this->Format->date($atualizacao->data, true) ?> - <?= $atualizacao->titulo ?></h5>
                                    <a class="detalhes">Clique aqui para ver o texto completo</a>
                                    <div id="texto" style="display: none"><?= $atualizacao->texto ?></div>
                                </div>
                            </div>
                        <?php endif;?>
                    <?php endforeach; ?>
                <?php endif;?>
                <hr/>
                <h4>Documentos e Anexos</h4>
                <?php if(count($anexos) > 0):?>
                    <?php if($movel): ?>
                        <?php foreach ($anexos as $anexo): ?>
                            <?php if($anexo->ativo):?>
                                <div class="d-flex flex-row" style="padding-bottom: 10px">
                                    <div class="p-2">
                                        <?php if($anexo->numero == ""):?>
                                            <?=$anexo->nome?> (<?=$this->Format->date($anexo->data)?>)
                                        <?php else: ?>
                                            <?=$anexo->numero?> - <?=$anexo->nome?> (<?=$this->Format->date($anexo->data)?>)
                                        <?php endif;?>
                                    </div>
                                    <div class="p-2">
                                        <a href="<?= $this->Url->build($anexo->arquivo) ?>" title="Download" target="_blank" class="btn btn-success btn-round btn-block">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            <?php endif;?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <table class="table table-striped">
                            <thead class="text-primary">
                                <tr>
                                    <th>Data</th>
                                    <th>Número</th>
                                    <th>Nome</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($anexos as $anexo): ?>
                                    <?php if($anexo->ativo):?>
                                        <tr>
                                            <td><?=$this->Format->date($anexo->data)?></td>
                                            <td><?=$anexo->numero?></td>
                                            <td><?=$anexo->nome?></td>
                                            <td class="td-actions text-right">
                                                <a href="<?= $this->Url->build($anexo->arquivo) ?>" title="Download" target="_blank" class="btn btn-success btn-round">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif;?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Não existe nenhum documento relacionado a esta licitação.</p>
                <?php endif; ?>

            </div>
            <div class="col-md-3">
                <h3>Dados Gerais</h3>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Número do Processo:</strong><br/>
                        <span><?=$this->Format->zeroPad($licitacao->numprocesso, 3) . '/' . $licitacao->ano?></span>
                    </div>
                    <div class="col-md-12">
                        <strong>Modalidade:</strong><br/>
                        <span><?=$this->Html->link($licitacao->modalidade->nome, ['controller' => 'licitacoes', 'action' => 'modalidade', $licitacao->modalidade->chave], ['title' => 'Clique aqui para ver outros processos licitatórios, com a modalidade ' . $licitacao->modalidade->nome])?></span>
                    </div>
                    <div class="col-md-12">
                        <strong>Número da Modalidade:</strong><br/>
                        <span><?=$this->Format->zeroPad($licitacao->nummodalidade, 3) . '/' . $licitacao->ano?></span>
                    </div>
                    <?php if($licitacao->numdocumento != null || $licitacao->numdocumento != ''):?>
                        <div class="col-md-12">
                            <strong>Documento:</strong><br/>
                            <span><?=$licitacao->documento?></span>
                        </div>
                        <div class="col-md-12">
                            <strong>Número do Documento:</strong><br/>
                            <span><?=$this->Format->zeroPad($licitacao->numdocumento, 3) . '/' . $licitacao->ano?></span>
                        </div>
                    <?php endif;?>
                    <?php if($licitacao->modalidade->chave == 'PP' ||
                             $licitacao->modalidade->chave == 'CO' ||
                             $licitacao->modalidade->chave == 'TP' ||
                             ($licitacao->modalidade->chave == 'IN' && $licitacao->dataSessao != '') ||
                             ($licitacao->modalidade->chave == 'DI' && $licitacao->dataSessao != '')):?>
                        <div class="col-md-12">
                            <strong>Data da Sessão:</strong><br/>
                            <span><?=$this->Format->date($licitacao->dataSessao, true)?></span>
                        </div>
                     <?php elseif(($licitacao->modalidade->chave == 'DI' && $licitacao->dataSessao == '') ||
                                 ($licitacao->modalidade->chave == 'IN' && $licitacao->dataSessao == '')):?>
                    <?php else: ?>
                        <div class="col-md-12">
                            <strong>Data do Início da Sessão:</strong><br/>
                            <span><?=$this->Format->date($licitacao->dataSessao, true)?></span>
                        </div>
                        <div class="col-md-12">
                            <strong>Data do Fim da Sessão:</strong><br/>
                            <span><?=$this->Format->date($licitacao->dataFim, true)?></span>
                        </div>
                    <?php endif;?>
                    <div class="col-md-12">
                        <strong>Data da Publicação:</strong><br/>
                        <span><?=$this->Format->date($licitacao->dataPublicacao, true)?></span>
                    </div>
                    <div class="col-md-12">
                        <strong>Data da Última Atualização:</strong><br/>
                        <span><?=$this->Format->date($licitacao->dataAtualizacao, true)?></span>
                    </div>
                    <div class="col-md-12">
                        <strong>Status:</strong><br/>
                        <span><?=$this->Html->link($licitacao->situacao, ['controller' => 'licitacoes', 'action' => 'status', $licitacao->status->id], ['title' => 'Clique aqui para ver outros processos licitatórios, sob o status ' . $licitacao->status->nome])?></span>
                    </div>
                    <div class="col-md-12">
                        <strong>Ano:</strong><br/>
                        <span><?=$this->Html->link($licitacao->ano, ['controller' => 'licitacoes', 'action' => 'ano', $licitacao->ano], ['title' => 'Clique aqui para ver outros processos licitatórios, do ano ' . $licitacao->ano])?></span>
                    </div>
                </div>
                <?php if(count($licitacao->assuntos) > 0): ?>
                    <h3>Assuntos</h3>
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="blog_category">
                                <?php foreach($licitacao->assuntos as $assunto): ?>
                                    <li><?=$this->Html->link($assunto->descricao, ['controller' => 'licitacoes', 'action' => 'assunto', $assunto->id], ['title' => 'Clique aqui para ver outros processos licitatórios, classificados sob o assunto ' . $assunto->descricao])?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!--/.container-->
</section>
