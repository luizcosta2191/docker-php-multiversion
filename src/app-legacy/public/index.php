<?php
echo "<h1>Bem-vindo ao App Legado!</h1>";
echo "<h3>Versão do PHP: <span style='color:red'>" . phpversion() . "</span></h3>";

$redis = new Redis();
$redis->connect('redis', 6379);
echo "Status do Redis: <b>" . ($redis->ping() ? "Conectado!" : "Falha") . "</b><br>";
?>
