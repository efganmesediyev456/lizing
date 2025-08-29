<div class="action">
                                        <button class="actionBtn" type="button">
                                            <img src="../assets/icons/three_points.svg" alt="">
                                        </button>
                                        <div class="action-links">
                                           
                                            <a href="{{ route('cashbox.show',['item'=>$item->id ?? ' ','model'=>get_class($item)]) }}" class="view_link action-link">
                                                <img src="../assets/icons/eye_yellow.svg" alt="">
                                                View
                                            </a>
                                        </div>
                                    </div>