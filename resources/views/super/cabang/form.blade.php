<div class="card-body">
    <div class="form-group">
        <label for="branch_name">Nama Cabang</label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="branch_name" placeholder="Masukan Nama Cabang" aria-describedby="branch_name-error" aria-invalid="false" value="{{ old("name") ?? @$branch->name }}">
        <span id="branch_name-error" class="error invalid-feedback">
            {{ $errors->has('name') ? '*) ' . $errors->first('name') : '' }}</span>
    </div>
    <div class="form-group">
        <label for="address_branch">Alamat Cabang</label>
        <input type="text" name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address_branch" placeholder="Masukan Alamat Cabang" aria-describedby="address_branch-error" aria-invalid="false"  value="{{ old("address") ?? @$branch->address }}">
        <span id="address_branch-error" class="error invalid-feedback">
            {{ $errors->has('address') ? '*) ' . $errors->first('address') : '' }}</span>
    </div>
    <div class="form-group">
        <label for="phone_branch">Telp Cabang</label>
        <input type="number" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone_branch" placeholder="Nomor Telp Cabang" aria-describedby="phone_branch-error" aria-invalid="false" value="{{ old("phone") ?? @$branch->phone }}">
        <span id="phone_branch-error" class="error invalid-feedback">
            {{ $errors->has('phone') ? '*) ' . $errors->first('phone') : '' }}</span>
    </div>
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
