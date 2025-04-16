<aside class="dashboard__sidebar">
    <nav class="dashboard__menu">
        <a 
            href="/admin/dashboard" 
            class="dashboard__enlace 
                <?php echo pagina_actual ('/dashboard') ? 'dashboard__enlace--actual' : ''; 
        ?>">
            <i class="fa-solid fa-house dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Inicio
            </span>
        </a>
        <a href="/admin/clientes" class="dashboard__enlace 
                <?php echo pagina_actual ('/usuarios') ? 'dashboard__enlace--actual' : ''; 
        ?>">
            <i class="fa-solid fa-users dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Clientes
            </span>
        </a>
        <a href="/admin/productos" class="dashboard__enlace 
                <?php echo pagina_actual ('/productos') ? 'dashboard__enlace--actual' : ''; 
        ?>">
            <i class="fa-solid fa-bag-shopping dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Productos
            </span>
        </a>
        <a href="/admin/servicios" class="dashboard__enlace 
                <?php echo pagina_actual ('/servicios') ? 'dashboard__enlace--actual' : ''; 
        ?>">
            <i class="fa-solid fa-hand-holding-heart dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Servicios
            </span>
        </a>
        <a href="/admin/agenda" class="dashboard__enlace 
                <?php echo pagina_actual ('/agenda') ? 'dashboard__enlace--actual' : ''; 
        ?>">
            <i class="fa-solid fa-calendar-days dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Agenda
            </span>
        </a>
        <a href="/admin/galeria" class="dashboard__enlace 
                <?php echo pagina_actual ('/galeria') ? 'dashboard__enlace--actual' : ''; 
        ?>">
            <i class="fa-solid fa-photo-film dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Galeria
            </span>
        </a>
    </nav>
</aside>