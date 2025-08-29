<div class="action">
    <button class="actionBtn" type="button">
        <img src="../assets/icons/three_points.svg" alt="">
    </button>
    <div class="action-links">
        {{-- <a href="{{  route('vehicles.penalties.index',['vehicle'=>$item->id]) }}" class="action-link" >
                                                <img src="../assets/icons/fine-auto.svg" alt="">
                                                Cərimələr
        </a> --}}
        <a href="{{ route('insurances.index',['vehicle'=>$item->id]) }}" class="action-link">
                                                <img src="../assets/icons/insurance-green.svg" alt="">
                                                Siğorta
                                            </a>
        <a href="{{ route("technical_reviews.index",['vehicle'=>$item->id]) }}" class="action-link">
                                                <img src="../assets/icons/technicalAuto-blue.svg" alt="">
                                                Texniki baxış
                                            </a>
        <button data-id="{{ $item->id }}" class="editUserBtn action-link editItem" type="button">
            <img src="../assets/icons/edit_blue.svg" alt="">
            Redaktə et
        </button>
        <a href="{{ route('vehicles.show',$item->id) }}" class="view_link action-link">
            <img src="../assets/icons/eye_yellow.svg" alt="">
            Baxış
        </a>
        <button data-permission="vehicles" class="deleteTableRow action-link" data-model="{{ get_class($item) }}" data-id="{{ $item->id }}">
            <img src="../assets/icons/trash-red.svg" alt="">
            Sil
        </button>
    </div>
</div>
