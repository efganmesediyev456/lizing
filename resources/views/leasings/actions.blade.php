<div class="action">
                                        <button class="actionBtn" type="button">
                                            <img src="../assets/icons/three_points.svg" alt="">
                                        </button>
                                        <div class="action-links">
                                            <button data-id="{{ $item->id }}"  class="editUserBtn editItem editLeasingBtn action-link" type="button">
                                                <img src="../assets/icons/edit_blue.svg" alt="">
                                                Edit
                                            </button>

                                             <button data-id="{{ $item->id }}"  class="createPaymentButton action-link" type="button">
                                                <img src="/assets/images/payment.png" alt="">
                                                Ödəniş əlavə et
                                            </button>


                                            <a href="{{ route('leasing.show',['item'=>$item->id]) }}" class="view_link action-link">
                                                <img src="../assets/icons/eye_yellow.svg" alt="">
                                                View
                                            </a>
                                            <button data-permission="leasing"  data-id="{{ $item->id }}" data-model="{{ get_class($item) }}"  class="deleteTableRow action-link">
                                                <img src="../assets/icons/trash-red.svg" alt="">
                                                Delete
                                            </button>
                                        </div>
                                    </div>