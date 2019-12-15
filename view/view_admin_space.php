<?php

$token = bin2hex(openssl_random_pseudo_bytes(6));
    
$_SESSION['token'] = $token;

?>

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


<h2 class="admin_title">Espace administrateur</h2>
<h3 class="admin_title"> Liste des articles </h3>


<div class="container">
    
    <?php if (array_key_exists('errors', $_SESSION)): ?>
    <div class="alert alert-danger">
        <?= implode('<br>', $_SESSION['errors']); ?>
    </div>
    <?php endif; ?>
    
    <?php if (array_key_exists('insert_success', $_SESSION)): ?>
    <div class="alert alert-success">
        Ajout de l'article réussie!
    </div>
    <?php endif; ?>

    <?php if (array_key_exists('delete_post', $_SESSION)): ?>
    <div class="alert alert-success">
        Suppression de l'article réussie!
    </div>
    <?php endif; ?>

    <?php if (array_key_exists('success_update', $_SESSION)): ?>
    <div class="alert alert-success">
        Modification de l'article réussie!
    </div>
    <?php endif; ?>


    <a href="index.php?action=add_article"><button type="button" class="btn btn-primary">Ajouter un article</button></a>
    <a href="index.php?action=manage_comment"><button type="button" class="btn btn-primary">Espace commentaire</button></a>

    <?php

    foreach ($newsList->getListPosts() as $news) {

        ?>

        <div class="list_news">

            <h3>
                <?= $news->getTitreArticle() ?>
            </h3>

            <p>
                <?= $news->getDescriptifArticle() ?>
            </p>

            <a href="index.php?action=update_post&amp;id=<?= $news->getIdPost()?>"><button type="button" class="btn btn-primary">Modifier</button></a>
            <form action="index.php?action=delete_post&amp;id=<?= $news->getIdPost()?>" method="post">
                <input type="submit" value="Supprimer" class="btn btn-primary delete_post">
                <input type="hidden" name="token" id="token" value="<?= $token ?>"/>
            </form>
        </div>

        <?php

    }

    ?>

</div>


<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>

<?php
unset($_SESSION['insert_success']);
unset($_SESSION['delete_post']);
unset($_SESSION['success_update']);
?>
