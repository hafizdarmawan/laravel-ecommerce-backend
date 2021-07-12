@extends('layouts.auth',['title' => 'Forgot Password'])
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-4">
         <div class="logo-img text-center mt-5">
            <img src="{{ asset('assets/img/company.png') }}" alt="" style="width: 80px">
         </div>
         <div class="card o-hidden border-0 shadow-lg mb-3 mt-5">
            <div class="card-body p-4">
               @if (session('status'))
                  <div class="alert alert-success">
                     {{ session('status') }}
                  </div>
               @endif
               <div class="text-center">
                  <h1 class="h5 text-gray-900 mb-3">RESET PASSWORD</h1>
               </div>
               <form action="{{ route('password.email') }}" method="POST">
                  @csrf
                  <div class="form-group">
                     <label for="email" class="font-weight-bold text-uppercase">Email Address</label>
                     <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" autofocus required autocomplete="email" placeholder="Masukan Email">
                     @error('email')
                        <div class="alert alert-danger mt-2">
                           <strong>{{ $message }}</strong>
                        </div>
                     @enderror
                  </div>
                  <button class="btn btn-primary btn-block">Send Password Reset Link</button>
               </form>
            </div>
             <div class="text-center">
               <label for=""><a href="/login" class="text-dark">Kembali Ke Login</a></label>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection