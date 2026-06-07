<div class="form-row">
    <div class="form-group">
        <label>Nomor Anggota *</label>
        <input type="text" name="nomor_anggota" value="{{ old('nomor_anggota', $anggota->nomor_anggota ?? '') }}"
            placeholder="ANG-001">
        @error('nomor_anggota') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label>Nama Lengkap *</label>
        <input type="text" name="nama" value="{{ old('nama', $anggota->nama ?? '') }}">
        @error('nama') <div class="field-error">{{ $message }}</div> @enderror
    </div>
</div>
<div class="form-row">
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $anggota->email ?? '') }}">
        @error('email') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label>Telepon</label>
        <input type="text" name="telepon" value="{{ old('telepon', $anggota->telepon ?? '') }}">
        @error('telepon') <div class="field-error">{{ $message }}</div> @enderror
    </div>
</div>
<div class="form-row">
    <div class="form-group">
        <label>Tanggal Daftar *</label>
        <input type="date" name="tanggal_daftar"
            value="{{ old('tanggal_daftar', isset($anggota) ? $anggota->tanggal_daftar->format('Y-m-d') : date('Y-m-d')) }}">
        @error('tanggal_daftar') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label>Status *</label>
        <select name="status">
            <option value="aktif" @selected(old('status', $anggota->status ?? 'aktif') === 'aktif')>Aktif</option>
            <option value="nonaktif" @selected(old('status', $anggota->status ?? '') === 'nonaktif')>Non-Aktif</option>
        </select>
        @error('status') <div class="field-error">{{ $message }}</div> @enderror
    </div>
</div>
<div class="form-group">
    <label>Alamat</label>
    <textarea name="alamat" rows="3">{{ old('alamat', $anggota->alamat ?? '') }}</textarea>
</div>