<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Perpustakaan')</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f6f9; }
        header { background: #1e293b; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: #cbd5e1; text-decoration: none; margin-right: 20px; font-weight: bold; }
        nav a:hover { color: white; }
        .container { max-width: 1000px; margin: 30px auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .success { background: #d1fae5; color: #065f46; padding: 12px; border-radius: 4px; margin-bottom: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 16px; }
        th, td { border: 1px solid #e2e8f0; padding: 10px 12px; text-align: left; }
        th { background: #f8fafc; }
        .btn { display: inline-block; padding: 8px 16px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-danger { background: #dc2626; }
        .error { color: #b91c1c; font-size: 14px; margin-top: 4px; }
        form.inline { display: inline; }
    </style>
</head>
<body>

    <header>
        <h2>Perpustakaan Digital</h2>
        <nav>
            <a href="{{ route('books.index') }}">Buku</a>
            <a href="{{ route('categories.index') }}">Kategori</a>
            <a href="{{ route('members.index') }}">Anggota</a>
            <a href="{{ route('loans.index') }}">Peminjaman</a>
        </nav>
    </header>

    <div class="container">
        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>

</body>
</html>
```[cite: 4]

---

### **Langkah 2: Hubungkan View Pertemuan 5 ke Master Layout**[cite: 4]

Ubah view yang sudah dibuat agar menggunakan `@extends('layouts.app')` dan `@section('content')`[cite: 4].

#### 1. Berkas `resources/views/categories/index.blade.php`[cite: 4]
```blade
@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Daftar Kategori</h1>
        <a href="{{ route('categories.create') }}" class="btn">+ Tambah Kategori</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->nama_kategori }}</td>
                    <td>{{ $category->deskripsi ?? '-' }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category->id) }}">Edit</a> |
                        <form class="inline" action="{{ route('categories.destroy', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:red; cursor:pointer;" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Belum ada data kategori.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 16px;">
        {{ $categories->links() }}
    </div>
@endsection
```[cite: 4]

#### 2. Berkas `resources/views/categories/create.blade.php`[cite: 4]
```blade
@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <h1>Tambah Kategori</h1>
    <p><a href="{{ route('categories.index') }}">&larr; Kembali</a></p>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 15px;">
            <label for="nama_kategori"><strong>Nama Kategori</strong></label>
            <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori') }}" style="width:100%; padding:8px; margin-top:5px;">
            @error('nama_kategori') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="deskripsi"><strong>Deskripsi (opsional)</strong></label>
            <textarea name="deskripsi" id="deskripsi" rows="4" style="width:100%; padding:8px; margin-top:5px;">{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn">Simpan</button>
    </form>
@endsection
```[cite: 4]

#### 3. Berkas `resources/views/books/index.blade.php`[cite: 4]
```blade
@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Daftar Buku</h1>
        <a href="{{ route('books.create') }}" class="btn">+ Tambah Buku</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Stok</th>
                <th>ID Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>{{ $book->judul }}</td>
                    <td>{{ $book->penulis }}</td>
                    <td>{{ $book->penerbit }}</td>
                    <td>{{ $book->tahun_terbit }}</td>
                    <td>{{ $book->stok }}</td>
                    <td>{{ $book->category_id }}</td>
                    <td>
                        <a href="{{ route('books.show', $book->id) }}">Detail</a> |
                        <a href="{{ route('books.edit', $book->id) }}">Edit</a> |
                        <form class="inline" action="{{ route('books.destroy', $book->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:red; cursor:pointer;" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8">Belum ada data buku.</td></tr>
            @endforelse
        </tbody>
    </table>

{{-- Letakkan ini di bawah tag </table> --}}
{{ $categories->links() }}
```

    <div style="margin-top: 16px;">
        {{ $books->links() }}
    </div>
@endsection
```[cite: 4]

---

### **Checkpoint Git & Commit (Gabungan Pertemuan 4 & 5)**[cite: 4]

Simpan seluruh perubahan tampilan baru ini ke dalam Git[cite: 4]:

```cmd
git add .
git commit -m "[P-4 & P-5] integrasi master layout blade dan crud database selesai"
git push origin dev