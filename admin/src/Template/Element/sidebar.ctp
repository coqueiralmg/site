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
            <li class="active">
                <a href="dashboard.html">
                    <i class="material-icons">dashboard</i>
                    <p>Início</p>
                </a>
            </li>
            <li>
                <a href="user.html">
                    <i class="material-icons">person</i>
                    <p>Usuários</p>
                </a>
            </li>
            <li>
                <a href="table.html">
                    <i class="material-icons">group_work</i>
                    <p>Grupo de Usuários</p>
                </a>
            </li>
            <li>
                <a href="typography.html">
                    <i class="material-icons">library_books</i>
                    <p>Publicações</p>
                </a>
            </li>
            <li>
                <a href="icons.html">
                    <i class="material-icons">work</i>
                    <p>Licitações</p>
                </a>
            </li>
            <li>
                <a href="maps.html">
                    <i class="material-icons">style</i>
                    <p>Notícias</p>
                </a>
            </li>
            <li>
                <a href="maps.html">
                   <i class="material-icons">location_city</i>
                    <p>Legislação</p>
                </a>
            </li>
            <li>
                <a href="maps.html">
                   <i class="material-icons">fingerprint</i>
                    <p>Auditoria</p>
                </a>
            </li>
            
        </ul>
    </div>
</div>