<main class="productos">
        <h1 class="productos__heading">Catálogo De Productos En Arriendo</h1>
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