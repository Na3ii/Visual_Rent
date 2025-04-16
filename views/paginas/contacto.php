<main class="contacto__contenedor">
    <h2 class="contacto__heading"><?php echo $titulo; ?></h2>
    <p class="contacto__descripcion">Déjanos tu mensaje y nos pondremos en contacto contigo lo antes posible.</p>

    <form 
        class="contacto__formulario" 
        method="POST"
        action="/contacto"
    >
        <div class="formulario__campo">
            <label class="formulario__label" for="nombre">Nombre</label>
            <input 
                class="formulario__input" 
                type="text" id="nombre" 
                name="nombre"
                placeholder="Tu Nombre y apellido" 
                required>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="empresa">Empresa</label>
            <input 
                class="formulario__input" 
                type="text" id="empresa" 
                name="empresa" 
                placeholder="Nombre de la Empresa"
                required>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="email">Email</label>
            <input 
                class="formulario__input" 
                type="email" 
                id="email" 
                name="email"
                placeholder="Tu Email" 
                required>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="telefono">Teléfono</label>
            <input 
                class="formulario__input" 
                type="text" 
                id="telefono" 
                name="telefono" 
                placeholder="Tu Teléfono"
                required>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="mensaje">Mensaje</label>
            <textarea 
                class="formulario__input" 
                id="mensaje" 
                name="mensaje" 
                rows="5" 
                placeholder="Escribe tu mensaje aquí"
                required></textarea>
        </div>    
        <?php
                require_once __DIR__ . '/../templates/alertas.php'; 
        ?>
        <input type="submit" class="formulario__submit formulario__submit--contactar" value="Enviar Mensaje">
    </form>
</main>
    
