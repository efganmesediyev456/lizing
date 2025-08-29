

@extends('layouts.app')


@section('content')
  <div class="viewNotification-container">
          <a href="{{ route('notifications.index') }}" class="backLink">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z"
                fill="#131527"
              />
            </svg>
            Geri
          </a>
          <div class="viewNotification-container-head">
            <h1>Bildiriş məlumatları</h1>
          </div>
          <div class="viewNotification-body">
            <div class="viewNotification-body-head">
              <h2>Ümumi Məlumatlar</h2>
            </div>
            <div class="viewNotification-form">
              <div class="notification-title">
                <h3>Başlıq</h3>
                <p>{{ $item->driverNotificationTopic?->title }}</p>
              </div>
              <div class="notification-status">
                <h3>Status</h3>
                <p>{{$status}}</p>
              </div>
              <div class="notification-note">
                <h3>Qeyd</h3>
                <p>{{ $item->note }}</p>
              </div>
              <div class="notification-users">
                <h3>Bildiriş alan şəxslər</h3>
                <div class="users-list">
                    @foreach($item->drivers as $dd)
                        <p>{{ $dd->driver?->fullName }}</p>
                    @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        @endsection