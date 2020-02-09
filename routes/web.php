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
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        //return view('welcome');
        return redirect()->route('middleware');
	});
});

Route::pattern('id', '[0-9]+');
Route::pattern('slug', '[0-9a-z-_]+');
Route::auth();
  //  Route::get('/admin', 'AdminController@index');
//});

Route::get('/currency', 'CurrencyController@index')->name('currency');
Route::get('/testmail', function(){
	mail('tak@test-redchain.ru', 'TEST', 'TEST');
});
//
Route::get('/get_status', 'TestController@getStatus')->name('get_status');
Route::post('/post_bc', 'TestController@postAddBCtype')->name('post_bc');

///TestAPIHandsBooksControllerTypeFee

Route::get('dotest','TestController@DoTest')->name('dotest');

Route::get('add_type_fee_test','TestController@addTypeFee')->name('add_type_fee_test');
Route::get('search_typefee_test','TestController@searchTypeFee')->name('search_typefee_test');
Route::get('post_type_feeadd_test','TestController@postTypeFeeAdd')->name('post_type_feeadd_test');
Route::get('post_type_feeedit_test','TestController@postTypeFeeEdit')->name('post_type_feeedit_test');


Route::get('/blocks', 'BlocksController@index')->name('blocks');
Route::get('/block-add', 'BlocksController@getBlockAdd')->name('block-add');
Route::get('/search_block', 'BlocksController@search')->name('search_block');
Route::get('/block-edit/{id}/', 'BlocksController@getBlockEdit')->name('block-edit');
Route::get('/block-duplicated/{id}', 'BlocksController@getBlockDuplicated')->name('block-duplicated');
Route::get('/get_avail_list', 'TestController@getAvailability')->name('get_avail_list');
Route::get('/testcur', 'TestController@testcur');
Route::get('/testgenerate', 'AxiosController@generatePdfAccount');
Route::get('/make_ticket', 'TestController@makeTicket')->name('make_ticket');
Route::get('/test_export', 'TestController@TestExport')->name('/test_export');
Route::get('/get_currency', 'HandBooksController@index')->name('get_currency');
Route::get('/get_provider', 'HandBooksController@getProvider')->name('get_provider');
Route::get('/get_edit_provider/{id}', 'HandBooksController@getEditProvider')->name('get_edit_provider');

Route::get('/get_edit_currency/{id}', 'HandBooksController@getEditCurrency')->name('get_edit_currency');

Route::get('/findtest', 'AxiosController@findData');
Route::get('/get_edit_airline/{id}', 'HandBooksController@getEditAirline')->name('get_edit_airline');


Route::get('/get_edit_farefamily/{id}', 'HandBooksController@getEditFareFamily')->name('get_edit_farefamily');

Route::get('/get_edit_passenger/{id}', 'HandBooksController@getEditPassenger')->name('get_edit_passenger');


Route::get('/get_edit_bctype/{id}', 'HandBooksController@getEditBCtype')->name('get_edit_bctype');

Route::get('/get_airlene', 'HandBooksController@getAirline')->name('get_airline');
Route::get('/get_farefamily', 'HandBooksController@getFareFamily')->name('get_farefamily');

Route::get('/get_passenger', 'HandBooksController@getPassenger')->name('get_passenger');

Route::get('/get_bctype','HandBooksController@getBCtype')->name('get_bctype');

Route::get ('test_company','TestController@testCompany')->name('test_company');

Route::get('/get_airoport','HandBooksController@getAiroport')->name('get_airoport');
Route::get('/get_type_fee','HandBooksController@getTypeFee')->name('get_typefee');

Route::get('/search_airline', 'HandBooksController@searchAirline')->name('search_airline');


Route::get('/search_currency', 'HandBooksController@searchCurrency')->name('search_currency');

Route::get('/search_farefamily', 'HandBooksController@searchFareFamily')->name('search_farefamily');


Route::get('/search_passenger', 'HandBooksController@searchPassenger')->name('search_passenger');

Route::get('/search_bctype', 'HandBooksController@searchBCtype')->name('search_bctype');

Route::get('/search_aeroport', 'HandBooksController@searchAeroport')->name('search_aeroport');
Route::get('/cancel_mail_order/{id}', 'MailingsController@cancelOrder')->name('cancel_mail_order');
Route::post('/cancel_mail_booking', 'MailingsController@postCancelBooking')->name('cancel_mail_booking');


Route::post('/currency_add', 'HandBooksController@postCurrencyAdd')->name('currency_add');

Route::post('/currency_edit', 'HandBooksController@postCurrencyEdit')->name('currency_edit');

