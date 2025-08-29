
<form action="{{route('brands.save',['item'=>$item?->id])}}" class="saveForm" enctype="multipart/form-data">
    
     <div class="form-item">
            <label for="">Marka</label>
            <div class="form-input">
                <input type="text" value="{{$item?->title}}" name="title">
            </div>
            @if($errors->has("title"))
                @foreach($errors->get("title") as $error)
                    <p style="color:red">{{$error}}</p>
                @endforeach
            @endif
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

