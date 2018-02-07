<?= $this->Html->script('controller/system.board.js', ['block' => 'scriptBottom']) ?>
<?= $this->Html->script('controller/ouvidoria.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="green">
                        <h4 class="title">Licitações Recentes</h4>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                                <th>Título</th>
                                <th>Data</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach ($licitacoes as $licitacao): ?>
                                    <tr>
                                        <td><?=$licitacao->titulo?></td>
                                        <td><?=date_format($licitacao->dataInicio, 'd/m/Y') ?></td>
                                        <td class="td-actions text-right">
                                            <?php if ($this->Membership->handleRole("editar_licitacao")): ?>
                                                <a href="<?= $this->Url->build(['controller' => 'licitacoes', 'action' => 'edit', $licitacao->id]) ?>" class="btn btn-primary btn-round" title="Editar">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <?php if ($this->Membership->handleRole("listar_licitacoes")): ?>
                                            <a href="<?= $this->Url->build(['controller' => 'licitacoes', 'action' => 'index']) ?>" class="btn btn-default btn-info">Ver Todos</a>
                                        <?php endif; ?>
                                        <?php if ($this->Membership->handleRole("adicionar_licitacao")): ?>
                                            <a href="<?= $this->Url->build(['controller' => 'licitacoes', 'action' => 'add']) ?>" class="btn btn-default btn-warning">Nova Licitação</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="green">
                        <h4 class="title">Publicações Recentes</h4>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                                <th>Título</th>
                                <th>Data</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach ($publicacoes as $publicacao): ?>
                                    <tr>
                                        <td><?=$publicacao->titulo?></td>
                                        <td><?=date_format($publicacao->data, 'd/m/Y') ?></td>
                                        <td class="td-actions text-right">
                                            <?php if ($this->Membership->handleRole("editar_publicacao")): ?>
                                                <a href="<?= $this->Url->build(['controller' => 'publicacoes', 'action' => 'edit', $publicacao->id]) ?>" class="btn btn-primary btn-round" title="Editar">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <?php if ($this->Membership->handleRole("listar_publicacoes")): ?>
                                            <a href="<?= $this->Url->build(['controller' => 'publicacoes', 'action' => 'index']) ?>" class="btn btn-default btn-info">Ver Todos</a>
                                        <?php endif; ?>
                                        <?php if ($this->Membership->handleRole("adicionar_publicacao")): ?>
                                            <a href="<?= $this->Url->build(['controller' => 'publicacoes', 'action' => 'add']) ?>" class="btn btn-default btn-warning">Nova Publicação</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($this->Membership->handleSubmenus("ouvidoria_manifestacoes", "ouvidoria_manifestantes")): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="green">
                            <h4 class="title">Ouvidoria da Prefeitura</h4>
                        </div>
                        <div class="card-content table-responsive">
                            <table class="table table-hover">
                                <thead class="text-warning">
                                    <th>Número</th>
                                    <th>Data</th>
                                    <th>Manifestante</th>
                                    <th>Assunto</th>
                                    <th>Status</th>
                                    <th>Prioridade</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <?php foreach ($manifestacoes as $manifestacao): ?>
                                        <tr style="
                                            <?=($manifestacao->prioridade->id == $this->Data->setting('Ouvidoria.prioridade.definicoes.urgente.id') 
                                                && $manifestacao->status->id != $this->Data->setting('Ouvidoria.status.fechado')
                                                && $manifestacao->status->id != $this->Data->setting('Ouvidoria.status.definicoes.recusado')) ? "font-weight: bold;" : ""?>
                                            <?=($manifestacao->atrasado) ? "color: red;" : ""?>
                                            ">
                                            <td><?=$this->Format->zeroPad($manifestacao->id)?></td>
                                            <td><?=$this->Format->date($manifestacao->data, true)?></td>
                                            <td><?=$manifestacao->manifestante->nome?></td>
                                            <td><?=$manifestacao->assunto?></td>
                                            <td><?=$manifestacao->status->nome?></td>
                                            <td><?=$manifestacao->prioridade->nome?></td>
                                            <td class="td-actions text-right" style="width: 8%">
                                                <?php if($manifestacao->status->id == $this->Data->setting('Ouvidoria.status.inicial')):?>
                                                    <?php if ($this->Membership->handleRole("responder_manifestacao")): ?>
                                                        <button type="button" onclick="verificarManifestacao(<?= $manifestacao->id ?>)" title="Verificar a manifestação" class="btn btn-primary btn-round"><i class="material-icons">insert_drive_file</i></button>
                                                    <?php endif; ?>
                                                    <?php if ($this->Membership->handleRole("recusar_manifestacao")): ?>
                                                        <button type="button" onclick="recusarManifestacao(<?= $manifestacao->id ?>)"  title="Recusar manifestação" class="btn btn-danger btn-round"><i class="material-icons">pan_tool</i></button>
                                                    <?php endif; ?>
                                                <?php elseif($manifestacao->status->id == $this->Data->setting('Ouvidoria.status.definicoes.recusado')):?>
                                                    <?php if ($this->Membership->handleRole("responder_manifestacao")): ?>
                                                        <a href="<?= $this->Url->build(['controller' => 'Ouvidoria', 'action' => 'manifestacao', $manifestacao->id]) ?>" title="Verificar a manifestação" class="btn btn-primary btn-round">
                                                            <i class="material-icons">insert_drive_file</i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if ($this->Membership->handleRole("fechar_manifestacao")): ?>
                                                        <button type="button" onclick="fecharManifestacao(<?= $manifestacao->id ?>)"  title="Fechar manifestação" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                    <?php endif; ?>
                                                <?php else:?>
                                                    <?php if ($this->Membership->handleRole("responder_manifestacao")): ?>
                                                        <a href="<?= $this->Url->build(['controller' => 'Ouvidoria', 'action' => 'manifestacao', $manifestacao->id]) ?>" title="Verificar a manifestação" class="btn btn-primary btn-round">
                                                            <i class="material-icons">insert_drive_file</i>
                                                        </a>
                                                        <?php if ($this->Membership->handleRole("exibir_manifestante_ouvidoria")): ?>
                                                            <button type="button" onclick="exibirManifestante(<?= $manifestacao->manifestante->id ?>)"  title="Informações sobre o manifestante" class="btn btn-info btn-round"><i class="material-icons">face</i></button>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                            
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7" class="text-right">
                                            <?php if ($this->Membership->handleRole("consultar_manifestacoes")): ?>
                                                <a href="<?= $this->Url->build(['controller' => 'ouvidoria', 'action' => 'index']) ?>" class="btn btn-default btn-info">Ver Todas as Manifestações</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">mic</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Em Aberto</p>
                            <h3 class="title"><?=$stat_ouvidoria['abertos']?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange">
                            <i class="material-icons">weekend</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Não Atendidos</p>
                            <h3 class="title"><?=$stat_ouvidoria['novos']?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="red">
                            <i class="material-icons">watch_later</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Atrasados</p>
                            <h3 class="title"><?=$stat_ouvidoria['atrasados']?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="purple">
                            <i class="material-icons">archive</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Fechados</p>
                            <h3 class="title"><?=$stat_ouvidoria['fechados']?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-chart" data-background-color="purple">
                            <canvas class="ct-chart" id="graficoEvolucao"></canvas>
                        </div>
                        <div class="card-content">
                            <h4 class="title">Evolução das Manifestações</h4>
                            <p class="category">Nos últimos 7 dias.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-chart" data-background-color="orange">
                            <canvas class="ct-chart" id="graficoTipo"></canvas>
                        </div>
                        <div class="card-content">
                            <h4 class="title">Manifestações Por Status</h4>
                            <p class="category">De todos os manifestos em aberto no sistema.</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="pull-left">
                <h3>Notícias Recentes </h3>
            </div>
            <div class="pull-right">
                <?php if ($this->Membership->handleRole("adicionar_noticia")): ?>
                    <a href="<?= $this->Url->build(['controller' => 'noticias', 'action' => 'add']) ?>" class="btn btn-warning btn-simple">Nova Notícia<div class="ripple-container"></div></a> |
                <?php endif; ?>
                <?php if ($this->Membership->handleRole("listar_noticias")): ?>
                    <a href="<?= $this->Url->build(['controller' => 'noticias', 'action' => 'index']) ?>" class="btn btn-info btn-simple">Ver Todas<div class="ripple-container"></div></a>
                <?php endif; ?>
            </div>
        </div>

        <br/>        

        <div class="row">
            <?php foreach ($noticias as $noticia): ?>
                <div class="col-md-4">
                    <div class="card card-product" data-count="9">
                        <div class="card-image" data-header-animation="true">
                            <a href="#pablo">
                                <img class="img" src="<?=$this->Url->build('/../' . $noticia->foto)?>">
                            </a>
                        </div>
                        <div class="card-content">
                        
                            <h4 class="card-title">
                                <a href="#pablo"><?= $noticia->post->titulo ?></a>
                            </h4>
                            <div class="card-description">
                                <?= $noticia->resumo ?> 
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="stats pull-right">
                                <?php if ($this->Membership->handleRole("editar_noticia")): ?>
                                    <a href="<?= $this->Url->build(['controller' => 'noticias', 'action' => 'edit', $noticia->id]) ?>" class="btn btn-primary btn-simple">Editar<div class="ripple-container"></div></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
        </div>

    </div>
</div>