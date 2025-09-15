        <form action="{{route('expenses.save',['item'=>$item?->id])}}" class="saveForm">
                <div class="form-items">
                    <div class="form-item">
                        <label for="">Tarix</label>
                        <div class="form-input">
                            <input type="date" value="{{ $item->date?->format('Y-m-d') }}" name="date">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Table ID</label>
                        <select name="tableId" id="id_card_serial_code">
                            <option value="">Seçin</option>
                            @foreach($tableIds as $id=>$value)
                                <option @selected($id==$item->tableId) value="{{ $id }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-item">
                        <label for="">D.Q.N</label>
                        <select name="vehicle_id" id="">
                            <option value="">Seçin</option>
                            @foreach($dqns as $id=>$value)
                                <option @selected($id==$item->vehicle_id) value="{{ $id }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- <div class="form-item">
                        <label for="">D.Q.N</label>
                        <select name="vehicle_id" id="">
                            <option value="">Seçin</option>
                            @foreach($vehicles as $vehicle)
                            <option @selected($vehicle->id == $item->vehicle_id) value="{{ $vehicle->id }}">{{ $vehicle->state_registration_number }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="form-item">
                        <label for="">Ümümi xərc</label>
                        <div class="form-input">
                            <input type="number" any=".01" value="{{ $item->total_expense }}" name="total_expense">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Ehtiyyat hissesi odənişi</label>
                        <div class="form-input">
                            <input type="number" any=".01" value="{{ $item->spare_part_payment }}" name="spare_part_payment">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Usta odənişi</label>
                        <div class="form-input">
                            <input type="number" any=".01" value="{{ $item->master_payment  }}" name="master_payment">
                            <span>azn</span>
                        </div>
                    </div>
                </div>
                <div class="form-item">
                    <label for="">Qeyd</label>
                    <div class="form-input">
                        <textarea name="note" class="note" id="">{{ $item->note }}</textarea>
                    </div>
                </div>
                <button class="submit" type="submit">Əlavə et</button>
            </form>