<main class="categoria">
    <h2 class="categoria__heading"><?php echo $titulo; ?></h2>

    <div class="servicios__grid">
        <?php foreach($servicios as $servicio): ?>
            <div class="servicio__card">
                <h3 class="servicio__nombre"><?php echo $servicio->nombre; ?></h3>
                <picture class="servicio__imagen">
                    <source srcset="/img/servicios/<?php echo $servicio->imagen; ?>.webp" type="image/webp">
                    <source srcset="/img/servicios/<?php echo $servicio->imagen; ?>.png" type="image/png">
                    <img class="servicio__imagen" loading="lazy" width="200" height="300" 
                    src="/img/servicios/<?php echo $servicio->imagen; ?>.png" alt="imagen servicio">
                </picture>
                <p class="servicio__descripcion"><?php echo $servicio->descripcion; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="contenedor__boton">
        <a class="servicio__boton" href="/servicios">Volver</a> 
    </div>             
</main>