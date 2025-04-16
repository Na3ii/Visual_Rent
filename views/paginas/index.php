<section class="productos">
    <div class="productos__contenedor">
        <h2 class="productos__heading">Nuestros Productos</h2>
        <div class="productos__grid">
            <?php foreach($productos as $producto) { ?>
                <div class="producto">
                    <picture class="producto__imagen">
                        <source srcset="/img/productos/<?php echo $producto->imagen; ?>.webp" type="image/webp">
                        <source srcset="/img/productos/<?php echo $producto->imagen; ?>.png" type="image/png">
                        <img class="producto__imagen" src="/img/productos/<?php echo $producto->imagen; ?>.png" alt="Imagen Producto">
                    </picture>
                    <div class="producto__contenido">
                        <h3 class="producto__nombre"><?php echo $producto->nombre; ?></h3>
                        <p class="producto__descripcion"><?php echo $producto->descripcion; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
        <div class="inicio__boton-contenedor">
            <a class="inicio__boton" href="/catalogo">Ver Catálogo Completo</a>
        </div>
</section>

<section class="sesrvicios">
    <div class="servicios__contenedor">
        <h2 class="servicios__heading">Servicios</h2>
        <div class="categorias__grid">
            <?php foreach($categorias as $categoria): ?>
                <div class="categoria__card">
                    <h3 class="categoria__nombre"><?php echo $categoria->nombre; ?></h3>
                    <picture class="categoria__imagen">
                            <source srcset="/img/categoria-servicios/<?php echo $categoria->imagen; ?>.webp" type="image/webp">
                            <source srcset="/img/categoria-servicios/<?php echo $categoria->imagen; ?>.png" type="image/png">
                            <img class="categoria__imagen" loading="lazy" width="200" height="300" 
                            src="/img/categoria-servicios/<?php echo $categoria->imagen; ?>.png" alt="imagen servicio">
                    </picture>
                    <p class="categoria__descripcion"><?php echo $categoria->descripcion; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="inicio__boton-contenedor">
        <a class="inicio__boton" href="/servicios">Ver Todos los Servicios</a>
    </div>
</section>

<section class="contacto">
    <div class="contacto__contenedor">
        <h2 class="contacto__heading">Contáctanos</h2>      
        <p class="contacto__descripcion">Déjanos tu mensaje y nos pondremos en contacto contigo lo antes posible.</p>
        <div class="inicio__boton-contenedor">
            <a class="inicio__boton" href="/contacto">Contactar</a>
        </div>
    </div>
</section>

<section class="galeria">
    <div class="galeria__contenedor">
        <h2 class="galeria__heading">Galeria</h2>
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
    </div>
    <div class="inicio__boton-contenedor">
        <a class="inicio__boton" href="/galeria">Ver Galeria</a>
    </div>
</section>