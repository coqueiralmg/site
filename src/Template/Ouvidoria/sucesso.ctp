<section id="error" class="container text-center">
    <h1>Mensagem enviada com sucesso</h1>
    <p>Obrigado por enviar a sua manifestação para nós. Responderemos em breve.</p>
    <p> Anote o número da manifestação abaixo para acompanhamento. Você também pode imprimir o número da manifestação com seus detalhes.</p>
    <div id="ticket">
        <span>
            <?=$this->Format->zeroPad($manifestacao)?>
        <span>
    </div>

    <?php if(count($manifestacoes) > 1): ?>
        <div id="malert">
            <span>
                Notamos aqui que você tem enviado suas manifestações anteriormente e os mesmos ainda encontram-se em aberto. Deseja verificar o andamento de outras manifestações?
            </span>
            <div class="buttons">
                <a class="btn btn-primary" href="/ouvidoria/acesso">Sim</a>
                <a class="btn btn-primary" onclick="$('#malert').hide()" >Não</a>
            </div>
        </div>
    <?php endif;?>
    <a class="btn btn-primary" href="/">Página Inicial</a>
    <a class="btn btn-primary" href="/faleconosco">Nova Manifestacao</a>
    <a class="btn btn-primary" href="/ouvidoria/acesso">Verificar Andamentos</a>
    <a class="btn btn-primary" href="<?='/ouvidoria/imprimir/' . $manifestacao?>" target="_blank">Imprimir</a>
</section><!--/#error-->
