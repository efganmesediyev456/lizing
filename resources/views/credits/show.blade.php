
@extends('layouts.app')


@section('content')
  <div class="viewCredit-container">
            <a href="{{ route('credits.index') }}" class="backLink">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#131527"/>
                </svg>
                Geri
            </a>
            <div class="viewCredit-container-head">
                <h1>Kredit məlumatları: {{ $item->vehicleNameView }}</h1>
            </div>
            <div class="viewCredit-body">
                <div class="viewCredit-body-head">
                    <h2>Ümumi Məlumatlar</h2>
                </div>
                <div class="viewCredit-form">
                                    <div class="form-items">
                    <div class="form-item">
                        <label for="">Table İD nömrəsi</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->tableId }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Tarix</label>
                        <div class="form-input">
                            <input type="date" value="{{ $item->date }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Marka</label>
                        <select name="" id="">
                            <option value="" >{{ $item->brand?->title }}</option>
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
                        <label for="">Istehsal ili</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->production_year }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Hesab</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->calculation }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Kod</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->code }}">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">İlkin ödəniş</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->down_payment }}">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Aylıq ödəniş</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->monthly_payment }}">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Ümumi ay</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->total_months }}">
                            <span>ay</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Ümumi odənilenecek kredit</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->total_payable_loan }}">
                            <span>azn</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Qalan ay</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->remaining_months }}">
                            <span>ay</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Qalan məbləğ</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->remaining_amount }}">
                            <span>azn</span>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
@endsection