
@extends('layouts.app')


@section('content')
   <div class="viewOilChange-container">
            <a href="{{ route('oil_changes.index') }}" class="backLink">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#131527"/>
                </svg>
                Geri
            </a>
            <div class="viewOilChange-container-head">
                <h1>Yağın dəyişilməsi məlumatları:{{ $item->brand?->title.' '.$item->model?->title }} </h1>
            </div>
            <div class="viewOilChange-body">
                <div class="viewOilChange-body-head">
                    <h2>Ümumi Məlumatlar</h2>
                </div>
                <div class="viewOilChange-form">
                    <div class="form-items">
                    <div class="form-item">
                        <label for="">Table İD nömrəsi</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->tableId }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Sürücünün adı</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->driver?->name.' '.$item->driver?->surname  }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Marka</label>
                        <select name="" id="">
                            <option value="">{{ $item->brand?->title }}</option>

                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Model</label>
                        <select name="" id="">
                            <option value="">{{ $item->model?->title }}</option>
                           
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="">Dövlət qeydiyyat nişanı</label>
                        <div class="form-input">
                                <input type="text" value="{{ $item->vehicle?->state_registration_number }}">
                        
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Tarix</label>
                        <div class="form-input">
                            <input type="date" value="{{ $item->date->format('Y-m-d') }}">
                        </div>
                    </div>
                    </div>
                    <div class="form-item">
                        <label for="">Yağ dəyişmə növü</label>
                        <select name="" id="">
                            <option value="">{{ $item->oilChangeType?->title }}</option>
                           
                        </select>
                    </div>
                    <div class="form-items">
                        <div class="form-item">
                            <label for="">Yağ dəyişmə km</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->change_interval }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Növbəti yağ dəyişmə km</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->next_change_interval }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Fərq</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->difference_interval }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Status</label>
                            <select name="" id="">
                                <option value="" @selected($item->status!==null and $item->status==1)>Active</option>
                                <option value="" @selected($item->status!==null and $item->status==0)>Deactive</option>
                            </select>
                        </div>
                        <div class="form-item">
                            <label for="">Ümumi qiymət</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->total_price }}">
                                <span>azn</span>
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Yağın qiyməti</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->oil_price }}">
                                <span>azn</span>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-item">
                        <label for="">Qeyd</label>
                        <div class="form-input">
                            <textarea name="" id="">{{ $item->note }}</textarea>
                        </div>
                    </div>
                    <div class="document-box">
                        <h2>Sənəd</h2>
                        <div class="document-list">
                          <div class="document-item">
                             @if($item->file)
                          <div class="document-title">
                            <img src="{{ asset('assets/icons/documentIcon.svg') }}" alt="">
                          
                            @php
                                $parts = explode('/', $item->file);
                                $fileName = end($parts);
                            @endphp

                            <p>{{ $fileName }}</p>

                          </div>
                          
                          <div class="document-actions">
                            <a href="{{ asset('storage/'.$item->file) }}" class="viewDocument" target="_blank">
                              <img src="{{ asset('assets/icons/eye-gray.svg') }}" alt="">
                            </a>
                            <button class="deleteDocument">
                              <img src="{{ asset('assets/icons/trash-gray.svg') }}" alt="">
                            </button>
                          </div>
                          @endif
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection