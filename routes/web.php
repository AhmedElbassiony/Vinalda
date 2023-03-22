<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('ajax/data/{id}', [\App\Http\Controllers\DashboardController::class, 'data'])->name('ajax.data');
    Route::get('ajax/stock/{id}', [\App\Http\Controllers\DashboardController::class, 'stock'])->name('ajax.stock');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class , 'create'])->name('profile.create');
    Route::post('profile', [\App\Http\Controllers\ProfileController::class , 'store'])->name('profile.store');

    Route::resource('user' , \App\Http\Controllers\UserContorller::class)->except('show');
    Route::get('user/data' , [\App\Http\Controllers\UserContorller::class , 'data'])->name('user.data');

    Route::resource('method' , \App\Http\Controllers\MethodController::class)->except('show');
    Route::get('method/data' , [\App\Http\Controllers\MethodController::class , 'data'])->name('method.data');

    Route::resource('governorate' , \App\Http\Controllers\GovernoratesController::class)->except('show');
    Route::get('governorate/data' , [\App\Http\Controllers\GovernoratesController::class , 'data'])->name('governorate.data');

    Route::resource('clients', \App\Http\Controllers\ClientController::class)->except('show');
    Route::get('clients/data', [\App\Http\Controllers\ClientController::class, 'data'])->name('clients.data');

    Route::resource('vendors', \App\Http\Controllers\VendorController::class)->except('show');
    Route::get('vendors/data', [\App\Http\Controllers\VendorController::class, 'data'])->name('vendors.data');

    Route::resource('category', \App\Http\Controllers\CategoryController::class)->except('show');
    Route::get('category/data', [\App\Http\Controllers\CategoryController::class, 'data'])->name('category.data');

    Route::resource('expense', \App\Http\Controllers\ExpenseController::class)->except('show');
    Route::get('expense/data', [\App\Http\Controllers\ExpenseController::class, 'data'])->name('expense.data');

    Route::resource('brand', \App\Http\Controllers\BrandController::class)->except('show');
    Route::get('brand/data', [\App\Http\Controllers\BrandController::class, 'data'])->name('brand.data');

    Route::resource('stock', \App\Http\Controllers\StockController::class)->except('show');
    Route::get('stock/data', [\App\Http\Controllers\StockController::class, 'data'])->name('stock.data');

    Route::resource('items', \App\Http\Controllers\ItemController::class)->except('show');
    Route::get('items/data', [\App\Http\Controllers\ItemController::class, 'data'])->name('items.data');

    Route::resource('itemChildren', \App\Http\Controllers\ItemChildController::class)->except('show');
    Route::get('itemChildren/{itemChildren}/detailsData', [\App\Http\Controllers\ItemChildController::class, 'detailsData'])->name('itemChildren.detailsData');

    Route::get('itemChildren/data', [\App\Http\Controllers\ItemChildController::class, 'data'])->name('itemChildren.data');
    Route::get('itemChildren/{itemChildren}/details', [\App\Http\Controllers\ItemChildController::class, 'details'])->name('itemChildren.details');

    Route::patch('bill/{bill}/update-status', [\App\Http\Controllers\BillController::class, 'updateStatus'])->name('bill.update.status');
    Route::get('bill/{bill}/delete', [\App\Http\Controllers\BillController::class, 'destroy'])->name('bill.delete');


    Route::get('billPurchase/data', [\App\Http\Controllers\BillPurchaseController::class, 'data'])->name('billPurchase.data');
    Route::get('billPurchase/{billPurchase}/print', [\App\Http\Controllers\BillPurchaseController::class, 'print'])->name('billPurchase.print');
    Route::resource('billPurchase', \App\Http\Controllers\BillPurchaseController::class)->except('show');

    Route::get('billSale/data', [\App\Http\Controllers\BillSaleController::class, 'data'])->name('billSale.data');
    Route::get('billSale/{billSale}/print', [\App\Http\Controllers\BillSaleController::class, 'print'])->name('billSale.print');
    Route::resource('billSale', \App\Http\Controllers\BillSaleController::class)->except('show');

    Route::get('billExchange/data', [\App\Http\Controllers\BillExchangeController::class, 'data'])->name('billExchange.data');
    Route::get('billExchange/{billExchange}/print', [\App\Http\Controllers\BillExchangeController::class, 'print'])->name('billExchange.print');
    Route::resource('billExchange', \App\Http\Controllers\BillExchangeController::class)->except('show');

    Route::get('bank/{bank}/data', [\App\Http\Controllers\BankController::class, 'showData'])->name('bank.show.data');
    Route::get('bank/data', [\App\Http\Controllers\BankController::class, 'data'])->name('bank.data');

    Route::resource('bank', \App\Http\Controllers\BankController::class);

    Route::resource('client-payment', \App\Http\Controllers\ClientPaymentController::class)->except('show');
    Route::get('client-payment/data', [\App\Http\Controllers\ClientPaymentController::class, 'data'])->name('client-payment.data');

    Route::resource('vendor-payment', \App\Http\Controllers\VendorPaymentController::class)->except('show');
    Route::get('vendor-payment/data', [\App\Http\Controllers\VendorPaymentController::class, 'data'])->name('vendor-payment.data');

    Route::resource('transaction-payment', \App\Http\Controllers\TransactionPaymentController::class)->except('show');
    Route::get('transaction-payment/data', [\App\Http\Controllers\TransactionPaymentController::class, 'data'])->name('transaction-payment.data');

    Route::resource('expense-payment', \App\Http\Controllers\ExpensePaymentController::class)->except('show');
    Route::get('expense-payment/data', [\App\Http\Controllers\ExpensePaymentController::class, 'data'])->name('expense-payment.data');

    Route::get('installment-payment/{bill}', [\App\Http\Controllers\InstallmentPaymentController::class, 'index'])->name('installment-payment.index');
    Route::post('installment-payment/{bill}', [\App\Http\Controllers\InstallmentPaymentController::class, 'store'])->name('installment-payment.store');
    Route::get('installment-payment/{bill}/create', [\App\Http\Controllers\InstallmentPaymentController::class, 'create'])->name('installment-payment.create');
    Route::get('installment-payment/{bill}/data', [\App\Http\Controllers\InstallmentPaymentController::class, 'data'])->name('installment-payment.data');
    Route::put('installment-payment/{bill}/{installment_payment}', [\App\Http\Controllers\InstallmentPaymentController::class, 'update'])->name('installment-payment.update');
    Route::delete('installment-payment/{bill}/{installment_payment}', [\App\Http\Controllers\InstallmentPaymentController::class, 'destroy'])->name('installment-payment.destroy');
    Route::get('installment-payment/{bill}/{installment_payment}/edit', [\App\Http\Controllers\InstallmentPaymentController::class, 'edit'])->name('installment-payment.edit');

    Route::get('report/allClients/data', [\App\Http\Controllers\ReportController::class , 'allClientsData'])->name('report.allClientsData');
    Route::get('report/client', [\App\Http\Controllers\ReportController::class , 'client'])->name('report.client');
    Route::get('report/allClients', [\App\Http\Controllers\ReportController::class , 'allClients'])->name('report.allClients');
    Route::get('report/allItems', [\App\Http\Controllers\ReportController::class , 'allItems'])->name('report.allItems');
    Route::post('report/allItemsIndex', [\App\Http\Controllers\ReportController::class , 'allItemsIndex'])->name('report.allItemsIndex');




    Route::get('pdf', [\App\Http\Controllers\DashboardController::class , 'generate_pdf'])->name('generate_pdf');
});

//Route::get('test', function () {
////    Artisan::call('key:generate');
//    Artisan::call('route:clear');
//    Artisan::call('config:clear');
//    Artisan::call('route:clear');
//    Artisan::call('view:clear');
//    Artisan::call('cache:forget spatie.permission.cache');
//    Artisan::call('cache:clear');
//    Artisan::call('migrate:fresh --seed');
//});

Route::get('/generate', [\App\Http\Controllers\UserContorller::class , 'generatePassword'])->name('generate-password');


require __DIR__ . '/auth.php';
