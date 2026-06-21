<?php
require 'connect.php';
require 'layout.php';

$kat  = $_GET['kat'] ?? '';
$stmt = mysqli_prepare($dbc, "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija=? ORDER BY id DESC");
mysqli_stmt_bind_param($stmt, 's', $kat);
mysqli_stmt_execute($stmt);
$r = mysqli_stmt_get_result($stmt);

header_html($kat . " – L'OBS");
?>
<section>
    <h2><?= strtoupper(htmlspecialchars($kat)) ?></h2>
    <div class="articles">
    <?php while ($v = mysqli_fetch_assoc($r)): ?>
        <article>
            <img src="<?= IMG . htmlspecialchars($v['slika']) ?>" alt="">
            <h3><a href="clanak.php?id=<?= $v['id'] ?>"><?= htmlspecialchars($v['naslov']) ?></a></h3>
            <p><?= htmlspecialchars($v['kategorija']) ?> - <?= htmlspecialchars($v['datum']) ?></p>
        </article>
    <?php endwhile; ?>
    </div>
</section>
<?php footer_html(); ?>
