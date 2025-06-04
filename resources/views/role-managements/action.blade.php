<div class="action">
    <button class="actionBtn" type="button">
        <img src="../assets/icons/three_points.svg" alt="">
    </button>
    <div class="action-links">
        <button data-id="{{ $item->id }}" class="editUserBtn action-link editItem" type="button">
            <img src="../assets/icons/edit_blue.svg" alt="">
            Edit
        </button>
        <a href="user_view.html" class="view_link action-link">
            <img src="../assets/icons/eye_yellow.svg" alt="">
            View
        </a>
        <button class="deleteTableRow action-link">
            <img src="../assets/icons/trash-red.svg" alt="">
            Delete
        </button>
    </div>
</div>