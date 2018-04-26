<div class="col-sm-7">
    &copy; <?=$this->Data->release()?> <?=$this->Data->setting('Author.company')?>. Desenvolvido por <a href="<?=$this->Data->setting('Author.developer.site')?>" target="_blank"><?=$this->Data->setting('Author.developer.name')?></a>.
</div>
<div class="col-sm-5">
    <ul class="pull-right">
        <li><a href="<?=$this->Url->build(['controller' => 'pages', 'action' => 'construcao', $this->Data->crypt(['mensagem' => 'O sistema encontra-se em manutenção, podendo retornar até o dia 7 de maio.'])])?>">Transparência</a></li>
        <li><?=$this->Html->link('Política de Privacidade', ['controller' => 'pages', 'action' => 'privacidade'])?></li>
        <li><?=$this->Html->link('Contato', ['controller' => 'pages', 'action' => 'contato'])?></li>
    </ul>
</div>
