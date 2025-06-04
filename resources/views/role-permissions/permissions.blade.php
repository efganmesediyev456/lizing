<div class="table_role_items">
    @foreach($item->permissions as $permission)
                                        <div class="roleItem">{{ $permission->permssion_title }}</div>
                                        @endforeach
                                        
                                    </div>