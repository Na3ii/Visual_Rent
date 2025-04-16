(function() {

    const caracteristicasInput = document.querySelector('#caracteristicas_input')

    if(caracteristicasInput) {

        const caracteristicasDiv = document.querySelector('#caracteristicas');
        const caracteristicasInputHidden = document.querySelector('[name="caracteristicas"]');

        let caracteristicas = [];

        // Recuperar del input oculto
        if(caracteristicasInputHidden.value !== '') {
            caracteristicas = caracteristicasInputHidden.value.split(',');
            mostrarCaracteristicas();
        }
 
        // Escuchar los cambios en el input
        caracteristicasInput.addEventListener('keypress', guardarCaracteristica)

        function guardarCaracteristica(e) {
            if(e.keyCode === 13) {
                if(e.target.value.trim() === '' || e.target.value < 1) { 
                    return
                }
                e.preventDefault();
                caracteristicas = [...caracteristicas, e.target.value.trim()];
                caracteristicasInput.value = '';
                mostrarCaracteristicas();
            }
        }

        function mostrarCaracteristicas() {
            caracteristicasDiv.textContent = '';
            caracteristicas.forEach(caracteristica => {
                const etiqueta = document.createElement('LI');
                etiqueta.classList.add('formulario__caracteristica')
                etiqueta.textContent = caracteristica;
                etiqueta.ondblclick = eliminarCaracteristica
                caracteristicasDiv.appendChild(etiqueta)
            })
            actualizarInputHidden();
        }   

        function eliminarCaracteristica(e) {
            e.target.remove()
            caracteristicas = caracteristicas.filter(caracteristica => caracteristica !== e.target.textContent)
            actualizarInputHidden();
        }

        function actualizarInputHidden() {
           caracteristicasInputHidden.value = caracteristicas.toString();
        }
    }

})();