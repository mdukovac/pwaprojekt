<?php
require 'connect.php';
require 'layout.php';
session_start();

$msg = ''; $ok = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['pass'] !== $_POST['passRep']) {
        $msg = 'Lozinke se ne podudaraju!';
    } else {
        $stmt = mysqli_prepare($dbc, "SELECT id FROM korisnik WHERE korisnicko_ime=?");
        mysqli_stmt_bind_param($stmt, 's', $_POST['username']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $msg = 'Korisničko ime već postoji!';
        } else {
            $hash = password_hash($_POST['pass'], PASSWORD_BCRYPT);
            $razina = 0;
            $stmt = mysqli_prepare($dbc, "INSERT INTO korisnik (ime,prezime,korisnicko_ime,lozinka,razina) VALUES (?,?,?,?,?)");
            mysqli_stmt_bind_param($stmt, 'ssssi', $_POST['ime'], $_POST['prezime'], $_POST['username'], $hash, $razina);
            mysqli_stmt_execute($stmt);
            $ok = true;
        }
    }
}

header_html("Registracija – L'OBS");
?>
<section class="form-section">
    <h2>Registracija</h2>
    <?php if ($ok): ?>
        <p class="msg msg-success">Uspješno registrirani! <a href="administrator.php">Prijavi se</a></p>
    <?php else: ?>
        <?php if ($msg): ?><p class="msg msg-error"><?= htmlspecialchars($msg) ?></p><?php endif; ?>
        <form action="registracija.php" method="POST">
            <div class="form-item"><label>Ime</label><input type="text" name="ime" required></div>
            <div class="form-item"><label>Prezime</label><input type="text" name="prezime" required></div>
            <div class="form-item"><label>Korisničko ime</label><input type="text" name="username" required></div>
            <div class="form-item"><label>Lozinka</label><input type="password" name="pass" required></div>
            <div class="form-item"><label>Ponovite lozinku</label><input type="password" name="passRep" required></div>
            <div class="form-item"><button type="submit">Registriraj se</button></div>
        </form>
    <?php endif; ?>
</section>
<?php footer_html(); ?>
