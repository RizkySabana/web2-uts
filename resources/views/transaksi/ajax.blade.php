@extends('layouts.app')
@section('title', 'Transaksi AJAX')
@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-bolt"></i> Transaksi AJAX</h1>
            <p class="page-subtitle">Kelola transaksi secara dinamis tanpa reload halaman</p>
        </div>
    </div>

    <div class="card-box">
        <div id="ajax-alert"></div>
        <div class="row mb-3">
            <div class="col-md-5">
                <input type="text" id="keyword" class="form-control" placeholder="Cari judul buku / nama anggota...">
            </div>
            <div class="col-md-3">
                <select id="filter-status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="dipinjam">Dipinjam</option>
                    <option value="dikembalikan">Dikembalikan</option>
                </select>
            </div>
        </div>
        <p id="statusText" style="color:#6B7280;font-size:13px">Memuat data...</p>
        <div id="loading" style="display:none;color:#1B6B5A"><i class="fas fa-spinner fa-spin"></i> Memuat data...</div>
        <div id="table-container">
            @include('transaksi.partials._table_ajax', ['transaksis' => $transaksis])
        </div>
    </div>

    <!-- Modal Detail -->
    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg"> {{-- tambah modal-lg --}}
            <div class="modal-content">
                <div class="modal-header" style="background:#1B6B5A;color:white">
                    <h5 class="modal-title"><i class="fas fa-info-circle"></i> Detail Transaksi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailContent">Memuat...</div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            let typingTimer = null;
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

            function escHtml(v) { return $('<div>').text(v ?? '').html(); }
            function showAlert(type, msg) { $('#ajax-alert').html(`<div class="alert alert-${type} mt-2">${escHtml(msg)}</div>`); }

            function loadData(pageUrl = null) {
                $('#loading').show();
                $.get(pageUrl ?? "{{ route('ajax.transaksi.data') }}", {
                    keyword: $('#keyword').val(),
                    status: $('#filter-status').val()
                }).done(function (res) {
                    $('#table-container').html(res.html);
                    $('#statusText').text('Total: ' + res.total + ' data');
                }).fail(function () {
                    showAlert('danger', 'Gagal memuat data.');
                }).always(function () { $('#loading').hide(); });
            }

            loadData();

            $('#keyword').on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => loadData(), 400);
            });
            $('#filter-status').on('change', () => loadData());

            $(document).on('click', '#table-container .pagination a', function (e) {
                e.preventDefault();
                const url = $(this).attr('href');
                if (url) loadData(url);
            });

            // ← GANTI BAGIAN DETAIL DENGAN YANG BARU INI
            $(document).on('click', '.btn-detail-ajax', function () {
                const id = $(this).data('id');
                $('#detailContent').html('<div class="text-center p-3"><i class="fas fa-spinner fa-spin"></i> Memuat...</div>');
                $.get(`/ajax/transaksi/${id}/detail`).done(function (d) {
                    let coverHtml = d.cover_url
                        ? `<img src="${d.cover_url}" alt="Cover Buku"
                            style="width:120px;height:170px;object-fit:cover;border-radius:8px;
                            border:2px solid #D4C9B0;box-shadow:0 2px 8px rgba(0,0,0,.15);">`
                        : `<div style="width:120px;height:170px;background:#F5F0E8;border-radius:8px;
                            border:2px dashed #D4C9B0;display:flex;align-items:center;justify-content:center;
                            flex-direction:column;color:#9CA3AF;font-size:12px;text-align:center;">
                            <i class="fas fa-book" style="font-size:32px;margin-bottom:8px;"></i>
                            Tidak ada cover
                           </div>`;
                    let badgeClass = d.terlambat ? 'bg-danger' : (d.status === 'dipinjam' ? 'bg-warning text-dark' : 'bg-success');
                    let statusText = d.terlambat ? '⚠ Terlambat' : d.status;
                    $('#detailContent').html(`
                        <div style="display:flex;gap:20px;align-items:flex-start;">
                            <div style="flex-shrink:0;text-align:center;">
                                ${coverHtml}
                                <div style="margin-top:8px;font-size:11px;color:#6B7280;">Cover Buku</div>
                            </div>
                            <div style="flex:1;">
                                <table class="table table-bordered" style="margin-bottom:0;font-size:14px;">
                                    <tr><th style="width:40%;background:#F5F0E8;">Judul Buku</th>
                                        <td><strong>${escHtml(d.judul_buku)}</strong></td></tr>
                                    <tr><th style="background:#F5F0E8;">Pengarang</th>
                                        <td>${escHtml(d.pengarang)}</td></tr>
                                    <tr><th style="background:#F5F0E8;">Kategori</th>
                                        <td>${escHtml(d.kategori)}</td></tr>
                                    <tr><th style="background:#F5F0E8;">Anggota</th>
                                        <td>${escHtml(d.nama_anggota)} <span class="badge bg-secondary">${escHtml(d.nomor_anggota)}</span></td></tr>
                                    <tr><th style="background:#F5F0E8;">Tgl Pinjam</th>
                                        <td>${escHtml(d.tanggal_pinjam)}</td></tr>
                                    <tr><th style="background:#F5F0E8;">Batas Kembali</th>
                                        <td>${escHtml(d.tanggal_kembali_rencana)}</td></tr>
                                    <tr><th style="background:#F5F0E8;">Tgl Kembali</th>
                                        <td>${escHtml(d.tanggal_kembali_aktual)}</td></tr>
                                    <tr><th style="background:#F5F0E8;">Status</th>
                                        <td><span class="badge ${badgeClass}">${escHtml(statusText)}</span></td></tr>
                                </table>
                            </div>
                        </div>
                    `);
                    new bootstrap.Modal(document.getElementById('detailModal')).show();
                }).fail(() => showAlert('danger', 'Gagal mengambil detail.'));
            });

            // Kembalikan via AJAX
            $(document).on('click', '.btn-kembali-ajax', function () {
                if (!confirm('Konfirmasi pengembalian buku ini?')) return;
                const id = $(this).data('id');
                $.ajax({ url: `/ajax/transaksi/${id}/kembali`, method: 'PATCH' })
                    .done(res => { showAlert('success', res.message); loadData(); })
                    .fail(() => showAlert('danger', 'Gagal memproses pengembalian.'));
            });

            // Hapus via AJAX
            $(document).on('click', '.btn-delete-ajax', function () {
                if (!confirm('Hapus data ini?')) return;
                const id = $(this).data('id');
                $.ajax({ url: `/ajax/transaksi/${id}`, method: 'DELETE' })
                    .done(res => { showAlert('success', res.message); loadData(); })
                    .fail(xhr => showAlert('danger', 'Gagal hapus. Status: ' + xhr.status));
            });
        });
    </script>
@endpush