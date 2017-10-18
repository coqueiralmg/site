<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?php if ($error instanceof Error) : ?>
        <strong>Error in: </strong>
        <?= sprintf('%s, line %s', str_replace(ROOT, 'ROOT', $error->getFile()), $error->getLine()) ?>
<?php endif; ?>
<?php
    echo $this->element('auto_table_warning');

    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>
<section id="error" class="container text-center">
    <h1>Erro 500: Erro interno de servidor</h1>
    <p>Lamentamos muito, ocorreu uma falha no sistema ao acessar esta página desejada. Caso isto ainda persista, <a href="/fale-conosco">entre em contato conosco</a>.</p>
    <div id="merror">
        <span>
            <?=h($message)?>
        <span>
    </div>
    <a class="btn btn-primary" href="/">Página Inicial</a>
    <a class="btn btn-primary" onclick="$('#merror').css('display','table')" href="#">Detalhes do erro</a>
</section><!--/#error-->

<script type="text/javascript">
    $(function(){
        ga('send', 'event', 'Sistema', 'Erro', 'Falha do sistema');
    });
    
</script>