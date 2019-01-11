<ul class="nav nav-pills nav-pills-success">
    <li class="nav-item">
        <?php
            if($this->Menu->activeMenu(['controller' => 'faq', 'action' => 'cadastro']))
            {
                echo $this->Html->link("Dados Cadastrais", "#", ['class' => 'nav-link active show']);
            }
            else
            {
                echo $this->Html->link("Dados Cadastrais", ['controller' => 'faq', 'action' => 'cadastro', $id], ['class' => 'nav-link']);
            }
        ?>
    </li>
    <li class="nav-item">
        <?php
            if($this->Menu->activeMenu(['controller' => 'faq', 'action' => 'relacionamentos']))
            {
                echo $this->Html->link("Relacionamentos", "#", ['class' => 'nav-link active show']);
            }
            else
            {
                echo $this->Html->link("Relacionamentos", ['controller' => 'faq', 'action' => 'relacionamentos', $id], ['class' => 'nav-link']);
            }
        ?>
    </li>
</ul>
