<?php

use App\Http\Controllers\AppStoreAssetController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\LeasingActiveController;
use App\Http\Controllers\LeasingDetailController;
use App\Http\Controllers\LeasingPassivController;
use App\Http\Controllers\LeasingStatusesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DriverNotificationTopicController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleManagementController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BanTypeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\OilChangeTypesController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VehicleStatusesController;
use App\Models\CashExpense;
use App\Models\SuccessPage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TechnicalReviewController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\OilChangeController;
use App\Http\Controllers\OilTypeController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\LeasingController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\Mobile\MobileSettingController;
use App\Http\Controllers\Mobile\SuccessPageController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\PenaltyTypesController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\CashboxController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\DriverStatusController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ColorController;


















/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'attempt']);
Route::get('/drivers/debts', [DebtController::class,'debtNotification']);


Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [HomeController::class,'dashboard'])->name('dashboard')->middleware('permission:dashboard.index');
    Route::get('/', [HomeController::class,'dashboard'])->name('dashboard')->middleware('permission:dashboard.index');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('profile', [AuthController::class, 'updateProfile'])->name('updateProfile');

    Route::get('/dashboard/payments', [HomeController::class, 'getMonthlyPayments']);


    Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware("permission:users.index");
    Route::post('users/form/{item?}', [UserController::class, 'form'])->name('users.form');
    Route::post('users/save/{item?}', [UserController::class, 'save'])->name('users.save');
    Route::get('users/{item?}', [UserController::class, 'show'])->name('users.show');

    //role-managements
    Route::get('role-managements', [RoleManagementController::class, 'index'])->name('role-managements.index')->middleware("permission:role-managements.index");
    Route::post('role-managements/form/{item?}', [RoleManagementController::class, 'form'])->name('role-managements.form');
    Route::post('role-managements/save/{item?}', [RoleManagementController::class, 'save'])->name('role-managements.save');

    //role-permission
    Route::get('role-permissions', [RolePermissionController::class, 'index'])->name('role-permissions.index')->middleware("permission:role-permissions.index");
    Route::get('role-permissions/create/{item?}', [RolePermissionController::class, 'create'])->name("role-permissions.create");
    Route::post('role-permissions/store/{item?}', [RolePermissionController::class, 'store'])->name("role-permissions.store");
    Route::get('role-permissions/show/{item}', [RolePermissionController::class, 'show'])->name("role-permissions.show");

    //drivers
    Route::get('drivers', [DriverController::class, 'index'])->name('drivers.index')->middleware('permission:drivers.index');
    Route::get('drivers/payments/{driver}', [DriverController::class, 'payments'])->name('drivers.payments');
    Route::get('drivers/export', [DriverController::class, 'export'])->name("drivers.export");


    Route::post('drivers/form/{item?}', [DriverController::class, 'form'])->name('drivers.form');
    Route::post('drivers/save/{item?}', [DriverController::class, 'save'])->name('drivers.save');
    Route::get( 'drivers/{item?}', [DriverController::class, 'show'])->name('drivers.show');
    Route::post('drivers/notification/{item?}', [DriverController::class, 'notification'])->name('notification.form');
    Route::post('drivers/notification/{item?}/send', [DriverController::class, 'sendNotification'])->name('notification.sendNotification');
    Route::get( 'drivers/{driver}/notifications', [DriverController::class, 'notifications'])->name('drivers.notifications.show');



     //penalty-types
    Route::get('penalty-types', [PenaltyTypesController::class, 'index'])->name('penalty-types.index')->middleware("permission:penalty-types.index");
    Route::post('penalty-types/form/{item?}', [PenaltyTypesController::class, 'form'])->name('penalty-types.form');
    Route::post('penalty-types/save/{item?}', [PenaltyTypesController::class, 'save'])->name('penalty-types.save');
    Route::get('penalty-types/export', [PenaltyTypesController::class, 'export'])->name("penalty-types.export");




    Route::get('vehicles/{vehicle}/penalties', [PenaltyController::class, 'index'])->name('vehicles.penalties.index')->middleware('permission:penalties.index');
    Route::post('vehicles/{vehicle}/penalties/form/{item?}', [PenaltyController::class, 'form'])->name('vehicles.penalties.form');
    Route::post('vehicles/{vehicle}/penalties/save/{item?}', [PenaltyController::class, 'save'])->name('vehicles.penalties.save');
    Route::post('vehicles/{vehicle}/penalty/{penalty}/payment/form/{item?}', [PenaltyController::class, 'payment'])->name('vehicles.penalties.payment');
    Route::post('vehicles/{vehicle}/penalty/{penalty}/payment/save/{item?}', [PenaltyController::class, 'savePayment'])->name('vehicles.penalties.payment.save');
    Route::get('vehicles/{vehicle}/penalties/export', [PenaltyController::class, 'export'])->name("vehicles.penalties.export");
    Route::get('vehicles/{vehicle}/penalties/show/{item}', [PenaltyController::class, 'show'])->name("vehicles.penalties.show");




        // drivers notification topics
    Route::get('drivers/notification/topics', [DriverNotificationTopicController::class, 'index'])->name('driver-notification-topic.index')->middleware('permission:driver-notification-topic.index');
    Route::post('drivers/notification/topic/form/{item?}', [DriverNotificationTopicController::class, 'form'])->name('driver-notification-topic.form');
    Route::post('drivers/notification/topic/save/{item?}', [DriverNotificationTopicController::class, 'save'])->name('driver-notification-topic.save');


    //vehicles
    Route::get('vehicles', [VehicleController::class, 'index'])->name('vehicles.index')->middleware('permission:vehicles.index');
    Route::post('vehicles/form/{item?}', [VehicleController::class, 'form'])->name('vehicles.form');
    Route::get('vehicles/export', [VehicleController::class, 'export'])->name('vehicles.export');
    Route::post('vehicles/save/{item?}', [VehicleController::class, 'save'])->name('vehicles.save');
    
    Route::get('vehicles/{item?}', [VehicleController::class, 'show'])->name('vehicles.show');


    //brands
    Route::get('brands', [BrandController::class, 'index'])->name('brands.index')->middleware("permission:brands.index");
    Route::post('brands/form/{item?}', [BrandController::class, 'form'])->name('brands.form');
    Route::post('brands/save/{item?}', [BrandController::class, 'save'])->name('brands.save');
    Route::get('brands/export', [BrandController::class, 'export'])->name("brands.export");


    //ban types
    Route::get('ban-types', [BanTypeController::class, 'index'])->name('ban-types.index')->middleware('permission:ban-types.index');
    Route::post('ban-types/form/{item?}', [BanTypeController::class, 'form'])->name('ban-types.form');
    Route::post('ban-types/save/{item?}', [BanTypeController::class, 'save'])->name('ban-types.save');
    Route::get('ban-types/export', [BanTypeController::class, 'export'])->name("ban-types.export");

    //ban types
    Route::get('models', [ModelController::class, 'index'])->name('models.index')->middleware('permission:models.index');
    Route::post('models/form/{item?}', [ModelController::class, 'form'])->name('models.form');
    Route::post('models/save/{item?}', [ModelController::class, 'save'])->name('models.save');
    Route::get('models/export', [ModelController::class, 'export'])->name("models.export");



    //oil_change_types
    Route::get('oil_change_types', [OilChangeTypesController::class, 'index'])->name('oil_change_types.index')->middleware("permission:oil_change_types.index");
    Route::post('oil_change_types/form/{item?}', [OilChangeTypesController::class, 'form'])->name('oil_change_types.form');
    Route::post('oil_change_types/save/{item?}', [OilChangeTypesController::class, 'save'])->name('oil_change_types.save');

    //cities
    Route::get('cities', [CitiesController::class, 'index'])->name('cities.index')->middleware('permission:cities.index');
    Route::post('cities/form/{item?}', [CitiesController::class, 'form'])->name('cities.form');
    Route::post('cities/save/{item?}', [CitiesController::class, 'save'])->name('cities.save');


    //technical_reviews
    Route::get('technical-reviews', [TechnicalReviewController::class, 'index'])->name('technical_reviews.index')->middleware("permission:technical-reviews.index");
    Route::post('technical-reviews/form/{item?}', [TechnicalReviewController::class, 'form'])->name('technical_reviews.form');
    Route::post('technical-reviews/save/{item?}', [TechnicalReviewController::class, 'save'])->name('technical_reviews.save');
    Route::get('technical-reviews/export', [TechnicalReviewController::class, 'export'])->name('technical_reviews.export');
    Route::get('technical-reviews/{item?}', [TechnicalReviewController::class, 'show'])->name('technical_reviews.show');


     //insurances
    Route::get('insurances', [InsuranceController::class, 'index'])->name('insurances.index')->middleware("permission:insurances.index");
    Route::post('insurances/form/{item?}', [InsuranceController::class, 'form'])->name('insurances.form');
    Route::post('insurances/save/{item?}', [InsuranceController::class, 'save'])->name('insurances.save');
    Route::get('insurances/export', [InsuranceController::class, 'export'])->name("insurances.export");
    Route::get('insurances/show/{item}', [InsuranceController::class, 'show'])->name("insurances.show");


      //oil_changes
    Route::get('oil-changes', [OilChangeController::class, 'index'])->name('oil_changes.index')->middleware("permission:oil-changes.index");
    Route::post('oil-changes/form/{item?}', [OilChangeController::class, 'form'])->name('oil_changes.form');
    Route::post('oil-changes/save/{item?}', [OilChangeController::class, 'save'])->name('oil_changes.save');
    Route::get('oil-changes/show/{item}', [OilChangeController::class, 'show'])->name("oil_changes.show");
    Route::post('oil-changes/changeOil', [OilChangeController::class, 'changeOil'])->name("oil_changes.changeOil");
    Route::post('/oil-changes/preview', [OilChangeController::class, 'preview']);


    Route::post('general/id-card-serial-number',[GeneralController::class,'getSerialCard'])->name('getSerialCard');
    Route::post('general/leasing-elements',[GeneralController::class,'getLeasingElements'])->name('getLeasingElements');
    Route::post('general/brands',[GeneralController::class,'getBrand'])->name('getBrand');
    Route::post('general/driver/fin',[GeneralController::class,'getDriverFin'])->name('getDriverFin');
    Route::post('general/delete',[GeneralController::class,'delete'])->name('general.delete');

   
    Route::get('oil-types', [OilTypeController::class, 'index'])->name('oil_types.index')->middleware('permission:oil-types.index');
    Route::post('oil-types/form/{item?}', [OilTypeController::class, 'form'])->name('oil_types.form');
    Route::post('oil-types/save/{item?}', [OilTypeController::class, 'save'])->name('oil_types.save');


    Route::get('logo-managements', [SiteSettingController::class, 'index'])->name('logo-managements.index')->middleware('permission:logo-managements.index');
    Route::post('logo-managements', [SiteSettingController::class, 'save'])->name('logo-managements.save')->middleware("permission:logo-managements.edit");

    Route::get('leasings/passive', [LeasingPassivController::class, 'index'])->name('leasing.passiv')->middleware('permission:leasing.passiv');
    Route::get('leasings/passive/{item}/show', [LeasingPassivController::class, 'show'])->name('leasing.passiv.show')->middleware('permission:leasing.passiv');
    
    
    Route::get('leasings/active', [LeasingActiveController::class, 'index'])->name('leasing.active')->middleware('permission:leasing.active');

     //leasing
    Route::get('leasing', [LeasingController::class, 'index'])->name('leasing.index')->middleware('permission:leasing.index');
    Route::get('leasing/export', [LeasingController::class, 'export'])->name("leasing.export");
    Route::post('leasing/form/{item?}', [LeasingController::class, 'form'])->name('leasing.form');
    Route::post('leasing/save/{item?}', [LeasingController::class, 'save'])->name('leasing.save');
    Route::get('leasing/{item?}', [LeasingController::class, 'show'])->name('leasing.show');
    Route::post('leasing/payment', [LeasingController::class, 'payment'])->name('leasing.payment');





    //mobile
    Route::get('mobile-logo-managements', [MobileSettingController::class, 'index'])->name('mobile-logo-managements.index')->middleware('permission:mobile-logo-managements.index');
    Route::post('mobile-logo-managements', [MobileSettingController::class, 'save'])->name('mobile-logo-managements.save')->middleware("permission:mobile-logo-managements.edit");



    Route::get('success-page', [SuccessPageController::class, 'index'])->name('success-page.index')->middleware('permission:success-page.index');
    Route::post('success-page', [SuccessPageController::class, 'save'])->name('success-page.save')->middleware("permission:success-page.edit");

    //leasing details

    Route::get('leasing-details', [LeasingDetailController::class, 'index'])->name('leasing-details.index')->middleware('permission:leasing-details.index');
    Route::post('leasing-details', [LeasingDetailController::class, 'save'])->name('leasing-details.save')->middleware("permission:leasing-details.edit");



    //payments
    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index')->middleware("permission:payments.index");
    Route::get('payments/show/{item}', [PaymentController::class, 'show'])->name("payments.show");
    Route::get('payments/export', [PaymentController::class, 'export'])->name("payments.export");



    Route::get('credits', [CreditController::class, 'index'])->name('credits.index')->middleware("permission:credits.index");
    Route::post('creadits/form/{item?}', [CreditController::class, 'form'])->name('credits.form');
    Route::post('credits/save/{item?}', [CreditController::class, 'save'])->name('credits.save');
    Route::get('credits/show/{item}', [CreditController::class, 'show'])->name("credits.show");



    Route::get('deposits', [DepositController::class, 'index'])->name('deposits.index')->middleware("permission:deposits.index");
    Route::post('deposits/form/{item?}', [DepositController::class, 'form'])->name('deposits.form');
    Route::post('deposits/save/{item?}', [DepositController::class, 'save'])->name('deposits.save');
    Route::get('deposits/show/{item}', [DepositController::class, 'show'])->name("deposits.show");
    Route::get('deposits/export', [DepositController::class, 'export'])->name("deposits.export");

    Route::get('app-store-assets', [AppStoreAssetController::class, 'index'])->name('app-store-assets.index');
    Route::put('app-store-assets/save', [AppStoreAssetController::class, 'save'])->name('app-store-assets.save');



    //expenses
    Route::get('expenses', [ExpenseController::class, 'index'])->name('expenses.index')->middleware("permission:expenses.index");
    Route::post('expenses/form/{item?}', [ExpenseController::class, 'form'])->name('expenses.form');
    Route::post('expenses/save/{item?}', [ExpenseController::class, 'save'])->name('expenses.save');
    Route::get('expenses/export', [ExpenseController::class, 'export'])->name("expenses.export");
    Route::get('expenses/show/{item}', [ExpenseController::class, 'show'])->name("expenses.show");

    Route::post('/expenses/update-order', [ExpenseController::class, 'updateOrder'])->name('expenses.updateOrder');


    //revenues
    Route::get('revenues', [RevenueController::class, 'index'])->name('revenues.index')->middleware("permission:revenues.index");
    Route::get('revenues/show/{item}', [RevenueController::class, 'show'])->name('revenues.show')->middleware("permission:revenues.show");
    Route::get('revenues/export', [RevenueController::class, 'export'])->name("revenues.export");


    //debts
    Route::get('debts', [DebtController::class, 'index'])->name('debts.index')->middleware("permission:debts.index");
    Route::post('debts/form/{item?}', [DebtController::class, 'form'])->name('debts.form');
    Route::post('debts/save/{item?}', [DebtController::class, 'save'])->name('debts.save');
    Route::get('debts/export', [DebtController::class, 'export'])->name("debts.export");


     //debts
    Route::get('cashbox', [CashboxController::class, 'index'])->name('cashbox.index')->middleware("permission:cashbox.index");
    Route::post('cashbox/form/{item?}', [CashboxController::class, 'form'])->name('cashbox.form');
    Route::post('cashbox/save/{item?}', [CashboxController::class, 'save'])->name('cashbox.save');
    Route::get('cashbox/export', [CashboxController::class, 'export'])->name("cashbox.export");
    Route::get('cashbox/show/{item}', [CashboxController::class, 'show'])->name("cashbox.show");



    Route::get('excel',[ExcelController::class,'index'])->name('excel.index');
    Route::post('excel/form',[ExcelController::class,'form'])->name('excel.form');
    Route::post('excel',[ExcelController::class,'store'])->name('excel.store');



    //driver_statuses
    Route::get('driver_statuses', [DriverStatusController::class, 'index'])->name('driver_statuses.index')->middleware("permission:driver_statuses.index");
    Route::post('driver_statuses/form/{item?}', [DriverStatusController::class, 'form'])->name('driver_statuses.form');
    Route::post('driver_statuses/save/{item?}', [DriverStatusController::class, 'save'])->name('driver_statuses.save');
    Route::get('driver_statuses/export', [DriverStatusController::class, 'export'])->name("driver_statuses.export");



    //notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index')->middleware("permission:notifications.index");
    Route::post('notifications/form/{item?}', [NotificationController::class, 'form'])->name('notifications.form');
    Route::post('notifications/save/{item?}', [NotificationController::class, 'save'])->name('notifications.save');
    Route::get('notifications/export', [NotificationController::class, 'export'])->name("notifications.export");
    Route::get('notifications/{item?}', [NotificationController::class, 'show'])->name('notifications.show');

    Route::get('notifications/{status}/users', [NotificationController::class, 'users']);




    Route::get('leasing-statuses', [LeasingStatusesController::class, 'index'])->name('leasing-statuses.index')->middleware("permission:leasing-statuses.index");
    Route::post('leasing-statuses/form/{item?}', [LeasingStatusesController::class, 'form'])->name('leasing-statuses.form');
    Route::post('leasing-statuses/save/{item?}', [LeasingStatusesController::class, 'save'])->name('leasing-statuses.save');
    Route::get('leasing-statuses/export', [LeasingStatusesController::class, 'export'])->name("leasing-statuses.export");


    Route::get('vehicle-statuses', [VehicleStatusesController::class, 'index'])->name('vehicle-statuses.index')->middleware("permission:vehicle-statuses.index");
    Route::post('vehicle-statuses/form/{item?}', [VehicleStatusesController::class, 'form'])->name('vehicle-statuses.form');
    Route::post('vehicle-statuses/save/{item?}', [VehicleStatusesController::class, 'save'])->name('vehicle-statuses.save');
    Route::get('vehicle-statuses/export', [VehicleStatusesController::class, 'export'])->name("vehicle-statuses.export");


    //ban types
    Route::get('expense-types', [ExpenseTypeController::class, 'index'])->name('expense-types.index')->middleware('permission:expense-types.index');
    Route::post('expense-types/form/{item?}', [ExpenseTypeController::class, 'form'])->name('expense-types.form');
    Route::post('expense-types/save/{item?}', [ExpenseTypeController::class, 'save'])->name('expense-types.save');
    Route::get('expense-types/export', [ExpenseTypeController::class, 'export'])->name("expense-types.export");
    Route::post('expense-types/expenseCreate', [ExpenseController::class, 'expenseCreate'])->name("expense-types.expenseCreate");



    //colors
    Route::get('colors', [ColorController::class, 'index'])->name('colors.index')->middleware('permission:colors.index');
    Route::post('colors/form/{item?}', [ColorController::class, 'form'])->name('colors.form');
    Route::post('colors/save/{item?}', [ColorController::class, 'save'])->name('colors.save');
    Route::get('colors/export', [ColorController::class, 'export'])->name("colors.export");




});




// Route::post('/stripe/webhook', [\App\Http\Controllers\Api\StripeController::class, 'handleWebhook']);


// Route::post('/github/deploy', [DeployController::class, 'handleWebhook']);

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});


Route::get('/success-payment', function () {
    $success= SuccessPage::first();
    return view('success_payment', compact('success'));
});



use App\Helpers\GoogleSheetsHelper;

Route::get("excel/credits",[ExcelController::class,'credits']);
Route::get("excel/technical_reviews",[ExcelController::class,'technicalReviews']);
Route::get("excel/insurances",[ExcelController::class,'insurances']);
Route::get("excel/penalties",[ExcelController::class,'penalties']);


//  $data = GoogleSheetsHelper::readSheet(env('GOOGLE_SPREADSHEET_RANGE'));
//     return response()->json($data);


Route::post('/payment/status/{kapital_order_id}', [\App\Http\Controllers\Api\KapitalPaymentController::class, 'checkPaymentStatus'])->name('order.status');



