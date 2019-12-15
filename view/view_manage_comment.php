<?php

$token = bin2hex(openssl_random_pseudo_bytes(6));
    
$_SESSION['token'] = $token;

?>

<?php $title = 'Mon blog'; ?>
<?php ob_start(); ?>


<?php if (array_key_exists('success_connect', $_SESSION)): ?>
<section class="section_connection">
    <div class="connect-sign hidden-sm">
        <?= $_SESSION['success_connect']; ?>
    </div>
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







<h2 style="text-align:center">Gestion des commentaires</h2>
<div class="container pagecomments">
    <?php if (array_key_exists('comment_approved', $_SESSION)): ?>
    <div class="alert alert-success">
        Le commentaire a été validé
    </div>
    <?php endif; ?>    

    <?php if (array_key_exists('comment_delete', $_SESSION)): ?>
    <div class="alert alert-success">
        Le commentaire a été supprimé
    </div>
    <?php endif; ?>    

    <?php
    foreach ($showComment->getListComment() as $comment) {
    
        ?>
        <div class="comments_list">
                    
            <h2><?= $comment->getTitreArticle()?></h2>

            <p><?= $comment->getContenuCommentaire()?></p>
       
            <p>Auteur du commentaire : <?= $comment->getPseudoAuteur()?></p>
                    
            <form action="index.php?action=approve&amp;id=<?= $comment->getIdCommentaire()?>" method="post">
                <input type="submit" class="btn btn-primary" value="Approuver">
                <input type="hidden" name="token" id="token" value="<?= $token ?>"/>
            </form>
            <form action="index.php?action=delete_comment&amp;id=<?= $comment->getIdCommentaire()?>" method="post">
                <input type="submit" class="btn btn-primary" value="Supprimer" style="margin-top:2px">
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
unset($_SESSION['success']);  
unset($_SESSION['errors']); 
unset($_SESSION['comment_approved']);
unset($_SESSION['comment_delete']); 
?>
        
