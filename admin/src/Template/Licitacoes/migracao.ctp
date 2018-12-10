<script type="text/javascript">
    var idLicitacao = <?=$id?>;
</script>
<?= $this->Html->script('select2.min', ['block' => 'scriptBottom']) ?>
<?= $this->Html->script('controller/licitacoes.migracao.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php
                            echo $this->Form->create($licitacao, [
                                "url" => [
                                    "controller" => "licitacoes",
                                    "action" => "save",
                                    $id
                                ],
                                'enctype' => 'multipart/form-data',
                                "role" => "form"]);
                            ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar a licitação',
                                'details' => ''
                            ]) ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_info',
                                'type' => 'info',
                                'restore' => true,
                                'message' => 'Foi detectado que existem informações não salvas dentro do cache de seu navegador. Clique em restaurar para recuperar esses dados e continuar com o cadastro ou clique em deecartar para excluir estes dados. Nenhuma das opções afetam em nada no banco de dados.'
                            ]) ?>
                            <?php if(!$pre_migracao):?>
                                <?=$this->element('message', [
                                    'name' => 'cadastro_info',
                                    'type' => 'warning',
                                    'restore' => true,
                                    'message' => 'Não foi possível realizar o processo automatizado de pré-migração de dados. Favor, verifique os dados contidos no sistema, antes de finalizar a migração.'
                                ]) ?>
                            <?php endif;?>
                            <?= $this->Flash->render() ?>
                            <?= $this->Form->hidden('lassuntos', ["id" => "lassuntos"]) ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("titulo", "Título") ?>
                                        <?= $this->Form->text("titulo", ["id" => "titulo", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("modalidade", "Modalidade") ?>
                                        <?= $this->Form->select("modalidade", $combo_modalidade, ["id" => "modalidade", "class" => "form-control", "empty" => true]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("numprocesso", "Número do Processo") ?>
                                        <?= $this->Form->number("numprocesso", ["id" => "numprocesso", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nummodalidade", "Número da Modalidade") ?>
                                        <?= $this->Form->number("nummodalidade", ["id" => "nummodalidade", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("numdocumento", "Número do Documento") ?>
                                        <?= $this->Form->number("numdocumento", ["id" => "numdocumento", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("status", "Status") ?>
                                        <?= $this->Form->select("status", $combo_status, ["id" => "status", "class" => "form-control", "empty" => true]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data_publicacao", "Data Publicação") ?>
                                        <?= $this->Form->text("data_publicacao", ["id" => "data_publicacao", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("hora_publicacao", "Hora Publicação") ?>
                                        <?= $this->Form->text("hora_publicacao", ["id" => "hora_publicacao", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("ano", "Ano") ?>
                                        <?= $this->Form->text("ano", ["id" => "ano", "class" => "form-control", "maxlength" => 4]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("documento", "Nome ou Tipo do Documento") ?>
                                        <?= $this->Form->text("documento", ["id" => "documento", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data_sessao", "Data da Sessão") ?>
                                        <?= $this->Form->text("data_sessao", ["id" => "data_sessao", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("hora_sessao", "Hora da Sessão") ?>
                                        <?= $this->Form->text("hora_sessao", ["id" => "hora_sessao", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data_fim", "Data Fim") ?>
                                        <?= $this->Form->text("data_fim", ["id" => "data_fim", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("hora_fim", "Hora Fim") ?>
                                        <?= $this->Form->text("hora_fim", ["id" => "hora_fim", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("descricao", "Descrição da Licitação") ?>
                                        <?= $this->Form->textarea("descricao", ["id" => "descricao", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= $this->Form->label("assuntos", "Assuntos") ?>
                                    <?=$this->Form->select('assuntos', $assuntos, ['id' => 'assuntos', 'multiple' => true, 'value' => $assuntos_pivot, 'class' => 'form-control'])?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Outras Opções</label> <br/>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("destaque", ['id' => 'destaque']) ?> Destaque
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("retificado", ['id' => 'retificado']) ?> Retificado
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("ativo", ['id' => 'ativo']) ?> Ativo
                                            </label>
                                        </div>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-content table-responsive">
                                    <legend>Arquivos capturados</legend>
                                    <p class="card-category">Arquivos capturados para conferência e definir dados corretos. Não será possível importar os arquivos com problemas. Só é possível reinserir os arquivos e/ou adicionar os novos, bem como excluir, somente depois da finalização da migração. Campos em arquivos inválidos não serão validados ou obrigatórios.</p>
                                    <table class="table" id="tblArquivos">
                                        <thead class="text-primary">
                                            <tr>
                                                <th style="width: 12%">Data</th>
                                                <th style="width: 20%">Número</th>
                                                <th style="width: 60%">Nome</th>
                                                <th class="text-center">Arquivo</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($arquivos as $arquivo): ?>
                                                 <tr>
                                                    <td>
                                                        <div class="form-group form-group-min">
                                                            <?=$this->Form->text("arquivo_data[]", ["id" => "arquivo_data", "class" => "form-control arqdata"])?>
                                                            <span class="material-input"></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group form-group-min">
                                                            <?=$this->Form->text("arquivo_numero[]", ["id" => "arquivo_numero", "class" => "form-control"])?>
                                                            <span class="material-input"></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group form-group-min">
                                                            <?=$this->Form->text("arquivo_nome[]", ["id" => "arquivo_nome", "class" => "form-control", "value" => $arquivo['nome']])?>
                                                            <span class="material-input"></span>
                                                        </div>
                                                    </td>
                                                    <td class="td-actions text-center">
                                                        <?php if($arquivo['status']['sucesso']): ?>
                                                            <?php if($arquivo['tipo'] == 'edital'): ?>
                                                                <a href="<?= $this->Url->build('/../' . $arquivo['arquivo'])?>" title="Ver arquivo" target="_blank" class="btn btn-info btn-round">
                                                                    <i class="material-icons">archive</i>
                                                                </a>
                                                            <?php else: ?>
                                                                <a href="<?= $this->Url->build('/../public/editor/files/' .  $this->File->nameFile($arquivo['arquivo']))?>" title="Ver arquivo" target="_blank" class="btn btn-info btn-round">
                                                                    <i class="material-icons">archive</i>
                                                                </a>
                                                            <?php endif;?>
                                                        <?php else: ?>
                                                            <a title="Arquivo inválido" class="btn btn-default btn-round">
                                                                <i class="material-icons">archive</i>
                                                            </a>
                                                        <?php endif;?>

                                                        <?= $this->Form->hidden("arquivo_tipo[]", ["id" => "arquivo_tipo", "value" => $arquivo['tipo']]);?>
                                                        <?= $this->Form->hidden("arquivo_arquivo[]", ["id" => "arquivo_arquivo", "value" => $arquivo['arquivo']]);?>
                                                    </td>
                                                    <td class="td-actions text-center">
                                                        <?php if($arquivo['status']['sucesso']): ?>
                                                            <a title="O arquivo está OK" class="btn btn-success btn-round">
                                                                <i class="material-icons">done</i>
                                                            </a>
                                                        <?php else: ?>
                                                        <a title="Existem problemas para este arquivo. Clique para ver detalhes" class="btn btn-danger btn-round", onclick="mostrarDetalhesErroArquivo('<?=$this->File->nameFile($arquivo['arquivo'])?>', '<?=$arquivo['status']['mensagem']?>')">
                                                                <i class="material-icons">close</i>
                                                            </a>
                                                        <?php endif;?>

                                                        <?= $this->Form->hidden("arquivo_valido[]", ["id" => "arquivo_valido", "value" => $arquivo['status']['sucesso']]);?>
                                                    </td>
                                                </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <button type="submit" onclick="return validar()" title="Finalizar a migração para o formato novo" class="btn btn-success pull-right">Finalizar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build(['action' => 'edicao', $id]) ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
