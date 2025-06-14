<fieldset class="formulario__fieldset">
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
        <label class="formulario__label" for="og_title">Titulo para Redes Sociales</label>
        <input 
            class="formulario__input" 
            type="text" 
            id="og_title" 
            name="og_title" 
            placeholder="Titulo para Redes Sociales"
            value="<?php echo s($producto->og_title); ?>"
        >
    </div>
    <div class="formulario__campo">
        <label class="formulario__label" for="og_description">Descripción para Redes Sociales</label>
        <input 
            class="formulario__input" 
            type="text" 
            id="og_description" 
            name="og_description" 
            placeholder="Descripción para Redes Sociales"
            value="<?php echo s($producto->og_description); ?>"
        >
    </div>
    <div class="formulario__campo">
        <label class="formulario__label" for="meta_description">Descripción para Motores de Busqueda</label>
        <input 
            class="formulario__input" 
            type="text" 
            id="meta_description" 
            name="meta_description" 
            placeholder="Descripción para Motores de Busqueda"
            value="<?php echo s($producto->meta_description); ?>"
        >
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="descripcion">Descripcion Producto</label>
        <textarea class="formulario__input" id="descripcion" name="descripcion" placeholder="Describe en breves palabras el producto" rows="4">
            <?php echo s($producto->descripcion);?>
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

    <!-- Campo para imágenes nuevas -->
    <div class="formulario__campo">
        <label for="imagenes" class="formulario__imagen">Agregar Imágenes</label>
        <input 
            type="file"
            class="formulario__input formulario__input--file"
            id="imagenes"
            name="imagenes[]"
            multiple
            accept="image/*"
        >
        <div id="preview-imagenes" class="imagenes-sortable">
            <div id="preview-contenedor" data-imagenes-actuales='<?= json_encode($imagenes_actuales ?? []) ?>'>
                <!-- JS inyectará aquí tanto las existentes (data-actual="1") como las nuevas (data-actual="0") -->
            </div>
        </div>
        <!-- Campo oculto para recopilar removidas -->
        <input type="hidden" id="imagenes_eliminadas" name="imagenes_eliminadas" value="[]" />
    </div>    
</fielset>
