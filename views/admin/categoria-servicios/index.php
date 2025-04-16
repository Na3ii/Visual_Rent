<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/servicios/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Servicio
    </a>
    <a class="dashboard__boton" href="/admin/servicios">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>
<div class="dashboard__contenedor">
    <?php if(!empty($servicios)) { ?> 
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Servicios</th>
                    <th scope="col" class="table__th table__th--acciones">Acciones</th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($servicios as $servicio) { ?>
                    <tr>
                        <td class="table__td"><?php echo $servicio -> nombre; ?></td>
                        <td class="table__td--acciones">
                            <a href="/admin/servicios/editar?id=<?php echo $servicio -> id; ?>" class="table__accion table__accion--editar">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" class="table__formulario" action="/admin/servicios/eliminar">
                                <input type="hidden" name="id" value="<?php echo $servicio -> id; ?>">
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
        <p class="dashboard__mensaje">No hay servicios registrados</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>