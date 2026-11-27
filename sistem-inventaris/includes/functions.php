<?php

function getBarang()
{
  $file = __DIR__ . '/../data/barang.json';

  if (!file_exists($file)) {
    file_put_contents($file, '[]');
  }

  $data = json_decode(file_get_contents($file), true);

  return is_array($data) ? $data : [];
}

function saveBarang($barang)
{
  $file = __DIR__ . '/../data/barang.json';

  file_put_contents(
    $file,
    json_encode($barang, JSON_PRETTY_PRINT),
    LOCK_EX
  );
}

function e($value)
{
  return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function cariBarang($id)
{
  $barang = getBarang();

  foreach ($barang as $item) {
    if ($item['id'] === $id) {
      return $item;
    }
  }

  return null;
}
