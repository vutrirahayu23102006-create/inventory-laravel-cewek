<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 30px 15px; background: #f3f5f9; font-family: Arial, sans-serif; color: #243047; }
        .container { max-width: 700px; margin: auto; padding: 28px; background: white; border-radius: 14px; box-shadow: 0 5px 20px #17203312; }
        h1 { margin-top: 0; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 7px; font-weight: bold; }
        input, select { width: 100%; padding: 12px; border: 1px solid #d5dbe5; border-radius: 8px; font-size: 15px; }
        .error { color: #c62828; font-size: 13px; margin-top: 5px; }
        .buttons { display: flex; gap: 10px; margin-top: 24px; }
        button, .back { padding: 12px 18px; border: 0; border-radius: 8px; font-size: 14px; text-decoration: none; cursor: pointer; }
        button { background: #f28c28; color: white; }
        .back { background: #e9edf4; color: #243047; }
    </style>
</head>
<body>
<div class="container">
    <h1>Tambah Produk</h1>
    <p>Masukkan informasi produk inventaris baru.</p>

    @if ($errors->any())
        <div class="error">
            <strong>Periksa kembali data berikut:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nama Produk</label>
            <input id="name" name="name" value="{{ old('name') }}" required>
            @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Kategori</label>
            <select id="category_id" name="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="sku">Kode Produk (SKU)</label>
            <input id="sku" name="sku" value="{{ old('sku') }}" required>
            @error('sku') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="price">Harga (Rp)</label>
            <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" step="0.01" required>
            @error('price') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="stock">Stok</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" min="0" required>
            @error('stock') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="minimum_stock">Batas Minimum Stok</label>
            <input type="number" id="minimum_stock" name="minimum_stock" value="{{ old('minimum_stock', 5) }}" min="0" required>
            @error('minimum_stock') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="buttons">
            <button type="submit">Simpan Produk</button>
            <a class="back" href="{{ route('products.index') }}">Kembali</a>
        </div>
    </form>
</div>
</body>
</html>
