<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">Buscar</h4>
                        
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <label>Número</label>
                                        <input class="form-control" type="text">
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <label>Título</label>
                                        <input class="form-control" type="text">
                                        <span class="material-input"></span></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <label>Data Inicial</label>
                                        <input id="data_inicial" class="form-control" type="text">
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <label>Data Final</label>
                                        <input id="data_final" class="form-control" type="text">
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                         <label>Mostrar</label> <br/>
                                        <select class="form-control" data-style="select-with-transition" title="Choose City" data-size="7" tabindex="-98">
                                            <option value="2">Todos</option>
                                            <option value="3">Somente Ativos</option>
                                            <option value="4">Somente Inativos</option>
                                        </select>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-button">
                            <button type="submit" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                            <?php if ($this->Membership->handleRole("adicionar_publicacao")): ?>
                                <a href="<?= $this->Url->build(['controller' => 'Publicacoes', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            <a href="<?= $this->Url->build(['controller' => 'Publicacoes', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if(count($publicacoes) > 0):?>
                        <h4 class="card-title">Lista de Publicações</h4>
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>Número</th>
                                    <th>Título</th>
                                    <th>Data</th>
                                    <th>Ativo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($publicacoes as $publicacao): ?>
                                    <tr>
                                        <td><?=$publicacao->numero?></td>
                                        <td><?=$publicacao->titulo?></td>
                                        <td><?= $this->Format->date($publicacao->data) ?></td>
                                        <td><?= $publicacao->ativado ?></td>
                                        <td class="td-actions text-right" style="width: 8%">
                                            <?php if ($this->Membership->handleRole("editar_publicacao")): ?>
                                                <a href="<?= $this->Url->build(['controller' => 'Publicacoes', 'action' => 'edit', $publicacao->id]) ?>" class="btn btn-primary btn-round">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($this->Membership->handleRole("excluir_publicacao")): ?>
                                                <button type="button" onclick="excluirPublicacao(<?= $publicacao->id ?>, '<?= $publicacao->ip ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                            <?php if ($this->Membership->handleRole("adicionar_usuario")): ?>
                                <h3>Nenhum usuário encontrado. Para adicionar novo usuário, <?=$this->Html->link("clique aqui", ["controller" => "usuarios", "action" => "add"])?>.</h3>
                            <?php else:?>
                                <h3>Nenhum usuário encontrado.</h3>
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