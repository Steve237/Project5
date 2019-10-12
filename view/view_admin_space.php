<?php $title = 'Mon blog'; ?>
<?php ob_start(); ?>



<h2 style="text-align:center">Espace administrateur</h2>
<h3 style="text-align: center"> Liste des articles </h3>


<div class="container">
    
    <?php if(array_key_exists('success', $_SESSION)): ?>
    <div class="alert alert-success">
        Ajout de l'article réussie!
    </div>
    <?php endif; ?>
    
     <?php if(array_key_exists('delete_post', $_SESSION)): ?>
    <div class="alert alert-success">
        Suppression de l'article réussie!
    </div>
    <?php endif; ?>
    
    <?php if(array_key_exists('success_update', $_SESSION)): ?>
    <div class="alert alert-success">
        Modification de l'article réussie!
    </div>
    <?php endif; ?>


    <a href="index.php?action=add_article"><button type="button" class="btn btn-primary">Ajouter un article</button></a> 
    <a href="index.php?action=manage_comment"><button type="button" class="btn btn-primary">Espace commentaire</button></a> 

    <?php

        foreach ($news_list->getListPosts() as $news)
        {

        ?>

            <div style="border: 2px solid black;margin-bottom:15px;background-color:cyan;padding:10px;">

                <h3> 
                    <?= $news->titre_article() ?>
                </h3>

                <p>
                    <?= $news->descriptif_article() ?>
                </p>
    
                <a href="index.php?action=update_post&amp;id=<?= $news->id_post()?>"><button type="button" class="btn btn-primary">Modifier</button></a>
                <a href="index.php?action=delete_post&amp;id=<?= $news->id_post()?>"><button type="button" class="btn btn-primary">Supprimer</button></a>

    
            </div>

    <?php

        }

        ?>

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

<?php
unset($_SESSION['message']);