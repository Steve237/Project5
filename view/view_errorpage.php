<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>

<div class="container">
    <section class="errorpage">
        <h1 class="error">Error 404 </h1>
    </section>
</div>
    
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>