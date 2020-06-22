<?php

if(!array_key_exists('success_connect1', $_SESSION)) {

    header('Location:../public/index.php');

}

$token = bin2hex(openssl_random_pseudo_bytes(6));
$_SESSION['token'] = $token;

?>

<?php $this->title = 'Gestion des commentaires'; ?>

<h2 class="title_comment">Gestion des commentaires</h2>
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


    <a href="../public/index.php?action=adminspace"><button type="button" class="btn btn-primary">Gestions des articles</button></a>
    <a href="../public/index.php?action=managecomment"><button type="button" class="btn btn-primary">Espace commentaire</button></a>
    <?php
    
    
    foreach ($comment as $resultat) {
        
    
        ?>
        <div class="comments_list">
                    
            <h2><?= $resultat->newtitle ?></h2>

            <p><?= $resultat->commentcontent ?></p>
       
            <p>Auteur du commentaire : <?= $resultat->pseudocomment ?></p>
                    
            <form action="../public/index.php?action=approve&amp;id=<?= $resultat->idcom ?>" method="post">
                <input type="submit" class="btn btn-primary" value="Approuver">
                <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
            </form>
            
            <form action="../public/index.php?action=deletecomment&amp;id=<?= $resultat->idcom ?>" method="post">
                <input type="submit" class="btn btn-primary" value="Supprimer" style="margin-top:2px">
                <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
            </form>
        </div>
        <?php
    }
    ?>
</div>


<?php
unset($_SESSION['comment_approved']);
unset($_SESSION['comment_delete']); 
?>
        
