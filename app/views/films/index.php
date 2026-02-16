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

