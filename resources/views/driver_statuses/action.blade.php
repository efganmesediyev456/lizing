


<div class="action">
                                        <button class="actionBtn" type="button">
                                            <img src="../assets/icons/three_points.svg" alt="">
                                        </button>
                                        <div class="action-links">
                                            <button data-id="{{ $item->id }}"  class="editUserBtn editBrandBtn editItem action-link" type="button">
                                                <img src="../assets/icons/edit_blue.svg" alt="">
                                                Edit
                                            </button> 
                                            @if($item->deleteable)
                                            <button data-model="{{ get_class($item) }}" data-id="{{ $item->id }}" data-permission="cities" class="deleteTableRow action-link">
                                                <img src="../assets/icons/trash-red.svg" alt="">
                                                Delete
                                            </button>
                                            @endif
                                        </div>
                                    </div>