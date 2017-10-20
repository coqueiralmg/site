<section id="error" class="container text-center">
    <h1>Verifique o resultado de suas manifestações</h1>
    <p>Para verificar todos as suas manifestações e ainda editar seus dados, digite seu e-mail e clique OK.</p>
    <p>Para verificar apenas um manifesto específico, digite o número e clique OK.</p>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?php
                echo $this->Form->create("ouvidoria", [
                    'class' => 'login_ouvidoria',
                    'url' => [
                        'controller' => 'ouvidoria',
                        'action' => 'logon'
                    ]]);
                ?>
                 <?= $this->Form->label('email', 'E-mail') ?>
                 <?= $this->Form->email('email', ['id' => 'email', 'class' => 'form-control', 'value' => $email]) ?>
                 <button type="submit" id="btn-pesquisar" class="btn btn-success"><i class="fa fa-chevron-circle-right"></i>&nbsp;Entrar</button>
                <?php echo $this->Form->end(); ?>
            </div>
            <div class="col-md-6">
            <?php
                echo $this->Form->create("ouvidoria", [
                    'class' => 'login_ouvidoria',
                    'url' => [
                        'controller' => 'ouvidoria',
                        'action' => 'manifestacao'
                    ]]);
                ?>
                <?= $this->Form->label('numero', 'Número') ?>
                <?= $this->Form->number('numero', ['id' => 'numero', 'class' => 'form-control']) ?>
                <button type="submit" id="btn-pesquisar" class="btn btn-success"><i class="fa fa-eye"></i>&nbsp;Consultar</button>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</section><!--/#error-->