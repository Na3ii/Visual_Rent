<main class="contenedor seccion contenido-centrado">
        <h1><?php echo $producto -> nombre; ?></h1>
        <picture>
            <source srcset="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto->imagen; ?>.webp" type="image/webp">
            <source srcset="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto->imagen; ?>.png" type="image/png">
            <img src="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto->imagen; ?>.png" alt="imagen producto">
        </picture>
        <div class="resumen-producto">
            <p class="precio"><?php echo $producto -> precio; ?></p>
            <p><?php echo $producto -> descripcion; ?>.</p>
        </div>
        <div class="alinear-derecha">
            <a href="productos" class="boton-verde">Volver</a>
        </div>
</main>