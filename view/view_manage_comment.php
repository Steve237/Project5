<?php $title = 'Mon blog'; ?>
<?php ob_start(); ?>

<h2 style="text-align:center">Gestion des commentaires</h2>
<div class="container">
    
    <?php if(array_key_exists('comment_approved', $_SESSION)): ?>
    <div class="alert alert-success">
        Le commentaire a été validé
    </div>
    <?php endif; ?>    
    
    <?php if(array_key_exists('comment_delete', $_SESSION)): ?>
    <div class="alert alert-success">
        Le commentaire a été supprimé
    </div>
    <?php endif; ?>    
    
    <div>
        <?php

            foreach ($showcomment->getListComment() as $comment)
            {

                ?>
        
                    <div style="border: 2px solid black;margin-bottom:15px;background-color:cyan;padding:10px;">
                    
                    <h2 style="text-align:center"><?= $comment->titre_article() ?></h2>

                    <p><?= $comment->contenu_commentaire() ?></p>
                    
                    <a href="index.php?action=approve&amp;id=<?= $comment->id_commentaire()?>"><button type="button" 
                    class="btn btn-primary">Approuver</button></a>
                    <a href="index.php?action=delete_comment&amp;id=<?= $comment->id_commentaire()?>"><button type="button" 
                    class="btn btn-primary">Supprimer</button></a>
                
                    </div>
    
                <?php

            }

        ?>

    </div>
    
    
</div>
<!-- jQuery -->
<script src="public/vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="public/vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Plugin JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<!-- Contact Form JavaScript -->
<script src="public/js/jqBootstrapValidation.js"></script>
<script src="public/js/contact_me.js"></script>
<!-- Theme JavaScript -->
<script src="public/js/freelancer.min.js"></script>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
