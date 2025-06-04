  @if(isset($message))
  <p style="padding:12px; background:green; color:white; border-radius:4px; text-align:center; margin-top:22px;" class="message"> {{$message}}</p>
  @else
  <form action="{{route('role-managements.save',['item'=>$item?->id])}}" class="saveForm" enctype="multipart/form-data">
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
         
      </div>
      <div class="form-items">
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
                <select name="status" id="">
                    <option value="1" @selected($item->status!==null && $item->status==1)>Active</option>
                    <option value="0" @selected($item->status!==null && $item->status==0)>Deactive</option>
                </select>
            </div>

             <div class="form-item">
                <label for="">Table İD nömrəsi</label>
                <div class="form-input">
                    <input type="text" value="{{$item?->tableId}}" name="tableId">

                </div>
                @if($errors->has("tableId"))
                @foreach($errors->get("tableId") as $error)
                <p style="color:red">{{$error}}</p>
                @endforeach
                @endif
            </div>
         
      </div>
     
      <button class="submit" type="submit">Əlavə et</button>
  </form>

  @endif