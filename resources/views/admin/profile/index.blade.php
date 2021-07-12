@extends('layouts.app')
@section('content')
{{-- bagin page section --}}
<div class="container-fluid">
   <div class="row">
      <div class="col-md-12">
         @if (session('status'))
            <div class="alert alert-success alert-dismissible show fade">
               <div class="alert-body">
                  <button class="close" data-dismiss="alert">&times;</button>
                   @if (session('status') == 'profile-information-updated')
                     profile has benn updated.
                   @endif
                  @if (session('status') == 'password-updated')
                     password has been upated.
                  @endif
                  @if (session('status') == 'two-factor-authentication-disabled')
                     Two factor authentication disabled
                  @endif
                  @if (session('status') == 'two-factor-authentication-enabled')
                     Two factor authentication enabled
                  @endif
                  @if (session('status') == 'recovery-codes-generated')
                     Recovery codes generated.
                  @endif
               </div>
            </div>
         @endif
      </div>
   </div>

   {{-- page heading --}}
   <div class="row">
      @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
         <div class="col-md-5 mb-5">
            <div class="card border-0 shadow">
               <div class="card-header">
                  <h6 class="m-0 font-weight-bold"><i class="fas fa-key"> TWO FACTOR AUTHENTICATION</i></h6>
               </div>
               <div class="card-body">
                  @if (!auth()->user()->two_factor_secret)
                  {{-- Enable 2fa --}}
                  <form action="{{ url('user/two-factor-authentication') }}" method="POST">
                     @csrf
                     <button type="submit" class="btn btn-primary text-uppercase">Enabled Two Factor</button>
                  </form>
                  @else
                  {{-- disabled 2fa --}}
                  <form action="{{ url('user/two-factor-authentication') }}" method="POST">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="btn btn-primary text-uppercase">Disabled Two Factor</button>
                  </form>
                        @if (session('status') == 'two-factor-authentication-enabled')
                           {{-- Show SVG QR Codes, After Enabling 2FA --}}
                           <P>Otentikasi dua faktor sekarang diaktifkan. pindai kode qr berikut menggunakan aplikasi pngauthentikasi di ponsel anda</P>
                           <div class="mb-3">
                              {!! auth()->user()->twoFactorQrCodeSvg() !!}
                           </div>
                        @endif
                        <p>
                           Simpan Recovery code ini dengan aman.Ini dapat digunakan untuk memuihkan akun anda jika otentikasi atau factor anda hilang
                        </p>
                        <div class="rounded p-3 mb-2" style="background:rgb(44,44,44); color: white ">
                           @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                              <div class="">{{ $code }}</div>
                           @endforeach
                        </div>
                        {{-- regenerate 2FA Recoery Codes --}}
                        <form action="{{ url('user/two-factor-recovery-codes') }}" method="POST">
                           @csrf
                           <button type="submit" class="btn btn-dark text-uppercase">Regenerate Recovery Codes</button>
                        </form>
                  @endif
               </div>
            </div>
         </div>
      @endif
      <div class="col-md-7">
         <div class="card border-0 shadow">
            <div class="card-header">
               <h6 class="m-0 font-weight-bold"><i class="fas fa-user-circle"></i> EDIT PROFILE</h6>
            </div>
            <div class="card-body">
               <form action="{{ route('user-profile-information.update') }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                     <label for="name" class="text-uppercase">Nama</label>
                     <input type="text" name="name" class="form-control" value="{{ old('name') ?? auth()->user()->name }}" required autofocus autocomplete="name">
                  </div>
                  <div class="form-group">
                     <label for="email" class="text-uppercase">Email</label>
                     <input type="email" name="email" class="form-control" value="{{ old('email') ?? auth()->user()->email }}" required autofocus >
                  </div>
                  <div class="form-group">
                     <button class="btn btn-primary text-uppercase" type="submit">Update Profile</button>
                  </div>
               </form>
            </div>
         </div>
         <div class="card border-0 shadow mt-3 mb-4">
            <div class="card-header">
               <h6 class="m-0 font-weight-bold">
                  <i class="fas fa-unlock"></i> UPDATE PASSWORD
               </h6>
            </div>
            <div class="card-body">
               <form action="{{ route('user-password.update') }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                     <label for="#" class="text-uppercase">Current Password</label>
                     <input type="password" name="current_password" class="form-control" required autocomplete="current_password">
                  </div>
                  <div class="form-group">
                     <label for="#" class="text-uppercase">Password</label>
                     <input type="password" name="password" class="form-control" required autocomplete="new_password">
                  </div>
                  <div class="form-group">
                     <button class="btn btn-primary text-uppercase" type="submit"> Update Password </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection