


<div class="action-links" style="display:flex!important;">
                                        <a href="{{ route('role-permissions.show',$item->id) }}" class="action-link">
                                            <img src="../assets/icons/eye_yellow.svg" alt="">
                                        </a>
                                        <a href="{{ route('role-permissions.create',$item->id) }}" class="action-link">
                                            <img src="../assets/icons/edit_blue.svg" alt="">
                                        </a>
                                        <button class="deleteTableRow action-link" data-permission="role-permissions" data-model="{{ get_class($item) }}" data-id="{{ $item->id }}">
                                            <img src="../assets/icons/trash-red.svg" alt="">
                                        </button>
                                    </div>


                                    