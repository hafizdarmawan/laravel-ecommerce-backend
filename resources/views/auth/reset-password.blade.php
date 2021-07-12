@extends('layouts.auth',['title' => 'Update Password'])
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-4">
         <div class="img-logo text-center mt-5"><img src="{{ asset('assets/img/company.png') }}" alt="" style="width: 80px">
      </div>
      <div class="card o-hidden border-0 shadow-lg mb-3 mt-5">
         <div class="card-body p-4">
            @if (session('status'))
               <div class="alert alert-success">
                  {{ $message }}
               </div>
            @endif
            <div class="text-center">
               <h1 class="h5 text-gray-900 mb-3">
                  UPDATE PASSWORD
               </h1>
            </div>
            <form action="{{ route('password.update') }}" method="POST">
               @csrf
               <input type="hidden" name="token" value="{{ $request->route('token') }}">
               <div class="form-group">
                  <label for="email" class="font-weight-bold text-uppercase">Email Address</label>
                  <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email" autofocus placeholder="Masukan Alamat Email" value="{{ $request->email ?? old('email') }}">
                  @error('email')
                     <div class="alert alert-danger mt-2">
                        <strong>{{ $message }}</strong>
                     </div>
                  @enderror
               </div>
                <div class="form-group">
                  <label for="password" class="font-weight-bold text-uppercase">Password</label>
                  <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus placeholder="Masukan Password">
                  @error('password')
                     <div class="alert alert-danger mt-2">
                        <strong>{{ $message }}</strong>
                     </div>
                  @enderror
               </div>
                <div class="form-group">
                  <label for="password-confirm" class="font-weight-bold text-uppercase">KONFIRMASI PASSWORD</label>
                  <input type="password-confirm" id="password-confirm" class="form-control @error('password-confirm') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" autofocus placeholder="Ulangi Password">
                  @error('password-confirm')
                     <div class="alert alert-danger mt-2">
                        <strong>{{ $message }}</strong>
                     </div>
                  @enderror
               </div>
               <button type="submit" class="btn btn-primary btn-block">UPDATE PASSWORD</button>
            </form>
         </div>
      </div>
      </div>
   </div>
</div>
@endsection