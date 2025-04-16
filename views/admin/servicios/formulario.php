<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Basica</legend>
    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Nombre servicio</label>
        <input 
            class="formulario__input" 
            type="text" 
            id="nombre" 
            name="nombre" 
            placeholder="Nombre servicio"
            value="<?php echo s($servicio->nombre); ?>"
        >
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="descripcion">Descripcion servicio</label>
        <textarea 
            class="formulario__input" 
            id="descripcion" 
            name="descripcion" 
            placeholder="Describe en breves palabras el servicio" 
            rows="4"
        >
            <?php echo s($servicio->descripcion); ?>
        </textarea>
    </div>
 
    <div class="formulario__campo">
        <label class="formulario__label" for="categoria">Categoria o Tipo de servicio</label>
        <select
            class="formulario__select"
            name="categoria_id" 
            id="categoria"
        >
            <option value="">- Seleccionar -</option>
            <?php foreach($categorias as $categoria) { ?>
            <option 
                <?php echo ($servicio->categoria_id === $categoria->id) ? 'selected' : '' ?>
                value="<?php echo $categoria->id; ?>"
            >
                <?php echo $categoria->nombre; ?>
            </option>
            <?php } ?>
        </select>
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
    <?php if(isset($servicio->imagen_actual)) { ?>
        <p class="formulario__texto">Imagen Actual:</p>
        <div class="formulario__imagen-miniatura">
            <picture>
                <source srcset="/img/servicios/<?php echo $servicio->imagen; ?>.webp" type="image/webp">
                <source srcset="/img/servicios/<?php echo $servicio->imagen; ?>.png" type="image/png">
                <img src="/img/servicios/<?php echo $servicio->imagen; ?>.png" alt="imagen servicio">
            </picture>
        </div>
    <?php } ?>
</fielset>
