<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Basica</legend>
    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Nombre Producto</label>
        <input 
            class="formulario__input" 
            type="text" 
            id="nombre" 
            name="nombre" 
            placeholder="Nombre Producto"
            value="<?php echo s($producto->nombre); ?>"
        >
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="descripcion">Descripcion Producto</label>
        <textarea class="formulario__input" id="descripcion" name="descripcion" placeholder="Describe en breves palabras el producto" rows="4">
            <?php echo s($producto->descripcion); ?>
        </textarea>
    </div>
    <div class="formulario__campo">
        <label for="caracteristicas_input" class="formualrio__label">Características</label>
        <input 
            type="text"
            class="formulario__input"
            id="caracteristicas_input"
            placeholder="caracteristicas separadas por ENTER"
        >
        <div id="caracteristicas" class="formulario__listado"></div>
        <input type="hidden" name="caracteristicas" id="caracteristicas_hidden" value="<?php echo $producto->caracteristicas ?? ''; ?>">
    </div>
    <div class="formulario__campo">
        <label class="formulario__label" for="categoria">Categoria o Tipo de Producto</label>
        <select
            class="formulario__select"
            name="categoria_id" 
            id="categoria"
        >
            <option value="" disabled selected>- Seleccionar -</option>
            <?php foreach($categorias as $categoria) { ?>
            <option 
                <?php echo ($producto->categoria_id === $categoria->id) ? 'selected' : '' ?>
                value="<?php echo $categoria->id; ?>"
            >
                <?php echo $categoria->nombre; ?>
            </option>
            <?php } ?>
        </select>
        </div>
        <div class="formulario_campo">
            <label class="formualrio__label" for="tactil">Equipo tactil</label>
            <select 
                class="formulario__select" 
                name="tactil" 
                id="tactil"
            >
                <option value="" disabled selected>-Seleccionar una opción-</option>
                <option value="1">Sí</option>
                <option value="2">No</option>
            </select>
        </div>
    <div class="formulario__campo">
        <label for="disponibles" class="formualrio__label">Cantidad Disponible</label>
        <input 
            type="number" 
            min="1"
            class="formulario__input"
            id="disponibles"
            name="disponibles"
            placeholder="Ej: 5"
            value="<?php echo s($producto->disponibles); ?>"
        >
    </div>
    <div class="formulario__campo">
        <label for="precio_informativo" class="formualrio__label">Precio</label>
        <input 
            type="number" 
            min="0"
            class="formulario__input"
            id="precio_informativo"
            name="precio_informativo"
            placeholder="Ej: 50000"
            value="<?php echo s($producto->precio_informativo); ?>"
        >
    </div>
    <div class="formulario__campo">
        <label for="precio_tactil" class="formualrio__label">Precio Tactil</label>
        <input 
            type="number" 
            min="0"
            class="formulario__input"
            id="precio_tactil"
            name="precio_tactil"
            placeholder="Ej: 20"
            value="<?php echo s($producto->precio_tactil); ?>"
        >
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
    <?php if(isset($producto->imagen_actual)) { ?>
        <p class="formulario__texto">Imagen Actual:</p>
        <div class="formulario__imagen-miniatura">
            <picture class="producto__imagen">
                <source srcset="/img/productos/<?php echo $producto->imagen; ?>.webp" type="image/webp">
                <source srcset="/img/productos/<?php echo $producto->imagen; ?>.png" type="image/png">
                <img class="producto__imagen" loading="lazy" width="200" height="300" 
                src="/img/productos/<?php echo $producto->imagen; ?>.png" alt="imagen producto">
            </picture>
        </div>
    <?php } ?>
</fielset>
