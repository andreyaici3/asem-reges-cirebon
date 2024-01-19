<div class="card-body">
    <div class="form-group">
        <label for="merk_mobil">Merk Mobil</label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="merk_mobil" placeholder="Masukan Merk Mobil" aria-describedby="merk_mobil-error" aria-invalid="false" value="{{ old("name") ?? @$merk->name }}">
        <span id="merk_mobil-error" class="error invalid-feedback">
            {{ $errors->has('name') ? '*) ' . $errors->first('name') : '' }}</span>
    </div>
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>