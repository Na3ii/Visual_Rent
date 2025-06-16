<main class="productos">
        <h1 class="productos__heading"><?= $categoria->nombre; ?> En Arriendo</h1>
        <p class="productos__descripcion">Descubre nuestro catálogo de <?= $categoria->nombre; ?> en arriendo. Encuentra artículos para todas tus necesidades con precios competitivos y opciones de alquiler flexibles.</p>
        <div class="productos__grid">
                <?php foreach($productos as $producto) { ?>
                        <div class="producto">
                                <picture class="producto__imagen">
                                        <source srcset="/img/productos/<?= $producto->imagen_url; ?>.webp" type="image/webp">
                                        <source srcset="/img/productos/<?= $producto->imagen_url; ?>.png" type="image/png">
                                        <img class="producto__imagen" loading="lazy" width="200" height="300" 
                                        src="/img/productos/<?= $producto->imagen_url; ?>.png" alt="imagen producto">
                                </picture>
                                <div class="producto__informacion">
                                        <h4 class="producto__nombre"><?= $producto -> nombre; ?></h4>
                                        <p class="producto__descripcion"><?= $producto -> descripcion; ?>.</p>
                                        <!--<p class="precio"><?= $producto -> precio; ?> UF</p> --->
                                </div>
                                <a href="/producto?id=<?= $producto->id; ?>#<?= $producto->nombre; ?>" class="producto__boton">Ver Producto</a>
                        </div>
                <?php } ?>
        </div>
        <?= $paginacion; ?>
</main>