@include('layouts/header');
     <!-- Striped Rows -->
     <div class="card">
        <h5 class="card-header">Data Masyarakat</h5>
        <div class="table-responsive text-nowrap px-4">
            <div class="card-header py-3">
                <a href="/data-masyarakat/create" class="btn btn-primary">
                    Tambah Masyarakat
                </a>
            </div>
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
                <th>NIK</th>
                <th>Nama</th>
                <th>NO Telepon</th>
                <th>Username</th>
                <th>Password</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @foreach ($users as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->nik }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->telp }}</td>
                <td>{{ $data->username }}</td>
                <td>{{ $data->password }}</td>
                <td>
                    <a href="/data-masyarakat/{{ $data->nik }}/edit" class="badge bg-warning text-decoration-none">Edit</a>
                    <form action="/data-masyarakat/{{ $data->nik }}" class="d-inline" method="post">
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