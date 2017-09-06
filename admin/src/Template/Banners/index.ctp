<?= $this->Html->script('controller/banners.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <?php if ($this->Membership->handleRole("adicionar_banner")): ?>
                            <a href="<?= $this->Url->build(['controller' => 'Banners', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                        <?php endif; ?>
                        <a href="<?= $this->Url->build(['controller' => 'Banners', 'action' => 'imprimir']) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if(count($banners) > 0):?>
                            <h4 class="card-title">Lista de Banners da Página Inicial</h4>
                            <table class="table table-shopping">
                                <thead>
                                    <tr>
                                        <th style="width: 15%"></th>
                                        <th>Nome</th>
                                        <th>Título/Descrição</th>
                                        <th>Destino</th>
                                        <th>Ordem</th>
                                        <th>Validade</th>
                                        <th>Ativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($banners as $banner): ?>
                                        <tr>
                                            <td>
                                                <img src="<?=$this->Url->build('/../' . $banner->imagem)?>" style="height: 75px; width: auto" class="img-rounded img-responsive img-raised">
                                            </td>
                                            <td class="td-name">
                                                <?=$banner->nome?>
                                            </td>
                                            <td class="td-name">
                                                <?=$banner->titulo?><br/>
                                                <small><?=$banner->descricao?></small>
                                            </td>
                                            <td class="td-name">
                                                <?=$banner->destino?>
                                            </td>
                                            <td>
                                                <?=$banner->ordem?>
                                            </td>
                                            <td>
                                                <?=$this->Format->date($banner->validade)?>
                                            </td>
                                            <td>
                                                <?=$banner->ativado?>
                                            </td>
                                            <td class="td-actions text-right">
                                                <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                                    <i class="material-icons">edit</i>
                                                </button>
                                                <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                                    <i class="material-icons">close</i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <?php if ($this->Membership->handleRole("adicionar_banner")): ?>
                                <h3>Nenhum banner encontrado. Para adicionar novo banner, <?=$this->Html->link("clique aqui", ["controller" => "banners", "action" => "add"])?>.</h3>
                            <?php else:?>
                                <h3>Nenhum banner encontrado.</h3>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="card-content">
                        <div class="material-datatables">
                            <div class="row">
                                <?=$this->element('pagination') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>