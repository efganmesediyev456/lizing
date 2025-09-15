
<form action="{{route('technical_reviews.save',['item'=>$item?->id])}}" class="saveForm" enctype="multipart/form-data">
    

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
                                <option value="">Secin</option>
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
                        <label for="">Istehsal ili</label>
                        <div class="form-input">
                            <input type="text" name="production_year" value="{{ $item->production_year }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Texniki baxış ödənişi</label>
                        <div class="form-input">
                            <input type="number" name="technical_review_fee" value="{{ $item->technical_review_fee }}">
                            <span>azn</span>
                        </div>
                    </div>

                    <div class="form-item">
                        <label for="">Karobka yaginin bize verenler</label>
                        <div class="form-input">
                            <input type="text" name="transmission_oil_suppliers" value="{{ $item->transmission_oil_suppliers}}">
                            <span>azn</span>
                        </div>
                    </div>


                    <div class="form-item">
                        <label for="">Status</label>
                        <select name="status" id="">
                            <option @selected($item?->status==1 and $item->status!==null) value="1">Keçdi</option>
                            <option @selected($item?->status==0 and $item->status!==null) value="0">Keçmədi</option>
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Başlama tarixi</label>
                        <div class="form-input">
                            <input name="start_date" type="date" value="{{ $item->start_date?->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Bitmə tarixi</label>
                        <div class="form-input">
                            <input name="end_date" type="date" value="{{ $item->end_date?->format('Y-m-d') }}"> 
                        </div>
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
                        <input type="file" name="file">
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

