<?php
session_start();
require 'connect.php';
require 'layout.php';

$msg = '';

// login
if (isset($_POST['prijava'])) {
    $stmt = mysqli_prepare($dbc, "SELECT korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime=?");
    mysqli_stmt_bind_param($stmt, 's', $_POST['username']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $dbUser, $dbPass, $dbRazina);
    mysqli_stmt_fetch($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0 && password_verify($_POST['lozinka'], $dbPass)) {
        $_SESSION['username'] = $dbUser;
        $_SESSION['razina']   = $dbRazina;
    } else {
        $msg = 'Pogrešni podaci. <a href="registracija.php">Registriraj se</a>';
    }
}

// logout
if (isset($_GET['odjava'])) {
    session_destroy();
    header('Location: administrator.php');
    exit;
}

// delete
if (isset($_SESSION['razina'], $_POST['delete']) && $_SESSION['razina'] == 1) {
    $id = (int)$_POST['id'];
    $stmt = mysqli_prepare($dbc, "DELETE FROM vijesti WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $msg = 'Vijest obrisana.';
}

// update
if (isset($_SESSION['razina'], $_POST['update']) && $_SESSION['razina'] == 1) {
    $id     = (int)$_POST['id'];
    $slika  = $_POST['cur_slika'];
    $arhiva = isset($_POST['archive']) ? 1 : 0;
    if (!empty($_FILES['pphoto']['name'])) {
        $slika = basename($_FILES['pphoto']['name']);
        move_uploaded_file($_FILES['pphoto']['tmp_name'], IMG . $slika);
    }
    $stmt = mysqli_prepare($dbc, "UPDATE vijesti SET naslov=?,sazetak=?,tekst=?,slika=?,kategorija=?,arhiva=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'sssssii', $_POST['title'], $_POST['about'], $_POST['content'], $slika, $_POST['category'], $arhiva, $id);
    mysqli_stmt_execute($stmt);
    $msg = 'Vijest ažurirana.';
}

header_html("Administracija – L'OBS");
if ($msg) echo "<p class='msg'>$msg</p>";
?>

<?php if (!isset($_SESSION['username'])): ?>

// forma za prijavu
    <section class="form-section">
        <h2>Prijava</h2>
        <form action="administrator.php" method="POST">
            <div class="form-item"><label>Korisničko ime</label><input type="text" name="username" autofocus></div>
            <div class="form-item"><label>Lozinka</label><input type="password" name="lozinka"></div>
            <div class="form-item"><button type="submit" name="prijava">Prijava</button></div>
        </form>
        <p style="margin-top:15px;font-size:14px;">Nemate račun? <a href="registracija.php">Registriraj se</a></p>
    </section>

<?php elseif ($_SESSION['razina'] == 0): ?>

    ne admin panel
    <p class="msg">Bok <?= htmlspecialchars($_SESSION['username']) ?>! Nemate administratorska prava.
    <a href="administrator.php?odjava=1">Odjava</a></p>

<?php else: ?>

    admin panel
    <p style="text-align:right;font-size:14px;margin-bottom:15px;">
        Prijavljeni: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
        | <a href="unos.php">Dodaj vijest</a>
        | <a href="administrator.php?odjava=1">Odjava</a>
    </p>

    <?php $r = mysqli_query($dbc, "SELECT * FROM vijesti ORDER BY id DESC");
    while ($v = mysqli_fetch_assoc($r)): ?>

    <form enctype="multipart/form-data" action="administrator.php" method="POST"
          style="background:white;border:1px solid #ddd;padding:20px;margin-bottom:25px;">
        <input type="hidden" name="id" value="<?= $v['id'] ?>">
        <input type="hidden" name="cur_slika" value="<?= htmlspecialchars($v['slika']) ?>">
        <div class="form-item"><label>Naslov</label>
            <input type="text" name="title" value="<?= htmlspecialchars($v['naslov']) ?>"></div>
        <div class="form-item"><label>Kratki sadržaj</label>
            <textarea name="about" rows="3"><?= htmlspecialchars($v['sazetak']) ?></textarea></div>
        <div class="form-item"><label>Sadržaj</label>
            <textarea name="content" rows="5"><?= htmlspecialchars($v['tekst']) ?></textarea></div>
        <div class="form-item"><label>Slika</label>
            <?php if ($v['slika']): ?>
                <img src="<?= IMG . htmlspecialchars($v['slika']) ?>" style="width:70px;height:50px;object-fit:cover;display:block;margin-bottom:6px;">
            <?php endif; ?>
            <input type="file" name="pphoto" accept="image/*"></div>
        <div class="form-item"><label>Kategorija</label>
            <select name="category">
                <option value="Politique"   <?= $v['kategorija']==='Politique'  ?'selected':'' ?>>Politique</option>
                <option value="Immobilier"  <?= $v['kategorija']==='Immobilier' ?'selected':'' ?>>Immobilier</option>
            </select></div>
        <div class="form-item"><label>
            <input type="checkbox" name="archive" <?= $v['arhiva'] ? 'checked' : '' ?>> Arhivirano
        </label></div>
        <div class="form-item">
            <button type="reset">Poništi</button>
            <button type="submit" name="update" class="btn-edit">Izmijeni</button>
            <button type="submit" name="delete" class="btn-delete" onclick="return confirm('Obrisati?')">Obriši</button>
        </div>
    </form>

    <?php endwhile; ?>

<?php endif; ?>

<?php footer_html(); ?>
