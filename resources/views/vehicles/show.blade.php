
@extends('layouts.app')


@section('content')
    <div class="viewAuto-container">
            <a href="{{ route('vehicles.index') }}" class="backLink">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#131527"/>
                </svg>
                Geri
            </a>
            <div class="viewAuto-container-head">
                <h1>Avtomobil məlumatları:{{ $item->brand?->title.' '.$item->model?->title }} </h1>
            </div>
            <div class="viewAuto-body">
                <div class="viewAuto-body-head">
                    <h2>Ümumi Məlumatlar</h2>
                </div>
                <div class="viewAuto-form">
                    <div class="form-items">
                        <div class="form-item">
                            <label for="">ID</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->id }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Status</label>
                            <div class="form-input">
                                <input type="text" value="">
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
                                <input type="text" value="{{ $item->state_registration_number }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Istehsal ili</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->production_year }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Siğorta</label>
                            <div class="form-input">
                                <input type="text" value="">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Texniki baxış</label>
                            <div class="form-input">
                                <input type="text" value="">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Alış qiyməti</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->purchase_price }}">
                                <span>azn</span>
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Ban növü</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->model?->banType?->title }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Gediş məsafəsi</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->mileage }}">
                                <span>km</span>
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Mühərrik</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->engine }}">
                                <span>l</span>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        @endsection