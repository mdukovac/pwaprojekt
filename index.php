<?php
require 'connect.php';
require 'layout.php';
header_html("L'OBS");

foreach (['Politique', 'Immobilier'] as $kat):
    $r = mysqli_query($dbc, "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='$kat' ORDER BY id DESC LIMIT 3");
?>
<section>
    <h2><?= strtoupper($kat) ?></h2>
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
<?php endforeach;

footer_html();
