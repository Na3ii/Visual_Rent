<main class="servicios">
    <h1 class="servicios__heading"><?= $titulo; ?></h1>
    <p class="servicios__descripcion">Visual Rent ofrece soluciones creativas y tecnológicas para todo tipo de eventos.</p>

    <div class="categorias__grid">
        <?php foreach($categorias as $categoria): ?>
            <div class="categoria__card">
                <h3 class="categoria__nombre"><?= $categoria->nombre; ?></h3>
                <picture class="categoria__imagen">
                        <source srcset="/img/categoria-servicios/<?= $categoria->imagen; ?>.webp" type="image/webp">
                        <source srcset="/img/categoria-servicios/<?= $categoria->imagen; ?>.png" type="image/png">
                        <img class="categoria__imagen" loading="lazy" width="200" height="300" 
                        src="/img/categoria-servicios/<?= $categoria->imagen; ?>.png" alt="imagen servicio">
                </picture>
                <p class="categoria__descripcion"><?= $categoria->descripcion; ?></p>
                <a class="categoria__enlace" href="/servicios/categoria?id=<?= $categoria->id; ?>#<?= $categoria->nombre; ?>">Ver Servicios</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>