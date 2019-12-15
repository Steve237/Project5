<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>


<?php if (array_key_exists('success_connect', $_SESSION)): ?>

<section class="section_connection">
    <div class="connect-sign hidden-sm"><?= $_SESSION['success_connect']; ?></div>
    <form action="index.php?action=disconnected" method="post">
        <button type="submit" class="btn btn-success btn-default button-disconnect hidden-sm" name="disconnect">Déconnexion</button>
    </form> 
</section>    
<?php endif; ?>

<?php if (array_key_exists('success_connect1', $_SESSION)): ?>

<section class="section_connection">
    <div class="connect-sign hidden-sm"><?= $_SESSION['success_connect1']; ?></div>
    <form action="index.php?action=disconnected" method="post">
        <button type="submit" class="btn btn-success btn-default button-disconnect hidden-sm" name="disconnect">Déconnexion</button>
    </form>
</section>    
<?php endif; ?>


<div class="container">
    <section class="errorpage">
        <h1 class="error">Error 404 </h1>
    </section>
</div>
    
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>