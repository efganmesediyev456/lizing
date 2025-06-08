


<div class="action">
                                        <button class="actionBtn" type="button">
                                            <img src="../assets/icons/three_points.svg" alt="">
                                        </button>
                                        <div class="action-links">
                                            <button data-id="{{ $item->id }}"  class="editUserBtn editBrandBtn editItem action-link" type="button">
                                                <img src="{{ asset('assets/icons/edit_blue.svg') }}" alt="">
                                                Edit
                                            </button>
                                            <a href="{{ route('technical_reviews.show',$item->id) }}" class="view_link action-link">
                                                <img src="{{ asset('assets/icons/eye_yellow.svg') }}" alt="">
                                                View
                                            </a>
                                            <button data-permission="technical-reviews" data-model="{{ get_class($item) }}" data-id="{{ $item->id }}" class="deleteTableRow action-link">
                                                <img src="{{ asset('assets/icons/trash-red.svg') }}" alt="">
                                                Delete
                                            </button>
                                        </div>
                                    </div>