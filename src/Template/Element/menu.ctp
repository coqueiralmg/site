<nav class="navbar navbar-inverse" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button type="button" title="Clique neste botão para acessar o menu" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Clique neste botão para acessar o menu</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= $this->Url->build(['controller' => 'pages', 'action' => 'home']) ?>">
                <?= $this->Html->image('logotipo.png', ['alt' => 'Prefeitura Municipal de Coqueiral']); ?>
            </a>
        </div>

        <div class="collapse navbar-collapse navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown <?= $this->Menu->activeMenu(['controller' => 'cidade']) ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">A Cidade <i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li class="<?= $this->Menu->activeMenu(['controller' => 'cidade', 'action' => 'historico']) ?>"><?=$this->Html->link('Histórico', ['controller' => 'cidade', 'action' => 'historico'])?></li>
                        <li class="<?= $this->Menu->activeMenu(['controller' => 'cidade', 'action' => 'perfil']) ?>"><?=$this->Html->link('Perfil', ['controller' => 'cidade', 'action' => 'perfil'])?></li>
                        <li class="<?= $this->Menu->activeMenu(['controller' => 'cidade', 'action' => 'localizacao']) ?>"><?=$this->Html->link('Localização', ['controller' => 'cidade', 'action' => 'localizacao'])?></li>
                    </ul>
                </li>
                <li class="dropdown <?= $this->Menu->activeMenus(['controller' => 'legislacao'], ['controller' => 'licitacoes'], ['controller' => 'concursos'], ['controller' => 'diarias'], ['controller' => 'publicacoes']) ? 'active' : '' ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Publicações <i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown-menu" style="min-width: 250px">
                        <li class="<?= $this->Menu->activeMenu(['controller' => 'legislacao']) ?>"><?=$this->Html->link('Legislação', ['controller' => 'legislacao'])?></li>
                        <li class="<?= $this->Menu->activeMenu(['controller' => 'licitacoes']) ?>"><?=$this->Html->link('Licitações', ['controller' => 'licitacoes'])?></li>
                        <li class="<?= $this->Menu->activeMenu(['controller' => 'concursos']) ?>"><?=$this->Html->link('Concursos e Processos Seletivos', ['controller' => 'concursos'])?></li>
                        <li class="<?= $this->Menu->activeMenu(['controller' => 'diarias']) ?>"><?=$this->Html->link('Relatórios de Diárias', ['controller' => 'diarias'])?></li>
                        <li class="<?= $this->Menu->activeMenu(['controller' => 'publicacoes']) ?>"><?=$this->Html->link('Outras Publicações', ['controller' => 'publicacoes'])?></li>
                    </ul>
                </li>
                <li><a onclick="ga('send', 'event', 'Externo', 'Site', 'Portal de Transparência'); LE.info('Acesso ao site da transparência. Página de referência: ' + window.location.href);" href="<?=$this->Url->build(['controller' => 'pages', 'action' => 'construcao', $this->Data->crypt(['mensagem' => 'O sistema encontra-se em manutenção, podendo retornar até o dia 7 de maio.'])])?>">Transparência</a>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'noticias']) ?>"><a href="/noticias">Notícias</a></li>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'pages', 'action' => 'contato']) ?>"><a href="/contato">Fale com a Prefeitura</a></li>

            </ul>
        </div>
    </div>
    <!--/.container-->
</nav>
