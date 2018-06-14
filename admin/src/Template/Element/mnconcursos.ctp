<ul class="nav nav-pills nav-pills-success">
    <li class="nav-item">
        <?php
            if($this->Menu->activeMenu(['controller' => 'concursos', 'action' => 'cadastro']))
            {
                echo $this->Html->link("Dados Cadastrais", "#", ['class' => 'nav-link active show']);
            }
            else
            {
                echo $this->Html->link("Dados Cadastrais", ['controller' => 'concursos', 'action' => 'cadastro', $id], ['class' => 'nav-link']);
            }
        ?>
    </li>
    <li class="nav-item">
        <?php
            if($this->Menu->activeMenu(['controller' => 'concursos', 'action' => 'anexos']))
            {
                echo $this->Html->link("Documentos e Anexos", "#", ['class' => 'nav-link active show']);
            }
            else
            {
                echo $this->Html->link("Documentos e Anexos", ['controller' => 'concursos', 'action' => 'anexos', $id], ['class' => 'nav-link']);
            }
        ?>
    </li>
    <li class="nav-item">
        <?php
            if($this->Menu->activeMenu(['controller' => 'concursos', 'action' => 'cargos']))
            {
                echo $this->Html->link("Cargos", "#", ['class' => 'nav-link active show']);
            }
            else
            {
                echo $this->Html->link("Cargos", ['controller' => 'concursos', 'action' => 'cargos', $id], ['class' => 'nav-link']);
            }
        ?>
    </li>
    <li class="nav-item">
        <?php
            if($this->Menu->activeMenu(['controller' => 'concursos', 'action' => 'informativos']))
            {
                echo $this->Html->link("Informativos", "#", ['class' => 'nav-link active show']);
            }
            else
            {
                echo $this->Html->link("Informativos", ['controller' => 'concursos', 'action' => 'informativos', $id], ['class' => 'nav-link']);
            }
        ?>
    </li>
    <li class="nav-item">
        <?php
            if($this->Menu->activeMenu(['controller' => 'concursos', 'action' => 'visualizar']))
            {
                echo $this->Html->link("Visualizar e Imprimir", "#", ['class' => 'nav-link active show']);
            }
            else
            {
                echo $this->Html->link("Visualizar e Imprimir", ['controller' => 'concursos', 'action' => 'visualizar', $id], ['class' => 'nav-link']);
            }
        ?>
    </li>
</ul>
