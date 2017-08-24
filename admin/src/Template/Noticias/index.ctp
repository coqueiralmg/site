<?= $this->Html->script('controller/noticias.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <?=$this->element('message', [
                            'name' => 'lista_erro',
                            'type' => 'error',
                            'message' => 'Ocorreu um erro ao buscar as notícias',
                            'details' => ''
                        ]) ?>
                        <h4 class="card-title">Buscar</h4>
                        <?php
                        echo $this->Form->create("Noticias", [
                            "url" => [
                                "controller" => "noticias",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("titulo", "Título") ?>
                                        <?= $this->Form->text("titulo", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_inicial", "Data Inicial") ?>
                                        <?= $this->Form->text("data_inicial", ["id" => "data_inicial", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_final", "Data Inicial") ?>
                                        <?= $this->Form->text("data_final", ["id" => "data_final", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("mostrar", "Mostrar") ?> <br/>
                                        <?=$this->Form->select('mostrar', $combo_mostra, ['class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-button">
                                <button type="submit" onclick="return validar()" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                                <?php if ($this->Membership->handleRole("adicionar_noticia")): ?>
                                    <a href="<?= $this->Url->build(['controller' => 'noticias', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                                <?php endif; ?>
                                <a href="<?= $this->Url->build(['controller' => 'noticias', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if(count($noticias) > 0): ?>
                            <h4 class="card-title">Notícias</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Título</th>
                                        <th>Autor</th>
                                        <th>Data da Postagem</th>
                                        <th>Data da Alteração</th>
                                        <th>Visto</th>
                                        <th>Destaque</th>
                                        <th>Ativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($noticias as $noticia): ?>
                                        <tr>
                                            <td><span rel="tooltip" title="<?= $noticia->post->titulo ?>"><?= $noticia->post->truncado ?></span></td>
                                            <td style="width: 15%"><?= $noticia->post->autor->pessoa->nome ?></td>
                                            <td style="width: 14%"><?= $this->Format->date($noticia->post->dataPostagem) ?></td>
                                            <td style="width: 14%"><?= $this->Format->date($noticia->post->dataAlteracao) ?></td>
                                            <td><?= $noticia->post->visualizacoes ?></td>
                                            <td><?= $noticia->post->destacado ?></td>
                                            <td><?= $noticia->post->ativado ?></td>
                                            <td class="td-actions text-right" style="width: 8%">
                                                <?php if ($this->Membership->handleRole("editar_noticia")): ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Noticias', 'action' => 'edit', $noticia->id]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_noticia")): ?>
                                                    <button type="button" onclick="excluirNoticia(<?= $noticia->id ?>, '<?= $noticia->post->titulo ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <?php if ($this->Membership->handleRole("adicionar_noticia")): ?>
                                <h3>Nenhuma notícia encontrada. Para adicionar nova notícia, <?=$this->Html->link("clique aqui", ["controller" => "noticias", "action" => "add"])?>.</h3>
                            <?php else:?>
                                <h3>Nenhuma notícia encontrada.</h3>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                     <div class="card-content">
                        <div class="material-datatables">
                            <div class="row">
                                <?=$this->element('pagination', $opcao_paginacao) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  