Route::post('/airline_add', 'HandBooksController@postAirlineAdd')->name('airline_add');
Route::get('/get_payment', 'TestController@getPayment')->name('get_payment');
Route::post('/add_payment', 'TestController@addPayment')->name('add_payment');
Route::post('/fare_family_add', 'HandBooksController@postFareFamilyAdd')->name('fare_family_add');

Route::get('/edit_provider', 'HandBooksController@getEditProvider')->name('edit_provider');

Route::get('/provider_add', 'HandBooksController@postProviderAdd')->name('provider_add');


Route::post('/provider_edit', 'HandBooksController@postProviderEdit')->name('provider_edit');

Route::get('/get_edit_currency', 'HandBooksController@getEditCurrency')->name('get_edit_currency');
 
Route::get('/get_edit_provider_account/{id}', 'HandBooksController@ getEditProviderAccount')->name('get_edit_provider_account');


Route::post('/provider_account_add', 'HandBooksController@postProviderAccountAdd')->name('provider_account_add');

Route::post('/provider_account_edit', 'HandBooksController@postProviderAccountEdit')->name('provider_account_edit');

Route::get('/get_provider_account', 'HandBooksController@getProviderAccount')->name('get_provider_account');

Route::get('/search_provider_account', 'HandBooksController@searchProviderAccount')->name('search_provider_account');

Route::get('/get_edit_farefamily/{id}', 'HandBooksController@getEditFareFamily')->name('get_edit_farefamily');

