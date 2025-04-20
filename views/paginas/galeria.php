<h1 class="galeria__heading"><?= $titulo; ?></h1>

<section class="galeria contenedor">
    <div class="galeria__grid" id="masonry-grid">
        <?php foreach ($imagenes as $imagen): ?>
            <figure class="galeria__item">
                <picture>
                    <source srcset="/img/galeria/<?= $imagen->imagen; ?>.webp" type="image/webp">
                    <source srcset="/img/galeria/<?= $imagen->imagen; ?>.png" type="image/png">
                    <img src="/img/galeria/<?= $imagen->imagen; ?>.png"
                        alt="<?= htmlspecialchars($imagen->descripcion); ?>"
                        title="<?= htmlspecialchars($imagen->descripcion); ?>"
                        class="galeria__imagen"
                        loading="lazy">
                </picture>
            </figure>
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
<?php
$imagenes_jsonld = [];

foreach ($imagenes as $imagen) {
    $imagenes_jsonld[] = [
        "@type" => "ImageObject",
        "contentUrl" => "https://visualrent.cl/img/galeria/{$imagen->imagen}.webp",
        "description" => $imagen->descripcion,
        "name" => $imagen->titulo ?? $imagen->descripcion,
        "author" => [
            "@type" => "Organization",
            "name" => "Visual Rent"
        ],
        "representativeOfPage" => true
    ];
}

$script_jsonld = [
    "@context" => "https://schema.org",
    "@graph" => $imagenes_jsonld
];

echo '<script type="application/ld+json">' . json_encode($script_jsonld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>';
?>