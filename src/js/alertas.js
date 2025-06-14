export function mostrarAlerta(mensaje, tipo = 'error', contenedor = null) {
    const alerta = document.createElement('div');
    alerta.classList.add('alerta');

    if (tipo === 'error') {
        alerta.classList.add('alerta__error');
    }else if (tipo === 'exito') {
        alerta.classList.add('alerta__exito');
    }
    alerta.textContent = mensaje;

    const destino = contenedor || document.querySelector('#miFormulario') || document.body;
    destino.prepend(alerta);

    setTimeout(() => alerta.remove(), 5000);
}