<fieldset class="formulario__fieldset">
    <div class="formulario__campo">
        <label for="imagen" class="formulario__imagen">Imagen</label>
        <input 
            type="file"
            class="formulario__input formulario__input--file"
            id="imagen"
            name="imagen"
        >
    </div>
    <?php if(isset($imagen->imagen_actual)) { ?>
        <p class="formulario__texto">Imagen Actual:</p>
        <div class="formulario__imagen-miniatura">
            <picture>
                <source srcset="/img/galeria/<?php echo $imagen->imagen; ?>.webp" type="image/webp">
                <source srcset="/img/galeria/<?php echo $imagen->imagen; ?>.png" type="image/png">
                <img src="/img/galeria/<?php echo $imagen->imagen; ?>.png" alt="<?php echo $imagen->descripcion; ?>">
            </picture>
        </div>
    <?php } ?>
    <div class="formulario__campo">
        <label class="formulario__label" for="descripcion">Descripcion imagen</label>
        <textarea class="formulario__input" id="descripcion" name="descripcion" placeholder="Describe en breves palabras la imagen" rows="1">
            <?php echo s($imagen->descripcion); ?>
        </textarea>
    </div>
    </fielset>