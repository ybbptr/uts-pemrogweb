<?php
require_once 'includes/functions.php';

$barang = getBarang();

$keyword = isset($_GET['search'])
  ? trim($_GET['search'])
  : '';

if ($keyword !== '') {
  $barang = array_filter($barang, function ($item) use ($keyword) {
    return stripos($item['nama'], $keyword) !== false
      || stripos($item['kode'] ?? '', $keyword) !== false;
  });
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Barang - Sistem Inventaris</title>
  <link rel="stylesheet" href="assets/style.css">
</head>

<body>

  <header class="header">
    <h1>Sistem Inventaris Barang</h1>
  </header>

  <main class="container">

    <div class="page-heading">
      <div>
        <h2>Data Inventaris</h2>
        <p>Daftar barang yang tersedia.</p>
      </div>

      <a href="index.php" class="btn btn-secondary">
        Kembali
      </a>
    </div>

    <section class="content-box">

      <div class="toolbar">

        <form action="data.php" method="GET" class="search-form">
          <input
            type="text"
            name="search"
            placeholder="Cari nama atau kode barang..."
            value="<?= e($keyword) ?>">

          <button type="submit" class="btn btn-primary">
            Cari
          </button>

          <!-- <?php if ($keyword !== ''): ?>
            <a href="data.php" class="btn btn-secondary">
              Reset
            </a>
          <?php endif; ?> -->
        </form>

        <a href="tambah.php" class="btn btn-success">
          + Tambah Data
        </a>

      </div>

      <div class="table-wrapper">
        <table>
          <thead>
            <tr>
              <th>Kode Barang</th>
              <th>Stok</th>
              <th>Nama Barang</th>
              <th>Tipe</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody>

            <?php if (count($barang) > 0): ?>

              <?php foreach ($barang as $item): ?>

                <tr>
                  <td><?= e($item['kode']) ?></td>
                  <td><?= e($item['stok']) ?></td>

                  <td class="item-name">
                    <?= e($item['nama']) ?>
                  </td>
                  <td>
                    <?= e($item['tipe'] ?: '-') ?>
                  </td>

                  <td>
                    <div class="action-buttons">

                      <a
                        href="edit.php?id=<?= urlencode($item['id']) ?>"
                        class="btn btn-edit">
                        Edit
                      </a>

                      <form
                        action="hapus.php"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                        <input
                          type="hidden"
                          name="id"
                          value="<?= e($item['id']) ?>">

                        <button
                          type="submit"
                          class="btn btn-danger">
                          Hapus
                        </button>
                      </form>

                    </div>
                  </td>
                </tr>

              <?php endforeach; ?>

            <?php else: ?>

              <tr>
                <td colspan="5" class="empty-state">
                  <?= $keyword !== ''
                    ? 'Barang tidak ditemukan.'
                    : 'Belum ada data barang.' ?>
                </td>
              </tr>

            <?php endif; ?>

          </tbody>
        </table>
      </div>
    </section>

  </main>

  <footer class="footer">
    <p>Roby Putera Adhiguna Rantung - 17241022</p>
  </footer>

</body>

</html>