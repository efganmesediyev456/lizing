   <div class="aside-container">
       <a href="{{ route('dashboard') }}" class="crm-logo">
           <img src="{{ asset('assets/images') }}/crmLogo.svg" alt="" />
       </a>
       <div class="aside-menu">

           <a href="{{ route('dashboard') }}" @class([
               'menuLink',
               'activeLink' => request()->route()->getName() == 'dashboard',
           ])>
               <div class="menuLink-inner">
                   <img src="{{ asset('assets/icons') }}/aside_dashboard.svg" alt="" />
                   <p>Dashboard</p>
               </div>
               <div class="right-title-box">
                   <p class="right-title">Dashboard</p>
               </div>
           </a>

         <a href="{{ route('vehicles.index') }}" @class([
               'menuLink',
               'activeLink' => request()->route()->getName() == 'vehicles.index',
           ])>
               <div class="menuLink-inner">
                   <img src="{{ asset('assets/icons') }}/aside_cars.svg" alt="" />
                   <p>Avtomobillər</p>
               </div>
               <div class="right-title-box">
                   <p class="right-title">Avtomobillər</p>
               </div>
           </a>




           <a href="{{ route('drivers.index') }}" @class([
               'menuLink',
               'activeLink' => request()->route()->getName() == 'drivers.index',
           ])>
               <div class="menuLink-inner">
                   <img src="{{ asset('assets/icons') }}/aside_drivers.svg" alt="" />
                   <p>Sürücülər</p>
               </div>
               <div class="right-title-box">
                   <p class="right-title">Sürücülər</p>
               </div>
           </a>

          
           {{-- <div @class([
               'aside-dropdown',
               'active activeLink' => in_array(request()->route()->getName(), [
                   'ban-types.index',
                   'brands.index',
                   'models.index',
                   'vehicles.index',
                   'technical_reviews.index',
                   'insurances.index',
                   'oil_changes.index',
                   'credits.index',
               ]),
           ])>
               <button class="asideDownBtn" type="button">
                   <div class="asideDownBtn-inner">
                       <img src="{{ asset('assets/icons') }}/aside_cars.svg" alt="" />
                       <p>Avtomobillər</p>
                       <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                           xmlns="http://www.w3.org/2000/svg">
                           <path d="M7.87695 10L12.877 15L17.877 10L7.87695 10Z" fill="white" />
                       </svg>
                   </div>
               </button>


               <div class="aside-dropdown-links">
                   <div class="dropdown-links-inner">

                       <a href="{{ route('vehicles.index') }}" class="dropdown-link">Avtomobillər</a>

                   </div>
               </div>

               
               <div class="right-title-box">
                   <div class="box-inner">
                       <h3 class="right-title">Avtomobillər</h3>
                       <div class="right-dropdown-links">
                           <a href="{{ route('vehicles.index') }}" class="dropdown-link">Avtomobillər</a>
                           <a href="{{ route('insurances.index') }}" class="dropdown-link">Sığorta</a>
                           <a href="{{ route('technical_reviews.index') }}" class="dropdown-link">Texniki baxış</a>
                           <a href="{{ route('credits.index') }}" class="dropdown-link">Kreditlər</a>
                       </div>
                   </div>
               </div>
           </div> --}}



           <div @class([
               'aside-dropdown',
               'active activeLink' => in_array(request()->route()->getName(), [
                   'leasing.index',
                   'deposits.index',
                   'leasing.passiv',
                   'leasing.active',
               ]),
           ])>
               <button class="asideDownBtn" type="button">
                   <div class="asideDownBtn-inner">
                       <img src="{{ asset('assets/icons') }}/aside_leasing.svg" alt="" />
                       <p>Lizinglər</p>
                       <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                           xmlns="http://www.w3.org/2000/svg">
                           <path d="M7.87695 10L12.877 15L17.877 10L7.87695 10Z" fill="white" />
                       </svg>
                   </div>
               </button>
               <div class="aside-dropdown-links">
                   <div class="dropdown-links-inner">
                       <a href="{{ route('leasing.index') }}" class="dropdown-link">Lizing</a>
                       {{-- <a href="{{ route('leasing.active') }}" class="dropdown-link">Aktiv borclular</a> --}}
                       {{-- <a href="{{ route('leasing.passiv') }}" class="dropdown-link">Passiv borclular</a> --}}
                       <a href="{{ route('deposits.index') }}" class="dropdown-link">Depozitlər</a>
                   </div>
               </div>
               <div class="right-title-box">
                   <div class="box-inner">
                       <h3 class="right-title">Lizinglər</h3>
                       <div class="right-dropdown-links">
                           <a href="../leasings/leasing.html" class="dropdown-link">Lizinglər</a>
                           <a href="../leasings/deposits.html" class="dropdown-link">Depozitlər</a>
                       </div>
                   </div>
               </div>
           </div>


           <a href="{{ route('payments.index') }}" @class([
               'menuLink',
               'activeLink' => request()->route()->getName() == 'payments.index',
           ])>
               <div class="menuLink-inner">
                   <img src="{{ asset('assets/icons') }}/aside_payment.svg" alt="" />
                   <p>Ödənişlər</p>
               </div>
               <div class="right-title-box">
                   <p class="right-title">Ödənişlər</p>
               </div>
           </a>

           <div @class([
               'aside-dropdown',
               'active activeLink' => in_array(request()->route()->getName(), [
                   'expenses.index',
                   'revenues.index',
                   'debts.index',
                   'cashbox.index',
               ]),
           ])>
               <button class="asideDownBtn" type="button">
                   <div class="asideDownBtn-inner">
                       <img src="{{ asset('assets/icons') }}/aside_cashbox.svg" alt="" />
                       <p>Kassa</p>
                       <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                           xmlns="http://www.w3.org/2000/svg">
                           <path d="M7.87695 10L12.877 15L17.877 10L7.87695 10Z" fill="white" />
                       </svg>
                   </div>
               </button>
               <div class="aside-dropdown-links">
                   <div class="dropdown-links-inner">
                       <a href="{{ route('expenses.index') }}" class="dropdown-link">Xərclər</a>
                       <a href="{{ route('revenues.index') }}" class="dropdown-link">Gəlirlər</a>
                       <a href="{{ route('cashbox.index') }}" class="dropdown-link">Kassa</a>
                       {{-- <a href="{{ route("debts.index") }}" class="dropdown-link">Borclar</a> --}}
                   </div>
               </div>
               <div class="right-title-box">
                   <div class="box-inner">
                       <h3 class="right-title">Kassa</h3>
                       <div class="right-dropdown-links">
                           <a href="{{ route('expenses.index') }}" class="dropdown-link">Xərclər</a>
                           <a href="{{ route('revenues.index') }}" class="dropdown-link">Gəlirlər</a>
                           <a href="{{ route('cashbox.index') }}" class="dropdown-link">Kassa</a>
                           <a href="{{ route('debts.index') }}" class="dropdown-link">Borclar</a>
                       </div>
                   </div>
               </div>
           </div>




           <a href="{{ route('notifications.index') }}" @class([
               'menuLink',
               'activeLink' => request()->route()->getName() == 'notifications.index',
           ])>
               <div class="menuLink-inner">
                   <img src="{{ asset('assets/icons/notification_white.svg') }}" alt="" />
                   <p>Bildirişlər</p>
               </div>
               <div class="right-title-box">
                   <p class="right-title">Bildirişlər</p>
               </div>
           </a>







           <div @class([
               'aside-dropdown',
               'active activeLink' => in_array(request()->route()->getName(), [
                   'mobile-logo-managements.index',
                   'success-page.index',
               ]),
           ])>
               <button class="asideDownBtn" type="button">
                   <div class="asideDownBtn-inner">
                       <img src="{{ asset('assets/icons') }}/ant-design_mobile-outlined.svg" alt="" />
                       <p>App</p>
                       <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                           xmlns="http://www.w3.org/2000/svg">
                           <path d="M7.87695 10L12.877 15L17.877 10L7.87695 10Z" fill="white" />
                       </svg>
                   </div>
               </button>
               <div class="aside-dropdown-links">
                   <div class="dropdown-links-inner">
                       <a href="{{ route('mobile-logo-managements.index') }}" class="dropdown-link">Logo</a>
                       <a href="{{ route('success-page.index') }}" class="dropdown-link">Success səhifəsi</a>
                   </div>
               </div>
               <div class="right-title-box">
                   <div class="box-inner">
                       <h3 class="right-title">App</h3>
                       <div class="right-dropdown-links">
                           <a href="{{ route('mobile-logo-managements.index') }}" class="dropdown-link">Logo</a>
                           <a href="{{ route('success-page.index') }}" class="dropdown-link">Success səhifəsi</a>

                       </div>
                   </div>
               </div>
           </div>



           <div @class([
               'aside-dropdown aside-settings',
               'active activeLink' => in_array(request()->route()->getName(), [
                   'users.index',
                   'logo-managements.index',
                   'role-permissions.index',
                   'role-managements.index',
                   'oil_change_types.index',
                   'cities.index',
                   'oil_types.index',
                   'driver-notification-topic.index',
                   'app-store-assets.index',
                   'driver_statuses.index',
                   'penalty-types.index',
               ]),
           ])>
               <button class="asideDownBtn" type="button">
                   <div class="asideDownBtn-inner">
                       <img src="{{ asset('assets/icons') }}/aside_setting.svg" alt="" />
                       <p>Tənzimləmələr</p>
                       <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                           xmlns="http://www.w3.org/2000/svg">
                           <path d="M7.87695 10L12.877 15L17.877 10L7.87695 10Z" fill="white" />
                       </svg>
                   </div>
               </button>
               <div class="aside-dropdown-links">
                   <div class="dropdown-links-inner">
                       <a href="{{ route('users.index') }}" class="dropdown-link">İstifadəçilər</a>
                       <a href="{{ route('logo-managements.index') }}" class="dropdown-link">Logo idarəetməsi</a>
                       <a href="{{ route('role-permissions.index') }}" class="dropdown-link">Rol icazələri</a>
                       <a href="{{ route('role-managements.index') }}" class="dropdown-link">Rol idarəetməsi</a>
                       <a href="{{ route('oil_change_types.index') }}" class="dropdown-link">Yağ dəyişmə növü</a>
                       <a href="{{ route('cities.index') }}" class="dropdown-link">Şəhərlər</a>
                       <a href="{{ route('oil_types.index') }}" class="dropdown-link">Yanacaq növü</a>
                       <a href="{{ route('driver-notification-topic.index') }}" class="dropdown-link">Sürücü bildiriş
                           mövzuları</a>
                       <a href="{{ route('driver_statuses.index') }}" class="dropdown-link">Sürücü Statusları</a>
                       <!-- <a href="{{ route('app-store-assets.index') }}" class="dropdown-link">App məlumatlar</a> -->
                       {{-- <a href="{{ route('penalty-types.index') }}" class="dropdown-link">Cərimə adları</a> --}}

                       <a href="{{ route('ban-types.index') }}" class="dropdown-link">Ban növü</a>
                       <a href="{{ route('brands.index') }}" class="dropdown-link">Marka</a>
                       <a href="{{ route('models.index') }}" class="dropdown-link">Model</a>
                       <a style="text-align: left;" href="{{ route('leasing-details.index') }}"
                           class="dropdown-link">Leasinq Qaydalar və şərtlər səhifəsi</a>
                       <a style="text-align: left;" href="{{ route('expense-types.index') }}"
                           class="dropdown-link">Xərc növü</a>
                       <a style="text-align: left;" href="{{ route('colors.index') }}"
                           class="dropdown-link">Rənglər</a>
                       <a style="text-align: left" href="{{ route('vehicle-statuses.index') }}"
                           class="dropdown-link">Nəqliyyat Vasitəsi Statusları</a>

                       <a href="{{ route('insurances.index') }}" class="dropdown-link">Sığorta</a>
                       <a href="{{ route('technical_reviews.index') }}" class="dropdown-link">Texniki baxış</a>
                       <a href="{{ route('credits.index') }}" class="dropdown-link">Kreditlər</a>
                       <a href="{{ route('oil_changes.index') }}" class="dropdown-link">Yağ dəyişilməsi</a>




                   </div>
               </div>
               <div class="right-title-box">
                   <div class="box-inner">
                       <h3 class="right-title">Tənzimləmələr</h3>
                       <div class="right-dropdown-links">
                           <a href="{{ route('users.index') }}" class="dropdown-link">İstifadəçilər</a>
                           <a href="{{ route('logo-managements.index') }}" class="dropdown-link">Logo idarəetməsi</a>
                           <a href="{{ route('role-permissions.index') }}" class="dropdown-link">Rol icazələri</a>
                           <a href="{{ route('role-managements.index') }}" class="dropdown-link">Rol idarəetməsi</a>
                           <a href="{{ route('oil_change_types.index') }}" class="dropdown-link">Yağ dəyişmə növü</a>
                           <a href="{{ route('cities.index') }}" class="dropdown-link">Şəhərlər</a>
                           <a href="{{ route('oil_types.index') }}" class="dropdown-link">Yanacaq növü</a>
                           <a href="{{ route('driver-notification-topic.index') }}" class="dropdown-link">Sürücü
                               bildiriş mövzuları</a>
                           <a href="{{ route('driver_statuses.index') }}" class="dropdown-link">Sürücü Statusları</a>
                           <a href="{{ route('penalty-types.index') }}" class="dropdown-link">Cərimə adları</a>
                           <a href="{{ route('oil_changes.index') }}" class="dropdown-link">Yağın deyişilməsi</a>

                           <a href="{{ route('insurances.index') }}" class="dropdown-link">Sığorta</a>
                           <a href="{{ route('technical_reviews.index') }}" class="dropdown-link">Texniki baxış</a>
                           <a href="{{ route('credits.index') }}" class="dropdown-link">Kreditlər</a>
                           <a href="{{ route('oil_changes.index') }}" class="dropdown-link">Yağ dəyişilməsi</a>

                           

                       </div>
                   </div>
               </div>
           </div>
           <a href="{{ route('logout') }}" type="button" class="exitProfile">
               <div class="exitProfile-inner">
                   <img src="{{ asset('assets/icons') }}/aside_exit.svg" alt="" />
                   <p>Çıxış</p>
               </div>
               <div class="right-title-box">
                   <p class="right-title">Çıxış</p>
               </div>
           </a>
       </div>
   </div>
