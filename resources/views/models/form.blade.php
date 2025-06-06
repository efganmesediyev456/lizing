@if(isset($message))
<p style="padding:12px; background:green; color:white; border-radius:4px; text-align:center; margin-top:22px;" class="message">{{$message}}</p>
@else
<form action="{{route('models.save',['item'=>$item?->id])}}" class="saveForm" enctype="multipart/form-data">
    
     <div class="form-item">
            <label for="">Marka</label>
            <select name="brand_id" id="">
                        <option value="">Secin</option>
                        @foreach($brands as $brand)
                        <option @selected($brand->id==$item?->brand_id) value="{{ $brand->id }}">{{ $brand->title }}</option>
                        @endforeach
                    </select>
            @if($errors->has("brand_id"))
                @foreach($errors->get("brand_id") as $error)
                    <p style="color:red">{{$error}}</p>
                @endforeach
            @endif
        </div>
        <div class="form-item">
                    <label for="">Model</label>
                    <div class="form-input">
                        <input name="title" type="text" value="{{ $item?->title }}">
                    </div>
                     @if($errors->has("title"))
                    @foreach($errors->get("title") as $error)
                        <p style="color:red">{{$error}}</p>
                    @endforeach
                @endif
                </div>



                <div class="form-item">
                    <label for="">Ban növü</label>
                    <select name="ban_type_id" id="" >
                        <option value="">Secin</option>
                         @foreach($banTypes as $ban)
                        <option @selected($item?->ban_type_id==$ban->id)  value="{{ $ban->id }}">{{ $ban->title }}</option>
                        @endforeach
                    </select>

                     @if($errors->has("ban_type_id"))
                    @foreach($errors->get("ban_type_id") as $error)
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
@endif
