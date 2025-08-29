
@extends('layouts.app')


@section('content')
 <div class="viewPenalty-container">
            <a href="{{ route('vehicles.penalties.index',['vehicle'=>request()->vehicle?->id]) }}" class="backLink">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#131527"/>
                </svg>
                Geri
            </a>
            
            <div class="viewPenalty-container-head">
                <h1>Cərimə məlumatları:{{ $item->vehicle?->brand?->title.' '.$item->vehicle?->model?->title }} </h1>
            </div>
            <div class="viewPenalty-body">
                <div class="viewPenalty-body-head">
                    <h2>Ümumi Məlumatlar</h2>
                </div>
                <div class="viewPenalty-form">
                  <div class="form-items">
                      <div class="form-item">
                          <label for="">Cərimə adı</label>
                          <select name="" id="">
                              <option>{{ $item->penaltyType?->title }}</option>
                          </select>
                      </div>
                      <div class="form-item">
                          <label for="">Tarix</label>
                          <div class="form-input">
                              <input type="date" value="{{ $item->date }}">
                          </div>
                      </div>
                      <div class="form-item">
                          <label for="">Cərimə sahibi</label>
                          <select name="" id="">
                              <option value="">Cərimə sahibi1</option>
                              <option value="">Cərimə sahibi2</option>
                              <option value="">Cərimə sahibi3</option>
                          </select>
                      </div>
                      <div class="form-item">
                          <label for="">Cərimənin kodu</label>
                          <div class="form-input">
                              <input type="text" value="{{ $item->penalty_code }}">
                          </div>
                      </div>
                      <div class="form-item">
                          <label for="">Məbləğ</label>
                          <div class="form-input">
                              <input type="text" value="{{ $item->amount }}">
                              <span>azn</span>
                          </div>
                      </div>
                      <div class="form-item">
                          <label for="">Status</label>
                          <select name="" id="">
                                  <option @selected($item->status==2) value="">Ödənilib</option>
                                  <option @selected($item->status==1) value="">Ödənilməyib</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-item">
                      <label for="">Qeyd</label>
                      <div class="form-input">
                          <textarea name="" id="">{{ $item->note }}</textarea>
                      </div>
                  </div>
                </div>
            </div>
        </div>
        @endsection