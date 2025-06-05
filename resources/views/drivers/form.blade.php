@if(isset($message))
<p style="padding:12px; background:green; color:white; border-radius:4px; text-align:center; margin-top:22px;" class="message">{{$message}}</p>
@else
<form action="{{route('drivers.save',['item'=>$item?->id])}}" class="saveForm" enctype="multipart/form-data">
    <div class="form-items">
        <div class="form-item">
            <label for="">Ad</label>
            <div class="form-input">
                <input type="text" value="{{$item?->name}}" name="name">
            </div>
            @if($errors->has("name"))
                @foreach($errors->get("name") as $error)
                    <p style="color:red">{{$error}}</p>
                @endforeach
            @endif
        </div>

        <div class="form-item">
            <label for="">Soyad</label>
            <div class="form-input">
                <input type="text" value="{{$item?->surname}}" name="surname">
            </div>
            @if($errors->has("surname"))
                @foreach($errors->get("surname") as $error)
                    <p style="color:red">{{$error}}</p>
                @endforeach
            @endif
        </div>

        <div class="form-item">
            <label for="">Email</label>
            <div class="form-input">
                <input type="text" value="{{$item?->email}}" name="email">
            </div>
            @if($errors->has("email"))
                @foreach($errors->get("email") as $error)
                    <p style="color:red">{{$error}}</p>
                @endforeach
            @endif
        </div>


        <div class="form-item">
            <label for="">Əlaqə nömrəsi</label>
            <div class="form-input">
                <input type="text" value="{{$item?->phone}}" name="phone">
            </div>
            @if($errors->has("phone"))
                @foreach($errors->get("phone") as $error)
                    <p style="color:red">{{$error}}</p>
                @endforeach
            @endif
        </div>

        <div class="form-item">
            <label for="">Status</label>
            <select name="status">
                <option value="1" @selected($item?->status == 1)>Aktiv</option>
                <option value="0" @selected($item?->status == 0)>Deaktiv</option>
            </select>
        </div>

        <div class="form-item">
            <label for="">Table İD nömrəsi</label>
            <div class="form-input">
                <input type="tableId" value="{{$item?->tableId}}" name="tableId">
            </div>
            @if($errors->has("tableId"))
                @foreach($errors->get("tableId") as $error)
                    <p style="color:red">{{$error}}</p>
                @endforeach
            @endif
        </div>
        

        <div class="form-item">
            <label for="">Şəxsiyyət FİN</label>
            <div class="form-input">
                <input type="text" value="{{$item?->fin}}" name="fin">
            </div>
            @if($errors->has("fin"))
                @foreach($errors->get("fin") as $error)
                    <p style="color:red">{{$error}}</p>
                @endforeach
            @endif
        </div>

        <div class="form-item">
            <label for="">Şəxsiyyətin seriya nömrəsi</label>
            <div class="form-input">
                <input type="text" value="{{$item?->id_card_serial_code}}" name="id_card_serial_code">
            </div>
            @if($errors->has("id_card_serial_code"))
                @foreach($errors->get("id_card_serial_code") as $error)
                    <p style="color:red">{{$error}}</p>
                @endforeach
            @endif
        </div>


        <div class="form-item">
            <label for="">Faktiki yaşadığı ünvan</label>
            <div class="form-input">
                <input type="text" value="{{$item?->current_address}}" name="current_address">
            </div>
             @if($errors->has("current_address"))
                @foreach($errors->get("current_address") as $error)
                    <p style="color:red">{{$error}}</p>
                @endforeach
            @endif
        </div>

        <div class="form-item">
            <label for="">Qeydiyyatda olduğu ünvan</label>
            <div class="form-input">
                <input type="text" value="{{$item?->registered_address}}" name="registered_address">
            </div>
            @if($errors->has("registered_address"))
                @foreach($errors->get("registered_address") as $error)
                    <p style="color:red">{{$error}}</p>
                @endforeach
            @endif
        </div>

        <div class="form-item">
            <label for="">Doğum Tarixi</label>
            <div class="form-input">
                <input type="date" value="{{$item?->date?->format('Y-m-d')}}" name="date">
            </div>
            @if($errors->has("date"))
                @foreach($errors->get("date") as $error)
                    <p style="color:red">{{$error}}</p>
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
            @if($item?->id_card_front)
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

        @if($errors->has("id_card_front"))
            @foreach($errors->get("id_card_front") as $error)
                <p style="color:red">{{$error}}</p>
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
            @if($item?->id_card_back)
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

        @if($errors->has("id_card_back"))
            @foreach($errors->get("id_card_back") as $error)
                <p style="color:red">{{$error}}</p>
            @endforeach
        @endif
    </div>

    <button class="submit" type="submit">Əlavə et</button>
</form>
@endif
