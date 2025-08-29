
<form action="{{route('credits.save',['item'=>$item?->id])}}" class="saveForm" enctype="multipart/form-data">
    <div class="form-items">
                    <div class="form-item">
                        <label for="">Table İD nömrəsi</label>
                        <div class="form-input">
                            <input type="text" name="tableId" value="{{ $item->tableId }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Tarix</label>
                        <div class="form-input">
                            <input type="date" name="date" value="{{ $item->date }}">
                        </div>
                    </div>
                   


                     <div class="form-item">
                        <label for="">Dövlət qeydiyyat nişanı</label>
                        <select name="vehicle_id" id="id_card_serial_code">
                            <option value="">Seçin</option>
                            @foreach($dqns as $id=>$value)
                                <option @selected($id==$item->vehicle_id) value="{{ $id }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Marka</label>
                        <select name="brand_id" id="">
                            <option value="">Seçin</option>
                           @foreach($brands as $brand)
                            <option @selected($brand->id==$item->brand_id) value="{{ $brand->id }}">{{ $brand->title }}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Model</label>
                        <select name="model_id" id="">
                            <option value="">Seçin</option>
                            @foreach($models as $model)
                                <option @selected($model->id==$item->model_id) value="{{ $model->id }}">{{ $model->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-item">
                        <label for="">Istehsal ili</label>
                        <div class="form-input">
                            <input type="text" name="production_year" value="{{ $item->production_year }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Hesab</label>
                        <div class="form-input">
                            <input type="number" name="calculation" value="{{ $item->calculation }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Kod</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->code }}" name="code">
                        </div>
                    </div>




                    
                    <div class="form-item">
    <label for="">İlkin ödəniş</label>
    <div class="form-input">
        <input type="number" name="down_payment" id="down_payment" value="{{ $item->down_payment }}">
        <span>azn</span>
    </div>
</div>
<div class="form-item">
    <label for="">Aylıq ödəniş</label>
    <div class="form-input">
        <input type="number" value="{{ $item->monthly_payment }}" name="monthly_payment" id="monthly_payment">
        <span>azn</span>
    </div>
</div>
<div class="form-item">
    <label for="">Ümumi ay</label>
    <div class="form-input">
        <input type="number" name="total_months"  id="total_months" value="{{ $item->total_months }}">
        <span>ay</span>
    </div>
</div>
<div class="form-item">
    <label for="">Ümumi ödəniləcək kredit</label>
    <div class="form-input">
        <input type="number" value="{{ $item->total_payable_loan }}" name="total_payable_loan" id="total_payable_loan" readonly>
        <span>azn</span>
    </div>
</div>
<div class="form-item">
    <label for="">Qalan ay</label>
    <div class="form-input">
        <input type="number" value="{{ $item->remaining_months }}" name="remaining_months" id="remaining_months">
        <span>ay</span>
    </div>
</div>
<div class="form-item">
    <label for="">Qalan məbləğ</label>
    <div class="form-input">
        <input type="number"  value="{{ $item->remaining_amount }}" name="remaining_amount" id="remaining_amount" readonly>
        <span>azn</span>
    </div>
</div>




                </div>
                <button class="submit" type="submit">Əlavə et</button>
</form>

