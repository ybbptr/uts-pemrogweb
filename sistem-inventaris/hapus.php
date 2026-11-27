
<?php
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $id = $_POST['id'] ?? '';

  $barang = getBarang();

  $barang = array_filter($barang, function ($item) use ($id) {
    return $item['id'] !== $id;
  });

  saveBarang(array_values($barang));
}

header('Location: data.php');
exit;
