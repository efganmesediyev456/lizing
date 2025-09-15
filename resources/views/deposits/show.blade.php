
@extends('layouts.app')


@section('content')
  <div class="viewPayments-container">
            <a href="{{ route('deposits.index') }}" class="backLink">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#131527"/>
                </svg>
                Geri
            </a>
            <div class="viewPayments-container-head">
                <h1>Ödəniş məlumatları</h1>
            </div>
            <div class="viewPayments-body">
                <div class="viewPayments-body-head">
                    <h2>Ümumi Məlumatlar</h2>
                </div>
                <div class="viewPayments-form">
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
                        <div class="form-item">
                            <label for="">Marka</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->leasing?->brand?->title }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Model</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->leasing?->model?->title }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Dövlət qeydiyyat nişanı</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->leasing?->vehicle?->state_registration_number }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Ödəniş statusu</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->statusView }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Ödəniş</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->price }}">
                                <span>azn</span>
                            </div>
                        </div>
                        {{-- <div class="form-item">
                            <label for="">Cərimə ödənişi</label>
                            <div class="form-input">
                                <input type="text" value="">
                                <span>azn</span>
                            </div>
                        </div> --}}
                        <div class="form-item">
                            <label for="">Ödəniş növü</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->paymentTypeView }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Depozit borcu</label>
                            <div class="form-input">
                                
                                <input type="text" value="{{ !$item->driver?->checkDepositDept()->exists() ?  $item->leasing?->deposit_debt : '' }}">
                                <span>azn</span>
                            </div>
                        </div>

                        

                        {{-- <div class="form-item">
                            <label for="">Qalıq borcu</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->leasingPayment?->remaining_amount }}">
                                <span>azn</span>
                            </div>
                        </div> --}}
                        {{-- <div class="form-item">
                            <label for="">Qalan lizinq müddəti</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->leasingPayment?->getCompletedPendingMonthDiffAttribute() }}">
                                <span>ay</span>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
@endsection