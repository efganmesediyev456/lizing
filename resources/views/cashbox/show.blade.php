
@extends('layouts.app')


@section('content')

<div class="viewCashbox-container">
            <a href="{{ route('cashbox.index') }}" class="backLink">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#131527"/>
                </svg>
                Geri
            </a>
            <div class="viewCashbox-container-head">
                <h1>Kassa məlumatları</h1>
            </div>
            <div class="viewCashbox-body">
                <div class="viewCashbox-body-head">
                    <h2>Ümumi Məlumatlar</h2>
                </div>
                <div class="viewCashbox-form">
                    <div class="form-items">
                        <div class="form-item">
                            <label for="">Tarix</label>
                            <div class="form-input">
                                <input type="date" value="{{ $item->created_at->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Table ID</label>
                            <select name="" id="">
                                <option value="">{{$item->tableId}}</option>
                            </select>
                        </div>
                        <div class="form-item">
                            <label for="">Dövlət qeydiyyat nişanı</label>
                            <select name="" id="">
                                <option value="">{{
                                    $item->leasing?->vehicle?->state_registration_number

                                    ?? $item->vehicle?->state_registration_number
                                    
                                    }}</option>
                            </select>
                        </div>
                        <div class="form-item">
                        <label for="">Ümümi xərc</label>
                        <div class="form-input">
                            <input type="text" value="{{ $item->price ?? $item->technical_review_fee ?? $item->insurance_fee }}">
                            <span>azn</span>
                        </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="">Qeyd</label>
                        <div class="form-input">
                            <textarea name="" id="">{{$item->note}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection