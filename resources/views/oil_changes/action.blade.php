


<div class="action">
                                        <button class="actionBtn" type="button">
                                            <img src="../assets/icons/three_points.svg" alt="">
                                        </button>
                                        <div class="action-links">
                                            <button data-id="{{ $item->id }}"  class="editUserBtn editBrandBtn editItem action-link" type="button">
                                                <img src="../assets/icons/edit_blue.svg" alt="">
                                                Edit
                                            </button>
                                            <a href="{{ route('oil_changes.show',$item->id) }}" class="view_link action-link">
                                                <img src="../assets/icons/eye_yellow.svg" alt="">
                                                View
                                            </a>
                                            <button data-permission="oil-changes" data-model="{{ get_class($item) }}" data-id="{{ $item->id }}" class="deleteTableRow action-link">
                                                <img src="../assets/icons/trash-red.svg" alt="">
                                                Delete
                                            </button>
                                        </div>
                                    </div>