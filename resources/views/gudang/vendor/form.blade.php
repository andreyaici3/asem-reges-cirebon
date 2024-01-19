<div class="card-body">
    <div class="form-group">
        <label for="vendor_name">Nama Vendor</label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="vendor_name" placeholder="Masukan Nama Vendor" aria-describedby="vendor_name-error" aria-invalid="false" value="{{ old("name") ?? @$vendor->name }}">
        <span id="vendor_name-error" class="error invalid-feedback">
            {{ $errors->has('name') ? '*) ' . $errors->first('name') : '' }}</span>
    </div>
    <div class="form-group">
        <label for="vendor_address">Alamat Vendor</label>
        <input type="text" name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="vendor_address" placeholder="Masukan Alamat Vendor" aria-describedby="vendor_address-error" aria-invalid="false" value="{{ old("address") ?? @$vendor->address }}">
        <span id="vendor_address-error" class="error invalid-feedback">
            {{ $errors->has('address') ? '*) ' . $errors->first('address') : '' }}</span>
    </div>
    <div class="form-group">
        <label for="phone_vendor">Telp Vendor</label>
        <input type="number" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone_vendor" placeholder="Nomor Telp Vendor" aria-describedby="phone_vendor-error" aria-invalid="false" value="{{ old("phone") ?? @$vendor->phone }}">
        <span id="phone_vendor-error" class="error invalid-feedback">
            {{ $errors->has('phone') ? '*) ' . $errors->first('phone') : '' }}</span>
    </div>
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>