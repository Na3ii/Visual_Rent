<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/galeria/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Imagen
    </a>
</div>

<div class="dashboard__contenedor">
    <?php if(!empty($imagenes)) { ?> 
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Imagen</th>
                    <th scope="col" class="table__th">descripcion</th>
                    <th scope="col" class="table__th table__th--acciones">Acciones</th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($imagenes as $imagen) { ?>
                    <tr>
                        <td class="table__td">                            
                            <div class="formulario__imagen-miniatura">
                                <picture>
                                    <source srcset="/img/galeria/<?php echo $imagen->imagen; ?>.webp" type="image/webp">
                                    <source srcset="/img/galeria/<?php echo $imagen->imagen; ?>.png" type="image/png">
                                    <img src="/img/galeria/<?php echo $imagen->imagen; ?>.png" alt="<?php echo $imagen->descripcion; ?>" class="galeria__imagen">
                                </picture>
                            </div>
                        </td>
                        <td class="table__td"><?php echo $imagen -> descripcion; ?></td>
                        <td class="table__td--acciones">
                            <a href="/admin/galeria/editar?id=<?php echo $imagen -> id; ?>" class="table__accion--galeria table__accion--editar">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" class="table__formulario" action="/admin/galeria/eliminar">
                                <input type="hidden" name="id" value="<?php echo $imagen -> id; ?>">
                                <button type="submit" class="table__accion--galeria table__accion--eliminar">
                                    <i class="fa-solid fa-trash"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="dashboard__mensaje">No hay imagenes en la galeria</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>