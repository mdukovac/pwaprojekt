<?php
function header_html($title = "L'OBS") { ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>L'OBS</h1></header>
<nav><ul>
    <li><a href="index.php">HOME</a></li>
    <li><a href="kategorija.php?kat=Politique">POLITIQUE</a></li>
    <li><a href="kategorija.php?kat=Immobilier">IMMOBILIERE</a></li>
    <li><a href="administrator.php">ADMINISTRACIJA</a></li>
</ul></nav>
<main>
<?php }

function footer_html() { ?>
</main>
<footer>
    <p>Marko Dukovac</p>
    <p>mdukovac@tvz.hr</p>
    <p>&copy; 2026</p>
</footer>
</body></html>
<?php }
