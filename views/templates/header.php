<header class="header">
    <div class="header__contenedor">
        <nav class="header__navegacion">
            <?php if(is_auth()) { ?>
                <a href="<?php echo is_admin() ? '/admin/dashboard' : '/finalizar-registro'; ?>" class="header__enlace">Administrar</a>
                <form action="/logout"  method="POST" class="header__form">
                    <input type="submit" value="Cerrar Sesión" class="header__submit">
                </form>
            <?php } else { ?>
                <!-- <a href="/registro" class="header__enlace">Registrarse</a> -->
                <a href="/login" class="header__enlace">Iniciar Sesión</a>
            <?php } ?>          
        </nav> 
        <div class="header__contenido">
            <a href="/">
            <img class="header__logo" src="/build/img/Visual_Rent_Horizontal.png" alt="Logo visual rent">
            </a>
            <p class="header__texto">Equipamos tu evento y creamos experiencias inolvidables</p>
            <p class="header__texto header__texto--slogan">
                Transformamos espacios en escenarios de emociones, donde la tecnología se fusiona con la experiencia para crear momentos únicos.
            </p>
            <a href="/productos/catalogo" class="header__boton">Ver Catalogo</a>
        </div>
    </div>
</header>
<div class="barra">
    <div class="barra__contenido">
        <a href="/">
            <img class="barra__logo" src="/build/img/Visual_Rent_Horizontal.png" alt="Logo visual rent">
        </a>
        <nav class="navegacion">
            <a href="/productos/index" class="navegacion__enlace <?= pagina_actual ('/producto') || pagina_actual ('/productos')? 'navegacion__enlace--actual' : '' ?>">Productos</a>
            <a href="/servicios/index" class="navegacion__enlace <?= pagina_actual ('/servicios')? 'navegacion__enlace--actual' : '' ?>">Servicios</a>
            <a href="/galeria" class="navegacion__enlace <?php echo pagina_actual ('/galeria')? 'navegacion__enlace--actual' : '' ?>">Galería</a>
            <a href="/contacto" class="navegacion__enlace <?php echo pagina_actual ('/contacto')? 'navegacion__enlace--actual' : '' ?>">Contacto</a>
        </nav>
    </div>
</div>