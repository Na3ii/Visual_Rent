<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
<a class="dashboard__boton" href="/admin/categoria-productos/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Categoria
    </a>
    <a class="dashboard__boton" href="/admin/productos/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Producto
    </a>
</div>


    <?php if(!empty($categorias)) { ?> 
        <div class="listado__categorias">
        <?php foreach($categorias as $categoria) { ?>
                        <div class="categoria">                            
                            <a href="/admin/categoria-productos?url=<?php echo $categoria -> url;?>" class="categoria__nombre"><?php echo $categoria -> nombre; ?></a>
                            <div class="categoria__botones">
                                <a href="/admin/categoria-productos/editar?id=<?php echo $categoria -> id; ?>" class="boton table__accion table__accion--editar">
                                    <i class="fa-solid fa-user-pen"></i>
                                    Editar
                                </a>
                                <form method="POST" class=" table__formulario" action="/admin/categoria-productos/eliminar">
                                    <input type="hidden" name="id" value="<?php echo $categoria -> id; ?>">
                                    <button type="submit" class="boton table__accion table__accion--eliminar">
                                        <i class="fa-solid fa-trash"></i>
                                        ELiminar
                                    </button>
                                </form>
                            </div>   
                        </div>
                <?php } ?>              
        </div>        
    <?php } else { ?>
        <p class="dashboard__mensaje">No hay Categorias registradas</p>
    <?php } ?>