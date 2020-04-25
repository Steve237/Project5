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
                        <p class="descriptif"><?= htmlspecialchars($singlepost->getDescriptifArticle())?></p>
                        <img src="<?= htmlspecialchars($singlepost->getImageArticle())?>" class="img-responsive img-centered" alt="image_article">
                        <p class="contenu"><?= nl2br(htmlspecialchars($singlepost->getContenu()))?></p>
                        <ul class="list-inline item-details">
                            <li>Auteur:
                                <strong><?= htmlspecialchars($singlepost->getPseudoAuteur())?></strong>
                            </li>
                            <li>Date de mise à jour:
                                <strong><?= htmlspecialchars($singlepost->getDateModification())?></strong>
                            </li>
                        </ul>

                        <?php if (array_key_exists('errors', $_SESSION)): ?>
                        <div class="alert alert-danger">
                            <?= implode('<br>', $_SESSION['errors']); ?>
                        </div>
                        <?php endif; ?>

                        <?php if (array_key_exists('send_comment', $_SESSION)): ?>
                        <div class="alert alert-success">
                            Votre commentaire a été envoyé pour approbation.
                        </div>
                        <?php endif; ?>
                        
                        <h3>Laissez un commentaire </h3>

                        <?php
                        if(array_key_exists('allowcomments', $_SESSION)) {
                            ?>
                        
                            <form action="../public/index.php?action=article&amp;id=<?= $singlepost->getIdPost()?>" id="comment" method="post">
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
                            
                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <button type="submit" class="btn btn-success btn-lg" name="submit_comment">Envoyer</button>
                                    </div>
                                </div>

                            </form>

                            <h3>Liste des commentaires</h3>
                        
                            <?php
                            foreach($comment as $comment)
                            {
                                ?>
                                <div class="list_comments" >

                                    <p>Auteur du commentaire : <?= htmlspecialchars($comment->getPseudoAuteur()); ?></p>
                                    <p><?= htmlspecialchars($comment->getContenuCommentaire());?></p>
                                    <p>Date du commentaire : <?= htmlspecialchars($comment->getDateCreation());?></p>

                                </div>

                                <?php
                            }
                        
                        }
                        else {
                            
                            ?>
                            <p>Veuillez vous <a href = "../public/index.php?action=connexion">connecter pour poster un commentaire<p></a>

                            <?php
                        }
                        ?>
                        

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
unset($_SESSION['errors']);
unset($_SESSION['send_comment']);
?>
