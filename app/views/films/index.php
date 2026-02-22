<section class="home-hero">
    <div class="home-hero-text">
        <h1>Pathé HP</h1>
        <p class="home-hero-subtitle">
            Réservez vos séances de films de singes en quelques clics.
        </p>
        <?php if (!empty($films)): ?>
            <p class="home-hero-meta">
                <?php echo count($films); ?> film(s) actuellement à l'affiche.
            </p>
        <?php endif; ?>
    </div>
</section>

<<<<<<< HEAD
<?php if (empty($films)): ?>
    <p>Aucun film pour le moment.</p>
<?php else: ?>
    <div class="films-grid">
        <?php foreach ($films as $film):
            $title = $film['title'] ?? '';
            if (!empty($film['poster_url'])) {
                $posterSrc = $film['poster_url'];
            } elseif (stripos($title, 'King Kong') !== false) {
                $posterSrc = BASE_URL . 'assets/images/king-kong.png';
            } elseif (stripos($title, 'Planète des Singes') !== false || stripos($title, 'Planete des Singes') !== false) {
                $posterSrc = BASE_URL . 'assets/images/planete-des-singes.png';
            } elseif (stripos($title, 'Madagascar') !== false && (stripos($title, 'Babouins') !== false || stripos($title, 'Opération') !== false)) {
                $posterSrc = BASE_URL . 'assets/images/madagascar-operation-babouins.png';
            } else {
                $posterSrc = 'https://www.themoviedb.org/t/p/w600_and_h900_face/pFStqHTVUceciD9vineiNJ9WHpA.jpg';
            }
            ?>
            <div class="film-card">
                <div class="film-poster-wrapper">
                    <img src="<?php echo \Security::e($posterSrc); ?>"
                         alt="Affiche de <?php echo \Security::e($title); ?>">
                </div>
                <div class="film-card-body">
                    <p class="film-card-title"><?php echo \Security::e($title); ?></p>
                    <p class="film-card-meta"><?php echo (int)($film['duration'] ?? 0); ?> min</p>
                    <div class="film-card-actions">
                        <a href="<?php echo BASE_URL; ?>?controller=film&action=show&id=<?php echo (int)$film['id']; ?>">
                            Voir les séances
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
=======
<section class="home-section">
    <h2 class="home-section-title">Films à l'affiche</h2>

    <?php if (empty($films)): ?>
        <p>Aucun film pour le moment.</p>
    <?php else: ?>
        <div class="film-grid">
            <?php foreach ($films as $film): ?>
                <div class="film-card">
                    <div class="film-card-title">
                        <?php echo \Security::e($film['title']); ?>
                    </div>
                    <div class="film-card-meta">
                        <?php echo (int)$film['duration']; ?> min
                    </div>
                    <a href="<?php echo BASE_URL; ?>?controller=film&action=show&id=<?php echo (int)$film['id']; ?>">
                        Voir les séances
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
>>>>>>> f0fa845c3cadc6ac053fc0ad0039d703a3b43f67

