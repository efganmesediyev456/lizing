


<div class="action">




<button class="actionBtn" type="button">
                                            <img src="{{  asset('assets/icons/three_points.svg') }}" alt="">
                                        </button>
                                        <div class="action-links">
                                            <button  data-id="{{ $item->id }}" class="payPenaltyBtn editUserBtn  action-link">
                                                <img src="{{  asset('assets/icons/money_green.svg') }}" alt="">
                                                Ödəniş
                                            </button>
                                            <button data-id="{{ $item->id }}"  class="editUserBtn editBrandBtn editItem action-link" type="button">
                                                <img src="{{  asset('assets/icons/edit_blue.svg') }}" alt="">
                                                Edit
                                            </button>
                                            <a href="{{ route('vehicles.penalties.show', ['vehicle'=>request()->vehicle, 'item'=>$item->id]) }}" class="view_link action-link">
                                                <img src="{{ asset('assets/icons/eye_yellow.svg') }}" alt="">
                                                View
                                            </a>
                                            <button data-permission="brands" data-id="{{ $item->id }}" data-model="{{ get_class($item) }}" class="deleteTableRow action-link">
                                                <img src="{{  asset('assets/icons/trash-red.svg') }}" alt="">
                                                Delete
                                            </button>
                                        </div>
                                    </div>