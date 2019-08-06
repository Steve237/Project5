<?php $title = htmlspecialchars($post['titre_article']); ?>

<?php ob_start(); ?>

<!-- Portfolio Modals -->
    <div class="portfolio-modal" tabindex="-1">
        <div class="modal-content">
            <div class="close-modal">
                
                <a href="index.php?action=listposts">
                <div class="lr">
                    <div class="rl"></div>
                </div>
                </a>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                        <h2><?= htmlspecialchars($post['titre_article']) ?></h2>
                            <hr class="star-primary">
                            <p><?= htmlspecialchars($post['descriptif_article'])?></p>
                            <img src="<?= htmlspecialchars($post['image_article']) ?>" class="img-responsive img-centered" alt="">
                            <p><?= nl2br(htmlspecialchars($post['contenu']))?></p>
                            <ul class="list-inline item-details">
                                <li>Auteur:
                                    <strong><?= htmlspecialchars($post['pseudo_auteur'])?>
                                    </strong>
                                </li>
                                <li>Date de mise à jour:
                                    <strong><?= htmlspecialchars($post['date_modification'])?>
                                    </strong>
                                </li>
                                
                            </ul>
                            
                            <h3>Laissez un commentaire </h3>
                            <form action="index.php?action=addComment&amp;id=<?= $post['id_article'] ?>" method="post">
                            
                            <div>
                            <label for="author"> Pseudo </label></br>
                            <input type="text", name="author", id="author" class="form-control" placeholder="Entrez votre pseudo"/></br>
                            </div>
                            <div>
                            <label for="comment">Entrez votre commentaire </label></br>
                            <textarea name="comment", id="comment" class="form-control" placeholder="Entrez votre commentaire"> </textarea>
                            </div></div></br>
                            
                            <div>
                            <input type="submit">    
                            </div></br>
                                
                            </form>
                            <a href="index.php?action=listposts"><button type="button" class="btn btn-default"><i class="fa fa-times"></i> Fermer </button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
    
    

                    
                
                
                
    
    