@if(isset($message))
<p style="padding:12px; background:green; color:white; border-radius:4px; text-align:center; margin-top:22px;" class="message">{{$message}}</p>
@else
<form action="{{route('oil_changes.save',['item'=>$item?->id])}}" class="saveForm" enctype="multipart/form-data">
    

    <div class="form-items">
                    <div class="form-item">
                        <label for="">Table İD nömrəsi</label>
                        <div class="form-input" >
                            <input type="text" name="tableId" value="{{ $item->tableId }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Sürücünün adı</label>
                        <select name="driver_id" id="">
                                <option>Secin</option>
                            @foreach($drivers as $driver)
                                <option @selected($driver->id==$item->driver_id) value="{{ $driver->id }}">{{ $driver->name.' '.$driver->surname }}</option>
                            @endforeach
                        </select>
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
                        <label for="">Tarix</label>
                        <div class="form-input">
                            <input type="date" name="date" value="{{ $item->date }}">
                        </div>
                    </div>
                    
                </div>


                <div class="form-item">
                    <label for="">Yağ dəyişmə növü</label>
                    <select name="oil_change_type_id" id="">
                        <option value="">Secin</option>
                       @foreach($oilChangeTypes as $oilChangeType)
                        <option value="{{ $oilChangeType->id }}" @selected($oilChangeType->id==$item->oil_change_type_id)>{{ $oilChangeType->title }}</option>

                       @endforeach
                    </select>
                </div>




                <div class="form-items">
                    <div class="form-item">
                        <label for="">Yağ dəyişmə km</label>
                        <div class="form-input">
                            <input type="number" name="change_interval" value="{{ $item->change_interval }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Növbəti yağ dəyişmə km</label>
                        <div class="form-input">
                            <input type="number" value="{{ $item->next_change_interval }}" name="next_change_interval">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Fərq</label>
                        <div class="form-input">
                            <input type="number" value="{{ $item->difference_interval }}" name="difference_interval">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Status</label>
                        <select name="status" id="">
                                <option @selected($item!==null and $item->status==1) value="1">Active</option>
                                <option @selected($item!==null and $item->status==0) value="0">Deactive</option>
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Ümumi qiymət</label>
                        <div class="form-input">
                            <input type="number" value="{{ $item->total_price }}" name="total_price">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Yağın qiyməti</label>
                        <div class="form-input">
                            <input type="number" value="{{ $item->oil_price }}" name="oil_price">
                            <span>azn</span>
                        </div>
                    </div>
                    
                </div>

                <div class="form-item">
                    <label for="">Qeyd</label>
                    <div class="form-input">
                        <textarea name="note" id="">{{ $item->note }}</textarea>
                    </div>
                </div>


                <div class="upload-box">
                    <div class="add_file_box">
                        <img src="../assets/icons/uploadIcon.svg" alt="" class="uploadIcon">
                        <div class="box-text">
                            <p>Sənəd əlavə et</p>
                            <span>JPG, XLSX or PDF, file size no more than 10MB</span>
                        </div>
                        <p class="selectFileTxt">Fayl seç</p>
                        <input type="file" name="file" class="file">
                    </div>
                    
                    <div class="document-list">
                        @if($item?->file!='' and $item?->file)
                        <div class="document-item">
                            <div class="document-title">
                                <img src="../assets/icons/documentIcon.svg" alt="">
                                <p>{{ $item->file }}</p>
                            </div>
                            <div class="document-actions">
                                <a href="/storage/{{ $item->file }}" class="viewDocument" target="_blank">
                                    <img src="../assets/icons/eye-gray.svg" alt="">
                                </a>
                                <button class="deleteDocument">
                                    <img src="../assets/icons/trash-gray.svg" alt="">
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                
                </div>

    <button class="submit" type="submit">Əlavə et</button>
</form>
@endif
