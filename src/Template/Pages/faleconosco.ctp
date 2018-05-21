<section id="feature">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Entre em Contato com a Prefeitura</h2>
            <p class="lead">Escolha um item abaixo de seu interesse para se comunicar com a prefeitura.</p>
        </div>
        <div class="row">
            <div class="features">
                <div class="col-md-6 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                    <a href="/ouvidoria" onclick="ga('send', 'event', 'Externo', 'Site', 'Meu ISS');">
                        <div class="feature-wrap">
                            <i class="fa fa-bullhorn"></i>
                            <h2>Ouvidoria</h2>
                            <h3>Envie sua mensagem a prefeitura. Sua participação é muito importante!</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                    <a href="/iluminacao" onclick="ga('send', 'event', 'Externo', 'Site', 'Nota Fiscal Eletrônica');">
                        <div class="feature-wrap">
                            <i class="fa fa-lightbulb-o"></i>
                            <h2>Iluminação Pública</h2>
                            <h3>Problemas na iluminação pública da sua rua? Fale com a gente aqui</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                    <a href="/ouvidoria/acesso" onclick="ga('send', 'event', 'Externo', 'Site', 'Meu ISS');">
                        <div class="feature-wrap">
                            <i class="fa fa-envelope"></i>
                            <h2>Andamento dos Chamados</h2>
                            <h3>Verifique o andamento de seus chamados/manifestações solicitados!</h3>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                    <a href="<?=$this->Url->build(['controller' => 'pages', 'action' => 'construcao'])?>" onclick="ga('send', 'event', 'Externo', 'Site', 'Meu ISS');">
                        <div class="feature-wrap">
                            <i class="fa fa-question"></i>
                            <h2>Perguntas Mais Frequentes</h2>
                            <h3>Perguntas mais frequentemente dadas para prefeitura, organizados por assuntos.</h3>
                        </div>
                    </a>
                </div>

            </div>
            <!--/.services-->
        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>

<section id="contact-info">
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
