<?= $this->Html->script('controller/ouvidoria.principal.js', ['block' => 'scriptBottom']) ?>
<section id="contact-info">
        <div class="center">
            <h2>Entre em contato com a prefeitura</h2>
            <p class="lead">Preencha corretamente todos os campos para facilitar o retorno e validar seu contato. A prefeitura garante total sigilo de seus dados.</p>
            <p class="lead">Para verificar o andamento de sua manifestação, <a href="/ouvidoria/acesso">clique aqui.</a></p>
        </div>
        <div class="gmap-area">
            <div class="container">
                <div class="row">

                    <div class="col-sm-7 map-content">
                        <ul class="row">
                            <li class="col-sm-6">
                                <address>
                                    <h5>Prefeitura</h5>
                                    <p>Rua Minas Gerais, 62 - Vila Sônia <br>
                                    Coqueiral - MG</p>
                                    <p>Telefones:<br/> 
                                    (35) 3855-1162<br>
                                    (35) 3855-1166</p>
                                    <p>CEP: 37235-000</p>
                                </address>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/gmap_area -->

<section id="contact-page">
    <div class="container">
        <div class="center">
            <h2>Formulário de Contato</h2>
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
                        <label>Endereço</label>
                        <?= $this->Form->text("endereco", ["id" => "endereco", "class" => "form-control", "maxlength" => 50]) ?>
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
                        <textarea name="mensagem" id="mensagem" required="required" class="form-control" rows="8"></textarea>
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