Route::get('/add_currency
', 'HandBooksController@addCurrency')->name('add_currency');


Route::get('/fare_family_edit
', 'HandBooksController@postFareFamilyEdit')->name('fare_family_edit');


Route::get('/add_provider
', 'HandBooksController@addProvider')->name('add_provider');

Route::get('/add_airline
', 'HandBooksController@addAirline')->name('add_airline');

Route::get('/add_provider_account
', 'HandBooksController@addProviderAccount')->name('add_provider_account');

Route::get('/add_fare_family
', 'HandBooksController@addFareFamily')->name('add_fare_family');

Route::get('/add_passenger
', 'HandBooksController@addPassenger')->name('add_passenger');

Route::get('/add_bctype
', 'HandBooksController@addBCtype')->name('add_bctype');

Route::get('/add_airoport
', 'HandBooksController@addAiroport')->name('add_airoport');


Route::get('/add_type_fee
', 'HandBooksController@addTypeFee')->name('add_type_fee');

Route::get('/create_multi_booking
', 'TestController@CreateMultiBooking')->name('create_multi_booking');

Route::get('/financies
', 'FinancesController@index')->name('financies');

Route::get('get_payment
', 'FinancesController@getPayment')->name('get_payment');
 
Route::post('/add_payment
', 'FinancesController@addPayment')->name('add_payment');

Route::post('/put_account
', 'FinancesController@putAccount')->name('put_account');

  


Route::get('/get_company_info/{id}', 'FinancesController@getCompanyInfo')->name('get_company_info');








Route::get('/get_farefamily', 'HandBooksController@getFareFamily')->name('get_farefamily');

Route::get('/search_passenger', 'HandBooksController@searchPassenger')->name('search_passenger');

Route::get('/get_edit_passenger', 'HandBooksController@getEditPassenger')->name('get_edit_passenger');

Route::get('/get_passenger', 'HandBooksController@getPassenger')->name('get_passenger');

Route::post('/passenger_add', 'HandBooksController@postAddPassenger')->name('passenger_add');

Route::post('/passenger_edit', 'HandBooksController@postEditPassenger')->name('passenger_edit');

Route::get('/get_bctype', 'HandBooksController@getBCtype')->name('get_bctype');

Route::get('/search_bctype', 'HandBooksController@searchBCtype')->name('search_bctype');

Route::get('/get_edit_bctype', 'HandBooksController@getEditBCtype')->name('get_edit_bctype');

Route::post('/edit_bctype', 'HandBooksController@postEditBCtype')->name('post_edit_bctype');

Route::get('/search_typefee', 'HandBooksController@searchTypeFee')->name('search_typefee');

Route::post('/type_fee_add', 'HandBooksController@postTypeFeeAdd')->name('type_fee_add');

Route::post('/type_fee_edit', 'HandBooksController@postTypeFeeEdit')->name('type_fee_edit');
Route::post('/edit_airoport', 'HandBooksController@postEditAiroport')->name('edit_airoport');
Route::post('/add_airoport', 'HandBooksController@postAddAiroport')->name('add_airoport');

//TestController
Route::get('/cancel_book', 'TestController@CancelBooking')->name('cancel_book');
Route::get('/read_book', 'TestController@ReadBooking')->name('read_book');
Route::get('/create_book', 'TestController@CreateBooking')->name('create_book');
Route::get('test_export', 'TestController@TestExport')->name('test_export');
Route::get('exchange/{id}', 'TestController@Exchange')->name('exchange');
Route::get('download_excel', 'TestController@downloadExcel')->name('download_excel');

Route::post('/postblockedit','BlocksController@postBlockEdit')->name('postblockedit');
Route::post('/postblockadd','BlocksController@postBlockAdd')->name('postblockadd');
Route::post('/postblockduplicated','BlocksController@postBlockDuplicated')->name('postblockduplicated');


//SchedulesController

Route::get('/schedules', 'SchedulesController@index')->name('schedules');
Route::get('/schedule-add', 'SchedulesController@getScheduleAdd')->name('schedule-add');
Route::get('/schedule-edit/{id}','SchedulesController@getScheduleEdit')->name('schedule-edit');
Route::post('/postscheduleadd', 'SchedulesController@postScheduleAdd')->name('postscheduleadd');
Route::post('/postscheduledit', 'SchedulesController@postScheduleEdit')->name('postscheduledit');


//SchedulesController

Route::get('/search_sсhedule', 'SchedulesController@search')->name('search_sсhedule');
Route::get('/admin', 'AdminController@index')->name('middleware');
Route::get('/passwords', 'AdminController@getPasswords')->name('passwords');
Route::post('/updateadminprofile', 'AdminController@updateProfile')->name('updateadminprofile');
Route::post('/updatepassword', 'AdminController@updatePassword')->name('updatepassword');
Route::get('/search_company', 'CompanyController@search')->name('search_company');


//AirlenesController

Route::get('/airline_index', 'AirlenesController@index')->name('airline_index');
Route::get('/get_edit_airlined/{id}', 'AirlenesController@getEditAirline')->name('get_edit_airlined');
Route::get('/get_airline', 'AirlenesController@getAirline')->name('/get_airline');
Route::post('/airline_added', 'AirlenesController@postAirlineAdd')->name('airline_added');
Route::post('/airline_edited', 'AirlenesController@postAirlineEdit')->name('airline_edited');
Route::get('/search_airline', 'AirlenesController@searchAirline')->name('/search_airline');
Route::get('/index_airline_api', 'APIAirlenesController@index')->name('index_airline_api');


//Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/profile', 'AdminController@profile')->name('profile');
Route::get('/admin/test', 'AdminController@test')->name('admin_test');
Route::get('/admin/chat', 'ChatController@index')->name('chat');

Route::get('/testbooking', 'API\BookingController@booking');
Route::get('/testwo', 'API\BookingController@writeout');



//FeesPlacesController

Route::get('/feesplaces','FeesPlacesController@index' )->name('feesplaces');
Route::get('/feesplace_search','FeesPlacesController@search' )->name('feesplace_search');
Route::get('/feesplace-edit/{id}','FeesPlacesController@getFeePlaceEdit')->name('feesplace-edit');
Route::get('/feesplace-add','FeesPlacesController@getFeePlaceAdd' )->name('feesplace-add');
Route::get('/feesplace-copy/{id}','FeesPlacesController@getFeePlaceCopy' )->name('feesplace-copy');
Route::get('/feesplace-copyreplace/','FeesPlacesController@getFeePlaceCopyReplace' )->name('feesplace-copyreplace');
Route::post('/postfeeplacecopyreplace', 'FeesPlacesController@postFeePlaceCopyReplace')->name('postfeeplacecopyreplace');
Route::post('/postfeeplacecopy', 'FeesPlacesController@postFeePlaceCopy')->name('postfeeplacecopy');
Route::post('/postfeesplaceadd', 'FeesPlacesController@postFeePlaceAdd')->name('postfeesplaceadd');
Route::post('/postfeesplaceadd', 'FeesPlacesController@postFeePlaceAdd')->name('postfeesplaceadd');
Route::post('/postfeesplaceedit', 'FeesPlacesController@postFeePlaceEdit')->name('postfeesplaceedit');


//OrdersController

Route::get('orders/all', 'OrdersController@index');
Route::get('/orders', 'OrdersController@index')->name('orders');
Route::get('/search_order', 'OrdersController@search')->name('search_order');
Route::get('/get_order/{id}', 'OrdersController@getOrder')->name('get_order');
Route::get('/get_all_orders', 'OrdersController@getAllOrders')->name('get_all_orders');
Route::get('/get_all_fees', 'OrdersController@getFees')->name('get_all_fees');
Route::get('/get_all_services', 'OrdersController@getAllServices')->name('get_all_services');
Route::get('/get_exchange_service','OrdersController@getServiceExchange')->name('get_exchange_service');
Route::get('/get_block/{id}', 'OrdersController@getBlock')->name('get_block');
Route::post('/generate_ticket','OrdersContreller@GenerateTicket')->name('generate_ticket');
Route::post('/block_final','OrdersContreller@postBlockFinal')->name('block_final');

//CraneController

Route::get('/crane', 'CraneController@index')->name('crane');
Route::post('/getairavailability', 'CraneController@getAirAvailability')->name('getairavailability');
Route::get('/getcancelbooking', 'CraneController@getCancelBooking')->name('getcancelbooking');
Route::get('/getreadbooking', 'CraneController@getReadBooking')->name('getreadbooking');
Route::get('/getcreatebooking', 'CraneController@getCreateBooking')->name('getcreatebooking');
Route::post('/postcreatebooking', 'CraneController@postCreateBooking')->name('postcreatebooking');
Route::post('/postcancelbooking', 'CraneController@postCancelBooking')->name('postcancelbooking');
Route::post('/postreadbooking', 'CraneController@postReadBooking')->name('postreadbooking');
Route::get('/getairticketreservation', 'CraneController@getAirTicketReservation')->name('getairticketreservation');
Route::post('/postairticketreservation','CraneController@postAirTicketReservation')->name('postairticketreservation');
Route::post('/postneworder','CraneController@postNewOrder')->name('postneworder');


//SearchFligtsController

Route::get('/searchflight','API\SearchFligtsController@search');


//CompanyController

Route::get('/admin/companies', 'CompanyController@index')->name('admincompanies');
Route::get('/company-edit/{id}', 'CompanyController@getCompanyEdit')->name('company-edit');
Route::get('/company-change-logo/{id}', 'CompanyController@postCompanyLogoChange');
Route::get('/company-add','CompanyController@getCompanyAdd')->name('company-add');
Route::get('/search_company','CompanyController@search')->name('search_company');
Route::get('/addcompany', 'CompanyController@postCompanyAdd')->name('addcompany');
Route::get('/getcompany/{id}', 'CompanyController@getCompany')->name('getcompany');
Route::post('/postcompanyadd', 'CompanyController@postCompanyAdd')->name('postcompanyadd');
Route::post('/postcompanyedit', 'CompanyController@postCompanyEdit')->name('postcompanyedit');



Route::get('/admin/messages', 'AdminController@messages')->name('admin_messages');

Route::get('/test', 'TestController@index')->name('test');

//PermissionController

Route::prefix('/admin/permissions')->group(function(){
	Route::get('/', 'PermissionController@getGroupAdd');
	Route::get('/groups-get', 'PermissionController@getGroups');
	Route::post('/group-add', 'PermissionController@postGroupAdd');
	Route::post('/group-delete', 'PermissionController@postGroupDelete');
	Route::post('/update', 'PermissionController@permissionsUpdate');
	Route::get('/permissions-get', 'PermissionController@getPermissions');
	Route::get('/permissions-get-all', 'PermissionController@getAllPermissions');
});

//UserController

Route::prefix('/admin/users')->group(function(){
	Route::get('/', 'UserController@index');
	Route::get('/create', 'UserController@create');
	Route::post('/create-user', 'UserController@storeNewUser');
	Route::get('/companies-get', 'UserController@companiesGet');
	Route::get('/get-users', 'UserController@getUsers');
	Route::post('/update-user', 'UserController@updateUser');
	Route::get('/edit/{id}', 'UserController@editUser');
	
});


//AxiosController

Route::prefix('/axios/get/')->group(function(){
	Route::get('/cities', 'AxiosController@getCities');
	Route::get('/airportsbycity', 'AxiosController@getAirportsByCity');
	Route::get('/companies', 'AxiosController@getCompanies');
	Route::get('/managers', 'AxiosController@getManagers');
});
Route::prefix('/axios/make/')->group(function(){
	Route::get('/booking', 'AxiosController@makeBooking');
});
 
	
Route::prefix('/axios/chat')->group(
	function(){
		Route::get('/get-users', 'ChatController@getUsers');
		Route::get('/get-conversations', 'ChatController@getConversations');
		Route::get('/get-messages', 'ChatController@getMessages');
		Route::post('/send-message', 'ChatController@sendMessage');
		Route::post('/create-conversation', 'ChatController@createConversation');

	}
);
Route::middleware('auth')->group(
	function(){
		Route::get('/admin/history', 'HistoryController@index');
		Route::get('/admin/history/date/{date}', 'HistoryController@date');
	}
);
Route::prefix('/admin/settings/advertising')->group(
	function(){
		Route::get('/', 'AdvertisingController@index');
		Route::post('/save', 'AdvertisingController@save');

	}
);
Route::get('/systemmessage/{text}', 'ChatController@createSystemMessage');
// Localization
Route::get('/js/lang.js', function () {
    $strings = Cache::rememberForever('lang.js', function () {
        $lang = config('app.locale');

        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');