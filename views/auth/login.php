<main class="auth">
    <h1 class="auth__heading"><?php echo $titulo; ?></h1>
    <p class="auth__texto">Inicia Sesión en Visual Rent</p>

    <form method="POST" action="/login" class="formulario">
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
        <div class="formulario__campo">
            <label for="password" class="formulario__label">Password</label>
            <input 
                type="password" 
                class="formulario__input"
                placeholder="Tu password"
                id="password"
                name="password"
            >
        </div>
        <?php
           require_once __DIR__ . '/../templates/alertas.php';
        ?>
        <input class="formulario__submit" type="submit" value="Iniciar Sesión">
    </form>
    <div class="acciones">
        <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Registrate</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu password?</a>
    </div>
</main>