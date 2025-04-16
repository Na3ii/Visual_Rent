(function() {
        const botonesVerProducto = document.querySelectorAll(".producto__boton");
        const modal = document.createElement("DIV");
        modal.classList.add("modal");
        let producto = [];

        botonesVerProducto.forEach(boton => {
            boton.addEventListener("click", async () => {
                const id = boton.dataset.id;
                const respuesta = await fetch(`/api/productos?id=${id}`);
                producto = await respuesta.json();
                
                // Insertar nombre, imagen y descripción
                //console.log(producto);
                // Convertir características separadas por "," en una lista
                const caracteristicas = producto.caracteristicas.split(","); // Convertir string en array
                console.log(caracteristicas);

                modal.classList.add("mostrar");
                modal.innerHTML = `
                    <div class="modal__contenido animate-fade-in">
                        <div>
                            <a class="modal__cerrar">&times;</a>
                        </div>
                        <h2 class="modal__heading">${producto.nombre}</h2>
                        <div class="modal__grid">
                            <div class="modal__imagen">
                                <picture>
                                    <source srcset="/img/productos/${producto.imagen}.webp" type="image/webp">
                                    <source srcset="/img/productos/${producto.imagen}.png" type="image/png">
                                    <img src="/img/productos/${producto.imagen}.png" alt="${producto.nombre}">
                                </picture>
                            </div>
                            <div class="modal__descripcion">
                                <p class="modal__descripcion">${producto.descripcion}</p>                            
                                <ul id="modalCaracteristicas"></ul>
                            </div>                           
                        </div>                        
                        <div class="contenedor__boton">
                            <a class="modal__boton" href="/contacto">Cotizar</a>
                        </div> 
                    </div>
                `;
                document.body.appendChild(modal); // Asegúrate de que el modal esté en el DOM

                caracteristicas.forEach(caracteristica => {
                    const caracteristicasLista = document.getElementById("modalCaracteristicas");
                    const li = document.createElement("li");
                    li.textContent = caracteristica.trim(); // Eliminar espacios en blanco al inicio/final
                    li.classList.add("modal__caracteristica");
                    caracteristicasLista.appendChild(li);                   
                });
            });
        });

        modal.addEventListener("click", (e) => {

            if (e.target.classList.contains('modal__cerrar') || e.target === modal) {
                
                const contenido = modal.querySelector('.modal__contenido');
        
                if (contenido) {
                    contenido.classList.remove('animate-fade-in');
                    contenido.classList.add('animate-fade-out');
        
                    // Esperar a que termine la animación antes de remover el modal
                    setTimeout(() => {
                        modal.remove();
                    }, 380); // Duración de la animación en milisegundos
                } else {
                    modal.remove(); // Fallback por si no encuentra el contenido
                }
            }
        });
    
   
})();