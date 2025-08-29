
<form action="{{route('vehicles.penalties.save',['item'=>$item?->id, 'vehicle'=>request()->vehicle])}}" class="saveForm" enctype="multipart/form-data">
    
     <div class="form-items">
                    <div class="form-item">
                        <label for="">Cərimə adı</label>
                        <select name="penalty_type_id" id="">
                            <option value="">Seçin</option>
                            @foreach($penaltiesTypes as $penalty)
                                 <option @selected($penalty->id ==$item->penalty_type_id) value="{{ $penalty->id }}">{{ $penalty->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Tarix</label>
                        <div class="form-input">
                            <input type="date" name="date" value="{{ $item->date }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Cərimə sahibi</label>
                        <select name="" id="">
                            <option value="">Cərimə sahibi1</option>
                            <option value="">Cərimə sahibi2</option>
                            <option value="">Cərimə sahibi3</option>
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Cərimənin kodu</label>
                        <div class="form-input">
                            <input type="text" name="penalty_code" value="{{ $item->penalty_code }}" >
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Məbləğ</label>
                        <div class="form-input">
                            <input any=".01" type="number" name="amount" value="{{ $item->amount }}">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Status</label>
                        <select name="status" id="">
                                <option @selected($item->status == 2) value="2">Ödənilib</option>
                                <option @selected($item->status == 1) value="1">Ödənilməyib</option>
                        </select>
                    </div>
                </div>
                <div class="form-item">
                    <label for="">Qeyd</label>
                    <div class="form-input">
                        <textarea class="note" name="note" id="">{{ $item->note }}</textarea>
                    </div>
                </div>

    <button class="submit" type="submit">Əlavə et</button>
</form>
