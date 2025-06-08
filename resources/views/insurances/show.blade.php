
@extends('layouts.app')


@section('content')
 <div class="viewInsurance-container">
            <a href="{{ route('insurances.index') }}" class="backLink">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#131527"/>
                </svg>
                Geri
            </a>
            <div class="viewInsurance-container-head">
                <h1>Siğorta məlumatları:{{ $item->brand?->title.' '.$item->model?->title }} </h1>
            </div>
            <div class="viewInsurance-body">
                <div class="viewInsurance-body-head">
                    <h2>Ümumi Məlumatlar</h2>
                </div>
                <div class="viewInsurance-form">
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
                            <div class="form-input">
                                <input type="text" value="{{ $item->brand?->title }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Model</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->model?->title }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Dövlət qeydiyyat nişanı</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->vehicle?->state_registration_number }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Istehsal ili</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->production_year }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Siğorta ödənişi</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->insurance_fee }} ">
                                <span>azn</span>
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Cari tarix</label>
                            <div class="form-input">
                                <input type="text" value="">
                            </div>
                        </div>
                      <div class="form-item">
                            <label for="">Başlama tarixi</label>
                            <div class="form-input">
                                <input type="date" value="{{ $item->start_date->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Bitmə tarixi</label>
                            <div class="form-input">
                                <input type="date" value="{{ $item->end_date->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="document-box">
                      <h2>Sığorta faylı</h2>
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