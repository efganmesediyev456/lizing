@extends('layouts.app')


@section('content')

<div class="addRolePermisson-container">
  <a href="{{ route('role-permissions.index') }}" class="backLink">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#131527"></path>
    </svg>
    Geri
  </a>
  <div class="addRolePermisson-container-head">
    <h1>Rol icazəsi əlavə et</h1>
  </div>
  <form action="{{ route('role-permissions.store', ['item'=>$item->id]) }}" class="roleForm" method="POST">
    @csrf
    <div class="role-name">
      <label for="">Rol adı</label>
      <select name="role_id" id="">
        <option value="">Seçin</option>
        @foreach($roles as $role)
        <option @selected($item->id == $role->id) value="{{ $role->id }}">{{ $role->name }}</option>
        @endforeach
      </select>
      @error('role_id')
      <p style="color:red">{{ $message }}</p>
      @enderror
    </div>
    <div class="permissons">
      <p>İcazələr</p>
      <div class="permissons-boxes">
        @foreach($permissions as $key=>$permissionGroups)
        <div class="permisson-box">
          <h2 class="permisson-title">{{ $key }}</h2>
          <div class="permisson-list">
            @foreach($permissionGroups as $per)
            <div class="permisson-item">
              <input @checked($item->hasPermissionTo($per->name)) value="{{ $per->name }}" name="permissions[]" type="checkbox">
              <label for="">{{ $per->permssion_title }}</label>
            </div>
            @endforeach
          </div>
        </div>
        @endforeach

        @error('permissions')
        <p style="color:red">{{ $message }}</p>
        @enderror
      </div>
    </div>
    <button class="saveForm" type="submit">
      Yadda saxla
    </button>
  </form>
</div>
@endsection