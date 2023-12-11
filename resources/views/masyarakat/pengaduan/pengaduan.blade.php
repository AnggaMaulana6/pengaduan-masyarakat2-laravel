@include('layouts/header');
     <!-- Striped Rows -->
     <div class="card">
        <h5 class="card-header">Data Aduan Anda</h5>
        <div class="table-responsive text-nowrap px-4">
            <div class="card-header py-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                    Tambah Data Aduan
                </button>
            </div>
    
            <!-- Modal -->
            <form action="/pengaduan" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Tambah Aduan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col mb-0">
                                        <label for="" class="form-label">Nama</label>
                                        <input type="text" id="" class="form-control" value="{{ auth()->user()->nama }}" readonly />
                                    </div>
                                    <div class="col mb-0">
                                        <label for="" class="form-label">NIK</label>
                                        <input type="number" id="" class="form-control" value="{{ auth()->user()->nik }}" readonly />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Tanggal Pengaduan</label>
                                        <input type="date" id="tgl_pengaduan" name="tgl_pengaduan" class="form-control @error('tgl_pengaduan') is-invalid @enderror" required />
                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Foto Penunjang</label>
                                        <input type="file" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror" required />
                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Isi Aduan</label>
                                        <textarea name="isi_laporan" id="" class="form-control @error('isi_laporan') is-invalid @enderror" required></textarea>
                                        @error('isi_laporan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Kembali
                                </button>
                                <button type="submit" name="submit" value="Simpan" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>          
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button class="btn btn-close" data-bs-dismiss='alert' aria-label="close"></button>
            </div>
            @endif
            <table class="table table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal Aduan</th>
                <th>Foto</th>
                <th>Isi Aduan</th>
                <th>Status</th>
                <th>Tanggapan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @foreach ($pengaduans as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->tgl_pengaduan }}</td>
                <td>
                    <img src="{{ asset('storage/'. $data->foto) }}" alt="" class="img-fluid max-width-max" style="max-height:120; max-width: 160px; overflow:hidden">
                </td>
                <td>{{ $data->isi_laporan }}</td>
                <td>
                    @if ($data->status == NULL)
                    {{ $status = 'Non Valid' }} 
                    @elseif($data->status == '0')
                    {{ $status = 'Valid' }}
                    @else
                    {{ $status = $data->status }}                       
                    @endif
                </td>
                <td>
                    @if ($data['status'] == 'proses' or $data->status == '0')
                        <a href="/lihat-tanggapan/{{ $data->id_pengaduan }}/edit" class="btn btn-warning btn-sm">Lihat Tanggapan</a>
                    @elseif($data->status == 'ditolak')
                    <div class="btn btn-danger btn-sm">Ditolak</div>
                    @elseif($data['status'] == 'selesai')
                    <div class="btn btn-info btn-sm">Selesai</div>
                    @else
                    <div class="btn btn-secondary btn-sm">Belum ditanggapi</div>
                    @endif
                </td>
                <td>
                    <a href="/pengaduan/{{ $data->id_pengaduan }}" class="badge bg-info text-decoration-none">Lihat</a>
                    <a href="/pengaduan/{{ $data->id_pengaduan }}/edit" class="badge bg-warning text-decoration-none">Edit</a>
                    <form action="/pengaduan/{{ $data->id_pengaduan }}" class="d-inline" method="post">
                    @method('delete')
                    @csrf
                    <button class="badge bg-danger border-0" type="submit" onclick="return confirm('yakin ingin menghapus data?')">Hapus</button>
                    </form>
                </td>
            </tr>
                
            @endforeach
            
            </tbody>
          </table>
        </div>
    </div>
      <!--/ Striped Rows -->
@include('layouts.footer');