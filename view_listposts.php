<?php $title = 'Mon blog'; ?>
<?php
require 'Database.php';
require 'Article.php';
?>

<?php ob_start(); ?>
<section id="portfolio" class="list_post">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="titre_portfolio">Nos icônes</h2>
                <hr class="star-primary">
            </div>
        </div>


        <div class="row">
            <?php
            $article = new Article();
            $articles = $article->getArticles();
            while($data = $articles->fetch()) 
            {
            ?>
                <div class="col-sm-6 col-md-4 col-lg-4 portfolio-item">
                    <a href="index.php?action=post&amp;id=<?= $data['idPost']?>&amp;titre=<?= $data['titreArticle']?>" class="portfolio-link">
                        <div class="caption">
                            <div class="caption-content">
                                <h6 class="hidden-sm hidden-md hidden-lg">
                                    <?= htmlspecialchars($data['titreArticle'])?>
                                </h6>

                                <h3 class="hidden-xs hidden-md hidden-lg">
                                    <?= htmlspecialchars($data['titreArticle'])?>
                                </h3>

                                <h4 class="hidden-xs hidden-sm">
                                    <?= htmlspecialchars($data['titreArticle'])?>
                                </h4>

                                <p class="description_text">
                                    <?= htmlspecialchars($data['descriptifArticle'])?>
                                </p>

                                <p class="titre">
                                    <?='Modifié le : ' . htmlspecialchars($data['dateModification'])?>
                                </p>
                            </div>
                        </div>
                        <img src="<?= htmlspecialchars($data['imageArticle'])?>" class="img-responsive" alt="image_article">
                    </a>
                </div>
                <?php
            }
            $articles->closeCursor();
            ?> 
        </div>
    </div>
</section>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>         


