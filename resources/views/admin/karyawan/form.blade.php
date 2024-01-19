<div class="card-body">
    <div class="form-group">
        <label for="admin_name">Nama Lengkap</label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="admin_name" placeholder="Masukan Nama Lengkap" aria-describedby="admin_name-error" aria-invalid="false" value="{{ old("name") ?? @$user->name }}">
        <span id="admin_name-error" class="error invalid-feedback">
            {{ $errors->has('name') ? '*) ' . $errors->first('name') : '' }}</span>
    </div>
    <div class="form-group">
        <label for="email_admin">Email</label>
        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email_admin" placeholder="Alamat Email" aria-describedby="email_admin-error" aria-invalid="false" value="{{ old("email") ?? @$user->email }}">
        <span id="email_admin-error" class="error invalid-feedback">
            {{ $errors->has('email') ? '*) ' . $errors->first('email') : '' }}</span>
    </div>
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>