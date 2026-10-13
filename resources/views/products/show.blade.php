<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <style>
        body { margin: 0; padding: 30px 15px; font-family: Arial, sans-serif; background: #f3f5f9; color: #243047; }
        .container { max-width: 700px; margin: auto; padding: 28px; background: white; border-radius: 14px; }
        .item { padding: 14px 0; border-bottom: 1px solid #edf0f4; }
        .item strong { display: inline-block; width: 180px; }
        .btn { display: inline-block; margin-top: 20px; padding: 11px 15px; border-radius: 7px; text-decoration: none; background: #263751; color: white; }
        .orange { background: #f28c28; }
    </style>
</head>
<body>
<div class="container">
    <h1>Detail Produk</h1>

    <div class="item"><strong>Nama Produk</strong> {{ $product->name }}</div>
    <div class="item"><strong>Kategori</strong> {{ $product->category?->name ?? '-' }}</div>
    <div class="item"><strong>Kode SKU</strong> {{ $product->sku }}</div>
    <div class="item"><strong>Harga</strong> Rp {{ number_format((float) $product->price, 0, ',', '.') }}</div>
    <div class="item"><strong>Stok</strong> {{ $product->stock }}</div>
    <div class="item"><strong>Minimum Stok</strong> {{ $product->minimum_stock }}</div>
    <div class="item">
        <strong>Status</strong>
        @if ($product->stock <= $product->minimum_stock)
            Stok Minimum
        @else
            Stok Aman
        @endif
    </div>
    <div class="item"><strong>Dibuat</strong> {{ $product->created_at->format('d-m-Y H:i') }}</div>

    <a class="btn" href="{{ route('products.index') }}">Kembali</a>
    <a class="btn orange" href="{{ route('products.edit', $product) }}">Edit Produk</a>
</div>
</body>
</html>
