<?php
require_once 'includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $kode = trim($_POST['kode'] ?? '');
  $nama = trim($_POST['nama'] ?? '');
  $stok = trim($_POST['stok'] ?? '');
  $tipe = trim($_POST['tipe'] ?? '');

  if ($kode === '' || $nama === '' || $stok === '') {
    $error = 'Kode barang, nama barang, dan stok wajib diisi.';
  } elseif (!ctype_digit($stok)) {
    $error = 'Stok harus berupa angka bulat positif atau nol.';
  } else {

    $barang = getBarang();

    $barang[] = [
      'id' => uniqid(),
      'kode' => $kode,
      'nama' => $nama,
      'stok' => (int)$stok,
      'tipe' => $tipe
    ];

    saveBarang($barang);

    header('Location: data.php');
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Barang</title>
  <link rel="stylesheet" href="assets/style.css">
</head>

<body>

  <header class="header">
    <h1>Sistem Inventaris Barang</h1>
    <p>Kelola data dan stok barang dengan mudah.</p>
  </header>

  <main class="container">

    <div class="page-heading">
      <div>
        <h2>Tambah Data Barang</h2>
        <p>Masukkan informasi barang baru.</p>
      </div>
    </div>

    <section class="form-box">

      <?php if ($error !== ''): ?>
        <div class="alert">
          <?= e($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" id="formBarang">
        <div class="form-group">
          <label for="kode">Kode Barang</label>
          <input
            type="text"
            id="kode"
            name="kode"
            placeholder="Contoh: BRG001"
            required>
        </div>
        <div class="form-group">
          <label for="nama">Nama Barang</label>
          <input
            type="text"
            id="nama"
            name="nama"
            placeholder="Masukkan nama barang"
            value="<?= e($_POST['nama'] ?? '') ?>"
            required>
        </div>

        <div class="form-group">
          <label for="stok">Stok</label>
          <input
            type="number"
            id="stok"
            name="stok"
            placeholder="Masukkan jumlah stok"
            min="0"
            step="1"
            value="<?= e($_POST['stok'] ?? '') ?>"
            required>
        </div>

        <div class="form-group">
          <label for="tipe">
            Tipe Barang
            <span class="optional">(Opsional)</span>
          </label>

          <input
            type="text"
            id="tipe"
            name="tipe"
            placeholder="Masukkan tipe barang"
            value="<?= e($_POST['tipe'] ?? '') ?>">
        </div>

        <div class="form-actions">
          <a href="data.php" class="btn btn-secondary">
            Batal
          </a>

          <button type="submit" class="btn btn-primary">
            Simpan Barang
          </button>
        </div>

      </form>

    </section>

  </main>

  <footer class="footer">
    <p>&copy; 2026 Sistem Inventaris Barang</p>
  </footer>

  <script>
    document.getElementById('formBarang').addEventListener('submit', function(event) {
      const stok = document.getElementById('stok').value;

      if (stok === '' || Number(stok) < 0 || !Number.isInteger(Number(stok))) {
        alert('Stok harus berupa angka bulat dan tidak boleh negatif.');
        event.preventDefault();
      }
    });
  </script>

</body>

</html>