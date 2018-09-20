<ul class="nav nav-pills nav-pills-success">
    <li class="nav-item">
        <?php
            if($this->Menu->activeMenu(['controller' => 'legislacao', 'action' => 'cadastro']))
            {
                echo $this->Html->link("Dados Cadastrais", "#", ['class' => 'nav-link active show']);
            }
            else
            {
                echo $this->Html->link("Dados Cadastrais", ['controller' => 'legislacao', 'action' => 'cadastro', $id], ['class' => 'nav-link']);
            }
        ?>
    </li>
    <li class="nav-item">
        <?php
            if($this->Menu->activeMenu(['controller' => 'legislacao', 'action' => 'relacionamentos']))
            {
                echo $this->Html->link("Relacionamentos", "#", ['class' => 'nav-link active show']);
            }
            else
            {
                echo $this->Html->link("Relacionamentos", ['controller' => 'legislacao', 'action' => 'relacionamentos', $id], ['class' => 'nav-link']);
            }
        ?>
    </li>
</ul>
