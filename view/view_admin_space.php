<?php $title = 'Mon blog'; ?>
<?php ob_start(); ?>



<h2 style="text-align:center">Espace administrateur</h2>
<h3 style="text-align: center"> Liste des articles </h3>



<div class="container">

<?php


foreach ($news_list->getListPosts() as $news)
{
    
?>

<h3> 
<?= $news->titre_article() ?>
</h3>

<p>
<?= $news->descriptif_article() ?>
</p>
    
<p>
    
<?= $news->contenu() ?> 

</p>


<button type="button" class="btn btn-primary">Ajouter</button>
<button type="button" class="btn btn-primary">Modifier</button>
<button type="button" class="btn btn-primary">Supprimer</button>




<?php

    
}

?>
</div>    
 
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>    