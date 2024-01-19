<div class="card-body">
    <div class="form-group">
        <label for="customer_name">Nama Pelanggan</label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
            id="customer_name" placeholder="Masukan Nama Pelanggan" aria-describedby="customer_name-error"
            aria-invalid="false" value="{{ old('name') ?? @$customer->name }}">
        <span id="customer_name-error" class="error invalid-feedback">
            {{ $errors->has('name') ? '*) ' . $errors->first('name') : '' }}</span>
    </div>

    <div class="form-group">
        <label for="customer_type_car">Tipe Mobil</label>
        <select class="form-control select2 {{ $errors->has('tipe') ? 'is-invalid' : '' }}" style="width: 100%;" name="tipe" id="customer_type_car">
            @foreach ($cars as $value)
                <option {{ (@$customer->car_type_id == $value->id) ? "selected" : "" }} value="{{ $value->id }}">{{ $value->merk->name }} - {{ $value->name }}</option>
            @endforeach
        </select>
        <span id="customer_type_car-error" class="error invalid-feedback">
            {{ $errors->has('tipe') ? '*) ' . $errors->first('tipe') : '' }}</span>
    </div>

    <div class="form-group">
        <label for="customer_number_plat">Plat Nomor</label>
        <input type="text" name="number_plat" class="form-control {{ $errors->has('number_plat') ? 'is-invalid' : '' }}"
            id="customer_number_plat" placeholder="Masukan Plat Nomor" aria-describedby="customer_number_plat-error"
            aria-invalid="false" value="{{ old('number_plat') ?? @$customer->number_plat }}">
        <span id="customer_number_plat-error" class="error invalid-feedback">
            {{ $errors->has('number_plat') ? '*) ' . $errors->first('number_plat') : '' }}</span>
    </div>
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
