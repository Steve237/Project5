<?php session_start();?>
<?php $this->title = 'Article'; ?>

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

                        <h2><?= htmlspecialchars($singlepost->getTitreArticle())?></h2>
                        <hr class="star-primary">
                        <p style='text-align:left'><?= htmlspecialchars($singlepost->getDescriptifArticle())?></p>
                        <img src="<?= htmlspecialchars($singlepost->getImageArticle())?>" class="img-responsive img-centered" alt="image_article">
                        <p style='text-align:left'><?= nl2br(htmlspecialchars($singlepost->getContenu()))?></p>
                        <ul class="list-inline item-details">
                            <li>Auteur:
                                <strong><?= htmlspecialchars($singlepost->getPseudoAuteur())?></strong>
                            </li>
                            <li>Date de mise à jour:
                                <strong><?= htmlspecialchars($singlepost->getDateModification())?></strong>
                            </li>
                        </ul>

                        
                        <h3>Laissez un commentaire </h3>

                        <?php
                        foreach($comment as $comment)
                        {
                            ?>
                            <form action="index.php?action=post&amp;id=<?= $comment->getIdPost()?>" id="comment" method="post">
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

                        
                            <div class="list_comments" >

                                <p>Auteur du commentaire : <?= htmlspecialchars($comment->getPseudoAuteur()); ?></p>
                                <p><?= htmlspecialchars($comment->getContenuCommentaire());?></p>
                                <p>Date du commentaire : <?= htmlspecialchars($comment->getDateCreation());?></p>

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

