<?php

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function pagina_actual($path) : bool {
    return str_contains($_SERVER['REQUEST_URI'] ?? '/', $path) ? true: false;
}

function is_auth() : bool {
    return isset($_SESSION['nombre']) && !empty($_SESSION);
}

function is_admin() : bool {
    return isset($_SESSION['admin']) && !empty ($_SESSION['admin']);
}

function aos_animacion() {
    $efectos = ['fade-up', 'fade-down', 'fade-left', 'fade-right', 'flip-up', 'flip-down', 'flip-left', 'flip-right'];

    $efecto = array_rand($efectos, 1);
    echo ' data-aos="' . $efectos[$efecto] . '" ';


}