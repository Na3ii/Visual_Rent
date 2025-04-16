<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Recupera tu acceso a Visual Rent</p>

    <form method="POST" action="/olvide" class="formulario">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input 
                type="email" 
                class="formulario__input"
                placeholder="Tu Email"
                id="email"
                name="email"
            >
        </div>
        <?php
           require_once __DIR__ . '/../templates/alertas.php';
        ?>
        <input class="formulario__submit" type="submit" value="Enviar Instrucciones">
    </form>
    
    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar sesión</a>
        <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Registrate</a>
    </div>
</main>