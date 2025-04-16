<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;
    public $empresa;
    public $telefono;
    public $mensaje;
    
    public function __construct($email, $nombre, $token, $empresa, $telefono, $mensaje)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
        $this->empresa = $empresa;
        $this->telefono = $telefono;
        $this->mensaje = $mensaje;
    }

    public function enviarConfirmacion() {

         // create a new object
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = $_ENV['EMAIL_HOST'];
         $mail->SMTPAuth = true;
         $mail->Port = $_ENV['EMAIL_PORT'];
         $mail->Username = $_ENV['EMAIL_USER'];
         $mail->Password = $_ENV['EMAIL_PASS'];
     
         $mail->setFrom('no-reply@visualrent.cl');
         $mail->addAddress($this->email, $this->nombre);
         $mail->Subject = 'Confirma tu Cuenta';

         // Set HTML
         $mail->isHTML(TRUE);
         $mail->CharSet = 'UTF-8';

         $contenido = '
            <html>
            <body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                    <table width="600" cellpadding="20" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                        <tr>
                        <td align="center">
                            <h2 style="color: #222;">¡Bienvenido a Visual Rent!</h2>
                            <p style="color: #555;">Hola <strong>' . $this->nombre . '</strong>, gracias por registrarte.</p>
                            <p style="color: #555;">Por favor confirma tu cuenta haciendo clic en el botón a continuación:</p>
                            <p>
                            <a href="' . $_ENV['HOST'] . '/confirmar-cuenta?token=' . $this->token . '" style="background-color: #5c6bc0; color: #fff; text-decoration: none; padding: 12px 20px; border-radius: 5px;">Confirmar Cuenta</a>
                            </p>
                            <p style="color: #999; font-size: 12px;">Si tú no creaste esta cuenta, puedes ignorar este mensaje.</p>
                        </td>
                        </tr>
                    </table>
                    </td>
                </tr>
                </table>
            </body>
            </html>';

         $mail->Body = $contenido;

         //Enviar el mail
         $mail->send();

    }

    public function enviarInstrucciones() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('no-reply@visualrent.cl');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Reestablece tu password';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '
            <html>
            <body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                    <table width="600" cellpadding="20" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                        <tr>
                        <td align="center">
                            <h2 style="color: #222;">Restablecimiento de Contraseña</h2>
                            <p style="color: #555;">Hola <strong>' . $this->nombre . '</strong>, has solicitado restablecer tu contraseña.</p>
                            <p style="color: #555;">Haz clic en el siguiente botón para continuar:</p>
                            <p>
                            <a href="' . $_ENV['HOST'] . '/recuperar?token=' . $this->token . '" style="background-color: #e53935; color: #fff; text-decoration: none; padding: 12px 20px; border-radius: 5px;">Reestablecer Contraseña</a>
                            </p>
                            <p style="color: #999; font-size: 12px;">Si tú no solicitaste este cambio, ignora este correo.</p>
                        </td>
                        </tr>
                    </table>
                    </td>
                </tr>
                </table>
            </body>
            </html>';
        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();
    }

    public function enviarFormularioContacto() {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('no-reply@visualrent.cl', 'Sitio Web VisualRent');
        $mail->addAddress('contacto@visualrent.cl'); // Correo de destino
    
        $mail->Subject = 'Nuevo mensaje desde el formulario de contacto';
    
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $fechaEnvio = date('d/m/Y H:i'); // Formato: 11/04/2025 14:30
    
        $contenido = '
            <html>
            <head>
                <style>
                    body {
                        font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
                        background-color: #f8f9fa;
                        padding: 20px;
                        margin: 0;
                    }
                    .container {
                        max-width: 600px;
                        background-color: #ffffff;
                        padding: 30px;
                        margin: auto;
                        border-radius: 10px;
                        border: 1px solid #e1e1e1;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                    }
                    h2 {
                        color: #333333;
                        margin-bottom: 20px;
                    }
                    .info {
                        margin-bottom: 20px;
                    }
                    .info p {
                        margin: 5px 0;
                        color: #555555;
                    }
                    .label {
                        font-weight: bold;
                        color: #000000;
                    }
                    .mensaje {
                        padding: 15px;
                        background-color: #f1f1f1;
                        border-left: 4px solid #007BFF;
                        color: #333;
                        white-space: pre-wrap;
                    }
                    .footer {
                        font-size: 12px;
                        color: #999;
                        text-align: center;
                        margin-top: 30px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h2>Nuevo mensaje de contacto desde el sitio web</h2>

                    <div class="info">
                        <p><span class="label">Fecha de envío:</span> ' . $fechaEnvio . '</p>
                        <p><span class="label">Nombre:</span> ' . htmlspecialchars($this->nombre) . '</p>
                        <p><span class="label">Empresa:</span> ' . htmlspecialchars($this->empresa) . '</p>
                        <p><span class="label">Email:</span> ' . htmlspecialchars($this->email) . '</p>
                        <p><span class="label">Teléfono:</span> ' . htmlspecialchars($this->telefono) . '</p>
                    </div>

                    <p><span class="label">Mensaje:</span></p>
                    <div class="mensaje">' . nl2br(htmlspecialchars($this->mensaje)) . '</div>

                    <div class="footer">
                        Visual Rent &copy; ' . date('Y') . ' | Este mensaje fue generado automáticamente desde el formulario de contacto.
                    </div>
                </div>
            </body>
            </html>';
    
        $mail->Body = $contenido;
    
        $mail->send();
    }

    public function enviarConfirmacionContactoUsuario() {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('no-reply@visualrent.cl', 'Visual Rent');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Hemos recibido tu mensaje';
    
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
    
        $contenido = '
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        padding: 20px;
                        margin: 0;
                    }
                    .container {
                        max-width: 600px;
                        background-color: #ffffff;
                        padding: 30px;
                        margin: auto;
                        border-radius: 10px;
                        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    }
                    h2 {
                        color: #333333;
                    }
                    p {
                        color: #555555;
                        line-height: 1.6;
                    }
                    .footer {
                        margin-top: 30px;
                        font-size: 12px;
                        color: #999999;
                        text-align: center;
                    }
                    .highlight {
                        color: #222222;
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h2>¡Hola ' . htmlspecialchars($this->nombre) . '!</h2>
                    <p>Gracias por contactarte con nosotros en <strong>Visual Rent</strong>.</p>
                    <p>Hemos recibido tu mensaje correctamente y nuestro equipo se pondrá en contacto contigo lo antes posible.</p>

                    <p><span class="highlight">Tu mensaje:</span><br>' . nl2br(htmlspecialchars($this->mensaje)) . '</p>

                    <p>Si tienes alguna duda adicional, puedes escribirnos directamente a <a href="mailto:contacto@visualrent.cl">contacto@visualrent.cl</a>.</p>

                    <div class="footer">
                        Visual Rent &copy; ' . date('Y') . ' | Este mensaje fue enviado automáticamente.
                    </div>
                </div>
            </body>
            </html>';
    
        $mail->Body = $contenido;
    
        $mail->send();
    }
}