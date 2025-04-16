(function() {

    const whatsappFloat = document.querySelector('#whatsapp-float')
    const modalWhatsapp = document.createElement("DIV");
    modalWhatsapp.classList.add("modal-whatsapp");
        
    whatsappFloat.addEventListener("click", () => {
        
            modalWhatsapp.classList.add("mostrar-whatsapp");
            modalWhatsapp.classList.add("animate-fade-in");
            modalWhatsapp.innerHTML = `
                <div class="whatsapp__contenido ">
                    <div class="whatsapp__header">
                        <svg class="whatsapp__logo" width="150" height="35" viewBox="0 0 120 28" src="/img/whatsapp.svg" alt="Logo de WhatsApp"></svg>
                        <a class="whatsapp__cerrar">&times;</a>
                    </div>
                    <div class="whatsapp__body">
                        <div class="whatsapp__chat">
                             <p class="whatsapp__texto">Hola,<br>Comunicate con nosotros por WhatsApp!</p>
                        </div>
                        <div class="whatsapp__abrirChat">
                            <a href="https://wa.me/56920519944" class="whatsapp__boton" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
                                Abrir WhatsApp
                            </a>
                        </div>                           
                    </div>
                </div>
            `;
            document.body.appendChild(modalWhatsapp); // Asegúrate de que el modal esté en el DOM

        
    });
    // Cerrar modal al hacer clic en el botón de cerrar
    modalWhatsapp.addEventListener("click", (e) => {
        if(e.target.classList.contains('whatsapp__cerrar')) {
            modalWhatsapp.remove();
        }
    });

    // Cerrar modal al hacer clic fuera del contenido
    modalWhatsapp.addEventListener("click", (e) => {
        if (e.target === modalWhatsapp) {
            modalWhatsapp.remove();
        }
    });

})();