<div class="action">
    <button class="actionBtn" type="button">
        <img src="../assets/icons/three_points.svg" alt="">
    </button>
    <div class="action-links">
        <button data-id="{{ $item->id }}" class="editUserBtn action-link editItem" type="button">
            <img src="../assets/icons/edit_blue.svg" alt="">
            Edit
        </button>
        <button data-permission="role-managements" class="deleteTableRow action-link" data-model="{{ get_class($item) }}" data-id="{{ $item->id }}">
            <img src="../assets/icons/trash-red.svg" alt="">
            Delete
        </button>
    </div>
</div>