<div class="col-sm-7">
    &copy; <?=$this->Data->release()?> <?=$this->Data->setting('Author.company')?>. Desenvolvido por <a href="<?=$this->Data->setting('Author.developer.site')?>" target="_blank"><?=$this->Data->setting('Author.developer.name')?></a>.
</div>
<div class="col-sm-5">
    <ul class="pull-right">
        <li><a href="http://www.municipalnet.com.br/fornecedorweb/portalTransparencia.php?cod=dHJhbnNwd2ViX2NvcXVlaXJhbA==" target="_blank">Transparência</a></li>
        <li><?=$this->Html->link('Política de Privacidade', ['controller' => 'pages', 'action' => 'privacidade'])?></li>
        <li><?=$this->Html->link('Contato', ['controller' => 'pages', 'action' => 'contato'])?></li>
    </ul>
</div>
