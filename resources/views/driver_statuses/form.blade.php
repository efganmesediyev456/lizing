
<form action="{{route('driver_statuses.save',['item'=>$item?->id])}}" class="saveForm" enctype="multipart/form-data">
    
     <div class="form-item">
            <label for="">Ad</label>
            <div class="form-input">
            <input type="text" name="status" value="{{ $item?->status }}">
            </div>
           
    </div>

    <button class="submit" type="submit">Əlavə et</button>
</form>

