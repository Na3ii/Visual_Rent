<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/productos/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Producto
    </a>
</div>

<div class="dashboard__contenedor">
    <?php if(!empty($productos)) { ?> 
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Stock</th>
                    <th scope="col" class="table__th table__th--acciones">Acciones</th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($productos as $producto) { ?>
                    <tr>
                        <td class="table__td"><?php echo $producto -> nombre; ?></td>
                        <td class="table__td"><?php echo $producto -> disponibles; ?></td>
                        <td class="table__td--acciones">
                            <a href="/admin/productos/editar?id=<?php echo $producto -> id; ?>" class="table__accion table__accion--editar">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" class="table__formulario" action="/admin/productos/eliminar">
                                <input type="hidden" name="id" value="<?php echo $producto -> id; ?>">
                                <button type="submit" class="table__accion table__accion--eliminar">
                                    <i class="fa-solid fa-trash"></i>
                                    ELiminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="dashboard__mensaje">No hay productos registrados</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>