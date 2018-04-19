<nav class="navbar navbar-inverse" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button type="button" title="Clique neste botão para acessar o menu" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Clique neste botão para acessar o menu</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <?= $this->Html->image('logotipo.png', ['alt' => 'Prefeitura Municipal de Coqueiral']); ?>
            </a>
        </div>

        <div class="collapse navbar-collapse navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown <?= $this->Menu->activeMenu(['controller' => 'cidade']) ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">A Cidade <i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li class="<?= $this->Menu->activeMenu(['controller' => 'cidade', 'action' => 'historico']) ?>"><a href="/cidade/historico">Histórico</a></li>
                        <li class="<?= $this->Menu->activeMenu(['controller' => 'cidade', 'action' => 'perfil']) ?>"><a href="/cidade/perfil">Perfil</a></li>
                        <li class="<?= $this->Menu->activeMenu(['controller' => 'cidade', 'action' => 'localizacao']) ?>"><a href="/cidade/localizacao">Localização</a></li>
                        <!--<li><a href="turismo.html">Pontos Turísticos</a></li>-->
                        <!--<li><a href="prefeitura.html">A Prefeitura</a></li>-->
                        <!--<li><a href="prefeito.html">O Prefeito</a></li>-->
                    </ul>
                </li>
                <li><a onclick="ga('send', 'event', 'Externo', 'Site', 'Portal de Transparência'); LE.info('Acesso ao site da transparência. Página de referência: ' + window.location.href);" href="https://e-gov.betha.com.br/transparencia/01030-015/recursos.faces?mun=_fV0IsqgT0A_livlamqEHrXhxsPXsJ0O" target="_blank">Transparência</a></li>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'publicacoes']) ?>"><a href="/publicacoes">Publicações</a></li>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'licitacoes']) ?>"><a href="/licitacoes">Licitações</a></li>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'noticias']) ?>"><a href="/noticias">Notícias</a></li>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'pages', 'action' => 'contato']) ?>"><a href="/contato">Fale com a Prefeitura</a></li>
            </ul>
        </div>
    </div>
    <!--/.container-->
</nav>
