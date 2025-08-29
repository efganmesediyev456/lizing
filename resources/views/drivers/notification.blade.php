@if(isset($message))
<p style="padding:12px; background:green; color:white; border-radius:4px; text-align:center; margin-top:22px;" class="message">{{$message}}</p>
@else
<form action="{{route('notification.sendNotification',['item'=>$item?->id])}}" class="saveForm" enctype="multipart/form-data">
    <div class="form-items">
                    <div class="form-item">
                        <label for="">Ad</label>
                        <div class="form-input">
                            <input type="text" name="name" value="{{ $item->name }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Soyad</label>
                        <div class="form-input">
                            <input type="text" name="surname" value="{{ $item->surname }}">
                        </div>
                    </div>
                </div>
                <div class="form-item">
                    <label for="">Mövzu</label>
                    <select id="" name="driver_notification_topic_id"> 
                        <option value="">Seçin</option>
                        @foreach($topics as $topic)
                        <option value="{{ $topic->id }}">{{ $topic->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-item">
                    <label for="">Qeyd</label>
                    <textarea class="formTextarea" name="note" id=""></textarea>
                </div>

                <div class="upload-box">
                    <div class="add_file_box">
                        <img src="../assets/icons/uploadIcon.svg" alt="" class="uploadIcon">
                        <div class="box-text">
                            <p>Fayl və ya şəkil əlavə et</p>
                            <span>JPG, XLSX or PDF, file size no more than 10MB</span>
                        </div>
                        <p class="selectFileTxt">Fayl seç</p>
                        <input type="file" name="image" class="notificationImage">
                    </div>
                     <div class="document-list">

                    </div>
                
                </div>

    <button class="submit" type="submit">Əlavə et</button>
</form>
@endif
