<div class="alert alert-info alert-with-icon" data-notify="container">
    <i class="material-icons" data-notify="icon">info</i>
    <button type="button" aria-hidden="true" class="close" onclick="$(this).parent().hide()">
        <i class="material-icons">close</i>
    </button>
    <span data-notify="message">
        <?= h($message) ?>
    </span>
</div>