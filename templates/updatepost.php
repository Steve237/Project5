<?php

if(!array_key_exists('success_connect1', $_SESSION)) {

    header('Location:../public/index.php');

}

?>

<?php $this->title = 'Modifier un article'; ?>

<!-- Contact Section -->
<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center update_title">
                <h2>Modifier un article </h2>
                <hr class="star-primary">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">

                <?php if (array_key_exists('errors', $_SESSION)): ?>
                <div class="alert alert-danger">
                    <?= implode('<br>', $_SESSION['errors']); ?>
                </div>
                <?php endif; ?>

                <?php if (array_key_exists('success', $_SESSION)): ?>
                <div class="alert alert-success">
                    Votre article a été modifié
                </div>
                <?php endif;?>
                
                <form action="../public/index.php?action=updatepost&amp;id=<?= $singlepost->getIdPost()?>" id="add_post" method="post" enctype="multipart/form-data" class="col-xs-12">
                    <div class="row control-group">
                        Modifiez le nom de l'auteur
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="author">Auteur de l'article</label>
                            <input type="text" name="post_author" id="author" class="form-control" value="<?= $singlepost->getPseudoAuteur()?>">
                            
                        </div>
                    </div>

                    <div class="row control-group">
                        Modifiez le titre de l'article
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="title">Titre de l'article</label>
                            <input type="text" name="post_title" id="title" class="form-control" value="<?= $singlepost->getTitreArticle()?>">
                        </div>
                    </div>

                    <div class="row control-group">
                        Modifiez le résumé l'article
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="resume">Résumé de l'article</label>
                            <textarea id="resume" name="resume_post" class="form-control"><?= $singlepost->getDescriptifArticle()?></textarea>
                        </div>
                    </div>

                    <div class="row control-group">
                        Modifiez le contenu l'article
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="content_post">Contenu de l'article</label>
                            <textarea name="content" id="content_post" class="form-control"><?= $singlepost->getContenu()?></textarea>
                        </div>
                    </div>

                    <div class="row control-group">
                        Modifiez l'image
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="image">Ajouter une image</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                            <input type="file" name="image_post" id="image" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-success btn-lg" name="add_new">Ajouter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<?php
unset($_SESSION['success']);
unset($_SESSION['errors']);
?>
