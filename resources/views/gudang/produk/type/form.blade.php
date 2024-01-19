<div class="card-body">
    <div class="form-group">
        <label for="tipe_produk">Tipe Produk</label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="tipe_produk" placeholder="Masukan Tipe Produk" aria-describedby="tipe_produk-error" aria-invalid="false" value="{{ old("name") ?? @$type->name }}">
        <span id="tipe_produk-error" class="error invalid-feedback">
            {{ $errors->has('name') ? '*) ' . $errors->first('name') : '' }}</span>
    </div>
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>