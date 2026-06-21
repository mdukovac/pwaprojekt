<?php
require 'connect.php';
require 'layout.php';

$ok = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slika = '';
    if (!empty($_FILES['slika']['name'])) {
        $slika = basename($_FILES['slika']['name']);
        move_uploaded_file($_FILES['slika']['tmp_name'], IMG . $slika);
    }
    $arhiva = isset($_POST['archive']) ? 1 : 0;
    $datum  = date('d.m.Y.');
    $stmt = mysqli_prepare($dbc, "INSERT INTO vijesti (datum,naslov,sazetak,tekst,slika,kategorija,arhiva) VALUES (?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, 'ssssssi', $datum, $_POST['title'], $_POST['about'], $_POST['content'], $slika, $_POST['category'], $arhiva);
    mysqli_stmt_execute($stmt);
    $ok = true;
}

header_html("Unos – L'OBS");
?>
<section class="form-section">
    <h2>Unos nove vijesti</h2>
    <?php if ($ok): ?><p class="msg msg-success">Vijest je uspješno dodana!</p><?php endif; ?>
    <form action="unos.php" method="POST" enctype="multipart/form-data">
        <div class="form-item"><label>Naslov</label><input type="text" name="title" required></div>
        <div class="form-item"><label>Kratki sadržaj</label><textarea name="about" rows="4" required></textarea></div>
        <div class="form-item"><label>Sadržaj</label><textarea name="content" rows="8" required></textarea></div>
        <div class="form-item"><label>Kategorija</label>
            <select name="category">
                <option value="Politique">Politique</option>
                <option value="Immobilier">Immobilier</option>
            </select>
        </div>
        <div class="form-item"><label>Slika</label><input type="file" name="slika" accept="image/*"></div>
        <div class="form-item"><label><input type="checkbox" name="archive"> Arhiviraj</label></div>
        <div class="form-item">
            <button type="reset">Poništi</button>
            <button type="submit">Pošalji</button>
        </div>
    </form>
</section>
<?php footer_html(); ?>
