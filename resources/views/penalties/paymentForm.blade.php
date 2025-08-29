        <form action="{{route('vehicles.penalties.payment.save',['penalty'=>$penalty?->id, 'vehicle'=>request()->vehicle])}}" class="saveForm" >
              <div class="form-items">
                    <div class="form-item">
                        <label for="">Mövzu</label>
                        <select name="type" id="">
                            <option value="1" @selected($item?->type == 1) >Nağd ödəniş</option>
                            <option value="2" @selected($item?->type==2)>Online ödəniş</option>
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Məbləğ</label>
                        <div class="form-input">
                            <input type="number" any=".01" name="amount" value="{{ $item?->amount }}">
                            <span>azn</span>
                        </div>
                    </div>
                </div>
                <div class="form-item">
                    <label for="">Qeyd</label>
                    <textarea style="border: 1px solid #d6d6d6;border-radius: 12px;padding:24px;" class="note" name="note" id="">{{ $item?->note }}</textarea>
                </div>
                <button class="submit" type="submit">Əlavə et</button>
        </form>