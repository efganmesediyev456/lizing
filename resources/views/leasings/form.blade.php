<form action="{{route('leasing.save',['item'=>$item?->id])}}" class="saveForm" enctype="multipart/form-data">
                <div class="form-items">
                    <div class="form-item">
                        <label for="">Sürücü</label>
                        <select  name="driver_id" id="driver_id">
                            <option value="">Seçin</option>
                            @foreach($drivers as $driver)
                                <option @selected($driver->id==$item->driver_id) value="{{ $driver->id }}">{{ $driver->name.' '.$driver->surname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Sürücü FİN</label>
                        <select name="fin" id="fin" >
                            <option value="">Seçin</option>
                            @if($item->driver_id)
                                <option selected value="{{ $item->driver?->fin }}">{{ $item->driver?->fin }}</option>
                            @endif
                        </select>
                    </div>
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
                            <input name="tableId" type="text" value="{{ $item->tableId }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Status</label>
                        <select name="status" id="">
                            <option value="" @selected($item->status!==null and $item->status==1)>Active</option>
                            <option value="" @selected($item->status!==null and $item->status==0)>Deactive</option>
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Reklam</label>
                        <select name="has_advertisement" id="">
                            <option value="1" @selected($item->has_advertisement!==null and $item->has_advertisement==1)>var</option>
                            <option value="0" @selected($item->has_advertisement!==null and $item->has_advertisement==0)>yoxdur</option>
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Depozit ödənişi</label>
                        <div class="form-input">
                            <input type="number" name="deposit_payment" value="{{ $item->deposit_payment }}">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Depozit qiyməti</label>
                        <div class="form-input">
                            <input type="number" name="deposit_price" value="{{ $item->deposit_price }}">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Depozit borcu</label>
                        <div class="form-input">
                            <input type="number" name="deposit_debt" value="{{ $item->deposit_debt }}">
                            <span>azn</span>
                        </div>
                    </div>
                    
                    <div class="form-item">
                        <label for="">Lizing qiyməti</label>
                        <div class="form-input">
                            <input type="number" name="leasing_price" value="{{ $item->leasing_price }}">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Günlük ödəniş</label>
                        <div class="form-input">
                            <input type="number" name="daily_payment" value="{{ $item->daily_payment }}">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Aylıq ödəniş</label>
                        <div class="form-input">
                            <input type="number" name="monthly_payment" value="{{ $item->monthly_payment }}">
                            <span>azn</span>
                        </div>
                    </div> 
                    <div class="form-item">
                        <label for="">Lizing müddəti (gün)</label>
                        <div class="form-input">
                            <input type="number" name="leasing_period_days" value="{{ $item->leasing_period_days }}">
                            <span>gün</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Lizing müddəti (ay)</label>
                        <div class="form-input">
                            <input type="number" name="leasing_period_months" value="{{ $item->leasing_period_months }}">
                            <span>ay</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Başlama tarixi</label>
                        <div class="form-input">
                            <input type="date" name="start_date" value="{{ $item->start_date?->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Bitmə tarixi</label>
                        <div class="form-input">
                            <input type="date" name="end_date" value="{{ $item->end_date?->format('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="form-item">
                    <label for="">Qeyd</label>
                    <div class="form-input">
                        <textarea name="notes" id="" >{{ $item->notes }}</textarea>
                    </div>
                </div>
                <div class="upload-box">
                    <div class="add_file_box">
                        <img src="../assets/icons/uploadIcon.svg" alt="" class="uploadIcon">
                        <div class="box-text">
                            <p>Müqavilə sənədini əlavə edin</p>
                            <span>JPG, XLSX or PDF, file size no more than 10MB</span>
                        </div>
                        <p class="selectFileTxt">Fayl seç</p>
                        <input type="file" name="upload" class="file">
                    </div>
                    <div class="document-list">
                        @if($item?->file)
                        <div class="document-item">
                            <div class="document-title">
                                <img src="../assets/icons/documentIcon.svg" alt="">
                                <p>{{ basename($item->file) }}</p>
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