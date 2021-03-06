<script type="text/javascript">
    var idPergunta = <?=$id?>;
</script>
<?= $this->Html->script('controller/faq.relacionamentos.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?php if ($id > 0) :?>
                        <div class="card-content">
                            <?= $this->element('mnfaq') ?>
                            <hr clear="all"/>
                        </div>
                    <?php endif; ?>
                    <div class="card-content">
                        <legend>Relacionamentos com a pergunta "<?=$pergunta->questao?>"</legend>
                        <?php
                        echo $this->Form->create("Perguntas", [
                            "url" => [
                                "controller" => "faq",
                                "action" => "relacionamentos"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao criar relacionamento entre perguntas.',
                                'details' => ''
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("documento", "Título") ?>
                                        [<a class="link_build_form" href="#" id="buscar_rel" data-toggle="modal" data-target="#modal_relacionamento_faq">Buscar</a>]
                                        <?= $this->Form->text("documento", ["id" => "documento", "class" => "form-control", "placeholder" => "Digite o título da pergunta que deseja relacionar e depois aperte ENTER."]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <?=$this->element('message', [
                                'name' => 'aviso_aguarde',
                                'type' => 'warning',
                                'message' => 'Aguarde enquanto a operação está sendo efetuada!'
                            ]) ?>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if(count($relacionadas) > 0):?>
                            <h4 class="card-title">Perguntas Relacionadas a "<?=$pergunta->questao?>"</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Questão</th>
                                        <th>Categoria</th>
                                        <th>Ativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($relacionadas as $relacionada): ?>
                                        <tr>
                                            <td><?=$relacionada->questao?></td>
                                            <td><?=$relacionada->categoria->nome?></td>
                                            <td><?= $relacionada->ativado ?></td>
                                            <td class="td-actions text-right" style="width: 8%">
                                                <a href="<?= $this->Url->build(['controller' => 'Faq', 'action' => 'relacionamentos', $relacionada->id]) ?>" title="Ver Relacionamentos" class="btn btn-info btn-round"><i class="material-icons">toc</i></a>
                                                <button type="button" onclick="cortarRelacionamento(<?= $relacionada->id ?>, '<?= $relacionada->questao ?>')" title="Cortar Relacionamento" class="btn btn-danger btn-round"><i class="material-icons">link_off</i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h3>Não existe nenhuma pergunta relacionada a esta.</h3>
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
