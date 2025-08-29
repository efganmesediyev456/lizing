@if (isset($message))
    <p style="padding:12px; background:green; color:white; border-radius:4px; text-align:center; margin-top:22px;"
        class="message">{{ $message }}</p>
@else
    <form action="{{ route('vehicles.save', ['item' => $item?->id]) }}" class="saveForm" enctype="multipart/form-data">
        <div class="form-items">
            <div class="form-item">
                <label for="">Table ID Nömrəsi</label>
                <div class="form-input">
                    <input type="text" value="{{ $item?->table_id_number }}" name="table_id_number">
                </div>
                @error('table_id_number')
                    <p style="color:red">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-item">
                <label for="">VIN Kod</label>
                <div class="form-input">
                    <input type="text" value="{{ $item?->vin_code }}" name="vin_code">
                </div>
                @error('vin_code')
                    <p style="color:red">{{ $message }}</p>
                @enderror
            </div>


            <div class="form-item">
                <label for="">Marka</label>
                <select name="brand_id" id="brand_id">
                    <option value="">Secin</option>
                    @foreach ($brands as $brand)
                        <option @selected($brand->id == $item?->brand_id) value="{{ $brand->id }}">{{ $brand->title }}</option>
                    @endforeach

                </select>
            </div>
            <div class="form-item">
                <label for="">Model</label>
                <select name="model_id" id="model_id">
                    <option value="">Secin</option>
                    @foreach ($models as $model)
                        <option @selected($model->id == $item?->model_id) value="{{ $model->id }}">{{ $model->title }}</option>
                    @endforeach

                </select>
            </div>

            <div class="form-item">
                <label for="">Dövlət Qeydiyyat Nişanı</label>
                <div class="form-input">
                    <input type="text" value="{{ $item?->state_registration_number }}"
                        name="state_registration_number">
                </div>
                @error('state_registration_number')
                    <p style="color:red">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-item">
                <label for="">Status</label>
                <select name="status">
                    <option value="1" @selected($item?->status == 1)>Aktiv</option>
                    <option value="0" @selected($item?->status == 0)>Deaktiv</option>
                </select>
            </div>


            <div class="form-item">
                <label for="">İstehsal İli</label>
                <div class="form-input">
                    <input type="number" value="{{ $item?->production_year }}" name="production_year">
                </div>
                @error('production_year')
                    <p style="color:red">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-item">
                <label for="">Alış Qiyməti</label>
                <div class="form-input">
                    <input type="number" step="0.01" value="{{ $item?->purchase_price }}" name="purchase_price">

                </div>
                @error('purchase_price')
                    <p style="color:red">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-item">
                <label for="">Gediş Məsafəsi</label>
                <div class="form-input">
                    <input type="number" value="{{ $item?->mileage }}" name="mileage">
                    <span>km</span>
                </div>
                @error('mileage')
                    <p style="color:red">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-item">
                <label for="">Rəngi</label>
                <select name="color_id" id="">
                    <option value="">Secin</option>
                    @foreach ($colors as $color)
                        <option @selected($color->id == $item?->color_id) value="{{ $color->id }}">{{ $color->title }}</option>
                    @endforeach

                </select>
            </div>


            <div class="form-item">
                <label for="">Yanacaq növü</label>
                <select name="oil_type_id" id="">
                    <option value="">Secin</option>
                    @foreach ($oilTypes as $oilType)
                        <option @selected($oilType->id == $item?->oil_type_id) value="{{ $oilType->id }}">{{ $oilType->title }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="form-item">
                <label for="">Mühərrik</label>
                <div class="form-input">
                    <input type="text" value="{{ $item?->engine }}" name="engine">
                    <span>l</span>
                </div>
                @error('engine')
                    <p style="color:red">{{ $message }}</p>
                @enderror
            </div>


            <div class="form-item">
                <label for="">Texniki baxış başlama vaxtı</label>
                <div class="form-input">
                    <input type="date" value="{{ $item?->technicalReview?->start_date?->format("Y-m-d") }}" name="technical_start_date">
                </div>
            </div>

            <div class="form-item">
                <label for="">Texniki baxış bitmə vaxtı</label>
                <div class="form-input">
                    <input type="date" value="{{ $item?->technicalReview?->end_date?->format("Y-m-d") }}" name="technical_end_date">
                </div>
            </div>


            <div class="form-item">
                <label for="">Texniki baxış ödənişi</label>
                <div class="form-input">
                    <input type="number" any=".01" value="{{ $item?->technicalReview?->technical_review_fee }}" name="technical_review_fee">
                </div>
            </div>


             <div class="form-item">
                <label for="">Karobka yaginin bize verenler</label>
                <div class="form-input">
                    <input type="text" value="{{ $item?->technicalReview?->transmission_oil_suppliers }}" name="technical_transmission_oil_suppliers">
                </div>
            </div>




            <div class="form-item">
                <label for="">Sığortanın başlama vaxtı</label>
                <div class="form-input">
                    <input type="date" value="{{ $item?->insurance?->start_date?->format("Y-m-d") }}" name="insurance_start_date">
                </div>
            </div>
            

            <div class="form-item">
                <label for="">Sığortanın bitmə vaxtı</label>
                <div class="form-input">
                    <input type="date" value="{{ $item?->insurance?->end_date?->format("Y-m-d") }}" name="insurance_end_date">
                </div>
            </div>

            <div class="form-item">
                        <label for="">Siğorta ödənişi</label>
                        <div class="form-input">
                            <input type="number" name="insurance_fee" value="{{ $item->insurance?->insurance_fee }}">
                            <span>azn</span>
                        </div>
                    </div>

             <div class="form-item">
                        <label for="">Sığorta şirkətinin adı</label>
                        <div class="form-input">
                            <input type="text" name="insurance_company_name" value="{{ $item?->insurance?->company_name }}">
                        </div>
                    </div>
                    








            


            <div class="form-item">
                <label for="">Avtomobil statusu</label>
                <select name="vehicle_status_id">
                    <option value="">Seçin</option>
                    @foreach ($vehicleStatuses as $vehicleStatus)
                        <option @selected($vehicleStatus->id == $item?->vehicle_status_id) value="{{ $vehicleStatus->id }}">
                            {{ $vehicleStatus->title }}
                        </option>
                    @endforeach
                </select>
            </div>



            <div class="upload-box" style="grid-column: span 2;">
                <div class="add_file_box">
                    <img src="../assets/icons/uploadIcon.svg" alt="" class="uploadIcon">
                    <div class="box-text">
                        <p>Şəxsiyyət vəsiqəsi (ön) əlavə edin</p>
                        <span>JPG, XLSX or PDF, file size no more than 10MB</span>
                    </div>
                    <p class="selectFileTxt">Fayl seç</p>
                    <input type="file" name="image" class="id_card_front">
                </div>

                <div class="document-list">
                    @if ($item?->image)
                        <div class="document-item">
                            <div class="document-title">
                                <img src="../assets/icons/documentIcon.svg" alt="">
                                <p>{{ basename($item->image) }}</p>
                            </div>
                            <div class="document-actions">
                                <a href="/storage/{{ $item->image }}" class="viewDocument" target="_blank">
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


        </div>


        </div>

        <button class="submit" type="submit">Yadda Saxla</button>
    </form>
@endif
