<h4 class="card-title">Dados do <?=$concurso->tipo == 'CP' ? 'Concurso Público' : 'Processo Seletivo'?></h4>
<div class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-1">
            <div class="form-group label-control">
                <?= $this->Form->label("numero", "Número") ?><br/>
                <b><?=$concurso->numero?></b>
                <span class="material-input"></span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group label-control">
                <?= $this->Form->label("titulo", "Título") ?><br/>
                <?=$concurso->titulo?>
                <span class="material-input"></span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group label-control">
                <?= $this->Form->label("inscricaoInicial", "Início das Inscrições") ?><br/>
                <?=$concurso->inscricaoInicio->i18nFormat('dd/MM/yyyy')?>
                <span class="material-input"></span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group label-control">
                <?= $this->Form->label("inscricaoFinal", "Término das Inscrições") ?><br/>
                <?=$concurso->inscricaoFim->i18nFormat('dd/MM/yyyy')?>
                <span class="material-input"></span>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group label-control">
                <?= $this->Form->label("prova", "Data da Prova") ?><br/>
                <?=$concurso->dataProva->i18nFormat('dd/MM/yyyy')?>
                <span class="material-input"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group label-control">
                <?= $this->Form->label("banca", "Banca") ?><br/>
                <?=$concurso->banca ?>
                <span class="material-input"></span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group label-control">
                <?= $this->Form->label("site", "Site da Banca") ?><br/>
                <?=$this->Html->link($concurso->siteBanca, $concurso->siteBanca, ['target' => '_blank'])?>
                <span class="material-input"></span>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <?= $this->Form->label("status", "Status do Concurso") ?><br/>
                <?=$concurso->status->nome ?>
                <span class="material-input"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group label-control">
                <?= $this->Form->label("descricao", "Descrição") ?><br/>
                <?= $concurso->descricao?>
                <span class="material-input"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group label-control">
                <?= $this->Form->label("observacoes", "Observações") ?><br/>
                <?= $concurso->observacoes?>
                <span class="material-input"></span>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<h4 class="card-title">Cargos</h4>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content table-responsive">
                    <?php if($cargos->count() > 0):?>
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>Cargo</th>
                                    <th>Vagas Total</th>
                                    <th>Vagas PCD</th>
                                    <th>Carga Horária</th>
                                    <th>Vencimento</th>
                                    <th>Taxa de Inscrição</th>
                                    <th>Ativo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cargos as $cargo): ?>
                                    <tr>
                                        <td><?=$cargo->nome?></td>
                                        <td><?=$cargo->vagas?></td>
                                        <td><?=$cargo->PCD?></td>
                                        <td><?=$cargo->cargaHoraria?></td>
                                        <td><?=$this->Format->currency($cargo->vencimento)?></td>
                                        <td><?=$this->Format->currency($cargo->taxaInscricao)?></td>
                                        <td><?=$cargo->ativado?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <h3>Não existem cargos relativos a <?= $concurso->tipo == 'CP' ? 'concurso público' : 'processo seletivo' ?> <?= $concurso->numero ?> - <?= $concurso->titulo ?>.</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<h4 class="card-title">Documentos e Anexos</h4>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content table-responsive">
                    <?php if($documentos->count() > 0):?>
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>Data</th>
                                    <th>Descrição</th>
                                    <th>Ativo</th>
                                    <th>Arquivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($documentos as $documento): ?>
                                    <tr>
                                        <td><?=$this->Format->date($documento->data)?></td>
                                        <td><?=$documento->descricao?></td>
                                        <td><?=$documento->ativado?></td>
                                        <td><?=str_replace('/admin/..', '', $this->Url->build('/../' . $documento->arquivo, true)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <h3>Não existem cargos relativos a <?= $concurso->tipo == 'CP' ? 'concurso público' : 'processo seletivo' ?> <?= $concurso->numero ?> - <?= $concurso->titulo ?>.</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($informativo->count() > 0): ?>
    <h4 class="card-title">Informativo do Concurso</h4>
    <div class="content">
        <div class="container-fluid">
            <?php foreach($informativo as $noticia): ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group label-control">
                            <?= $this->Form->label("data", $this->Format->date($noticia->data, true) . ' | ' . $noticia->titulo) ?><br/>
                            <?= $noticia->texto ?>
                            <span class="material-input"></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
