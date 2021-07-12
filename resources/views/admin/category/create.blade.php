@extends('layouts.app',['title' => 'Tambah Kategori'])
@section('content')
{{-- begin page content --}}
<div class="container-fluid">
   <div class="row">
      <div class="col-md-12">
         <div class="card border-0 shadow">
            <div class="card-header">
               <h6 class="m-0 font-weight-bold">
                  <i class="fas fa-folder"></i> Tambah Kategori
               </h6>
            </div>
            <div class="card-body">
               <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                     <label for="gambar">Gambar</label>
                     <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                     @error('image')
                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="name">Nama Kategori</label>
                     <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukan Nama Kategori">
                     @error('name')
                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                     @enderror
                  </div>
                  <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> Simpan</button>
                  <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> Reset</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection