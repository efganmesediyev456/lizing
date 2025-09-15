<div class="action">
    <button class="actionBtn" type="button">
        <img src="../assets/icons/three_points.svg" alt="">
    </button>
    <div class="action-links ">
        <button data-id="{{ $item->id }}" class="editUserBtn editBrandBtn editItem action-link" type="button">
            <img src="../assets/icons/edit_blue.svg" alt="">
            Edit
        </button>
        @if(!$item->is_online and !$item->is_offline_payment and !$item->is_elshad_take)
        <button data-permission="ban-types" data-model="{{ get_class($item) }}" data-id="{{ $item->id }}"
            class="deleteTableRow action-link">
            <img src="../assets/icons/trash-red.svg" alt="">
            Delete
        </button>
        @endif
    </div>
</div>
