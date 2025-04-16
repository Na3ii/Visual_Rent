<main class="productos">
        <h2 class="productos__heading">Catálogo De Productos</h2>
        <p class="productos__descripcion">Conoce nuestro catálogo de productos</p>
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
