
<form action="{{route('excel.store')}}" class="saveForm" enctype="multipart/form-data">

    <div class="upload-box">
        <div class="add_file_box">
            <img src="../assets/icons/uploadIcon.svg" alt="" class="uploadIcon">
            <div class="box-text">
                <p>Şəxsiyyət vəsiqəsi (ön) əlavə edin</p>
                <span>JPG, XLSX or PDF, file size no more than 10MB</span>
            </div>
            <p class="selectFileTxt">Fayl seç</p>
            <input type="file" name="file" class="file">
        </div>

        <div class="document-list">
           
        </div>

        
    </div>

    <button class="submit" type="submit">Əlavə et</button>
</form>

