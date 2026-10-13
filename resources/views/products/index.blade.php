<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f3f5f9; color: #243047; }
        header { background: #17243b; color: white; padding: 22px 5%; }
        header h1 { margin: 0 0 7px; }
        header p { margin: 0; color: #cbd5e1; }
        main { max-width: 1200px; margin: 28px auto; padding: 0 20px; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 22px; }
        .stat, .panel { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 3px 14px #1720330b; }
        .stat span { color: #68758a; font-size: 14px; }
        .stat h2 { margin: 10px 0 0; }
        .toolbar { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; }
        input, select { padding: 11px; border: 1px solid #d6dce5; border-radius: 7px; }
        .toolbar input { flex: 1; min-width: 180px; }
        .btn { display: inline-block; border: 0; padding: 11px 14px; border-radius: 7px; background: #f28c28; color: white; text-decoration: none; cursor: pointer; font-size: 14px; }
        .btn-dark { background: #263751; }
        .btn-red { background: #c0392b; }
        .btn-small { padding: 7px 9px; font-size: 12px; margin: 2px; }
        .success { padding: 12px; margin-bottom: 15px; background: #dff6e8; color: #17683a; border-radius: 8px; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 750px; }
        th, td { padding: 13px 10px; border-bottom: 1px solid #edf0f4; text-align: left; }
        th { background: #f8fafc; color: #526078; font-size: 13px; }
        .badge { display: inline-block; padding: 6px 9px; border-radius: 20px; font-size: 12px; }
        .safe { background: #dcfce7; color: #166534; }
        .low { background: #fee2e2; color: #991b1b; }
        .muted { color: #6b7280; }
        .pagination { margin-top: 18px; }
        .pagination a, .pagination span { display: inline-block; padding: 7px 10px; border: 1px solid #ddd; border-radius: 5px; margin: 2px; text-decoration: none; color: #243047; }
        .pagination span[aria-current="page"] { background: #263751; color: white; }
        form.inline { display: inline; }
    </style>
</head>
<body>
<header>
    <h1>Inventory Management</h1>
    <p>Kelola produk, kategori, dan stok inventaris.</p>
</header>

<main>
    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <section class="stats">
        <div class="stat"><span>Total Produk</span><h2>{{ $totalProducts }}</h2></div>
        <div class="stat"><span>Total Kategori</span><h2>{{ $totalCategories }}</h2></div>
        <div class="stat"><span>Total Stok</span><h2>{{ $totalStock }}</h2></div>
        <div class="stat"><span>Produk Stok Minimum</span><h2>{{ $lowStock }}</h2></div>
    </section>

    <section class="panel">
        <h2>Daftar Produk</h2>

        <form class="toolbar" method="GET" action="{{ route('products.index') }}">
            <input
                type="text"
                name="search"
                placeholder="Cari nama, SKU, atau kategori..."
                value="{{ $search }}"
            >

            <select name="sort">
                <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Terbaru</option>
                <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>Nama A–Z</option>
                <option value="stock" {{ $sort === 'stock' ? 'selected' : '' }}>Stok terendah</option>
                <option value="price" {{ $sort === 'price' ? 'selected' : '' }}>Harga terendah</option>
            </select>

            <button class="btn btn-dark" type="submit">Cari / Urutkan</button>
            <a class="btn" href="{{ route('products.create') }}">+ Tambah Produk</a>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>SKU</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Status Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $products->firstItem() + $loop->index }}</td>
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
                            <td>
                                <a class="btn btn-dark btn-small" href="{{ route('products.show', $product) }}">Detail</a>
                                <a class="btn btn-small" href="{{ route('products.edit', $product) }}">Edit</a>
                                <form class="inline" action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-red btn-small" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="muted">Belum ada produk. Klik Tambah Produk untuk memasukkan data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">{{ $products->links() }}</div>
    </section>
</main>
</body>
</html>
