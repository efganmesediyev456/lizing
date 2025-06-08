@if(isset($message))
<p style="padding:12px; background:green; color:white; border-radius:4px; text-align:center; margin-top:22px;" class="message">{{$message}}</p>
@else
<form action="{{route('vehicles.save',['item'=>$item?->id])}}" class="saveForm" enctype="multipart/form-data">
    <div class="form-items">
        <div class="form-item">
            <label for="">Table ID Nömrəsi</label>
            <div class="form-input">
                <input type="text" value="{{$item?->table_id_number}}" name="table_id_number">
            </div>
            @error('table_id_number')
                <p style="color:red">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-item">
            <label for="">VIN Kod</label>
            <div class="form-input">
                <input type="text" value="{{$item?->vin_code}}" name="vin_code">
            </div>
            @error('vin_code')
                <p style="color:red">{{ $message }}</p>
            @enderror
        </div>


        <div class="form-item">
                        <label for="">Marka</label>
                        <select name="brand_id" id="brand_id">
                            <option value="">Secin</option>
                            @foreach($brands as $brand)
                            <option @selected($brand->id==$item?->brand_id) value="{{ $brand->id }}">{{ $brand->title }}</option>
                            @endforeach
                          
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Model</label>
                        <select name="model_id" id="model_id">
                            <option value="">Secin</option>
                            @foreach($models as $model)
                            <option @selected($model->id==$item?->model_id) value="{{ $model->id }}">{{ $model->title }}</option>
                            @endforeach
                          
                        </select>
                    </div>

        <div class="form-item">
            <label for="">Dövlət Qeydiyyat Nişanı</label>
            <div class="form-input">
                <input type="text" value="{{$item?->state_registration_number}}" name="state_registration_number">
            </div>
            @error('state_registration_number')
                <p style="color:red">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-item">
            <label for="">İstehsal İli</label>
            <div class="form-input">
                <input type="number" value="{{$item?->production_year}}" name="production_year">
            </div>
            @error('production_year')
                <p style="color:red">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-item">
            <label for="">Alış Qiyməti</label>
            <div class="form-input">
                <input type="number" step="0.01" value="{{$item?->purchase_price}}" name="purchase_price">

            </div>
            @error('purchase_price')
                <p style="color:red">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-item">
            <label for="">Gediş Məsafəsi</label>
            <div class="form-input">
                <input type="number" value="{{$item?->mileage}}" name="mileage">
                <span>km</span>
            </div>
            @error('mileage')
                <p style="color:red">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-item">
                        <label for="">Yanacaq növü</label>
                        <select name="oil_type_id" id="">
                            <option value="">Secin</option>
                            @foreach($oilTypes as $oilType)
                            <option @selected($oilType->id==$item?->oil_type_id) value="{{ $oilType->id }}">{{ $oilType->title }}</option>
                            @endforeach
                          
                        </select>
                    </div>

        <div class="form-item">
            <label for="">Mühərrik</label>
            <div class="form-input">
                <input type="text" value="{{$item?->engine}}" name="engine">
                <span>l</span>
            </div>
            @error('engine')
                <p style="color:red">{{ $message }}</p>
            @enderror
        </div>

        <!-- <div class="form-item">
            <label for="">Status</label>
            <select name="status">
                <option value="1" @selected($item?->status == 1)>Aktiv</option>
                <option value="0" @selected($item?->status == 0)>Deaktiv</option>
            </select>
        </div> -->
    </div>

    <button class="submit" type="submit">Yadda Saxla</button>
</form>
@endif
