@if(isset($message))
<p style="padding:12px; background:green; color:white; border-radius:4px; text-align:center; margin-top:22px;" class="message">{{$message}}</p>
@else
<form action="{{route('driver-notification-topic.save',['item'=>$item?->id])}}" class="saveForm" enctype="multipart/form-data">
    
     <div class="form-item">
            <label for="">Ad</label>
            <div class="form-input">
                <input type="text" value="{{$item?->title}}" name="title">
            </div>
            
        </div>
     <div class="form-item">
            <label for="">Status</label>
            <select name="status">
                <option value="1" @selected($item?->status!==null && $item?->status == 1)>Aktiv</option>
                <option value="0" @selected($item?->status!==null && $item?->status == 0)>Deaktiv</option>
            </select>
        </div>

    <button class="submit" type="submit">Əlavə et</button>
</form>
@endif
