<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php
                            echo $this->Form->create($usuario, [
                                "url" => [
                                    "controller" => "usuarios",
                                    "action" => "save",
                                    $id
                                ],
                                "role" => "form"]);
                            ?>
                             <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar o usuário',
                                'details' => ''
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("pessoa.nome", "Nome") ?>
                                        <?= $this->Form->text("pessoa.nome", ["id" => "nome", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control input-group date">
                                        <?= $this->Form->label("pessoa.apelido", "Apelido") ?>
                                        <?= $this->Form->text("pessoa.apelido", ["id" => "apelido", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control input-group date">
                                        <?= $this->Form->label("pessoa.dataNascimento", "Data de Nascimento") ?>
                                        <?= $this->Form->text("pessoa.dataNascimento", ["id" => "data_nascimento", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("email", "E-mail") ?>
                                        <?= $this->Form->email("email", ["id" => "email", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?= $this->Form->label("usuario", "Usuário") ?>
                                        <?= $this->Form->text("usuario", ["id" => "usuario", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?= $this->Form->label("senha", "Senha") ?>
                                        <?= $this->Form->password("senha", ["id" => "senha", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?= $this->Form->label("confirma_senha", "Confirme a Senha") ?>
                                        <?= $this->Form->password("confirma_senha", ["id" => "confirma_senha", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= $this->Form->label("grupo", "Grupo") ?> <br/>
                                        <?=$this->Form->select('grupo', $grupos, ['id' => 'grupo', 'empty' => true, 'class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Outras Opções</label> <br/>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("ativo") ?> Ativo
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("verificar") ?> Obrigar o usuário a trocar de senha
                                            </label>
                                        </div>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" onclick="return validar()" class="btn btn-success pull-right">Salvar</button>
                            <button type="reset" class="btn btn-default pull-right">Limpar</button>
                            <button type="button" onclick="window.location="<?= $this->Url->build('/usuarios') ?>" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#data_nascimento').datepicker({
            language: 'pt-BR'
        });

        $('#data_nascimento').mask('00/00/0000');
    });

     function validar(){
        var mensagem = "";

        if ($("#nome").val() === "") {
            mensagem += "<li> O nome do usuário é obrigatório.</li>";
            $("label[for='pessoa-nome']").css("color", "red");
        } else {
            $("label[for='pessoa-nome']").css("color", "#aaa");
        }

        if ($("#data_nascimento").val() === "") {
            mensagem += "<li> É obrigatório informa a data de nascimento.</li>";
            $("label[for='pessoa-datanascimento']").css("color", "red");
        } else {
            $("label[for='pessoa-datanascimento']").css("color", "#aaa");
        }

        if ($("#email").val() === "") {
            mensagem += "<li> O e-mail do usuário é obrigatório.</li>";
            $("label[for='email']").css("color", "red");
        } else {
            $("label[for='email']").css("color", "#aaa");            
        }

        if ($("#usuario").val() === "") {
            mensagem += "<li> É obrigatório informar o login do usuário.</li>";
            $("label[for='usuario']").css("color", "red");
        } else {
            $("label[for='usuario']").css("color", "#aaa");
        }

        if ($("#senha").val() === "") {
            mensagem += "<li> É obrigatório informar a senha do usuário.</li>";
            $("label[for='senha']").css("color", "red");
        } else {
            $("label[for='senha']").css("color", "#aaa");
        }

        if ($("#confirma_senha").val() === "") {
            mensagem += "<li> É obrigatório informar a confirmação da senha.</li>";
            $("label[for='confirma-senha']").css("color", "red");
        } else {
            $("label[for='confirma-senha']").css("color", "#aaa");
        }

        if ($("#grupo").val() === "") {
            mensagem += "<li> É obrigatório informar o grupo de usuário.</li>";
            $("label[for='grupo']").css("color", "red");
        } else {
            $("label[for='grupo']").css("color", "red");
        }

        if ($("#senha").val() != "" && $("#confirma_senha").val() != "") {
            if ($("#senha").val() !== $("#confirma_senha").val()) {
                mensagem += "<li>A senha e a confirmação estão diferentes.</li>";
                $("label[for='senha']").css("color", "red");
                $("label[for='confirma-senha']").css("color", "red");
            } else {
                $("label[for='senha']").css("color", "#aaa");
                $("label[for='confirma-senha']").css("color", "#aaa");
            }
        }

        if(mensagem == ""){
            return true;
        } else {
            $("#cadastro_erro").show('shake');
            $("#details").html("<ol>" + mensagem + "</ol>");
            return false;
        }
    }
</script>