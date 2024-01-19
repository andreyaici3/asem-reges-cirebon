<div class="card-body">
    <div class="form-group">
        <label for="tipe_mobil">Tipe Mobil</label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="tipe_mobil" placeholder="Masukan Tipe Mobil" aria-describedby="tipe_mobil-error" aria-invalid="false" value="{{ old("name") ?? @$type->name }}">
        <span id="tipe_mobil-error" class="error invalid-feedback">
            {{ $errors->has('name') ? '*) ' . $errors->first('name') : '' }}</span>
    </div>
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>