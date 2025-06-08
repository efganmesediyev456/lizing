
@extends('layouts.app')


@section('content')
 <div class="viewDrivers-container">
            <a href="{{ route('drivers.index') }}" class="backLink">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z" fill="#131527"/>
                </svg>
                Geri
            </a>
            <div class="viewDrivers-container-head">
                <h1>Sürücü məlumatları:{{ $item->name.' '.$item->username }} </h1>
            </div>
            <div class="viewDrivers-body">
                <div class="viewDrivers-body-head">
                    <h2>Ümumi Məlumatlar</h2>
                </div>
                <div class="viewDrivers-form">
                    <div class="form-items">
                        <div class="form-item">
                            <label for="">Ad</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->name }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Soyad</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->surname }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Email</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->email }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Əlaqə nömrəsi</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->phone }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Şəxsiyyət FİN</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->fin }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Şəxsiyyətin seriya nömrəsi</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->id_card_serial_code }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Doğum tarixi</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->date->format('d/m/Y') }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Cinsiyyət</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->gender===0 ? 'Kişi' :($item->gender===1 ? 'Qadın': '') }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Şəhər</label>
                            <div class="form-input">
                                <input type="text" value="{{ $item->city?->title }}">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="">Şifrə</label>
                            <div class="form-input">
                                <input type="password" value="">
                                    <button class="password-eye" type="button">
                                    <svg class="eye-open" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 9C12.7956 9 13.5587 9.31607 14.1213 9.87868C14.6839 10.4413 15 11.2044 15 12C15 12.7956 14.6839 13.5587 14.1213 14.1213C13.5587 14.6839 12.7956 15 12 15C11.2044 15 10.4413 14.6839 9.87868 14.1213C9.31607 13.5587 9 12.7956 9 12C9 11.2044 9.31607 10.4413 9.87868 9.87868C10.4413 9.31607 11.2044 9 12 9ZM12 4.5C17 4.5 21.27 7.61 23 12C21.27 16.39 17 19.5 12 19.5C7 19.5 2.73 16.39 1 12C2.73 7.61 7 4.5 12 4.5ZM3.18 12C3.98825 13.6503 5.24331 15.0407 6.80248 16.0133C8.36165 16.9858 10.1624 17.5013 12 17.5013C13.8376 17.5013 15.6383 16.9858 17.1975 16.0133C18.7567 15.0407 20.0117 13.6503 20.82 12C20.0117 10.3497 18.7567 8.95925 17.1975 7.98675C15.6383 7.01424 13.8376 6.49868 12 6.49868C10.1624 6.49868 8.36165 7.01424 6.80248 7.98675C5.24331 8.95925 3.98825 10.3497 3.18 12Z" fill="#A7A7A7"/>
                                    </svg>
                                    <svg class="eye-close" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 5.27L3.28 4L20 20.72L18.73 22L15.65 18.92C14.5 19.3 13.28 19.5 12 19.5C7 19.5 2.73 16.39 1 12C1.69 10.24 2.79 8.69 4.19 7.46L2 5.27ZM12 9C12.7956 9 13.5587 9.31607 14.1213 9.87868C14.6839 10.4413 15 11.2044 15 12C15.0005 12.3406 14.943 12.6787 14.83 13L11 9.17C11.3213 9.05698 11.6594 8.99949 12 9ZM12 4.5C17 4.5 21.27 7.61 23 12C22.1834 14.0729 20.7966 15.8723 19 17.19L17.58 15.76C18.9629 14.8034 20.0783 13.5091 20.82 12C20.0117 10.3499 18.7565 8.95963 17.1974 7.98735C15.6382 7.01508 13.8375 6.49976 12 6.5C10.91 6.5 9.84 6.68 8.84 7L7.3 5.47C8.74 4.85 10.33 4.5 12 4.5ZM3.18 12C3.98835 13.6501 5.24345 15.0404 6.80264 16.0126C8.36182 16.9849 10.1625 17.5002 12 17.5C12.69 17.5 13.37 17.43 14 17.29L11.72 15C11.0242 14.9254 10.3748 14.6149 9.87997 14.12C9.38512 13.6252 9.07458 12.9758 9 12.28L5.6 8.87C4.61 9.72 3.78 10.78 3.18 12Z" fill="#A7A7A7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="driver-document-images">
                      <div class="document-box">
                        <h2>Sürücünün şəxsiyyət vəsiqəsi (ön,arxa)</h2>
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
                    </div> -->
                </div>
            </div>
        </div>
        @endsection