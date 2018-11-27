<ul class="nav nav-pills nav-pills-success">
    <li class="nav-item">
        <?php
            if($this->Menu->activeMenu(['controller' => 'licitacoes', 'action' => 'cadastro']))
            {
                echo $this->Html->link("Dados Cadastrais", "#", ['class' => 'nav-link active show']);
            }
            else
            {
                echo $this->Html->link("Dados Cadastrais", ['controller' => 'licitacoes', 'action' => 'cadastro', $id], ['class' => 'nav-link']);
            }
        ?>
    </li>
    <li class="nav-item">
        <?php
            if($this->Menu->activeMenu(['controller' => 'licitacoes', 'action' => 'informativos']))
            {
                echo $this->Html->link("Extratos e Informativos", "#", ['class' => 'nav-link active show']);
            }
            else
            {
                echo $this->Html->link("Extratos e Informativos", ['controller' => 'licitacoes', 'action' => 'informativos', $id], ['class' => 'nav-link']);
            }
        ?>
    </li>
    <li class="nav-item">
        <?php
            if($this->Menu->activeMenu(['controller' => 'licitacoes', 'action' => 'anexos']))
            {
                echo $this->Html->link("Documentos e Anexos", "#", ['class' => 'nav-link active show']);
            }
            else
            {
                echo $this->Html->link("Documentos e Anexos", ['controller' => 'licitacoes', 'action' => 'anexos', $id], ['class' => 'nav-link']);
            }
        ?>
    </li>

    <li class="nav-item">
        <?php
            if($this->Menu->activeMenu(['controller' => 'licitacoes', 'action' => 'visualizar']))
            {
                echo $this->Html->link("Visualizar e Imprimir", "#", ['class' => 'nav-link active show']);
            }
            else
            {
                echo $this->Html->link("Visualizar e Imprimir", ['controller' => 'licitacoes', 'action' => 'visualizar', $id], ['class' => 'nav-link']);
            }
        ?>
    </li>
</ul>
