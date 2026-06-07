<div class="form-row">
    <div class="form-group">
        <label>Kode Buku *</label>
        <input type="text" name="kode_buku" value="{{ old('kode_buku', $buku->kode_buku ?? '') }}"
            placeholder="Contoh: BK-001">
        @error('kode_buku') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label>Judul Buku *</label>
        <input type="text" name="judul" value="{{ old('judul', $buku->judul ?? '') }}" placeholder="Judul lengkap buku">
        @error('judul') <div class="field-error">{{ $message }}</div> @enderror
    </div>
</div>
<div class="form-row">
    <div class="form-group">
        <label>Pengarang *</label>
        <input type="text" name="pengarang" value="{{ old('pengarang', $buku->pengarang ?? '') }}">
        @error('pengarang') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label>Penerbit</label>
        <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit ?? '') }}">
        @error('penerbit') <div class="field-error">{{ $message }}</div> @enderror
    </div>
</div>
<div class="form-row">
    <div class="form-group">
        <label>Kategori *</label>
        <input type="text" name="kategori" value="{{ old('kategori', $buku->kategori ?? '') }}"
            placeholder="Contoh: Teknologi, Sastra">
        @error('kategori') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label>Tahun Terbit</label>
        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}" min="1900"
            max="{{ date('Y') }}">
        @error('tahun_terbit') <div class="field-error">{{ $message }}</div> @enderror
    </div>
</div>
<div class="form-row">
    <div class="form-group">
        <label>Stok Total *</label>
        <input type="number" name="stok_total" value="{{ old('stok_total', $buku->stok_total ?? 1) }}" min="1">
        @error('stok_total') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label>Cover Buku (gambar)</label>
        <input type="file" name="cover" accept="image/*">
        @error('cover') <div class="field-error">{{ $message }}</div> @enderror
        @if(!empty($buku?->cover_path))
            <div style="margin-top:8px;">
                <img src="{{ route('storage.file', $buku->cover_path) }}" width="80"
                    style="border-radius:6px;border:1px solid #D4C9B0;">
            </div>
        @endif
    </div>
</div>
<div class="form-group">
    <label>Deskripsi</label>
    <textarea name="deskripsi" rows="3"
        placeholder="Deskripsi singkat buku">{{ old('deskripsi', $buku->deskripsi ?? '') }}</textarea>
</div>