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
	<a href="<?=site_url('Login')?>">Panel logowania</a> <br />
	<h1>Repertuar dla multikina</h1>
	<div>
		<?=$multikino?>
	</div>
</div>

</body>
</html>
