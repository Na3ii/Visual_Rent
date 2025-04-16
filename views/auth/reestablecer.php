<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Ingresa tu nueva contraseña</p>
    <form method="POST" class="formulario">
        
        <?php if($token_valido) { ?>
        <div class="formulario__campo">
            <label for="password" class="formulario__label">password</label>
            <input 
                type="password" 
                class="formulario__input"
                placeholder="Tu password"
                id="password"
                name="password"
            >
        </div>
        <input class="formulario__submit" type="submit" value="Guardar Contraseña">        
        <?php } ?>
        <?php
            require_once __DIR__ . '/../templates/alertas.php';
        ?>
    </form>
    
    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar sesión</a>
        <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Registrate</a>
    </div>
</main>