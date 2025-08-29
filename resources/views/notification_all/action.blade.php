  <div class="action">
                        <button class="actionBtn" type="button">
                          <img src="../assets/icons/three_points.svg" alt="" />
                        </button>
                        <div class="action-links">
                          <a
                            href="{{ route('notifications.show',['item'=>$item->id]) }}"
                            class="view_link action-link"
                          >
                            <img src="../assets/icons/eye_yellow.svg" alt="" />
                            View
                          </a>
                          <button data-permission="notifications" class="deleteTableRow action-link" data-id="{{ $item->id }}" data-model="{{ get_class($item) }}">
                            <img src="../assets/icons/trash-red.svg" alt="" />
                            Delete
                          </button>
                        </div>
                      </div>