 <form enctype="multipart/form-data" action="{{route('debts.save',['item'=>$item?->id])}}" class="saveForm">
                <div class="form-items">
                  <div class="form-item">
                        <label for="">Table ID</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->tableId }}" name="tableId">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Tarix</label>
                        <div class="form-input">
                            <input type="date" value="{{ $item->date }}" name="date">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Dövlət qeydiyyat nişanı</label>
                        <select id="id_card_serial_code" name="vehicle_id" id="">
                                <option value="">Secin</option>
                            @foreach($vehicles as $vehicle)
                                <option @selected($vehicle->id==$item->vehicle_id) value="{{ $vehicle->id }}">{{ $vehicle->state_registration_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Marka</label>
                        <select name="brand_id" id="">
                            <option value="">Secin</option>
                            @foreach($brands as $brand)
                            <option @selected($brand->id==$item->brand_id) value="{{ $brand->id }}">{{ $brand->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Model</label>
                        <select name="model_id" id="">
                            <option value="">Secin</option>
                            @foreach($models as $model)
                            <option value="{{ $model->id }}" @selected($model->id==$item->model_id)>{{ $model->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    
                    
                    <div class="form-item">
                        <label for="">Istehsal ili</label>
                        <div class="form-input">
                            <input type="text" name="production_year" value="{{ $item->production_year }}">
                        </div>
                    </div>
                </div>
                <div class="form-item">
                      <label for="">Ehtiyyat hissəsinin adı</label>
                      <div class="form-input">
                          <input type="text" name="spare_part_title" value="{{ $item->spare_part_title }}">
                      </div>
                </div>
                <div class="form-items">
                  <div class="form-item">
                      <label for="">Qiyməti</label>
                      <div class="form-input">
                          <input type="text" value="{{ $item->price }}" name="price">
                          <span>azn</span>
                      </div>
                  </div>
                  <div class="form-item">
                      <label for="">Ödənilib</label>
                      <div class="form-input">
                          <input type="text" name="price_payment" value="{{ $item->price_payment }}">
                          <span>azn</span>
                      </div>
                  </div>
                </div>
                <div class="form-item">
                      <label for="">Qeyd</label>
                      <div class="form-input">
                          <textarea  id="" name="note">{{ $item->note }}</textarea>
                      </div>
                </div>
                <button class="submit" type="submit">Əlavə et</button>
            </form>