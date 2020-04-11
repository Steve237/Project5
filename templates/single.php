<!-- Portfolio Modals -->
<div class="portfolio-modal" tabindex="-1">
    <div class="modal-content">
        
        <div class="close-modal">
            <a href="index.php?action=listposts">
                <h4>Fermer</h4>
            </a>
        </div>

        <?php

       
        $singlepost = new App\src\DAO\ArticleDAO();
        $singlepost = $singlepost->getArticle($_GET['id']);
        $data = $singlepost->fetch()
        ?>
       
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">

                        <h2><?= htmlspecialchars($data['titreArticle'])?></h2>
                        <hr class="star-primary">
                        <p style='text-align:left'><?= htmlspecialchars($data['descriptifArticle'])?></p>
                        <img src="<?= htmlspecialchars($data['imageArticle'])?>" class="img-responsive img-centered" alt="image_article">
                        <p style='text-align:left'><?= nl2br(htmlspecialchars($data['contenu']))?></p>
                        <ul class="list-inline item-details">
                            <li>Auteur:
                                <strong><?= htmlspecialchars($data['pseudoAuteur'])?></strong>
                            </li>
                            <li>Date de mise à jour:
                                <strong><?= htmlspecialchars($data['dateModification'])?></strong>
                            </li>
                        </ul>
        <?php
        $singlepost->closeCursor();
        ?>
                        
                        <h3>Laissez un commentaire </h3>

                        <?php
                        $comment = new App\src\DAO\CommentDAO();
                        $comment = $comment->getCommentsFromArticle($_GET['id']);
                        while($datas = $comment->fetch())
                        {
                            ?>
                            <form action="index.php?action=post&amp;id=<?= $datas['idPost']?>" id="comment" method="post">
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

                                <p>Auteur du commentaire : <?= htmlspecialchars($datas['pseudoAuteur'])?></p>
                                <p><?= htmlspecialchars($datas['contenuCommentaire'])?></p>
                                <p>Date du commentaire : <?= htmlspecialchars($datas['dateCreation'])?></p>

                            </div>

                            <?php
                        
                        }
                        
                        $comment->closeCursor();
                        
                        ?>
                        

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

