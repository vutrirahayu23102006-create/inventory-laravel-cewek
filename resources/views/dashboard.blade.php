<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Inventory</title>

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f5f9;
            color: #243047;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 230px;
            background: #17243b;
            color: white;
            padding: 28px 18px;
        }
        .brand { font-size: 21px; font-weight: bold; margin-bottom: 35px; }
        .sidebar a {
            display: block;
            color: #d4dbea;
            text-decoration: none;
            padding: 13px 12px;
            border-radius: 8px;
            margin-bottom: 8px;
        }
        .sidebar a.active, .sidebar a:hover {
            background: #f28c28;
            color: white;
        }
        .main { margin-left: 230px; padding: 30px; }
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }
        .topbar h1 { margin: 0 0 8px; font-size: 28px; }
        .muted { color: #758198; }
        .btn {
            display: inline-block;
            padding: 12px 16px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            background: #f28c28;
            color: white;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 25px;
        }
        .card {
            background: white;
            padding: 22px;
            border-radius: 13px;
            box-shadow: 0 3px 15px #1720330b;
        }
        .card-label { color: #758198; font-size: 14px; }
        .card-number { font-size: 29px; font-weight: bold; margin-top: 12px; }
        .orange { border-top: 4px solid #f28c28; }
        .green { border-top: 4px solid #22a06b; }
        .purple { border-top: 4px solid #8b5cf6; }
        .red { border-top: 4px solid #e05252; }
        .panel {
            background: white;
            border-radius: 13px;
            padding: 22px;
            box-shadow: 0 3px 15px #1720330b;
        }
        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }
        .panel-heading h2 { margin: 0; font-size: 19px; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 650px; }
        th, td { padding: 14px 10px; border-bottom: 1px solid #edf0f4; text-align: left; }
        th { font-size: 13px; color: #758198; background: #f8fafc; }
        .badge { padding: 6px 9px; border-radius: 20px; font-size: 12px; white-space: nowrap; }
        .safe { background: #dcfce7; color: #166534; }
        .low { background: #fee2e2; color: #991b1b; }
        .empty { padding: 25px; text-align: center; color: #758198; }
        @media (max-width: 1050px) {
            .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 700px) {
            .sidebar { position: static; width: 100%; padding: 18px; }
            .brand { margin-bottom: 15px; }
            .sidebar a { display: inline-block; margin-right: 5px; }
            .main { margin-left: 0; padding: 18px; }
            .stats { grid-template-columns: 1fr 1fr; gap: 10px; }
            .card { padding: 15px; }
            .card-number { font-size: 23px; }
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="brand">Inventory App</div>
    <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
    <a href="{{ route('products.index') }}">Produk</a>
    <a href="{{ route('products.create') }}">Tambah Produk</a>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <h1>Dashboard</h1>
            <div class="muted">Ringkasan data inventaris kamu.</div>
        </div>
        <a class="btn" href="{{ route('products.create') }}">+ Tambah Produk</a>
    </div>

    <section class="stats">
        <div class="card orange">
            <div class="card-label">Total Produk</div>
            <div class="card-number">{{ $totalProducts }}</div>
        </div>

        <div class="card purple">
            <div class="card-label">Total Kategori</div>
            <div class="card-number">{{ $totalCategories }}</div>
        </div>

        <div class="card green">
            <div class="card-label">Total Stok Barang</div>
            <div class="card-number">{{ number_format($totalStock) }}</div>
        </div>

        <div class="card red">
            <div class="card-label">Produk Stok Minimum</div>
            <div class="card-number">{{ $lowStock }}</div>
        </div>
    </section>

    <section class="panel">
        <div class="panel-heading">
            <h2>Produk Terbaru</h2>
            <a class="btn" href="{{ route('products.index') }}">Lihat Semua</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>SKU</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category?->name ?? '-' }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                            <td>
                                @if ($product->stock <= $product->minimum_stock)
                                    <span class="badge low">Stok Minimum</span>
                                @else
                                    <span class="badge safe">Stok Aman</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada produk. Silakan tambahkan produk terlebih dahulu.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>

</body>
</html>
