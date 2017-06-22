<section id="about-us">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Localização</h2>
            <p class="lead">Saiba como chegar a nossa cidade.</p>
        </div>

        <!-- about us slider -->
        <div id="about-slider">
            <div id="carousel-slider" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators visible-xs">
                    <li data-target="#carousel-slider" data-slide-to="0" class="active"></li>
                </ol>

                <div class="carousel-inner">
                    <div class="item active">
                        <center>
                            <?= $this->Html->image('praca.jpg', ['class' => 'img-responsive', 'alt' => 'Praça Dom Pedro II, no centro de coqueiral']); ?>
                        </center>
                    </div>
                </div>

            </div>
            <!--/#carousel-slider-->
        </div>
        <!--/#about-slider-->

        <div class="skill-wrap wow fadeInDown">
            <div class="center wow fadeInDown">
                <h2>Mapa</h2>
            </div>

            <div class="row">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12729.742897664417!2d-45.44894457641181!3d-21.18788756735225!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94b564c4ecfe4ec1%3A0xb1c5d24735ebd686!2sCoqueiral%2C+MG!5e1!3m2!1spt-BR!2sbr!4v1486740933314"
                    width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>

        <div class="col-md-12 wow fadeInDown">
            <div class="center wow fadeInDown">
                <h2>Como Chegar?</h2>
            </div>
            <div class="col-sm-12 col-md-4">
                <h2>De Ônibus</h2>
                <h3>Horário de Ônibus Saindo de Coqueiral</h3>
                <h4>Belo Horizonte</h4>
                <span>08:10</span>
                <h4>Nepomuceno e Lavras</h4>
                <span>08:10, 10:35, 14:35, 19:10</span>
                <h4>Santana da Vargem</h4>
                <span>07:45*, 11:00, 17:20, 19:30</span>
                <h4>Três Pontas e Varginha</h4>
                <span>07:45*, 11:00, 17:20</span>
                <h4>Alfenas e Campos Gerais</h4>
                <span>11:00, 17:20</span>
                <h4>Boa Esperança</h4>
                <span>07:45*, 11:00, 17:20</span><br/>
                <span>*Não funciona aos domingos</span>

                <h3>Horário de Ônibus Chegando a Coqueiral</h3>
                <h4>Saindo de Belo Horizonte</h4>
                <span>06:30</span>
                <h4>Saindo de Lavras</h4>
                <span>06:30, 10:05, 16:00, 18:30</span>
                <h4>Saindo de Varginha</h4>
                <span>09:00, 13:00, 17:30</span>
                <h4>Saindo de Alfenas</h4>
                <span>06:00</span>
                <h4>Saindo de Boa Esperança</h4>
                <span>07:25, 09:40, 18:00</span><br/><br/>
                <span>OBS: Se você pretende chegar a Coqueiral vindo de Rio de Janeiro, São Paulo, Belo Horizonte e Brasília, recomenda-se também ver conexões em Lavras, Varginha e Boa Esperança.</span>
            </div>
            <div class="col-sm-12 col-md-4">
                <h2>De Carro</h2>
                <p>O acesso a cidade é por meio da rodovia BR-265. A mesma termina na Rodovia Fernão Dias, que liga Belo Horizonte a São Paulo.</p>
            </div>
            <div class="col-sm-12 col-md-4">
                <h2>De Avião</h2>
                <p>Os aeroportos mais próximos de Coqueiral, situam-se em Lavras e Varginha. De lá, é preciso pegar um ônibus. Acesse <a href="http://www.voeminasgerais.com.br/" target="_blank"> Voe Minas Gerais </a> para maiores informaçõoes.</p>
            </div>
        </div>

        <br><br><br>

        <div class="wow fadeInDown">
            <div class="center wow fadeInDown">
                <h2>Maiores informações</h2>
            </div>
            <div class="col-md-6">
                <center>
                    <a onclick="ga('send', 'event', 'Externo', 'Site', 'Expresso Gardênia');" href="http://expressogardenia.com.br/" target="_blank" />
                        <?= $this->Html->image('expresso-gardenia.png', ['class' => 'img-responsive', 'alt' => 'Expresso Gardênia', 'title' => 'Expresso Gardênia']); ?>
                    </a>
                </center>
            </div>
            <div class="col-md-6">
                <center>
                    <a onclick="ga('send', 'event', 'Externo', 'Site', 'Voe Minas');" href="http://www.voeminasgerais.com.br/" target="_blank" />
                        <?= $this->Html->image('voe-minas.png', ['class' => 'img-responsive', 'alt' => 'Voe Minas Gerais', 'title' => 'Voe Minas Gerais']); ?>
                    </a>
                </center>
            </div>
            
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Go to www.addthis.com/dashboard to customize your tools --> 
                <div class="addthis_inline_share_toolbox"></div>

            </div>
        </div>

    </div>
    <!--/.container-->
</section>
<!--/about-us-->