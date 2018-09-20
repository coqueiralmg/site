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
                                <div class="col-md-10">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("numero", "Número ou Título") ?>
                                        <?= $this->Form->text("numero", ["class" => "form-control", "placeholder" => "Digite o número ou o título da lei que deseja relacionar e depois aperte ENTER para fazer a ligação."]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-button">
                                    <button type="submit" onclick="return validar()" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
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
