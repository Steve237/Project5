<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>


<!-- Portfolio Modals -->
<div class="portfolio-modal" tabindex="-1">
    <div class="modal-content">
        
        <div class="close-modal">
            <a href="index.php?action=listposts">
                <h4>Fermer</h4>
            </a>
        </div>
       
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">

                        <h2><?= htmlspecialchars($news->getTitreArticle())?></h2>
                        <hr class="star-primary">
                        <p style='text-align:left'><?= htmlspecialchars($news->getDescriptifArticle())?></p>
                        <img src="<?= htmlspecialchars($news->getImageArticle())?>" class="img-responsive img-centered" alt="image_article">
                        <p style='text-align:left'><?= nl2br(htmlspecialchars($news->getContenu()))?></p>
                        <ul class="list-inline item-details">
                            <li>Auteur:
                                <strong><?= htmlspecialchars($news->getPseudoAuteur())?></strong>
                            </li>
                            <li>Date de mise à jour:
                                <strong><?= htmlspecialchars($news->getDateModification())?></strong>
                            </li>
                        </ul>

                        <?php if (array_key_exists('errors', $_SESSION)): ?>
                        <div class="alert alert-danger">
                            <?= implode('<br>', $_SESSION['errors']); ?>
                        </div>
                        <?php endif;?>

                        <?php if (array_key_exists('success', $_SESSION)): ?>
                        <div class="alert alert-danger">
                            Votre commentaire a été soumis pour validation.
                        </div>
                        <?php endif;?>

                        <h3>Laissez un commentaire </h3>
                        <form action="index.php?action=post&amp;id=<?= $news->getIdPost()?>" id="comment" method="post">
                            <div class="row control-group">
                                <div class="form-group col-xs-12 floating-label-form-group controls">
                                    <label for="pseudo_user">Votre pseudo</label>
                                    <input required placeholder="Entrez votre pseudo" type="text" name="pseudo" class="form-control">
                                </div>
                            </div>

                            <div class="row control-group">
                                <div class="form-group col-xs-12 floating-label-form-group controls">
                                    <label for="commentaire">Entrez votre commentaire</label>
                                    <textarea name="user_comment" class="form-control">Entrez votre commentaire</textarea>
                                </div>
                            </div>

                            <br>
                            <div id="success"></div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <button type="submit" class="btn btn-success btn-lg" name="submit_comment">Envoyer</button>
                                </div>
                            </div>

                        </form>

                        <h3>Liste des commentaires</h3>

                        <?php
                        foreach($listComments as $comments) {
                            ?>  
                            <div class="list_comments" >

                                <p>Auteur du commentaire : <?= htmlspecialchars($comments->getPseudoAuteur())?></p>
                                <p><?= htmlspecialchars($comments->getContenuCommentaire())?></p>
                                <p>Date du commentaire : <?= htmlspecialchars($comments->getDateCreation())?></p>

                            </div>

                            <?php
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean();?>
<?php require('template.php');?>
<?php
unset($_SESSION['success']);  
unset($_SESSION['errors']);
?>