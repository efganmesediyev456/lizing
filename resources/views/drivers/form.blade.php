<form action="{{ route('drivers.save', ['item' => $item?->id]) }}" class="saveForm" enctype="multipart/form-data">
    <div class="form-items">
        <div class="form-item">
            <label for="">Ad</label>
            <div class="form-input">
                <input type="text" value="{{ $item?->name }}" name="name">
            </div>
            @if ($errors->has('name'))
                @foreach ($errors->get('name') as $error)
                    <p style="color:red">{{ $error }}</p>
                @endforeach
            @endif
        </div>

        <div class="form-item">
            <label for="">Soyad</label>
            <div class="form-input">
                <input type="text" value="{{ $item?->surname }}" name="surname">
            </div>
            @if ($errors->has('surname'))
                @foreach ($errors->get('surname') as $error)
                    <p style="color:red">{{ $error }}</p>
                @endforeach
            @endif
        </div>
        <div class="form-item">
            <label for="">Ata adı</label>
            <div class="form-input">
                <input type="text" value="{{ $item?->father_name }}" name="father_name">
            </div>
            @if ($errors->has('father_name'))
                @foreach ($errors->get('father_name') as $error)
                    <p style="color:red">{{ $error }}</p>
                @endforeach
            @endif
        </div>

        <div class="form-item">
            <label for="">Email</label>
            <div class="form-input">
                <input type="text" value="{{ $item?->email }}" name="email">
            </div>
            @if ($errors->has('email'))
                @foreach ($errors->get('email') as $error)
                    <p style="color:red">{{ $error }}</p>
                @endforeach
            @endif
        </div>


        <div class="form-item">
            <label for="">Əlaqə nömrəsi<span style="color:orange;">(format 0558857194 olmalıdır)</span></label>
            <div class="form-input">
                <input type="text" value="{{ $item?->phone }}" name="phone">
            </div>
            @if ($errors->has('phone'))
                @foreach ($errors->get('phone') as $error)
                    <p style="color:red">{{ $error }}</p>
                @endforeach
            @endif
        </div>

        <div class="form-item">
            <span contenteditable="true" class="editable-label">{{ $item->phone2_label ?? 'Əlaqə nömrəsi 2' }}</span>
            <input type="hidden" name="phone2_label" value="Əlaqə nömrəsi 2">

            <div class="form-input">
                <input type="text" value="{{ $item?->phone2 }}" name="phone2">
            </div>
            @if ($errors->has('phone2'))
                @foreach ($errors->get('phone2') as $error)
                    <p style="color:red">{{ $error }}</p>
                @endforeach
            @endif
        </div>

        <div class="form-item">
            <span contenteditable="true" class="editable-label">{{ $item->phone3_label ?? 'Əlaqə nömrəsi 3' }}</span>
            <input type="hidden" name="phone3_label" value="Əlaqə nömrəsi 3">

            <div class="form-input">
                <input type="text" value="{{ $item?->phone3 }}" name="phone3">
            </div>
            @if ($errors->has('phone3'))
                @foreach ($errors->get('phone3') as $error)
                    <p style="color:red">{{ $error }}</p>
                @endforeach
            @endif
        </div>

        <div class="form-item">
            <span contenteditable="true" class="editable-label">{{ $item->phone4_label ?? 'Əlaqə nömrəsi 4' }}</span>
            <input type="hidden" name="phone4_label" value="Əlaqə nömrəsi 4">

            <div class="form-input">
                <input type="text" value="{{ $item?->phone4 }}" name="phone4">
            </div>
            @if ($errors->has('phone4'))
                @foreach ($errors->get('phone4') as $error)
                    <p style="color:red">{{ $error }}</p>
                @endforeach
            @endif
        </div>

        {{-- <div class="form-item">
            <label for="">Status(Açıq bağlı)</label>
            <select name="status">
                <option value="1" @selected($item?->status == 1)>Aktiv</option>
                <option value="0" @selected($item?->status == 0)>Deaktiv</option>
            </select>
        </div> --}}


        <div class="form-item">
            <label for="">Status</label>
            <select name="status_id">
                <option value="">Seçin</option>
                @foreach ($statuses as $status)
                    <option @if ($action == 'create' and $status->is_active == 1) selected @endif @selected($status->id == $item->status_id)
                        value="{{ $status->id }}">{{ $status->status }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-item">
            <label for="">Table İD nömrəsi</label>
            <div class="form-input">
                <input type="tableId" value="{{ $item?->tableId }}" name="tableId">
            </div>
            @if ($errors->has('tableId'))
                @foreach ($errors->get('tableId') as $error)
                    <p style="color:red">{{ $error }}</p>
                @endforeach
            @endif
        </div>


        <div class="form-item">
            <label for="">Şəxsiyyət FİN</label>
            <div class="form-input">
                <input type="text" value="{{ $item?->fin }}" name="fin">
            </div>
            @if ($errors->has('fin'))
                @foreach ($errors->get('fin') as $error)
                    <p style="color:red">{{ $error }}</p>
                @endforeach
            @endif
        </div>

        <div class="form-item">
            <label for="">Şəxsiyyətin seriya nömrəsi</label>
            <div class="form-input">
                <input type="text" value="{{ $item?->id_card_serial_code }}" name="id_card_serial_code">
            </div>
            @if ($errors->has('id_card_serial_code'))
                @foreach ($errors->get('id_card_serial_code') as $error)
                    <p style="color:red">{{ $error }}</p>
                @endforeach
            @endif
        </div>


        <div class="form-item">
            <label for="">Faktiki yaşadığı ünvan</label>
            <div class="form-input">
                <input type="text" value="{{ $item?->current_address }}" name="current_address">
            </div>
            @if ($errors->has('current_address'))
                @foreach ($errors->get('current_address') as $error)
                    <p style="color:red">{{ $error }}</p>
                @endforeach
            @endif
        </div>

        <div class="form-item">
            <label for="">Qeydiyyatda olduğu ünvan</label>
            <div class="form-input">
                <input type="text" value="{{ $item?->registered_address }}" name="registered_address">
            </div>
            @if ($errors->has('registered_address'))
                @foreach ($errors->get('registered_address') as $error)
                    <p style="color:red">{{ $error }}</p>
                @endforeach
            @endif
        </div>

        <div class="form-item">
            <label for="">Doğum Tarixi</label>
            <div class="form-input">
                <input type="date" value="{{ $item?->date?->format('Y-m-d') }}" name="date">
            </div>
            @if ($errors->has('date'))
                @foreach ($errors->get('date') as $error)
                    <p style="color:red">{{ $error }}</p>
                @endforeach
            @endif
        </div>



        <div class="form-item">
            <label for="">Cinsiyyət</label>
            <select name="gender">
                <option value="0" @selected($item?->gender == 0)>Kişi</option>
                <option value="1" @selected($item?->gender == 1)>Qadın</option>
            </select>
        </div>

        <div class="form-item">
            <label for="">Şəhər</label>
            <select name="city_id" id="">
                <option value="">Secin</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" @selected($city->id == $item->city_id)>{{ $city->title }}</option>
                @endforeach

            </select>
        </div>


        {{-- <div class="form-item">
                        <label for="">Aylıq ödəniş</label>
                        <select name="monthly_payment" id="">
                            <option value="1" @selected($item->monthly_payment==1)>Aktiv</option>
                            <option value="0" @selected($item->monthly_payment==0)>Deaktiv</option>
                        </select>
       </div>

       <div class="form-item">
                        <label for="">Günlük ödəniş</label>
                        <select name="daily_payment" id="">
                            <option value="1" @selected($item->daily_payment==1)>Aktiv</option>
                            <option value="0" @selected($item->daily_payment==0)>Deaktiv</option>
                        </select>
       </div>

       <div class="form-item">
                        <label for="">Depozit ödəniş</label>
                        <select name="deposit_payment" id="">
                            <option value="1" @selected($item->deposit_payment==1)>Aktiv</option>
                            <option value="0" @selected($item->deposit_payment==0)>Deaktiv</option>
                        </select>
       </div> --}}

        {{-- <div class="form-item">
                        <label for="">İlkin Depozit ödəniş</label>
                        <select name="first_deposit_payment" id="">
                            <option value="1" @selected($item->first_deposit_payment==1)>Aktiv</option>
                            <option value="0" @selected($item->first_deposit_payment==0)>Deaktiv</option>
                        </select>
       </div> --}}


        <div class="form-item">
            <label for="">Şifrə</label>
            <div class="form-input">
                <input type="password" name="password">
                <button class="password-eye" type="button">
                    <svg class="eye-open" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 9C12.7956 9 13.5587 9.31607 14.1213 9.87868C14.6839 10.4413 15 11.2044 15 12C15 12.7956 14.6839 13.5587 14.1213 14.1213C13.5587 14.6839 12.7956 15 12 15C11.2044 15 10.4413 14.6839 9.87868 14.1213C9.31607 13.5587 9 12.7956 9 12C9 11.2044 9.31607 10.4413 9.87868 9.87868C10.4413 9.31607 11.2044 9 12 9ZM12 4.5C17 4.5 21.27 7.61 23 12C21.27 16.39 17 19.5 12 19.5C7 19.5 2.73 16.39 1 12C2.73 7.61 7 4.5 12 4.5ZM3.18 12C3.98825 13.6503 5.24331 15.0407 6.80248 16.0133C8.36165 16.9858 10.1624 17.5013 12 17.5013C13.8376 17.5013 15.6383 16.9858 17.1975 16.0133C18.7567 15.0407 20.0117 13.6503 20.82 12C20.0117 10.3497 18.7567 8.95925 17.1975 7.98675C15.6383 7.01424 13.8376 6.49868 12 6.49868C10.1624 6.49868 8.36165 7.01424 6.80248 7.98675C5.24331 8.95925 3.98825 10.3497 3.18 12Z"
                            fill="#A7A7A7"></path>
                    </svg>
                    <svg class="eye-close" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2 5.27L3.28 4L20 20.72L18.73 22L15.65 18.92C14.5 19.3 13.28 19.5 12 19.5C7 19.5 2.73 16.39 1 12C1.69 10.24 2.79 8.69 4.19 7.46L2 5.27ZM12 9C12.7956 9 13.5587 9.31607 14.1213 9.87868C14.6839 10.4413 15 11.2044 15 12C15.0005 12.3406 14.943 12.6787 14.83 13L11 9.17C11.3213 9.05698 11.6594 8.99949 12 9ZM12 4.5C17 4.5 21.27 7.61 23 12C22.1834 14.0729 20.7966 15.8723 19 17.19L17.58 15.76C18.9629 14.8034 20.0783 13.5091 20.82 12C20.0117 10.3499 18.7565 8.95963 17.1974 7.98735C15.6382 7.01508 13.8375 6.49976 12 6.5C10.91 6.5 9.84 6.68 8.84 7L7.3 5.47C8.74 4.85 10.33 4.5 12 4.5ZM3.18 12C3.98835 13.6501 5.24345 15.0404 6.80264 16.0126C8.36182 16.9849 10.1625 17.5002 12 17.5C12.69 17.5 13.37 17.43 14 17.29L11.72 15C11.0242 14.9254 10.3748 14.6149 9.87997 14.12C9.38512 13.6252 9.07458 12.9758 9 12.28L5.6 8.87C4.61 9.72 3.78 10.78 3.18 12Z"
                            fill="#A7A7A7"></path>
                    </svg>
                </button>
            </div>

        </div>










    </div>

    <div class="upload-box">
        <div class="add_file_box">
            <img src="../assets/icons/uploadIcon.svg" alt="" class="uploadIcon">
            <div class="box-text">
                <p>Şəxsiyyət vəsiqəsi (ön) əlavə edin</p>
                <span>JPG, XLSX or PDF, file size no more than 10MB</span>
            </div>
            <p class="selectFileTxt">Fayl seç</p>
            <input type="file" name="id_card_front" class="id_card_front">
        </div>

        <div class="document-list">
            @if ($item?->id_card_front)
                <div class="document-item">
                    <div class="document-title">
                        <img src="../assets/icons/documentIcon.svg" alt="">
                        <p>{{ basename($item->id_card_front) }}</p>
                    </div>
                    <div class="document-actions">
                        <a href="/storage/{{ $item->id_card_front }}" class="viewDocument" target="_blank">
                            <img src="../assets/icons/eye-gray.svg" alt="">
                        </a>
                        <button class="deleteDocument">
                            <img src="../assets/icons/trash-gray.svg" alt="">
                        </button>
                    </div>
                </div>
            @endif
        </div>

        @if ($errors->has('id_card_front'))
            @foreach ($errors->get('id_card_front') as $error)
                <p style="color:red">{{ $error }}</p>
            @endforeach
        @endif
    </div>

    <div class="upload-box">
        <div class="add_file_box">
            <img src="../assets/icons/uploadIcon.svg" alt="" class="uploadIcon">
            <div class="box-text">
                <p>Şəxsiyyət vəsiqəsi (arxa) əlavə edin</p>
                <span>JPG, XLSX or PDF, file size no more than 10MB</span>
            </div>
            <p class="selectFileTxt">Fayl seç</p>
            <input type="file" name="id_card_back" class="id_card_back">
        </div>

        <div class="document-list">
            @if ($item?->id_card_back)
                <div class="document-item">
                    <div class="document-title">
                        <img src="../assets/icons/documentIcon.svg" alt="">
                        <p>{{ basename($item->id_card_back) }}</p>
                    </div>
                    <div class="document-actions">
                        <a href="/storage/{{ $item->id_card_back }}" class="viewDocument" target="_blank">
                            <img src="../assets/icons/eye-gray.svg" alt="">
                        </a>
                        <button class="deleteDocument">
                            <img src="../assets/icons/trash-gray.svg" alt="">
                        </button>
                    </div>
                </div>
            @endif
        </div>

        @if ($errors->has('id_card_back'))
            @foreach ($errors->get('id_card_back') as $error)
                <p style="color:red">{{ $error }}</p>
            @endforeach
        @endif
    </div>


    <div class="upload-box">
        <div class="add_file_box">
            <img src="../assets/icons/uploadIcon.svg" alt="" class="uploadIcon">
            <div class="box-text">
                <p>Sürücülük vəsiqəsi (ön) əlavə edin</p>
                <span>JPG, XLSX or PDF, file size no more than 10MB</span>
            </div>
            <p class="selectFileTxt">Fayl seç</p>
            <input type="file" name="drivers_license_front" class="drivers_license_front">
        </div>

        <div class="document-list">
            @if ($item?->drivers_license_front)
                <div class="document-item">
                    <div class="document-title">
                        <img src="../assets/icons/documentIcon.svg" alt="">
                        <p>{{ basename($item->drivers_license_front) }}</p>
                    </div>
                    <div class="document-actions">
                        <a href="/storage/{{ $item->drivers_license_front }}" class="viewDocument" target="_blank">
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

    <div class="upload-box">
        <div class="add_file_box">
            <img src="../assets/icons/uploadIcon.svg" alt="" class="uploadIcon">
            <div class="box-text">
                <p>Sürücülük vəsiqəsi (arxa) əlavə edin</p>
                <span>JPG, XLSX or PDF, file size no more than 10MB</span>
            </div>
            <p class="selectFileTxt">Fayl seç</p>
            <input type="file" name="drivers_license_back" class="drivers_license_back">
        </div>

        <div class="document-list">
            @if ($item?->drivers_license_back)
                <div class="document-item">
                    <div class="document-title">
                        <img src="../assets/icons/documentIcon.svg" alt="">
                        <p>{{ basename($item->drivers_license_back) }}</p>
                    </div>
                    <div class="document-actions">
                        <a href="/storage/{{ $item->drivers_license_back }}" class="viewDocument" target="_blank">
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
