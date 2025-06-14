import { mostrarAlerta } from './alertas.js';
import { validarImagen } from './validarImagen.js';

(function() {
    document.addEventListener('DOMContentLoaded', () => {
        const inputImagenes = document.querySelector('#imagenes');
        const previewContenedor = document.querySelector('#preview-contenedor');
        const form = document.querySelector('#miFormulario');
        
        let imagenesSeleccionadas = [];   // nuevas imágenes
        let imagenesActuales = [];       // imágenes cargadas desde servidor
        let imagenesAEliminar = [];      // ids de imágenes existentes para eliminar

        // Inicializar imágenes actuales desde data-attribute
        const data = previewContenedor.dataset.imagenesActuales;
        if (data) {
            imagenesActuales = JSON.parse(data);
        }

        // Renderizar imágenes actuales y nuevas (unificado)
        function renderizar() {
            previewContenedor.innerHTML = '';
            // 1) imágenes actuales
            imagenesActuales.forEach((item, actualIdx) => {
                const cont = document.createElement('div');
                cont.className = 'preview-imagen';
                cont.dataset.actual = '1';
                cont.dataset.idImagen = item.id;

                const span = document.createElement('span');
                span.className = 'orden-visual';
                span.textContent = actualIdx + 1;
                cont.appendChild(span);

                const imgEl = document.createElement('img');
                imgEl.className = 'thumb';
                imgEl.src = `/img/productos/thumbs/${item.url}.webp`;
                cont.appendChild(imgEl);

                const inpDesc = document.createElement('input');
                inpDesc.type = 'text';
                inpDesc.className = 'descripcion-imagen';
                inpDesc.value = item.descripcion || '';
                inpDesc.addEventListener('input', () => {
                    imagenesActuales[actualIdx].descripcion = inpDesc.value;
                });
                cont.appendChild(inpDesc);

                const btnDel = document.createElement('button');
                btnDel.className = 'btn-eliminar';
                btnDel.textContent = 'X';
                btnDel.addEventListener('click', () => {
                    imagenesAEliminar.push(item.id);
                    imagenesActuales.splice(actualIdx, 1);
                    renderizar();
                });
                cont.appendChild(btnDel);

                previewContenedor.appendChild(cont);
            });

            // 2) imágenes nuevas
            imagenesSeleccionadas.forEach((item, newIdx) => {
                const cont = document.createElement('div');
                cont.className = 'preview-imagen';
                cont.dataset.actual = '0';

                const span = document.createElement('span');
                span.className = 'orden-visual';
                span.textContent = imagenesActuales.length + newIdx + 1;
                cont.appendChild(span);

                const imgEl = document.createElement('img');
                imgEl.className = 'thumb';
                imgEl.src = item.base64;
                cont.appendChild(imgEl);

                const inpDesc = document.createElement('input');
                inpDesc.type = 'text';
                inpDesc.className = 'descripcion-imagen';
                inpDesc.value = item.descripcion || '';
                inpDesc.addEventListener('input', () => {
                    imagenesSeleccionadas[newIdx].descripcion = inpDesc.value;
                });
                cont.appendChild(inpDesc);

                const btnDel = document.createElement('button');
                btnDel.className = 'btn-eliminar';
                btnDel.textContent = 'X';
                btnDel.addEventListener('click', () => {
                    imagenesSeleccionadas.splice(newIdx, 1);
                renderizar();
                });
                cont.appendChild(btnDel);

                previewContenedor.appendChild(cont);
            });
        }


        // Manejo de nuevas imágenes
        if (inputImagenes) {
            inputImagenes.addEventListener('change', e => {
                const files = Array.from(e.target.files);
                files.forEach(file => {
                    if (!validarImagen(file)) return;
                    // duplicados globales
                    const exists = imagenesActuales.some(i=>i.url===file.name) ||
                                   imagenesSeleccionadas.some(i=>i.archivo.name===file.name);
                    if (exists) {
                        mostrarAlerta('Imagen ya agregada', 'error');
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = evt => {
                        imagenesSeleccionadas.push({
                            archivo: file,
                            base64: evt.target.result,
                            descripcion: '',
                            url: file.name // temp id
                        });
                        renderizar();
                    };
                    reader.readAsDataURL(file);
                });
                inputImagenes.value = '';
            });
        }

        // Actualizar orden al arrastrar (drag and drop)
        previewContenedor.addEventListener('dragstart', e => e.target.classList.add('dragging'));
        previewContenedor.addEventListener('dragend', e => {
            e.target.classList.remove('dragging');
            const dragging = previewContenedor.querySelector('.dragging');
            const siblings = [...previewContenedor.querySelectorAll('.preview-imagen:not(.dragging)')];
            const after = siblings.find(sib => sib.getBoundingClientRect().top > dragging.getBoundingClientRect().top);
            previewContenedor.insertBefore(dragging, after || null);
            // reordenar arrays
            const combined = [...imagenesActuales, ...imagenesSeleccionadas];
            const newActuales = combined.filter(i=>i.actual);
            const newNuevas = combined.filter(i=>!i.actual);
            imagenesActuales = newActuales;
            imagenesSeleccionadas = newNuevas;
            renderizar();
        });
        
        // Envío del formulario
        if (form) {
            form.addEventListener('submit', e => {
                e.preventDefault();
                // validaciones
                const incompletas = [...imagenesActuales, ...imagenesSeleccionadas]
                    .some(i=>!i.descripcion || !i.descripcion.trim());
                if (incompletas) {
                    mostrarAlerta('Rellena todas las descripciones', 'error');
                    return;
                }
                const fd = new FormData(form);
                // actuales
                imagenesActuales.forEach((img, i) => {
                    fd.append(`actuales[${i}][id]`, img.id);
                    fd.append(`actuales[${i}][descripcion]`, img.descripcion);
                    fd.append(`actuales[${i}][orden]`, i);
                    fd.append(`actuales[${i}][eliminada]`, '0');
                });
                // eliminadas
                imagenesAEliminar.forEach((id, i) => {
                    fd.append(`eliminadas[${i}]`, id);
                });
                // nuevas
                imagenesSeleccionadas.forEach((img, i) => {
                    fd.append(`imagenes[${i}]`, img.archivo);
                    fd.append(`descripciones[${i}]`, img.descripcion);
                    fd.append(`ordenes[${i}]`, imagenesActuales.length + i);
                    fd.append(`is_main[${i}]`, i===0 ? '1' : '0');
                });

                
                console.log('📨 formData:', Array.from(fd.entries()));
                

                fetch(form.action, { method: 'POST', body: fd, headers: {'X-Requested-With':'XMLHttpRequest'} })
                .then(res=>res.text())
                .then(text => {
                    console.log("Respuesta del servidor:", text);
                    try {
                        const data = JSON.parse(text);
                        if (data.status === 'success') {
                            mostrarAlerta('Producto actualizado correctamente', 'exito');
                            setTimeout(() => {
                                window.location.href = data.redirect || '/admin/productos';
                            }, 1500);
                        } else {
                            mostrarAlerta(data.mensaje || 'Error al actualizar producto.', 'error');
                        }
                    } catch (error) {
                        console.error('❌ JSON.parse falló:', err);
                        mostrarAlerta('Respuesta inesperada del servidor.', 'error');
                    }
                });
            });
        }
        renderizar();
    });
})();