<?php

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


Auth::routes();
Route::get('/catalog', 'CatalogController@index')->name('catalog');
Route::get('/catalog_detail/{id}', 'CatalogController@detail')->name('catalog_detail');


Route::group(['middleware' => ['role:owner']], function() {
	Route::resource('users', 'UsersController');
	Route::resource('roles', 'RolesController');
	Route::resource('permissions', 'PermissionsController');
});

Route::middleware(['auth'])->group(function () {

	
	Route::get('/add_prows', 'PurchaseController@add_prows');

	Route::get('/', 'HomeController@dashboard');
	Route::get('/pullinfo', 'HomeController@pullinfo');


Route::resource('colors', 'ColorController');


Route::get('/item_sc_detail/{dc}', 'HomeController@item_sc_detail')->name('item_sc_detail');
Route::get('/colors_list', 'HomeController@colors_list')->name('colors_list');
Route::get('/designcodes', 'HomeController@designcodes')->name('designcodes');
Route::post('/save_sc', 'HomeController@save_sc')->name('save_sc');

//BIGCOMMERCE ACTIONS
// Route::get('/bc_fetch_orders', 'BcController@fetch_orders')->name('bc_fetch_orders');
 Route::get('/upload_on_fws/{dc}', 'BcController@uploadonfws')->name('upload_on_fws');
//BIGCOMMERCE ACTIONS

Route::get('/cumulative', 'PackingController@cumulative')->name('cumulative');
Route::get('/accounts/{id}', 'AccountController@index')->name('accounts');
Route::post('/update_credit_limit', 'AccountController@update_credit_limit')->name('update_credit_limit');
Route::get('/voucher_details/{id}/{st}', 'AccountController@voucher_detail')->name('accounts');
Route::post('/makepayment', 'AccountController@makepayment')->name('accounts');
// Invoice Invoice Invoice

//Payments Payments Payments
Route::get('/pending_payments', 'PaymentsController@pending_payments')->name('pending_payments');
Route::get('/received_payments', 'PaymentsController@received_payments')->name('received_payments');	
Route::get('/receive_payment/{receipt_id}', 'PaymentsController@received')->name('receive_payment');
Route::get('/markunmark', 'PaymentsController@markunmark')->name('markunmark');	
//Payments Payments Payments

Route::get('/shipping_charges/{order_no}', 'InvoiceController@shipping_charges')->name('shipping_charges');
Route::post('/add_shipping', 'InvoiceController@add_shipping')->name('add_shipping');
Route::post('/generate_invoice', 'InvoiceController@generate_invoice')->name('generate_invoice');
Route::get('/view_invoice/{order_no}', 'InvoiceController@view_invoice')->name('view_invoice');
Route::get('/summary/{order_no}', 'InvoiceController@summary')->name('summary');
Route::get('/edit_invoice_qty/{order_no}', 'InvoiceController@edit_invoice_qty')->name('edit_invoice_qty');
Route::get('/edit_qty/{order_no}/{item_no}', 'InvoiceController@edit_qty')->name('edit_qty');
Route::post('/update_edit_qty', 'InvoiceController@update_edit_qty')->name('update_edit_qty');
Route::get('/view_list/{order_no}', 'InvoiceController@view_list')->name('view_list');
// Invoice Invoice Invoice


/* Customers */
Route::resource('customers', 'CustomerController');
Route::get('/generate_code/{id}', 'CustomerController@generate_code');
Route::get('/nonactive', 'CustomerController@nonactive');
/* Customers */

Route::resource('categories', 'CategoryController');

Route::get('/purchase', 'PurchaseController@index')->name('purchase');

Route::get('/purchase_list', 'PurchaseController@listc')->name('purchase_list');

Route::get('/purchase_placed', 'PurchaseController@placed')->name('purchase_placed');

Route::get('/purchase_detail/{id}', 'PurchaseController@detail')->name('purchase_detail');

Route::post('/receive_porder/{id}', 'PurchaseController@update')->name('receive_porder');


Route::get('/add_purchase_item', 'PurchaseController@addItem')->name('add_purchase_item');

Route::get('/remove_purchase_item', 'PurchaseController@removeItem')->name('remove_purchase_item');

Route::post('/makepurchase', 'PurchaseController@makePurchase')->name('makepurchase');

//SALES SALES SALES 
Route::get('/sales', 'SalesController@index')->name('sales');

Route::post('/select_customer', 'SalesController@selectCustomer')->name('select_customer');

Route::get('/select_warehouses', 'SalesController@selectWarehouses')->name('select_warehouses');

Route::post('/select_warehouse', 'SalesController@selectWarehouse')->name('select_warehouse');

Route::get('/listing', 'SalesController@listing')->name('listing');

Route::get('/item_detail/{design_code}', 'SalesController@item_detail')->name('item_detail');

Route::post('/addtobucket', 'SalesController@AddtoBucket')->name('addtobucket');

Route::get('/viewbucket', 'SalesController@viewBucket')->name('viewbucket');

Route::get('/remove_line/{id}', 'SalesController@remove_line')->name('remove_line');

Route::post('/add_address', 'SalesController@add_address')->name('add_address');

Route::post('/complete_order', 'SalesController@complete_order')->name('complete_order');

//SALES SALES SALES 


Route::get('/getchildcats', 'HomeController@getcat_child')->name('home');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/repeating', 'HomeController@repeating')->name('repeating');

Route::get('/size_colors/{id}', 'HomeController@size_colors')->name('size_colors');


Route::post('/saveitem', 'HomeController@save')->name('saveitem');
Route::post('/updateitem/{id}', 'HomeController@update')->name('updateitem');

Route::get('/add', 'HomeController@add')->name('item_add');

Route::get('/item_details/{id}', 'HomeController@detail')->name('item_details');

Route::get('dropzone/{dc}', 'HomeController@dropzone');
Route::post('dropzone/store', ['as'=>'dropzone.store','uses'=>'HomeController@dropzoneStore']);

Route::get('/delete_images/{id}', 'HomeController@delete_images')->name('delete_images');

// Orders Orders Orders

Route::get('/commission', 'OrdersController@commission')->name('commission');
Route::post('/post_comm', 'OrdersController@post_comm')->name('post_comm');
Route::get('/change_order_status/{order_no}', 'OrdersController@change_status')->name('change_status');
Route::post('/update_order_status', 'OrdersController@update_status')->name('update_status');

Route::post('/fill_order', 'OrdersController@fill_order')->name('fill_order');

Route::post('/update_note', 'OrdersController@update_note')->name('update_note');

Route::get('/hawavee_orders/{id}', 'OrdersController@hawavee_detail')->name('hawavee_order_detail');

Route::get('/hawavee_orders', 'OrdersController@hawavee')->name('hawavee_orders');

Route::get('/hawavee_pending_orders', 'OrdersController@hawavee_pending')->name('hawavee_orders');

Route::get('/fws_detail/{id}', 'OrdersController@fws_detail')->name('fws_detail');

Route::post('/update_fws_order', 'OrdersController@update_fws_order')->name('update_fws_order');

Route::get('/fws_orders', 'OrdersController@fws')->name('fws_orders');

Route::get('/ebay_orders', 'OrdersController@ebay')->name('ebay_orders');

// Orders Orders Orders


Route::get('/ebay_getaccess', 'EbayController@getUserAccess')->name('ebay_getaccess');

Route::get('/ebay_acceptedurl', 'EbayController@acceptedURL')->name('ebay_acceptedurl');

Route::get('/ebay_declineurl', 'EbayController@declineURL')->name('ebay_declineurl');

Route::get('/ebay_items', 'EbayController@viewEbayItems')->name('ebay_items');

Route::post('/ebay_post_items/{item}', 'EbayController@postItemEbay')->name('ebay_post_items');

Route::get('/ebay_categories', 'EbayController@getAllCategories')->name('ebay_all_categories');

Route::get('/ebay_cat_spec', 'EbayController@categorySpecifics')->name('ebay_cat_spec');

Route::get('/hawavee_cats', 'EbayController@getHawaveeCats')->name('hawavee_cats');

Route::post('/save_hawavee_cats', 'EbayController@saveHawaveeCats')->name('hawavee_cats');

Route::get('/get_ebay_orders', 'EbayController@getEbayOrders')->name('get_ebay_orders');

Route::resource('ebay_templates', 'EbayTemplateController');

Route::get('/mode', 'HomeController@setCounryMode');

Route::post('/boxes', 'InvoiceController@updateBoxes')->name('boxes');

//User Notes or Messages

Route::get('/message', 'messageController@index')->name('message');
Route::post('/save_message', 'messageController@save_message')->name('save message');
Route::get('/view_messages', 'messageController@view_messages')->name('View message');

Route::get('/message/{id}', 'messageController@message_id')->name('View Detail message');
Route::get('/report', 'messageController@report')->name('report');

Route::get('/user_report', 'messageController@user_report')->name('User Report');

Route::get('/blocked_customers', 'messageController@show_blocked_customers')->name('Show Blocked Customers');
Route::get('/blocked_users', 'messageController@show_blocked_users')->name('Show Blocked Users');

//User Notes or Messages

Route::get('/expenses', 'expenseController@index')->name('expenses');
Route::post('/save_expense', 'expenseController@save_expense')->name('save message');
Route::get('/expense_report', 'expenseController@report')->name('expense report');


});
