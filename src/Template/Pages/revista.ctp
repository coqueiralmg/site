<section id="about-us">
    <div class="container">
        <div class="center wow fadeInDown" style="padding-bottom: 0">
            <h2>Revista Digital</h2>
            <p class="lead">Saiba de todos os acontecimentos do Município de Coqueiral</p>
        </div>
        <div class="row clearfix wow fadeInDown">
            <p>Esta versão digital é a cópia digital da versão impressa, disponível para distribuição gratuita a todo cidadão. Para obter a versão impressa, compareça a recepção da prefeitura na Rua Minas Gerais, 62 - Vila Sônia - Coqueiral - MG ou ligue para (35) 3855-1162.</p>
        </div>
        <div class="row clearfix wow fadeInDown">
            <div class="col-lg-9 col-md-8 col-sm-6">
                <h3>Edições</h3>
                <table class="table table-striped">
                    <thead class="text-primary">
                        <tr>
                            <th>Edição</th>
                            <th>Ano</th>
                            <th>Data</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01</td>
                            <td>01</td>
                            <td>DEZEMBRO DE 2018</td>
                            <td class="td-actions text-right">
                                <a href="public/storage/revista/0101DEZ2018.pdf" title="Download" target="_blank" class="btn btn-success btn-round">
                                    <i class="fa fa-download"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <aside class="col-lg-3 col-md-4 col-sm-6">
                <div class="widget categories">
                    <h3>Notícias Recentes</h3>
                    <div class="col-sm-12">
                        <?php foreach($noticias as $noticia): ?>
                            <div class="single_comments">
                                <p><?=$this->Html->link('[' . $this->Format->date($noticia->post->dataPostagem, true) . '] ' . $noticia->post->titulo, ['controller' => 'noticias', 'action' =>  'noticia', $noticia->post->slug . '-' . $noticia->id])?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
