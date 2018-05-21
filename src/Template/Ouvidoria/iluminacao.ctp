<?= $this->Html->script('controller/ouvidoria.principal.js', ['block' => 'scriptBottom']) ?>
<?= $this->Html->script('controller/ouvidoria.acesso.js', ['block' => 'scriptBottom']) ?>
<section id="error" class="container text-center">
    <h2>Verifique o resultado de suas manifestações</h2>
    <p>Para verificar todos as suas manifestações e ainda editar seus dados, digite seu e-mail e clique em "Entrar".</p>
    <p>Para verificar apenas um manifesto específico, digite o número e clique "Consultar".</p>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?php
                echo $this->Form->create("ouvidoria", [
                    'class' => 'login_ouvidoria',
                    'id' => 'frm_logon',
                    'url' => [
                        'controller' => 'ouvidoria',
                        'action' => 'logon'
                    ]]);
                ?>
                 <?= $this->Form->label('email', 'E-mail') ?>
                 <?= $this->Form->email('email', ['id' => 'email', 'class' => 'form-control', "required" => true]) ?>
                 <button type="submit" id="btn-entrar" class="btn btn-success"><i class="fa fa-chevron-circle-right"></i>&nbsp;Entrar</button>
                <?php echo $this->Form->end(); ?>
            </div>
            <div class="col-md-6">
            <?php
                echo $this->Form->create("ouvidoria", [
                    'class' => 'login_ouvidoria',
                    'id' => 'frm_manifestacao',
                    'url' => [
                        'controller' => 'ouvidoria',
                        'action' => 'manifestacao'
                    ]]);
                ?>
                <?= $this->Form->label('numero', 'Número') ?>
                <?= $this->Form->number('numero', ['id' => 'numero', 'min' => 0, "required" => true, 'class' => 'form-control']) ?>
                <button type="submit" id="btn-consultar" class="btn btn-success"><i class="fa fa-eye"></i>&nbsp;Consultar</button>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</section><!--/#error-->
<section id="contact-page">
    <div class="container">
        <div class="center">
            <h2>Nova Manifestação/Chamado</h2>
            <p class="lead">Campos marcados com * são obrigatórios.</p>
        </div>
        <div class="row contact-wrap">
            <div class="status alert alert-success" style="display: none"></div>
            <?php
                echo $this->Form->create($manifestante, [
                    "url" => [
                        "controller" => "ouvidoria",
                        "action" => "send"
                    ],
                    "id" => "main-contact-form",
                    "class" => "contact-form",
                    "name" => "contact-form"]);
                ?>

                <div class="col-sm-5 col-sm-offset-1">
                    <div class="form-group">
                        <label>Nome *</label>
                        <?= $this->Form->text("nome", ["id" => "nome", "class" => "form-control", "required" => true, "maxlength" => 80]) ?>
                    </div>
                    <div class="form-group">
                        <label>E-mail *</label>
                        <?= $this->Form->email("email", ["id" => "email", "class" => "form-control", "required" => true, "maxlength" => 50]) ?>
                    </div>
                    <div class="form-group">
                        <label>Endereço *</label>
                        <?= $this->Form->text("endereco", ["id" => "endereco", "class" => "form-control", "required" => true, "maxlength" => 50]) ?>
                    </div>
                    <div class="form-group">
                        <label>Número *</label>
                        <?= $this->Form->text("numendereco", ["id" => "numendereco", "class" => "form-control", "required" => true, "maxlength" => 50]) ?>
                    </div>
                    <div class="form-group">
                        <label>Complemento</label>
                        <?= $this->Form->text("complemento", ["id" => "complemento", "class" => "form-control", "required" => true, "maxlength" => 50]) ?>
                    </div>
                    <div class="form-group">
                        <label>Bairro *</label>
                        <?= $this->Form->text("bairro", ["id" => "bairro", "class" => "form-control", "required" => true, "maxlength" => 50]) ?>
                    </div>
                    <div class="form-group">
                        <label>Telefone de Contato</label>
                        <?= $this->Form->tel("telefone", ["id" => "telefone", "class" => "form-control", "maxlength" => 50]) ?>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Assunto *</label>
                        <input type="text" id="assunto" name="assunto" class="form-control" required="required"/>
                    </div>
                    <div class="form-group">
                        <label>Mensagem *</label>
                        <textarea name="mensagem" id="mensagem" required="required" class="form-control" rows="20"></textarea>
                    </div>
                    <?php if(!$movel):?>
                        <div class="form-group">
                            <input type="checkbox" id="privativo" name="privativo"> Não salvar os dados neste computador <a data-toggle="popover" data-html="true" data-container="body" data-placement="top" data-content="O portal da Prefeitura Municipal de Coqueiral possui recursos para facilitar comunicação entre você e a prefeitura. Para isso, esta opção precisa ser desmarcada. É recomendável que se marque esta opção, caso esteja acessando este site de computadores públicos como em lanhouses, cybercafés e similares. Os dados enviados serão salvos no nosso banco de dados, para análise e o melhor atendimento, mas é você quem decide, se os mesmos podem ser salvos neste computador.  Para maiores informações, veja a nossa <a href='/privacidade' style='text-decoration: underline'>Política de Privacidade</a>."><i class="fa fa-question-circle"></i></a>
                        </div>
                    <?php endif;?>
                    <?php if($manifestante == null):?>
                        <div id="recapcha" class="g-recaptcha" data-sitekey="<?=$this->Data->setting('Security.reCaptcha.default.siteKey')?>"></div>
                        <div class="form-group">
                            <button type="submit" onclick="return enviarMensagem()" name="submit" class="btn btn-primary btn-lg" required="required">Enviar Mensagem</button>
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <button type="submit" id="enviar" name="enviar" class="g-recaptcha btn btn-primary btn-lg" data-sitekey="<?=$this->Data->setting('Security.reCaptcha.invisible.siteKey')?>" data-callback="onSubmit">Enviar Mensagem</button>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>
<!--/#contact-page-->
