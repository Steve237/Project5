<?php $this->title = 'Liste des articles'; ?>

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
            foreach($article as $article) 
            {
            ?>
                <div class="col-sm-6 col-md-4 col-lg-4 portfolio-item">
                    <a href="../public/index.php?action=article&amp;id=<?= $article->getIdPost() ?>&amp;titre=<?= $article->getTitreArticle()?>" class="portfolio-link">
                        <div class="caption">
                            <div class="caption-content">
                                <h6 class="hidden-sm hidden-md hidden-lg">
                                    <?= htmlspecialchars($article->getTitreArticle())?>
                                </h6>

                                <h3 class="hidden-xs hidden-md hidden-lg">
                                    <?= htmlspecialchars($article->getTitreArticle())?>
                                </h3>

                                <h4 class="hidden-xs hidden-sm">
                                    <?= htmlspecialchars($article->getTitreArticle())?>
                                </h4>

                                <p class="description_text">
                                    <?= htmlspecialchars($article->getDescriptifArticle())?>
                                </p>

                                <p class="titre">
                                    <?='Modifié le : ' . htmlspecialchars($article->getDateModification())?>
                                </p>
                            </div>
                        </div>
                        <img src="<?= htmlspecialchars($article->getImageArticle())?>" class="img-responsive" alt="image_article">
                    </a>
                </div>
                <?php
            }
            
            ?> 
        </div>
    </div>
</section>

       


