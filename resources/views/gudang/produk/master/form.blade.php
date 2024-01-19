<div class="card-body">
    <div class="form-group">
        <label for="product_code">Kode Produk</label>
        <input type="text" name="code" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}"
            id="product_code" placeholder="Kode Product" aria-describedby="product_code-error" aria-invalid="false"
            value="{{ old('code') ?? @$kode }}" readonly>
        <span id="product_code-error" class="error invalid-feedback">
            {{ $errors->has('code') ? '*) ' . $errors->first('code') : '' }}</span>
    </div>

    <div class="form-group">
        <label for="product_name">Nama Produk</label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
            id="product_name" placeholder="Masukan Nama Produk" aria-describedby="product_name-error"
            aria-invalid="false" value="{{ old('name') ?? @$product->name }}">
        <span id="product_name-error" class="error invalid-feedback">
            {{ $errors->has('name') ? '*) ' . $errors->first('name') : '' }}</span>
    </div>

    <div class="form-group">
        <label for="product_type">Merk - Type Produk</label>
        <select class="form-control select2" style="width: 100%;" name="product_type">
            @foreach ($type as $value)
                <option {{ @$product->product_type_id == $value->id ? 'selected' : '' }} value="{{ $value->id }}">
                    {{ $value->merk->name }} - {{ $value->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="product_vendor">Vendor</label>
        <select class="form-control select2" style="width: 100%;" name="vendor">
            @foreach ($vendor as $value)
                <option {{ @$product->vendor_id == $value->id ? 'selected' : '' }} value="{{ $value->id }}">
                    {{ $value->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="product_price">Harga Beli</label>
        <input type="number" name="price" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
            id="product_price" placeholder="Harga Beli" aria-describedby="product_price-error" aria-invalid="false"
            value="{{ old('price') ?? @$product->price }}">
        <span id="product_price-error" class="error invalid-feedback">
            {{ $errors->has('price') ? '*) ' . $errors->first('price') : '' }}</span>
    </div>

    <div class="form-group">
        <label for="product_selling">Harga Jual</label>
        <input type="number" name="selling" class="form-control {{ $errors->has('selling') ? 'is-invalid' : '' }}"
            id="product_selling" placeholder="Harga Beli" aria-describedby="product_selling-error" aria-invalid="false"
            value="{{ old('selling') ?? @$product->selling }}">
        <span id="product_selling-error" class="error invalid-feedback">
            {{ $errors->has('selling') ? '*) ' . $errors->first('selling') : '' }}</span>
    </div>

    <div class="form-group">
        <label for="product_stok">Stok</label>
        <input type="number" name="stok" class="form-control {{ $errors->has('stok') ? 'is-invalid' : '' }}"
            id="product_stok" placeholder="Jumlah Stok" aria-describedby="product_stok-error" aria-invalid="false"
            value="{{ old('stok') ?? @$product->stok }}">
        <span id="product_stok-error" class="error invalid-feedback">
            {{ $errors->has('stok') ? '*) ' . $errors->first('stok') : '' }}</span>
    </div>

    <div class="form-group">
        <label>Kompatibel Untuk</label>
        <select class="select2bs4 {{ $errors->has('available') ? 'is-invalid' : '' }}" multiple="type" data-placeholder="Pilih Mobil Yang Kompatibel" style="width: 100%;"
            name="available[]" >
            @foreach ($car as $value)
                <option @if(@$product != null) @foreach (@$product->available as $available) {{ @$available->tipe->id == $value->id ? 'selected' : '' }} @endforeach @endif value="{{ $value->id }}">{{ $value->merk->name }} - {{ $value->name }}</option>
            @endforeach
        </select>
        <span id="product_selling-error" class="error invalid-feedback">
            {{ $errors->has('available') ? '*) ' . $errors->first('available') : '' }}</span>
    </div>

</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
