<div class="card-body">
    <div class="form-group">
        <label for="merk_produk">Merk Produk</label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="merk_produk" placeholder="Masukan Merk" aria-describedby="merk_produk-error" aria-invalid="false" value="{{ old("name") ?? @$merk->name }}">
        <span id="merk_produk-error" class="error invalid-feedback">
            {{ $errors->has('name') ? '*) ' . $errors->first('name') : '' }}</span>
    </div>
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>