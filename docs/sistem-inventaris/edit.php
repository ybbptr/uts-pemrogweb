<?php
require_once 'includes/functions.php';

$id = $_GET['id'] ?? '';
$item = cariBarang($id);

if (!$item) {
  header('Location: data.php');
  exit;
}

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
    foreach ($barang as $data) {
      if ($data['kode'] === $kode && $data['id'] !== $id) {
        $error = 'Kode barang sudah digunakan.';
        break;
      }
    }

    foreach ($barang as &$data) {
      if ($data['id'] === $id) {
        $data['kode'] = $kode;
        $data['nama'] = $nama;
        $data['stok'] = (int)$stok;
        $data['tipe'] = $tipe;
        break;
      }
    }

    unset($data);

    saveBarang($barang);

    header('Location: data.php');
    exit;
  }

  $item['nama'] = $nama;
  $item['kode'] = $kode;
  $item['stok'] = $stok;
  $item['tipe'] = $tipe;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Barang</title>
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
        <h2>Edit Data Barang</h2>
        <p>Perbarui informasi barang.</p>
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
            value="<?= e($item['kode'] ?? '') ?>"
            required>
        </div>
        <div class="form-group">
          <label for="nama">Nama Barang</label>
          <input
            type="text"
            id="nama"
            name="nama"
            value="<?= e($item['nama']) ?>"
            required>
        </div>

        <div class="form-group">
          <label for="stok">Stok</label>
          <input
            type="number"
            id="stok"
            name="stok"
            min="0"
            step="1"
            value="<?= e($item['stok']) ?>"
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
            value="<?= e($item['tipe']) ?>">
        </div>

        <div class="form-actions">
          <a href="data.php" class="btn btn-secondary">
            Batal
          </a>

          <button type="submit" class="btn btn-primary">
            Simpan Perubahan
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