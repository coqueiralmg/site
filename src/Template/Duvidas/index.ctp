<?= $this->Html->script('controller/duvidas.lista.js', ['block' => 'scriptBottom']) ?>
<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Dúvidas e Perguntas</h2>
            <p class="lead">Dúvidas e perguntas pertinentes, relativos a qualquer assunto sobre prefeitura e município de Coqueiral.</p>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php
                echo $this->Form->create("Duvidas", [
                    "url" => [
                        "controller" => "licitacoes",
                        "action" => "busca"
                    ],
                    'idPrefix' => 'pesquisar-duvidas',
                    'type' => 'get',
                    'role' => 'form']);

                ?>

                <?= $this->Form->search('chave', ['id' => 'pesquisa', 'class' => 'form-control busca', 'placeholder' => 'Digite aqui para buscar']) ?>
                 <button type="submit" id="btn-pesquisar" class="btn btn-success"><i class="fa fa-search"></i>&nbsp;Buscar</button>

                <?php echo $this->Form->end(); ?>
            </div>
        </div>

        <div class="row">
             <?php if(count($destaques) > 0): ?>
                <div class="col-md-6">
                    <h3>Destaques</h3>
                    <ul>
                        <?php foreach($destaques as $destaque): ?>
                            <li><?=$this->Html->link($destaque->questao, ['controller' => 'duvidas', 'action' => 'duvida', $destaque->slug . '-' . $destaque->id])?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-6">
             <?php else: ?>
                <div class="col-md-12">
             <?php endif; ?>
                    <h3>Mais Vistos</h3>
                    <ol>
                        <?php foreach($populares as $popular): ?>
                            <li><?=$this->Html->link($popular->questao, ['controller' => 'duvidas', 'action' => 'duvida', $popular->slug . '-' . $popular->id])?></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3>Categorias</h3>
            </div>
            <?php foreach($categorias as $categoria): ?>
                <?php if(count($categoria->perguntas) > 0):?>
                <div class="col-md-3">
                    <h4><?=$categoria->nome?></h4>
                    <ul>
                    <?php for($i = 0; $i < count($categoria->perguntas) && $i < 3; $i++): ?>
                        <?php
                            $pergunta = $categoria->perguntas[$i];
                        ?>
                        <li><?=$this->Html->link($pergunta->questao, ['controller' => 'duvidas', 'action' => 'duvida', $pergunta->slug . '-' . $pergunta->id])?></li>
                    <?php endfor; ?>
                    </ul>
                    <?php if(count($categoria->perguntas) > 3):?>
                        <div>
                            <?=$this->Html->link('Veja Mais', ['controller' => 'duvidas', 'action' => 'categoria', $categoria->id], ['class' => 'btn btn-primary btn-block'])?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif;?>
            <?php endforeach; ?>
        </div>
        <hr clear="all"/>
        <div class="row">
            <div class="col-md-12 text-center">
                    Existem ao todo, <?=$total?> perguntas cadastradas.
            </div>
        </div>
    </div>

    <!--/.container-->
</section>
<!--/about-us-->
