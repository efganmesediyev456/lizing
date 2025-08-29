 <form action="{{route('deposits.save',['item'=>$item?->id])}}" class="saveForm" enctype="multipart/form-data">

 <div class="form-items">
                    <div class="form-item">
                        <label for="">Tarix</label>
                        <div class="form-input">
                            <input type="date" value="{{ now()->format('Y-m-d') }}" name="date">
                        </div>
                    </div>

                    <input type="hidden" value="{{ $item->leasing_id }}" name="leasing_id">
                    <input type="hidden" value="{{ $item->driver_id }}" name="driver_id">


                      <div class="form-item">
                        <label for="">D.Q.N</label>
                        <select name="vehicle_id" id="id_card_serial_code">
                            <option value="">Seçin</option>
                            @foreach($dqns as $id=>$value)
                                <option @selected($id==$item->vehicle_id) value="{{ $id }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Ad soyad</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->name }}" name="name">
                        </div>
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
                        <label for="">Table ID</label>
                        <div class="form-input">
                            <input type="text" name="tableId" value="{{ $item->tableId }}">
                        </div>
                    </div>
                     <div class="form-item">
                        <label for="">Depozit borcu</label>
                        <div class="form-input">
                            <input type="number" value="{{ $item->deposit_debt }}" name="deposit_debt">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Depozit</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->price }}" name="price">
                            <span>azn</span>
                        </div>
                    </div>
                </div>
                <div class="form-item">
                    <label for="">Qeyd</label>
                    <div class="form-input">
                        <textarea name="notes" class="note" id="">{{ $item->notes }}</textarea>
                    </div>
                </div>
                <button class="submit" type="submit">Əlavə et</button>
                </form>
