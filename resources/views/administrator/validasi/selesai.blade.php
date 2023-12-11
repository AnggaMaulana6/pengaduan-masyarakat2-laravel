@include('layouts/header');
<!-- Striped Rows -->
<div class="card">
   <h5 class="card-header">Data Aduan Selesai</h5>
   <div class="table-responsive text-nowrap px-4">
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
           <th>Nama Pengadu</th>
           <th>Tanggal Aduan</th>
           <th>Foto</th>
           <th>Isi Aduan</th>
           <th>Status</th>
         </tr>
       </thead>
       <tbody class="table-border-bottom-0">
       @foreach ($pengaduans as $data)
       <tr>
           <td>{{ $loop->iteration }}</td>
           <td>{{ $data->nama }}</td>
           <td>{{ $data->tgl_pengaduan }}</td>
           <td>
               <img src="{{ asset('storage/'. $data->foto) }}" alt="" class="img-fluid max-width-max" style="max-height:120; max-width: 160px; overflow:hidden">
           </td>
           <td>{{ $data->isi_laporan }}</td>
           <td>
               @if($data->status == NULL)
               {{ $status = 'Non Valid' }} 
               @elseif($data->status == '0')
               {{ $status = 'Valid' }}
               @else
               {{ $status = $data->status }}                       
               @endif
           </td>
       </tr>
           
       @endforeach
       
       </tbody>
     </table>
   </div>
 </div>
 <!--/ Striped Rows -->
@include('layouts.footer');