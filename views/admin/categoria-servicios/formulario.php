<fieldset class="formulario__fieldset">
    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Nombre Categoria</label>
        <input 
            class="formulario__input" 
            type="text" 
            id="nombre" 
            name="nombre" 
            placeholder="Nombre categoria"
            value="<?php echo s($categoria->nombre); ?>"
        >
    </div>
    
    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Titulo para Redes Sociales</label>
        <input 
            class="formulario__input" 
            type="text" 
            id="og_title" 
            name="og_title" 
            placeholder="Nombre categoria"
            value="<?php echo s($categoria->og_title); ?>"
        >
    </div>
    
    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Descripción para las Redes Sociales</label>
        <input 
            class="formulario__input" 
            type="text" 
            id="og_description" 
            name="og_description" 
            placeholder="Descripción para las Redes Sociales"
            value="<?php echo s($categoria->og_description); ?>"
        >
    </div>
    
    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Descripción para los Motores de Búsqueda</label>
        <input 
            class="formulario__input" 
            type="text" 
            id="meta_description" 
            name="meta_description" 
            placeholder="Descripción para los Motores de Búsqueda"
            value="<?php echo s($categoria->meta_description); ?>"
        >
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="descripcion">Descripcion categoria</label>
        <textarea 
            class="formulario__input" 
            id="descripcion" 
            name="descripcion" 
            placeholder="Describe en breves palabras la categoria" 
            rows="4"
        >
            <?php echo s($categoria->descripcion); ?>
        </textarea>
    </div>
 
    <div class="formulario__campo">
        <label for="imagen" class="formulario__imagen">Imagen</label>
        <input 
            type="file"
            class="formulario__input formulario__input--file"
            id="imagen"
            name="imagen"
        >
    </div>
    <?php if(isset($categoria->imagen_actual)) { ?>
        <p class="formulario__texto">Imagen Actual:</p>
        <div class="formulario__imagen-miniatura">
            <picture>
                <source srcset="/img/categoria-servicios/<?php echo $categoria->imagen; ?>.webp" type="image/webp">
                <source srcset="/img/categoria-servicios/<?php echo $categoria->imagen; ?>.png" type="image/png">
                <img src="/img/categoria-servicios/<?php echo $categoria->imagen; ?>.png" alt="imagen servicio">
            </picture>
        </div>
    <?php } ?>
</fielset>
