@extends('layouts.app')


@section('content')

<div class="viewExpenses-container">
            <a href="{{ route('expenses.index') }}" class="backLink">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#131527"/>
                </svg>
                Geri
            </a>
            <div class="viewExpenses-container-head">
                <h1>Xərc məlumatları</h1>
            </div>
            <div class="viewExpenses-body">
                <div class="viewExpenses-body-head">
                    <h2>Ümumi Məlumatlar</h2>
                </div>
                <div class="viewExpenses-form">
                    <div class="form-items">
                        <div class="form-item">
                            <label for="">Tarix</label>
                            <div class="form-input">
                                <input type="date" value="{{ $item->created_at->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Table ID</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->tableId }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">D.Q.N</label>
                            <select name="" id="">
                                <option value="">{{$item->vehicle?->state_registration_number}}</option>
                               
                            </select>
                        </div>
                        <div class="form-item">
                            <label for="">Ümümi xərc</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->total_expense }}">
                                <span>azn</span>
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Ehtiyyat hissesi odənişi</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->spare_part_payment }}">
                                <span>azn</span>
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Usta odənişi</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->master_payment }}">
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
