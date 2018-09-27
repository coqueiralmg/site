<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="description" content="Site oficial da Prefeitura Municipal de Coqueiral">
        <meta name="google-site-verification" content="7fEpE0IROydpIMxVfMVazAHHWbWeAH3t8RIHZVCLjFM" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

        <title><?=$this->Data->setting('System.name')?></title>

        <?= $this->Html->css('maintenance.css') ?>
    </head>
    <body class="is-preload">
        <?= $this->fetch('content') ?>
    </body>
</html>
