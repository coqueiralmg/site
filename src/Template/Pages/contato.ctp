<section id="contact-info">
        <div class="center">
            <h2>Entre em contato com a prefeitura</h2>
            <p class="lead">Preencha corretamente todos os campos para facilitar o retorno e validar seu contato.</p>
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
            <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="/pages/contato">
                <div class="col-sm-5 col-sm-offset-1">
                    <div class="form-group">
                        <label>Nome *</label>
                        <input type="text" id="nome" name="nome" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label>E-mail *</label>
                        <input type="email" id="email" name="email" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label>Telefone de Contato</label>
                        <input type="tel" id="telefone" name="telefone" class="form-control">
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Assunto *</label>
                        <input type="text" id="assunto" name="assunto" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label>Mensagem *</label>
                        <textarea name="mensagem" id="mensagem" required="required" class="form-control" rows="8"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" onclick="enviarMensagem()" name="submit" class="btn btn-primary btn-lg" required="required">Enviar Mensagem</button>
                    </div>
                </div>
            </form>
        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>
<!--/#contact-page-->
