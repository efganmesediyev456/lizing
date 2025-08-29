<div class="action">
    <button class="actionBtn" type="button">
        <img src="../assets/icons/three_points.svg" alt="">
    </button>
    <div class="action-links">
        <!-- <button data-id="{{ $item->id }}" class="notificationDriverBtn action-link addNotification addNewUsers" type="button">
            <img src="../assets/icons/notification_orange.svg" alt="">
            Bildiriş göndər
        </button> -->


        <a class="view_link action-link" href="{{ route('drivers.notifications.show',['driver'=>$item->id]) }}"  type="button">
            <img src="../assets/icons/notification_orange.svg" alt="">
            Bildiriş göndər
        </a>

        <a href="{{ route('drivers.payments',['driver'=>$item->id]) }}"   class="createPaymentButton action-link" type="button">
                                                <img src="/assets/images/payment.png" alt="">
                                                Ödənişlər
        </a>


        <button data-id="{{ $item->id }}" class="editUserBtn action-link editItem" type="button">
            <img src="../assets/icons/edit_blue.svg" alt="">
            Redaktə et
        </button>
        <a href="{{ route('drivers.show',$item->id) }}" class="view_link action-link">
            <img src="../assets/icons/eye_yellow.svg" alt="">
            Baxış
        </a>
        <button data-permission="drivers" class="deleteTableRow action-link" data-id="{{ $item->id }}" data-model="{{ get_class($item) }}">
            <img src="../assets/icons/trash-red.svg" alt="">
            Sil
        </button>
    </div>
</div>
