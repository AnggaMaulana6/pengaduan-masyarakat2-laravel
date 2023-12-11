@include('layouts/header');
     <!-- Striped Rows -->
     <div class="card">
        <h5 class="card-header">Data Aduan Anda</h5>
        <div class="table-responsive text-nowrap px-4">
            <div class="card-header py-3">
                <a href="/data-petugas/create" class="btn btn-primary">
                    Tambah Petugas
                </a>
            </div>
    
            {{-- <!-- Modal -->
            <form action="/data-petugas" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Tambah Petugas</h5>
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
            </form>           --}}
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
                <th>Nama Petugas</th>
                <th>Email</th>
                <th>Username</th>
                <th>Password</th>
                <th>level</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @foreach ($users as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->nama_petugas }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->username }}</td>
                <td>{{ $data->password }}</td>
                <td>{{ $data->level }}</td>
                <td>
                    <a href="/data-petugas/{{ $data->id_petugas }}/edit" class="badge bg-warning text-decoration-none">Edit</a>
                    <form action="/data-petugas/{{ $data->id_petugas }}" class="d-inline" method="post">
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