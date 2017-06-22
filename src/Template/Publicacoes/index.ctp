<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Publicações</h2>
            <p class="lead">Documentos, portarias, concursos e outras publicações oficiais.</p>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php
                echo $this->Form->create("Publicacao", [
                    "url" => [
                        "controller" => "usuario",
                        "action" => "index"
                    ],
                    'idPrefix' => 'pesquisar-publicacao',
                    'type' => 'get',
                    'role' => 'form']);
                    
                ?>

                <?php echo $this->Form->end(); ?>
                <form id="pesquisar-legislacao">
                    <input id="pesquisa" name="search" type="search" class="form-control busca" placeholder="O que deseja buscar?">
                    <button type="button" id="btn-pesquisar" name="submit" class="btn btn-success"><i class="fa fa-search"></i>&nbsp;Buscar</button>
                </form>
            </div>
        </div>

        <div class="row">
            <?php if(count($publicacoes) > 0): ?>
                <?php foreach($publicacoes as $publicacao): ?>
                    <div class="item col-md-12 col-lg-6">
                        <h3 class="media-heading" style="text-transform: uppercase;"><?= $publicacao->titulo ?></h3>
                        <p><?= $publicacao->resumo ?></p>
                        <?= $this->Html->link('Veja mais', ['controller' => 'publicacoes', 'action' =>  'publicacao', $publicacao->id], ['class' => 'btn btn-success']) ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhuma publicação disponível!</p>
            <?php endif; ?>
            <!--
            {% if publicacoes | length > 0 %} {% for publicacao in publicacoes %}
            <div class="item col-md-12 col-lg-6">
                <h3 class="media-heading">{{ publicacao.getTitulo() | upper }}</h3>
                <p>{{ cortarTexto(publicacao.getDescricao(), 350, true, true) }}</p>
                <a href="/publicacao/{{ gerarSlug(publicacao.getTitulo()) ~" / "~ publicacao.getId() }}" class="btn btn-success">Veja mais</a>
            </div>

            {% endfor %} {% else %}
            <p>Nenhuma publicação disponível!</p>
            {% endif %}
            -->
        </div>

        <?=$this->element('pagination', $opcao_paginacao) ?>
    </div>
    <!--/.container-->
</section>
<!--/about-us-->