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
                 <?=$this->request->session()->read('UsuarioNome')?>
                <b class="caret"></b>
            </a>
            <div class="collapse" id="collapseExample" aria-expanded="false" style="height: auto;">
                <ul class="nav">
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'perfil', 'action' => 'index']) ?>">Perfil</a>
                    </li>
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'log', 'action' => 'index']) ?>">Log de Acesso</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="sidebar-wrapper">
        <ul class="nav">
            <?php if ($this->Membership->handleMenu("painel")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'system', 'action' => 'board']) ?>">
                    <a href="<?= $this->Url->build(['controller' => 'system', 'action' => 'board']) ?>">
                        <i class="material-icons">dashboard</i>
                        <p>Início</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("usuarios")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'usuarios']) ?>">
                    <a href="<?= $this->Url->build('/usuarios') ?>">
                        <i class="material-icons">person</i>
                        <p>Usuários</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("grupo_usuarios")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'grupos']) ?>">
                    <a href="<?= $this->Url->build('/grupos') ?>">
                        <i class="material-icons">group_work</i>
                        <p>Grupo de Usuários</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("firewall")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'firewall']) ?>">
                    <a href="<?= $this->Url->build(['controller' => 'firewall', 'action' => 'index']) ?>">
                        <i class="material-icons">security</i>
                        <p>Firewall</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("feriado")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'feriado']) ?>">
                    <a href="<?= $this->Url->build(['controller' => 'feriado', 'action' => 'index']) ?>">
                        <i class="material-icons">event</i>
                        <p>Feriados</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("legislacao")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'legislacao']) ?>">
                    <a href="<?= $this->Url->build('/legislacao') ?>">
                        <i class="material-icons">gavel</i>
                        <p>Legislação</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("licitacoes")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'licitacoes']) ?>">
                    <a href="<?= $this->Url->build('/licitacoes') ?>">
                        <i class="material-icons">work</i>
                        <p>Licitações</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("concursos")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'concursos']) ?>">
                    <a href="<?= $this->Url->build('/concursos') ?>">
                        <i class="material-icons">content_paste</i>
                        <p>Concursos</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("publicacoes")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'publicacoes']) ?>">
                    <a href="<?= $this->Url->build('/publicacoes') ?>">
                        <i class="material-icons">insert_drive_file</i>
                        <p>Publicações</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("diarias")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'diarias']) ?>">
                    <a href="<?= $this->Url->build('/diarias') ?>">
                        <i class="material-icons">directions_car</i>
                        <p>Diárias</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("noticias")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'noticias']) ?>">
                    <a href="<?= $this->Url->build('/noticias') ?>">
                        <i class="material-icons">style</i>
                        <p>Notícias</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleSubmenus("ouvidoria_manifestacoes", "ouvidoria_manifestantes")): ?>
                <li>
                    <a data-toggle="collapse" href="#legislacao">
                    <i class="material-icons">hearing</i>
                    <p>Ouvidoria <b class="caret"></b></p>
                    </a>
                    <div class="collapse" id="legislacao" aria-expanded="true" style="padding: 0 0 0 40px">
                        <ul class="nav">
                            <?php if ($this->Membership->handleMenu("ouvidoria_manifestacoes")): ?>
                                <li class="<?= $this->Menu->activeMenu(['controller' => 'ouvidoria', 'action' => 'index']) ?>">
                                    <a href="<?= $this->Url->build('/ouvidoria') ?>">
                                        Manifestações
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($this->Membership->handleMenu("ouvidoria_manifestantes")): ?>
                                <li class="<?= $this->Menu->activeMenu(['controller' => 'ouvidoria', 'action' => 'manifestantes']) ?>">
                                    <a href="<?= $this->Url->build(['controller' => 'ouvidoria', 'action' => 'manifestantes']) ?>">
                                        Manifestantes
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleSubmenus("faq", "categoria_faq")): ?>
                <li>
                    <a data-toggle="collapse" href="#faq">
                    <i class="material-icons">device_unknown</i>
                    <p>Perguntas Frequentes <b class="caret"></b></p>
                    </a>
                    <div class="collapse" id="faq" aria-expanded="true" style="padding: 0 0 0 40px">
                        <ul class="nav">
                            <?php if ($this->Membership->handleMenu("faq")): ?>
                                <li class="<?= $this->Menu->activeMenu(['controller' => 'ouvidoria', 'action' => 'index']) ?>">
                                    <a href="<?= $this->Url->build('/faq') ?>">
                                        Perguntas
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($this->Membership->handleMenu("categoria_faq")): ?>
                                <li class="<?= $this->Menu->activeMenu(['controller' => 'ouvidoria', 'action' => 'manifestantes']) ?>">
                                    <a href="<?= $this->Url->build(['controller' => 'faq', 'action' => 'categorias']) ?>">
                                        Categorias
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("secretarias")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'secretarias']) ?>">
                    <a href="<?= $this->Url->build('/secretarias') ?>">
                        <i class="material-icons">business_center</i>
                        <p>Secretarias</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("paginas")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'paginas']) ?>">
                    <a href="<?= $this->Url->build('/paginas') ?>">
                        <i class="material-icons">public</i>
                        <p>Páginas</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("banners")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'banners']) ?>">
                    <a href="<?= $this->Url->build('/banners') ?>">
                        <i class="material-icons">slideshow</i>
                        <p>Banners</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->Membership->handleMenu("auditoria")): ?>
                <li class="<?= $this->Menu->activeMenu(['controller' => 'auditoria']) ?>">
                    <a href="<?= $this->Url->build('/auditoria') ?>">
                    <i class="material-icons">fingerprint</i>
                        <p>Auditoria</p>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
