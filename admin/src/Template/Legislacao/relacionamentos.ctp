<script type="text/javascript">
    var idLegislacao = <?=$id?>;
</script>
<?= $this->Html->script('controller/legislacao.relacionamentos.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?php if ($id > 0) :?>
                        <div class="card-content">
                            <?= $this->element('mnlegislacao') ?>
                            <hr clear="all"/>
                        </div>
                    <?php endif; ?>
                    <div class="card-content">
                        <legend>Relacionamento entre Documentos da Legislação</legend>
                        <?php
                        echo $this->Form->create("Legislacao", [
                            "url" => [
                                "controller" => "legislacao",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("numero", "Número ou Título") ?>
                                        [<a class="link_build_form" href="#" id="buscar_rel" data-toggle="modal" data-target="#modal_rel">Buscar</a>]
                                        <?= $this->Form->text("numero", ["class" => "form-control", "placeholder" => "Digite o número ou o título da lei que deseja relacionar e depois aperte ENTER para fazer a ligação."]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                            </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
