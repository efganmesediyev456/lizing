
@extends('layouts.app')


@section('content')
 <div class="viewRevenue-container">
            <a href="{{ route('revenues.index') }}" class="backLink">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#131527"/>
                </svg>
                Geri
            </a>
            <div class="viewRevenue-container-head">
                <h1>Gəlir məlumatları</h1>
            </div>
            <div class="viewRevenue-body">
                <div class="viewRevenue-body-head">
                    <h2>Ümumi Məlumatlar</h2>
                </div>
                <div class="viewRevenue-form">
                    <div class="form-items">
                          <div class="form-item">
                              <label for="">Tarix</label>
                              <div class="form-input">
                                  <input type="date" value="{{ $item->updated_at?->format('Y-m-d') }}">
                              </div>
                          </div>
                          <div class="form-item">
                              <label for="">Table ID</label>
                              <div class="form-input">
                                  <input type="text" value="{{ $item->leasing?->tableId }}">
                              </div>
                          </div>
                          <div class="form-item">
                              <label for="">D.Q.N</label>
                              <select name="" id="">
                                  <option value="">{{ $item?->leasing?->vehicle?->state_registration_number }}</option>
                              </select>
                          </div>
                          <div class="form-item">
                              <label for="">Gəlir</label>
                              <div class="form-input">
                                  <input type="text" value="{{ $item->price }}">
                                  <span>azn</span>
                              </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection