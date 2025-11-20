<main class="producto-main">
    <div class="breadcrumbs"></div>

    <div class="producto__grid">
        <div class="producto__informacion">
            <div class="producto__informacion-principal">
                <div 
                    id="galeria-producto-contenedor"
                    class="producto__informacion__imagenes-contenedor"
                    data-imagenes="<?= htmlspecialchars($json_imagenes, ENT_QUOTES, 'UTF-8'); ?>"
                >

                    <!-- Contenedor para la imagen principal y sus controles -->
                    <div class="galeria-principal">
                        <picture>
                            <source srcset="/img/productos/<?php echo ($main_image_url); ?>.webp" type="image/webp">
                            <source srcset="/img/productos/<?php echo ($main_image_url); ?>.png" type="image/png">
                            <img id="imagen-principal-producto" src="/img/productos/<?php echo ($main_image_url); ?>.png" alt="Imagen principal de <?php echo ($producto->nombre); ?>">
                        </picture>

                        <?php if (count($imagenes) > 1) : ?>
                            <button id="galeria-anterior" class="galeria-btn galeria-btn--anterior" aria-label="Imagen anterior">&#10094;</button>
                            <button id="galeria-siguiente" class="galeria-btn galeria-btn--siguiente" aria-label="Siguiente imagen">&#10095;</button>
                        <?php endif; ?>
                    </div>

                    <!-- Contenedor para las miniaturas -->
                    <?php if (count($imagenes) > 1) : ?>
                    <div id="galeria-miniaturas" class="galeria-miniaturas">
                        <?php foreach ($imagenes as $index => $imagen) : ?>
                            <div class="galeria-miniatura__contenedor">
                                <img 
                                    class="galeria-miniatura__imagen <?php echo ($imagen->url === $main_image_url) ? 'activa' : ''; ?>"
                                    src="/img/productos/thumbs/<?php echo ($imagen->url); ?>.png" 
                                    alt="Miniatura de <?php echo ($producto->nombre); ?> - Imagen <?php echo $index + 1; ?>"
                                    data-indice="<?php echo $index; ?>"
                                >
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                </div>
                <div class="producto__informacion__basica">
                    <div class="producto__header">
                        <h1 class="producto__titulo"><?= $producto->nombre; ?></h1>
                        <div class="producto__puntuacion">
                            <span class="producto__puntuacion-estrellas"></span>
                        </div>
                    </div>
                    <?php
                        $precio_informativo = (float) $producto->precio_informativo;
                        $precio_tactil = (float) $producto->precio_tactil;
                    ?>
                    <div class="producto__precio">
                        <?php if ($precio_tactil > 0 && $precio_tactil !== $precio_informativo) : ?>
                            <!-- Caso 1: Hay dos precios diferentes y el táctil no es cero -->
                            <p>Precio desde:</p>
                            <span class="producto__precio-anterior">$ <?= number_format($precio_informativo, 0, ',', '.'); ?></span>
                            <p>Con función táctil desde:</p>
                            <span class="producto__precio-actual">$ <?= number_format($precio_tactil, 0, ',', '.'); ?></span>
                        <?php else : ?>
                            <!-- Caso 2: Solo hay un precio o ambos son iguales -->
                            <p>Precio:</p>
                            <span class="producto__precio-actual">$ <?= number_format($precio_informativo, 0, ',', '.'); ?></span>
                        <?php endif; ?>
                    </div>                        
                    <div class="contenedor__boton">
                        <a class="contacto__boton" href="/contacto">contacto</a>                        
                        <a a href="https://wa.me/56920519944" class="whatsapp__boton" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">WhatsApp</a>
                    </div> 
                </div>
            </div>
            <div class="producto__informacion-detalle">
                <div class="producto__caracteristicas">
                    <h3 class="producto__caracteristicas-header">Caracteristicas</h3>
                    <?php 
                        if (!empty($producto->caracteristicas)) : 
                            $caracteristicas_array = explode(',', $producto->caracteristicas);
                    ?>
                        <ul class="producto__caracteristicas-lista">
                            <?php 
                                foreach ($caracteristicas_array as $caracteristica) : 
                            ?>
                                <li class="producto__caracteristicas-item"><?= htmlspecialchars(trim($caracteristica)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="producto__descripcion">
                    <h3 class="producto__descripcion-header">Descripcion</h3>
                    <p class="producto__descripcion-texto"><?= $producto->descripcion; ?></p>
                </div>
            </div>
        </div>
        <div class="producto__extras">
            <div class="producto__preguntas">
                <section class="faq__item">
                    <h4 class="faq__pregunta">¿Cómo puedo cotizar un servicio?</h4>
                    <p class="faq__respuesta">
                    Puedes llenar el formulario de contacto en nuestro sitio web, escribirnos directamente por WhatsApp o enviarnos un correo a <a href="mailto:contacto@visualrent.cl">contacto@visualrent.cl</a>. Recibirás una cotización personalizada según los requerimientos de tu evento.
                    </p>
                </section>

                <section class="faq__item">
                    <h4 class="faq__pregunta">¿Qué incluye el servicio de arriendo?</h4>
                    <p class="faq__respuesta">
                    Todos nuestros servicios incluyen instalación y asistencia técnica, en algunos casos también ofrecemos soporte en tiempo real durante el evento para asegurar que todo funcione correctamente. El costo de entrega y retiro se calcula al momento de la cotización dependiendo de la ubicacion de entrega.
                    </p>
                </section>

                <section class="faq__item">
                    <h4 class="faq__pregunta">¿Con cuánto tiempo de anticipación debo reservar?</h4>
                    <p class="faq__respuesta">
                    Te recomendamos hacer la reserva al menos con 7 a 10 días de anticipación, especialmente en temporada alta (ferias, festividades o lanzamientos). Esto nos permite garantizar disponibilidad y una correcta planificación logística.
                    </p>
                </section>
                <section class="faq__item">
                    <h4 class="faq__pregunta">¿Ofrecen soporte técnico en el lugar?</h4>
                    <p class="faq__respuesta">
                    Sí, dependiendo del tipo de equipo y evento, podemos incluir un técnico en terreno para garantizar el funcionamiento óptimo durante toda la actividad. Este servicio puede tener un costo adicional.
                    </p>
                </section>
            </div>
            <div class="producto__opiniones">
                <div class="producto__calificaciones"></div>
                <div class="producto__opiniones-destacadas"></div>
            </div>
        </div>
    </div>
    <div class="productos__relacionados">
        <h3 class="productos__relacionados-header"></h3>
        <div class="productos__relacionados-carrusel"></div>
    </div>   
</main>