<!-- Header -->
<header id="header">
    <h1>Este site está em manutenção</h1>
    <p>Esta site encontra-se em manutenção para o melhor atendimento. Por favor, retorne mais tarde.<br />
    Em caso de urgência, clique nos ícones abaixo ou  ligue para (35) 3855-1162.</p>
</header>

<!-- Footer -->
<footer id="footer">
    <ul class="icons">
        <li><a href="https://www.facebook.com/prefeituradecoqueiral" target="_blank" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
        <li><a href="mailto: site@coqueiral.mg.gov.br" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
    </ul>
    <ul class="copyright">
        <li>&copy; <?=$this->Data->release()?> <?=$this->Data->setting('Author.company')?>.</li>
    </ul>
</footer>

<!-- Scripts -->
<?= $this->Html->script('maintenance.js') ?>
