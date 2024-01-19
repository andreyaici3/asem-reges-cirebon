<div class="card-body">
    <div class="form-group">
        <label>Pilih Cabang</label>
        <select class="form-control select2bs4" style="width: 100%;" name="branch_id">
            <option value="">- Belum Cabang -</option>
            @foreach ($branch as $value)
                <option @if(isset($maping))
                    {{ (@$value->id == $maping->branch_id) ? "selected" : "" }}
                @endif value="{{ $value->id }}">{{ $value->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Pilih Kepala Cabang</label>
        <select class="form-control select2bs4" style="width: 100%;" name="users_id">
            <option value="">- Belum Ada Kepala -</option>
            @foreach ($admin as $value)
                <option 
                    @if(isset($maping))
                        {{ ($value->id == $maping->users_id) ? "selected" : "" }}
                    @endif
                 value="{{ $value->id }}">{{ $value->name }} - {{ $value->email }}</option>
            @endforeach
        </select>
    </div>

</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
