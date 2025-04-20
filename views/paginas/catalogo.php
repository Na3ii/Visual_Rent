<main class="productos">
        <h2 class="productos__heading">Catálogo De Productos En Arriendo</h2>
        <p class="productos__descripcion">Descubre nuestro catálogo de productos en arriendo. Encuentra artículos para todas tus necesidades con precios competitivos y opciones de alquiler flexibles.</p>
        <div class="productos__grid">
                <?php foreach($productos as $producto) { ?>
                <div class="producto">
                        <picture class="producto__imagen">
                                <source srcset="/img/productos/<?php echo $producto->imagen; ?>.webp" type="image/webp">
                                <source srcset="/img/productos/<?php echo $producto->imagen; ?>.png" type="image/png">
                                <img class="producto__imagen" loading="lazy" width="200" height="300" 
                                src="/img/productos/<?php echo $producto->imagen; ?>.png" alt="imagen producto">
                        </picture>
                        <div class="producto__informacion">
                                <h4 class="producto__nombre"><?php echo $producto -> nombre; ?></h4>
                                <p class="producto__descripcion"><?php echo $producto -> descripcion; ?>.</p>
                                <!--<p class="precio"><?php echo $producto -> precio; ?> UF</p> --->
                        </div>
                        <button class="producto__boton" data-id="<?php echo $producto->id; ?>">Ver Producto</button>
                </div>
                <?php } ?>
        </div>
        <?php echo $paginacion; ?>
</main>
<?php
// Función para generar un slug desde el nombre del producto
function generarSlug($cadena) {
    $cadena = strtolower(trim($cadena));
    $cadena = preg_replace('/[^a-z0-9áéíóúñü\s-]/', '', $cadena); // quitar símbolos raros
    $cadena = preg_replace('/[\s-]+/', '-', $cadena); // espacios o guiones múltiples → guión simple
    $cadena = preg_replace('/^-+|-+$/', '', $cadena); // quitar guiones al principio/final
    return $cadena;
}

// Inicializa un array para almacenar los productos en formato JSON-LD
$productos_jsonld = [];

foreach ($productos as $producto) {
    $slug = generarSlug($producto->nombre);
    $productos_jsonld[] = [
        "@type" => "Product",
        "name" => $producto->nombre,
        "image" => "https://visualrent.cl/img/productos/{$producto->imagen}.png",
        "description" => $producto->descripcion,
        "brand" => [
            "@type" => "Brand",
            "name" => "Visual Rent"
        ],
        "offers" => [
            "@type" => "Offer",
            "itemCondition" => "https://schema.org/NewCondition",
            "availability" => "https://schema.org/InStock",
            "url" => "https://visualrent.cl/catalogo#$slug"
        ]
    ];
}

// Genera el script JSON-LD
$script_jsonld = [
    "@context" => "https://schema.org",
    "@graph" => $productos_jsonld
];

// Imprime el script al final del HTML
echo '<script type="application/ld+json">' . json_encode($script_jsonld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>';
?>