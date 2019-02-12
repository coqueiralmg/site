<section id="about-us">
    <div class="container">

        <div class="center wow fadeInDown">
            <h2><?= $pergunta->questao ?></h2>
            <p class="lead">Categoria: <?=$pergunta->categoria->nome ?> </p>
        </div>

        <div class="wow fadeInDown">
            <div class="col-md-12">
                <?= $pergunta->resposta ?>
            </div>
        </div>
        <br/><br/><br/>
        <h5>Dúvidas Relacionadas</h5>
        <hr/>
        <?php if(count($pergunta->relacionadas) > 0):?>
            <table class="table table-striped">
                <thead class="text-primary">
                    <tr>
                        <th>Questão</th>
                        <th>Categoria</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pergunta->relacionadas as $relacionada): ?>
                        <tr>
                            <td><?=$relacionada->questao?></td>
                            <td><?=$relacionada->categoria->nome?></td>
                            <td class="td-actions text-right">
                                <a href="<?= $this->Url->build(['controller' => 'duvidas', 'action' => 'duvida',  $relacionada->slug . '-' . $relacionada->id]) ?>" title="Ver Detalhes" class="btn btn-success btn-round">
                                    <i class="fa fa-file-text"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Não existe nenhuma dúvida relacionada a esta.</p>
        <?php endif; ?>
        <br/><br/><br/>
        <div id="malert" class="text-center">
            <span>
                Ainda não conseguiu entender? Entre em contato conosco, clicando no botão abaixo.
            </span>
            <div class="buttons">
                <?=$this->Html->Link('Entre em Contato', $gatilho, ['class' => 'btn btn-primary'])?>
            </div>
        </div>
    </div>
    <!--/.container-->
</section>
