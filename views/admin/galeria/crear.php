<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/galeria">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>
<div class="dashboard__formulario">
    <form 
        method="POST" 
        action="/admin/galeria/crear" 
        enctype="multipart/form-data" 
        class="formulario"
    >        
        <?php
                require_once __DIR__ . '/formulario.php';
        ?>
        <?php
                require_once __DIR__ . '/../../templates/alertas.php';
        ?>
        <input class="formulario__submit formulario__submit--registrar" type="submit" value="Agregar Imagen">
    </form>
</div>