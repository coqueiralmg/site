<?= $this->Html->script('controller/legislacao.documento.js', ['block' => 'scriptBottom']) ?>
<section id="about-us">
    <div class="container">

        <div class="center wow fadeInDown">
            <h2><?= $legislacao->titulo ?></h2>
            <p class="lead">Data: <?= $this->Format->date($legislacao->data) ?> | Número: <?= $legislacao->numero ?></p>
        </div>
        <div class="wow fadeInDown">
            <div class="col-md-9">
                <?= $legislacao->descricao ?>
                <br/><br/><br/>
                <h5>Legislação Relacionada</h5>
                <hr/>
                <?php if(count($legislacao->relacionadas) > 0):?>
                    <table class="table table-striped">
                        <thead class="text-primary">
                            <tr>
                                <th>Número</th>
                                <th>Título</th>
                                <th>Data</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($legislacao->relacionadas as $relacionada): ?>
                                <tr>
                                    <td><?=$relacionada->numero?></td>
                                    <td><?=$relacionada->titulo?></td>
                                    <td><?=$this->Format->date($relacionada->data)?></td>
                                    <td class="td-actions text-right">
                                        <a href="<?= $this->Url->build(['controller' => 'legislacao', 'action' => 'documento', $relacionada->id]) ?>" title="Ver Detalhes" class="btn btn-success btn-round">
                                            <i class="fa fa-file-text"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Não existe nenhum documento relacionado a este.</p>
                <?php endif; ?>
            </div>
            <div class="col-md-3">
                <h3>Dados Gerais</h3>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Número:</strong>
                        <span><?=$legislacao->numero?></span>
                    </div>
                    <div class="col-md-12">
                        <strong>Data:</strong>
                        <span><?=$this->Format->date($legislacao->data)?></span>
                    </div>
                    <div class="col-md-12">
                        <strong>Tipo:</strong>
                        <span><?=$this->Html->link($legislacao->tipo->nome, ['controller' => 'legislacao', 'action' => 'tipo', $legislacao->tipo->id], ['title' => 'Clique aqui para ver outros documentos do tipo ' . $legislacao->tipo->nome])?></span>
                    </div>
                    <div class="col-md-12">
                        <strong>Ano:</strong>
                        <span><?=$this->Html->link($legislacao->data->i18nFormat('yyyy'), ['controller' => 'legislacao', 'action' => 'ano', $legislacao->data->i18nFormat('yyyy')], ['title' => 'Clique aqui para ver outros documentos do ano ' . $legislacao->data->i18nFormat('yyyy')])?></span>
                    </div>
                </div>
                <?php if(count($legislacao->assuntos) > 0): ?>
                    <h3>Assuntos</h3>
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="blog_category">
                                <?php foreach($legislacao->assuntos as $assunto): ?>
                                    <li><?=$this->Html->link($assunto->descricao, ['controller' => 'legislacao', 'action' => 'assunto', $assunto->id], ['title' => 'Clique aqui para ver outros documentos com assunto ' . $assunto->descricao])?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                <hr clear="all"/>
                <div class="col-md-12">
                    <a onclick="lerEdital()" href="<?= '../../' . $legislacao->arquivo ?>" target="_blank" class="btn btn-success"><i class="fa fa-download"></i>&nbsp;Download</a>
                </div>
            </div>
        </div>


    </div>
    <!--/.container-->
</section>
