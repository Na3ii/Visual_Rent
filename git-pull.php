<?php
// git-pull.php
$secret = 'V.R-4dm1n15tr4c10n';
if ($_GET['key'] !== $secret) {
    http_response_code(403);
    exit('No autorizado');
}

$output = shell_exec('cd /home/u240592458/domains/visualrent.cl/public_html && git pull 2>&1');
echo "<pre>$output</pre>";
?>