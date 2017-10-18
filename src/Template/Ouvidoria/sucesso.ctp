<section id="error" class="container text-center">
    <h1>Mensagem enviada com sucesso</h1>
    <p>Obrigado por enviar a sua manifestação para nós. Responderemos em breve.</p>
    <p> Anote o número da manifestação abaixo para acompanhamento. Você também pode imprimir o número da manifestação com seus detalhes.</p>
    <div id="ticket">
        <span>
            <?=$this->Format->zeroPad($manifestacao)?>
        <span>
    </div>
    <a class="btn btn-primary" href="/">PÁGINA INICIAL</a>
    <a class="btn btn-primary" href="/ouvidoria">NOVA MANIFESTAÇÃO</a>
    <a class="btn btn-primary" href="<?='/ouvidoria/imprimir/' . $manifestacao?>" target="_blank">IMPRIMIR</a>
</section><!--/#error-->