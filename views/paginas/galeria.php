<h2 class="galeria__heading"><?= $titulo; ?></h2>

<section class="galeria contenedor">
    <div class="galeria__grid" id="masonry-grid">
        <?php foreach ($imagenes as $imagen): ?>
            <div class="galeria__item">
                <picture>
                    <source srcset="/img/galeria/<?= $imagen->imagen; ?>.webp" type="image/webp">
                    <source srcset="/img/galeria/<?= $imagen->imagen; ?>.png" type="image/png">
                    <img src="/img/galeria/<?= $imagen->imagen; ?>.png" alt="<?= htmlspecialchars($imagen->descripcion); ?>" class="galeria__imagen">
                </picture>
            </div>
        <?php endforeach; ?>
    </div>
</section>

    <div class="paginacion">
        <?= $paginacion; ?>
    </div>
</section>

<!-- Modal -->
<div class="modal" id="modal">
    <div class="modal__contenido">
        <button class="modal__cerrar" id="cerrar-modal">&times;</button>
        <img id="modal-imagen" src="" alt="Imagen ampliada">
    </div>
</div>