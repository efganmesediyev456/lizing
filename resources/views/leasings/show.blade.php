
@extends('layouts.app')


@section('content')
 <div class="viewLeasing-container">
            <a href="{{ route('leasing.index') }}" class="backLink">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#131527"/>
                </svg>
                Geri
            </a>
            <div class="viewLeasing-container-head">
                <h1>Lizing məlumatı : {{ $item->driver?->name }} {{ $item->driver?->surname }}</h1>
            </div>
            <div class="viewLeasing-body">
                <div class="viewLeasing-tabs">
                    <button class="leasing_tab active" id="driverInfo">Sürücü Məlumatlar</button>
                    <button class="leasing_tab" id="autoInfo">Auto məlumatlar</button>
                    <button class="leasing_tab" id="leasingInfo">Lizing məlumatlar</button>
                </div>
                <div class="viewLeasing_content driverInfoContent active" data-id="driverInfo">
                  <div class="form-items">
                      <div class="form-item">
                            <label for="">Ad</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->driver?->name }}">
                            </div>
                      </div>
                      <div class="form-item">
                            <label for="">Soyad</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->driver?->surname }}">
                            </div>
                      </div>
                      <div class="form-item">
                          <label for="">Əlaqə nömrəsi</label>
                          <div class="form-input">
                              <input type="text" value="{{ $item->driver?->phone }}">
                          </div>
                      </div>
                      <div class="form-item">
                          <label for="">Şəhər</label>
                          <div class="form-input">
                              <input type="text" value="{{ $item->driver?->city?->title }}">
                          </div>
                      </div>
                      <div class="form-item">
                          <label for="">Şəxsiyyət FİN</label>
                          <div class="form-input">
                              <input type="text" value="{{ $item->driver?->fin }}">
                          </div>
                      </div>
                      <div class="form-item">
                          <label for="">Şəxsiyyətin seriya nömrəsi</label>
                          <div class="form-input">
                              <input type="text" value="{{ $item->driver?->id_card_serial_code }}">
                          </div>
                      </div>
                  </div>
                  {{-- <div class="driver-document-images">
                    <div class="document-box">
                      <h2>Sürücünün şəxsiyyət vəsiqəsi (ön,arxa)</h2>
                      <div class="document-list">
                        <div class="document-item">
                          <div class="document-title">
                            <img src="../assets/icons/documentIcon.svg" alt="">
                            <p>{{ basename($item->driver?->id_card_front) }}</p>
                          </div>
                          <div class="document-actions">
                            <a href="{{ asset('storage/'.$item->driver?->id_card_front) }}" class="viewDocument" target="_blank">
                              <img src="../assets/icons/eye-gray.svg" alt="">
                            </a>
                            <button class="deleteDocument">
                              <img src="../assets/icons/trash-gray.svg" alt="">
                            </button>
                          </div>
                        </div>
                        <div class="document-item">
                          <div class="document-title">
                            <img src="../assets/icons/documentIcon.svg" alt="">
                            <p>{{ basename($item->driver?->id_card_back) }}</p>
                          </div>
                          <div class="document-actions">
                            <a href="{{ asset('storage/'.$item->driver?->id_card_back) }}" class="viewDocument" target="_blank">
                              <img src="../assets/icons/eye-gray.svg" alt="">
                            </a>
                            <button class="deleteDocument">
                              <img src="../assets/icons/trash-gray.svg" alt="">
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="document-box">
                      <h2>Sürücünün sürücülük vəsiqəsi (ön,arxa)</h2>
                      <div class="document-list">
                        <div class="document-item">
                          <div class="document-title">
                            <img src="../assets/icons/documentIcon.svg" alt="">
                            <p>demo_image.jpg</p>
                          </div>
                          <div class="document-actions">
                            <a href="" class="viewDocument" target="_blank">
                              <img src="../assets/icons/eye-gray.svg" alt="">
                            </a>
                            <button class="deleteDocument">
                              <img src="../assets/icons/trash-gray.svg" alt="">
                            </button>
                          </div>
                        </div>
                        <div class="document-item">
                          <div class="document-title">
                            <img src="../assets/icons/documentIcon.svg" alt="">
                            <p>demo_image.jpg</p>
                          </div>
                          <div class="document-actions">
                            <a href="" class="viewDocument" target="_blank">
                              <img src="../assets/icons/eye-gray.svg" alt="">
                            </a>
                            <button class="deleteDocument">
                              <img src="../assets/icons/trash-gray.svg" alt="">
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> --}}
                </div>

                <div class="viewLeasing_content autoInfoContent" data-id="autoInfo">
                  <div class="form-items">
                      <div class="form-item">
                            <label for="">İD nömrə</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->vehicle?->table_id_number }}">
                            </div>
                      </div>
                      <div class="form-item">
                            <label for="">VIN kod</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->vehicle?->vin_code }}">
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
                              <input type="text" value="{{ $item->vehicle?->production_year }}">
                          </div>
                      </div>
                      <div class="form-item">
                          <label for="">Alış qiyməti</label>
                          <div class="form-input">
                              <input type="text" value="{{ $item->vehicle?->purchase_price }}">
                              <span>azn</span>
                          </div>
                      </div>
                      <div class="form-item">
                          <label for="">Yanacaq növü</label>
                          <div class="form-input">
                              <input type="text" value="{{ $item->vehicle?->oilType?->title }}">
                          </div>
                      </div>
                      <div class="form-item">
                          <label for="">Gediş məsafəsi</label>
                          <div class="form-input">
                              <input type="text" value="{{ $item->vehicle?->mileage }}">
                              <span>km</span>
                          </div>
                      </div>
                      <div class="form-item">
                          <label for="">Mühərrik</label>
                          <div class="form-input">
                              <input type="text" value="{{ $item->vehicle?->engine }}">
                              <span>l</span>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="viewLeasing_content leasingInfoContent" data-id="leasingInfo">
                  <div class="form-items">
                      <div class="form-item">
                          <label for="">Depozit ödənişi</label>
                          <div class="form-input">
                              <input type="text" value="{{ $item->deposit_payment }}">
                              <span>azn</span>
                          </div>
                      </div>
                      <div class="form-item">
                          <label for="">Lizing ödənişi</label>
                          <div class="form-input">
                              <input type="text" value="{{ $item->deposit_price }}">
                              <span>azn</span>
                          </div>
                      </div>
                      <div class="form-item">
                            <label for="">Günlük ödəniş</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->daily_payment }}">
                                <span>azn</span>
                            </div>
                      </div>
                      <div class="form-item">
                          <label for="">Lizing müddəti</label>
                          <div class="form-input">
                              <input type="text" value="{{ $item->leasing_period_months }}">
                              <span>ay</span>
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
                  <div class="form-item">
                      <label for="">Qeyd</label>
                      <div class="form-input">
                          <textarea name="" id="">{{ $item->notes }}</textarea>
                      </div>
                  </div>
                  <div class="documents">
                    <div class="document-box">
                      <h2>Müqavilə</h2>
                      <div class="document-list">
                        <div class="document-item">
                          <div class="document-title">
                            <img src="../assets/icons/documentIcon.svg" alt="">
                            <p>{{ basename($item->contract_file) }}</p>
                          </div>
                          <div class="document-actions">
                            <a href="{{ url('storage/'.$item->contract_file) }}" class="viewDocument" target="_blank">
                              <img src="../assets/icons/eye-gray.svg" alt="">
                            </a>
                            {{-- <button class="deleteDocument">
                              <img src="../assets/icons/trash-gray.svg" alt="">
                            </button> --}}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        @endsection