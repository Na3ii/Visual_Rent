const extensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
const tamanoMaximoMB = 5;

function esExtensionValida(nombreArchivo) {
    const extension = nombreArchivo.split('.').pop().toLowerCase();
    return extensionesPermitidas.includes(extension);
}

function esTamanoValido(archivo) {
    return archivo.size <= tamanoMaximoMB * 1024 * 1024;
}

function validarImagen(archivo) {
    if (!esExtensionValida(archivo.name)) {
        mostrarAlerta(`Archivo no permitido: ${archivo.name}. Solo se permiten ${extensionesPermitidas.join(', ')}`, 'error');
        return false;
    }

    if (!esTamanoValido(archivo)) {
        mostrarAlerta(`El archivo ${archivo.name} excede los ${tamanoMaximoMB}MB permitidos`, 'error');
        return false;
    }

    return true;
}

export { validarImagen };
