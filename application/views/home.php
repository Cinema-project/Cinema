<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>
</head>
<body>

<div id="container">
    Menu:
    <a href="<?=base_url()?>index.html">Panel logowania</a> <br />
    <h1>The Movie db</h1>
    <div>
        <h3>Kategorie</h3>
        <?=$themoviedbLista?>
    </div>
    <div>
        <h3>Np.:Akcja</h3>
        <?=$themoviedbAkcja?>
    </div>
    <div>
        <h3>Szczegóły:</h3>
        <?=$movieDetails?>
        <div>
            <img src="<?=$poster?>" />
        </div>
    </div>
    <h1>Repertuar dla multikina</h1>
    <div>
        <?=$multikino?>
    </div>
</div>

</body>
</html>
