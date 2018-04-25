<div class="col-sm-7">
    &copy; <?=$this->Data->release()?> <?=$this->Data->setting('Author.company')?>. Desenvolvido por <a href="<?=$this->Data->setting('Author.developer.site')?>" target="_blank"><?=$this->Data->setting('Author.developer.name')?></a>.
</div>
<div class="col-sm-5">
    <ul class="pull-right">
        <li><a href="https://e-gov.betha.com.br/transparencia/01030-015/recursos.faces?mun=_fV0IsqgT0A_livlamqEHrXhxsPXsJ0O" target="_blank">Transparência</a></li>
        <li><?=$this->Html->link('Política de Privacidade', ['controller' => 'pages', 'action' => 'privacidade'])?></li>
        <li><?=$this->Html->link('Ouvidoria', ['controller' => 'ouvidoria'])?></li>
    </ul>
</div>
