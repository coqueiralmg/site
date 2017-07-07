<div class="sidebar" data-background-color="white" data-color="green">
    <div class="logo">
        <center>
            <?= $this->Html->image('brasao_coqueiral.png', ['class' => 'img-responsive', 'width' => '100px;', 'title' => 'Prefeitura Municipal de Coqueiral', 'alt' => 'Prefeitura Municipal de Coqueiral', 'url' => ['controller' => 'System', 'action' => 'board']]); ?>
        </center>
        <?= $this->Html->link('Painel de Controle', ['controller' => 'System', 'action' => 'board'],  ['class' => 'simple-text']) ?>
    </div>

    <div class="user">

        <div class="info">
            <a data-toggle="collapse" href="#collapseExample" class="collapsed" aria-expanded="false">
                <i class="material-icons">assignment_ind</i> 
                Nome do Usuário
                <b class="caret"></b>
            </a>
            <div class="collapse" id="collapseExample" aria-expanded="false" style="height: auto;">
                <ul class="nav">
                    <li>
                        <a href="#">Perfil</a>
                    </li>
                    <li>
                        <a href="#">Log de Acesso</a>
                    </li>
                    <li>
                        <a href="#">Opções</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="<?= $this->Menu->activeMenu(['controller' => 'system', 'action' => 'board']) ?>">
                <a href="<?= $this->Url->build(['controller' => 'system', 'action' => 'board']) ?>">
                    <i class="material-icons">dashboard</i>
                    <p>Início</p>
                </a>
            </li>
            <li class="<?= $this->Menu->activeMenu(['controller' => 'usuarios']) ?>">
                <a href="<?= $this->Url->build('/usuarios') ?>">
                    <i class="material-icons">person</i>
                    <p>Usuários</p>
                </a>
            </li>
            <li class="<?= $this->Menu->activeMenu(['controller' => 'grupos']) ?>">
                <a href="<?= $this->Url->build('/grupos') ?>">
                    <i class="material-icons">group_work</i>
                    <p>Grupo de Usuários</p>
                </a>
            </li>
            <li class="<?= $this->Menu->activeMenu(['controller' => 'publicacoes']) ?>">
                <a href="<?= $this->Url->build('/publicacoes') ?>">
                    <i class="material-icons">library_books</i>
                    <p>Publicações</p>
                </a>
            </li>
            <li class="<?= $this->Menu->activeMenu(['controller' => 'licitacoes']) ?>">
                <a href="<?= $this->Url->build('/licitacoes') ?>">
                    <i class="material-icons">work</i>
                    <p>Licitações</p>
                </a>
            </li>
            <li class="<?= $this->Menu->activeMenu(['controller' => 'noticias']) ?>">
                <a href="<?= $this->Url->build('/noticias') ?>">
                    <i class="material-icons">style</i>
                    <p>Notícias</p>
                </a>
            </li>
            <li class="<?= $this->Menu->activeMenu(['controller' => 'legislacao']) ?>">
                <a data-toggle="collapse" href="#legislacao">
                   <i class="material-icons">location_city</i>
                   <p>Legislação <b class="caret"></b></p>
                </a>
                <div class="collapse" id="legislacao" aria-expanded="true" style="padding: 0 0 0 40px">
                    <ul class="nav">
                        <li>
                            <a href="<?= $this->Url->build('/legislacao') ?>">
                                Pesquisa de Legislação
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->Url->build(['controller' => 'legislacao', 'action' => 'importacao']) ?>">
                                Cadastro em Massa
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->Url->build(['controller' => 'legislacao', 'action' => 'categorias']) ?>">
                                Categorias
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->Url->build(['controller' => 'legislacao', 'action' => 'tags']) ?>">
                                Tags
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="<?= $this->Menu->activeMenu(['controller' => 'secretarias']) ?>">
                <a href="<?= $this->Url->build('/secretarias') ?>">
                    <i class="material-icons">business_center</i>
                    <p>Secretarias</p>
                </a>
            </li>
            <li class="<?= $this->Menu->activeMenu(['controller' => 'banners']) ?>">
                <a href="<?= $this->Url->build('/banners') ?>">
                    <i class="material-icons">slideshow</i>
                    <p>Banners</p>
                </a>
            </li>
            <li class="<?= $this->Menu->activeMenu(['controller' => 'outros']) ?>">
                <a  data-toggle="collapse" href="#outros">
                    <i class="material-icons">extension</i>
                    <p>Outros <b class="caret"></b></p> 
                </a>
                <div class="collapse" id="outros" aria-expanded="true" style="padding: 0 0 0 40px">
                    <ul class="nav">
                        <li>
                            <a href="<?= $this->Url->build(['controller' => 'legislacao', 'action' => 'importacao']) ?>">
                                Páginas Fixas
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->Url->build('/comandos') ?>">
                                Comandos da Home
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->Url->build(['controller' => 'legislacao', 'action' => 'categorias']) ?>">
                                Informações Extras
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="<?= $this->Menu->activeMenu(['controller' => 'auditoria']) ?>">
                <a href="<?= $this->Url->build('/auditoria') ?>">
                   <i class="material-icons">fingerprint</i>
                    <p>Auditoria</p>
                </a>
            </li>

        </ul>
    </div>
</div>