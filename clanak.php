<?php
require 'connect.php';
require 'layout.php';

$id   = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($dbc, "SELECT * FROM vijesti WHERE id=?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$v = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$v) { header('Location: index.php'); exit; }

header_html($v['naslov']);
?>
<p class="breadcrumb">L'Obs &gt; <?= htmlspecialchars($v['kategorija']) ?></p>
<article class="full-article">
    <h1><?= htmlspecialchars($v['naslov']) ?></h1>
    <?php if ($v['slika']): ?><img src="<?= IMG . htmlspecialchars($v['slika']) ?>" alt=""><?php endif; ?>
    <p class="lead"><?= htmlspecialchars($v['sazetak']) ?></p>
    <div class="date">Publié le <?= htmlspecialchars($v['datum']) ?></div>
    <p><?= nl2br(htmlspecialchars($v['tekst'])) ?></p>
</article>
<?php footer_html(); ?>
