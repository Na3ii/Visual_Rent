(function() {
    // Este código solo se ejecutará si encuentra los elementos de la galería en la página.
    const galeriaProducto = () => {
        // 1. Obtener los datos de las imágenes desde el atributo data-* del contenedor
        const galeriaContenedor = document.getElementById('galeria-producto-contenedor');
        if (!galeriaContenedor) return; // Si no existe el contenedor, no hacer nada.

        // Leer el string JSON desde el dataset
        const imagenesJSON = galeriaContenedor.dataset.imagenes;
        if (!imagenesJSON) return; // Si el atributo está vacío, salir.
        
        // Convertir el string JSON en un objeto JavaScript
        const imagenes = JSON.parse(imagenesJSON);
        if (!imagenes || imagenes.length === 0) return; // Si no hay imágenes, salir.

        // 2. Referencias a los elementos del DOM
        const imagenPrincipal = document.getElementById('imagen-principal-producto');
        const miniaturasContenedor = document.getElementById('galeria-miniaturas');
        const btnAnterior = document.getElementById('galeria-anterior');
        const btnSiguiente = document.getElementById('galeria-siguiente');

        if (!imagenPrincipal || !miniaturasContenedor) return;

        let indiceActual = 0;

        // 3. Función para cambiar la imagen principal (esta función no necesita cambios)
        const cambiarImagen = (nuevoIndice) => {
            if (nuevoIndice < 0 || nuevoIndice >= imagenes.length) {
                return;
            }
            const nuevaImagenUrl = imagenes[nuevoIndice].url;

            const picture = imagenPrincipal.parentElement;
            picture.querySelector('source[type="image/webp"]').srcset = `/img/productos/${nuevaImagenUrl}.webp`;
            picture.querySelector('source[type="image/png"]').srcset = `/img/productos/${nuevaImagenUrl}.png`;
            imagenPrincipal.src = `/img/productos/${nuevaImagenUrl}.png`;
            imagenPrincipal.alt = `Imagen principal de producto - ${imagenes[nuevoIndice].descripcion || ''}`;

            // Quitar 'activa' de todos los contenedores de miniaturas
            const contenedoresMiniatura = miniaturasContenedor.querySelectorAll('.galeria-miniatura__contenedor');
            contenedoresMiniatura.forEach(cont => cont.classList.remove('activa'));
            
            // Añadir 'activa' al contenedor de la miniatura seleccionada
            const miniaturaActiva = miniaturasContenedor.querySelector(`.galeria-miniatura__contenedor:has(img[data-indice="${nuevoIndice}"])`);
            if (miniaturaActiva) {
                miniaturaActiva.classList.add('activa');
                // Opcional: Hacer scroll para que la miniatura activa esté visible
                miniaturaActiva.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
            
            indiceActual = nuevoIndice;
        };

        // 4. Añadir eventos a las miniaturas
        // (Actualizado para usar delegación de eventos, más eficiente)
        miniaturasContenedor.addEventListener('click', (e) => {
            // Verificar si se hizo clic en una imagen de miniatura
            if (e.target.classList.contains('galeria-miniatura__imagen')) {
                const indice = parseInt(e.target.dataset.indice);
                cambiarImagen(indice);
            }
        });


        // 5. Añadir eventos a los botones de navegación (sin cambios)
        if (btnAnterior && btnSiguiente) {
            btnAnterior.addEventListener('click', () => {
                let nuevoIndice = indiceActual - 1;
                if (nuevoIndice < 0) {
                    nuevoIndice = imagenes.length - 1; // Loop al final
                }
                cambiarImagen(nuevoIndice);
            });

            btnSiguiente.addEventListener('click', () => {
                let nuevoIndice = indiceActual + 1;
                if (nuevoIndice >= imagenes.length) {
                    nuevoIndice = 0; // Loop al inicio
                }
                cambiarImagen(nuevoIndice);
            });
        }

        // Inicializar con la primera imagen activa
        const miniaturaActivaInicial = miniaturasContenedor.querySelector('.galeria-miniatura__contenedor.activa img');
        if (miniaturaActivaInicial) {
            indiceActual = parseInt(miniaturaActivaInicial.dataset.indice);
        }
    };

    // Llamar a la función cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', galeriaProducto);

})();