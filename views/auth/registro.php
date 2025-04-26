<main class="auth">
    <h1 class="auth__heading"><?php echo $titulo; ?></h1>
    <p class="auth__texto">Registrate en Visual Rent</p>
    <form method="POST" action="/registro" class="formulario">
        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Nombre</label>
            <input 
                type="nombre" 
                class="formulario__input"
                placeholder="Tu nombre"
                id="nombre"
                name="nombre"
                value="<?php echo $usuario->nombre;?>"
            >
        </div>
        <div class="formulario__campo">
            <label for="apellido" class="formulario__label">Apellido</label>
            <input 
                type="apellido" 
                class="formulario__input"
                placeholder="Tu apellido"
                id="apellido"
                name="apellido"
                value="<?php echo $usuario->apellido;?>"
            >
        </div>
        <div class="formulario__campo">
            <label for="empresa" class="formulario__label">Empresa</label>
            <input 
                type="empresa" 
                class="formulario__input"
                placeholder="Tu empresa"
                id="empresa"
                name="empresa"
                value="<?php echo $usuario->empresa;?>"
            >
        </div>
        <div class="formulario__campo">
            <label for="rut" class="formulario__label">RUT</label>
            <input 
                type="rut" 
                class="formulario__input"
                placeholder="Sin puntos y sin guion"
                id="rut"
                name="rut"
                value="<?php echo $usuario->rut;?>"
            >
        </div>
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input 
                type="email" 
                class="formulario__input"
                placeholder="Tu email"
                id="email"
                name="email"
                value="<?php echo $usuario->email;?>"
            >
        </div>
        <div class="formulario__campo">
            <label for="telefono" class="formulario__label">teléfono</label>
            <input 
                type="telefono" 
                class="formulario__input"
                placeholder="telefono con sus 9 digitos"
                id="telefono"
                name="telefono"
                value="<?php echo $usuario->telefono;?>"
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
        <div class="formulario__campo">
            <label for="password2" class="formulario__label">Repetir Password</label>
            <input 
                type="password" 
                class="formulario__input"
                placeholder="Repetir password"
                id="password2"
                name="password2"
            >
        </div>
        <?php
            require_once __DIR__ . '/../templates/alertas.php';
        ?>
        <input class="formulario__submit" type="submit" value="Crear Cuenta">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar sesión</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu password?</a>
    </div>
</main>