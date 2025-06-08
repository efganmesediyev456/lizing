@extends('layouts.app')


@section('content')
  <div class="viewRolePermisson-container">
            <a href="{{ route('role-permissions.index') }}" class="backLink">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#131527"/>
                </svg>
                Geri
            </a>
            <div class="viewRolePermisson-container-head">
                <h1>Rol icazəsi məlumatları</h1>
            </div>
            <div class="roleForm">
                <div class="role-name">
                    <label for="">Rol adı</label>
                    <input type="text" value="{{ $item->name }}">
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
            </div>
  </div>
@endsection

