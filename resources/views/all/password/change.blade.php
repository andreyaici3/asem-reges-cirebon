<x-app-layout menuActive="ganti-password">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">GANTI PASSWORD</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Ganti Password</li>
            </ol>
        </div><!-- /.col -->
    @endsection

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (Session::has('sukses'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Selamat!</h5>
                        {{ session('sukses') }}
                    </div>
                @endif

                @if (Session::has('gagal'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Oopss!</h5>
                        {{ session('gagal') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <form method="POST" action="{{ route('auth.change') }}">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="old_password">Password Lama</label>
                                <input type="password" name="old_password"
                                    class="form-control {{ $errors->has('old_password') ? 'is-invalid' : '' }}"
                                    id="old_password" placeholder="Passwod Lama" aria-describedby="old_password-error"
                                    aria-invalid="false" value="{{ old('old_password') }}">
                                <span id="old_password-error" class="error invalid-feedback">
                                    {{ $errors->has('old_password') ? '*) ' . $errors->first('old_password') : '' }}</span>
                            </div>
                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <input type="password" name="password"
                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    id="password" placeholder="Password Baru" aria-describedby="password-error"
                                    aria-invalid="false" value="{{ old('password') }}">
                                <span id="password-error" class="error invalid-feedback">
                                    {{ $errors->has('password') ? '*) ' . $errors->first('password') : '' }}</span>
                            </div>
                            <div class="form-group">
                                <label for="new_password">Konfirmasi Password</label>
                                <input type="password" name="new_password"
                                    class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}"
                                    id="new_password" placeholder="Konfirmasi Password"
                                    aria-describedby="new_password-error" aria-invalid="false"
                                    value="{{ old('new_password') }}">
                                <span id="new_password-error" class="error invalid-feedback">
                                    {{ $errors->has('new_password') ? '*) ' . $errors->first('new_password') : '' }}</span>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
