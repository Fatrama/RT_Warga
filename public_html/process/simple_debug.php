<?php
echo "<h1>Simple Debug</h1>";
echo "<pre>";
print_r($_SERVER);
echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<h2>POST Data:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo "<h2>GET Data:</h2>";
    echo "<pre>";
    print_r($_GET);
    echo "</pre>";
} else {
    echo "<p>No request method detected</p>";
}
?>