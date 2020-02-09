<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//route auth
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//route api:auth

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {

});

Route::group(['middleware' => 'auth:api'], function(){

//UserController

Route::post('details', 'API\UserController@details');
Route::post('company/managers', 'API\UserController@managers');


//HistoryController
Route::get('history', 'HistoryController@index');
Route::get('history/date/{date}', 'HistoryController@bydate');

Route::post('flights/edit/{id}', 'FlightsController@edit');
Route::get('flights', 'FlightsController@index');

//PermissionController
Route::prefix('permissions')->group(function(){
   // Route::get('/', 'PermissionController@getGroupAdd');

	Route::get('groups', 'PermissionController@getGroups');
	Route::post('group/add', 'PermissionController@postGroupAdd');
	Route::post('group/delete', 'PermissionController@postGroupDelete');
	Route::post('update', 'PermissionController@permissionsUpdate');
	Route::get('permissions','PermissionController@getPermissions');
	Route::get('permissions/all','PermissionController@getAllPermissions');

});


//AxiosController
Route::get('/account/generate', 'AxiosController@generatePdfAccount');\Route::get('currency/all', 'AxiosController@allCurrencies');
Route::get('countries/all', 'AxiosController@getCounties');
Route::get('airports/search', 'AxiosController@getAirportsByCity');
Route::get('locations', 'AxiosController@getACCs');
Route::post('country/add', 'AxiosController@countryAdd');
Route::post('city/add', 'AxiosController@cityAdd');
Route::post('airport/add', 'AxiosController@airportAdd');
Route::post('country/edit', 'AxiosController@countryEdit');
Route::post('city/edit', 'AxiosController@cityEdit');
Route::get('find', 'AxiosController@findData');
Route::post('airport/edit', 'AxiosController@airportEdit');
Route::post('country/delete', 'AxiosController@countryDelete');
Route::post('city/delete', 'AxiosController@cityDelete');
Route::post('airport/delete', 'AxiosController@airportDelete');
Route::post('passenger/edit', 'PassengersController@edit');

//BookingController
Route::post('booking', 'API\BookingController@booking')->name('booking');


//CraneController

Route::get('crane', 'CraneController@index')->name('crane');
Route::post('getairavailability', 'CraneController@getAirAvailability')->name('getairavailability');
Route::get('getcancelbooking', 'CraneController@getCancelBooking')->name('getcancelbooking');
Route::get('getreadbooking', 'CraneController@getReadBooking')->name('getreadbooking');
Route::get('getcreatebooking', 'CraneController@getCreateBooking')->name('getcreatebooking');
Route::post('postcreatebooking', 'CraneController@postCreateBooking')->name('postcreatebooking');
Route::post('postcancelbooking', 'CraneController@postCancelBooking')->name('postcancelbooking');
Route::post('postreadbooking', 'CraneController@postReadBooking')->name('postreadbooking');
Route::get('getairticketreservation', 'CraneController@getAirTicketReservation')->name('getairticketreservation');
Route::post('postairticketreservation','CraneController@postAirTicketReservation')->name('postairticketreservation');
Route::post('postneworder','CraneController@postNewOrder')->name('postneworder');

//APIFeesPlacesController
Route::post('postfeeplacecopyreplace', 'API\APIFeesPlacesController@postFeePlaceCopyReplace');
Route::get('bctype/all','API\BCTypesController@allbc' );
Route::get('feesplaces','API\APIFeesPlacesController@index' );
Route::post('feesplaces/add', 'API\APIFeesPlacesController@add');
Route::post('feesplaces/edit', 'API\APIFeesPlacesController@edit');
Route::post('feesplaces/copy', 'API\APIFeesPlacesController@copy');
Route::post('feesplaces/replace', 'API\APIFeesPlacesController@replace');
	
//APISchedulesController
Route::get('schedules','API\APISchedulesController@index' );
Route::post('schedule/add', 'API\APISchedulesController@add');
Route::post('schedule/edit', 'API\APISchedulesController@edit');
Route::get('orders/all', 'OrdersController@index');
Route::post('crane/search', 'CraneController@getAirAvailability');
Route::post('flights/search', 'API\SearchFligtsController@search');

//CompanyController
Route::get('company/all', 'CompanyController@index');
Route::post('company/search', 'CompanyController@search');
Route::get('company/show/{id}', 'CompanyController@show');
Route::post('company/add', 'CompanyController@postCompanyAdd');
Route::post('company/edit', 'CompanyController@postCompanyEdit');
Route::get('airlines/all', 'CompanyController@getAirlines');
Route::post('add_company_mailing/{$company_id}','CompanyController@AddCompanyMailing');
Route::prefix('/company/settings/advertising')->group(
	function(){
		Route::get('/', 'AdvertisingController@index');
		Route::post('/save', 'AdvertisingController@save');
		Route::post('/delete', 'AdvertisingController@delete');

	}
);

//BlocksController
Route::get('blocks', 'BlocksController@index')->name('blocks');
Route::post('block-add', 'BlocksController@postBlockAdd');
Route::get('search_block', 'BlocksController@search')->name('search_block');
Route::post('block/edit', 'BlocksController@edit');
Route::post('flights/generate/{id}', 'BlocksController@getBlockDuplicated');
Route::get('block-duplicated/{id}', 'BlocksController@getBlockDuplicated')->name('block-duplicated');
Route::post('postblockedit','BlocksController@postBlockEdit')->name('postblockedit');
Route::post('postblockadd','BlocksController@postBlockAdd')->name('postblockadd');
Route::post('postblockduplicated','BlocksController@postBlockDuplicated')->name('postblockduplicated');

//MailingsController
Route::get('cancel_mail_order_api/{id}', 'MailingsController@cancelOrder')->name('cancel_mail_order_api');
Route::post('cancel_mail_booking_api', 'MailingsController@postCancelBooking')->name('cancel_mail_booking_api');

//APIFinancesController
Route::get('finance', 'API\APIFinancesController@index')->name('financies');
Route::post('payment/create', 'API\APIFinancesController@makePayment')->name('make_payment');

Route::get('payments', 'API\APIFinancesController@getPayment');
Route::get('get_account', 'API\APIFinancesController@getAccount');

Route::get('bills', 'API\APIFinancesController@getBills');
Route::post('bill/create', 'API\APIFinancesController@putAccount');

//APIBlocksOrdersController
Route::get('blocksorders_api', 'API\APIBlocksOrdersController@index')->name('blocksorders_api');
Route::get('get_blockstickets_api', 'API\APIBlocksOrdersController@getTickets')->name('get_blockstickets_api');
Route::get('get_blockorder_api/{id}', 'API\APIBlocksOrdersController@getBlockOrder')->name('get_blockorder_api');
Route::post('blocksticket_edit_api', 'API\APIBlocksOrdersController@postTicketBlockEdit')->name('blocksticket_edit_api');
Route::get('get_blockticket_api/{id}', 'API\APIBlocksOrdersController@getBlockTicket')->name('get_blockticket_api');
Route::post('blocksorders_edit_api', 'API\APIBlocksOrdersController@postOrderBlockEdit')->name('blocksorder_edit_api');



Route::prefix('chat')->group(
	function(){
		Route::get('/users', 'ChatController@getUsers');
		Route::get('/conversations', 'ChatController@getConversations');
		Route::get('/messages', 'ChatController@getMessages');
		Route::post('/send-message', 'ChatController@sendMessage');
		Route::post('/conversation/create', 'ChatController@createConversation');

	}
);

//APIReportsController

Route::get('reports','API\APIReportsController@index')->name('reports');
Route::get('get_link_report_api', 'API\APIReportsController@getEmailReport')->name('get_email_export_api');
Route::post('post_email_report_api', 'API\APIReportsController@postEmailReport')->name('post_email_report_api');
Route::get('get_report_api/{$id}', 'API\APIReportsController@getReport')->name('get_report_api');
Route::get('get_make_report_api', 'API\APIReportsController@makeReport')->name('get_make_report_api');


//APIOrdersController

Route::get('search_order_api', 'API\APIOrdersController@search')->name('search_order_api');

Route::post('post_done_cancel_service','API\APIOrdersController@postDoneCancelService')->name('post_done_cancel_service');
Route::get('cancel_order/{id}','API\APIOrdersController@gcancelOrder')->name('cancel_order');
Route::post('post_cancel_service','API\APIOrdersController@postCancelService')->name('post_cancel_service'); 
Route::get('done_cancel_service/{id}','API\APIOrdersController@getDoneCancelService')->name('done_cancel_service');
Route::get('order/writeout', 'API\BookingController@writeout');
Route::get('get_order_api/{id}', 'API\APIOrdersController@getOrder')->name('get_order_api');
Route::get('get_all_orders_api', 'API\APIOrdersController@getAllOrders')->name('get_all_orders_api');
Route::get('get_all_fees_api', 'API\APIOrdersController@getFees')->name('get_all_fees_api');
Route::get('get_all_services_api', 'API\APIOrdersController@getAllServices')->name('get_all_services_api');
Route::get('get_services_exchange_api/{id}', 'API\APIOrdersController@getServiceExchange');
Route::post('post_services_exchange_api','API\APIOrdersController@postEditServiceExchange')->name('post_services_exchange_api');
Route::get('get_block_api/{id}', 'API\APIOrdersController@getBlock')->name('get_block_api');
Route::post('generate_ticket_api','API\APIOrdersContreller@GenerateTicket')->name('generate_ticket_api');
Route::post('block_final_api','API\APIOrdersContreller@postBlockFinal_api')->name('block_final_api');
Route::get('orders_api', 'API\APIOrdersController@index')->name('orders_api');
Route::post('order/edit', 'API\APIOrdersController@edit');
Route::post('order/setstatus', 'API\APIOrdersController@setstatus');
Route::post('exchanged_status_api', 'API\APIOrdersController@postExchangedStatus')->name('exchanged_status_api');
Route::post('blocked_status_api', 'API\APIOrdersController@postBlockedStatus')->name('blocked_status_api');
Route::post('inwork_status_api', 'API\APIOrdersController@postInworkStatus')->name('inwork_status_api');
Route::post('issued_status_api', 'API\BookingController@writeout')->name('issued_status_api');
Route::post('issued_block_status_api', 'API\APIOrdersController@postIssuedBlockStatus')->name('issued_block_status_api');
Route::post('elemenated_status_api', 'API\APIOrdersController@postCancelService')->name('elemenated_status_api');
Route::post('canceled_status_api', 'API\APIOrdersController@postCancelService')->name('canceled_status_api');

//APIMailingsController


Route::get('mailings', 'API\APIMailingsController@index')->name('mailings');
Route::get('add_mailing', 'API\APIMailingsController@addMailing')->name('add_mailing');
Route::post('post_mailing_add', 'API\APIMailingsController@postMailingAdd')->name('post_mailing_add');
Route::post('mailing/status/change', 'API\APIMailingsController@changeStatus');
Route::get('get_mailing_edit/{$id}', 'API\APIMailingsController@getMailingEdit')->name('get_mailing_edit');
Route::post('post_mailing_edit', 'API\APIMailingsController@postMailingEdit')->name('post_mailing_edit');
Route::get('add_mailing_list', 'API\APIMailingsController@addMailList')->name('add_mailing_list');
Route::post('post_mail_list_add', 'API\APIMailingsController@postMailListAdd')->name('post_mail_list_add');
Route::get('get_mail_list_edit/{$id}', 'API\APIMailingsController@getMailListEdit')->name('get_mail_list_edit');
Route::get('change_mail_status', 'API\APIMailingsController@changeMailStatus')->name('change_mail_status');
Route::post('post_mail_list_edit', 'API\APIMailingsController@postMailListEdit')->name('post_mail_list_edit');

Route::post('post_email_delete', 'API\APIMailingsController@postDeleteEmail')->name('post_email_delete');
Route::post('post_add_email', 'API\APIMailingsController@postAddEmail')->name('post_add_email');



//APIHandsBooksController
Route::get('get_currency_api', 'API\APIHandsBooksController@index')->name('get_currency_api');
Route::get('get_provider_api', 'API\APIHandsBooksController@getProvider')->name('get_provider_api');
Route::get('get_edit_provider_api/{id}', 'API\APIHandsBooksController@getEditProvider')->name('get_edit_provider_api');
Route::get('get_edit_currency_api/{id}', 'API\APIHandsBooksController@getEditCurrency')->name('get_edit_currency_api_api');
Route::get('get_edit_airline_api/{id}', 'API\APIHandsBooksController@getEditAirline')->name('get_edit_airline_api');
Route::get('get_edit_farefamily_api/{id}', 'API\APIHandsBooksController@getEditFareFamily')->name('get_edit_farefamily_api');
Route::get('get_edit_passenger_api/{id}', 'API\APIHandsBooksController@getEditPassenger')->name('get_edit_passenger_api');
Route::get('get_edit_bctype_api/{id}', 'API\APIHandsBooksController@getEditBCtype')->name('get_edit_bctype_api');
Route::get('get_airline_api', 'API\APIHandsBooksController@getAirline')->name('get_airline_api');
Route::get('get_farefamily_api', 'API\APIHandsBooksController@getFareFamily')->name('get_farefamily_api');
Route::get('get_passenger_api', 'API\APIHandsBooksController@getPassenger')->name('get_passenger_api');
Route::get('get_bctype_api','API\APIHandsBooksController@getBCtype')->name('get_bctype_api');
Route::get('get_airoport_api','API\APIHandsBooksController@getAiroport')->name('get_airoport_api');
Route::get('search_airoport_api','API\APIHandsBooksController@searchAeroport')->name('search_airoport_api');
Route::post('country_add_api','API\APIHandsBooksController@postCountryAdd')->name('country_add_api');
Route::post('country_edit_api','API\APIHandsBooksController@postCountryEdit')->name('country_edit_api');
Route::post('city_add_api','API\APIHandsBooksController@postCityAdd')->name('city_add_api');
Route::post('city_edit_api','API\APIHandsBooksController@postCityEdit')->name('city_edit_api');
Route::get('get_type_fee_api','API\APIHandsBooksController@getTypeFee')->name('get_typefee_api');
Route::get('search_airline_api', 'API\APIHandsBooksController@searchAirline')->name('search_airline_api');
Route::get('search_currency_api', 'API\APIHandsBooksController@searchCurrency')->name('search_currency_api');
Route::get('search_farefamily_api', 'API\APIHandsBooksController@searchFareFamily')->name('search_farefamily_api');
Route::get('search_passenger_api', 'API\APIHandsBooksController@searchPassenger')->name('search_passenger_api');
Route::get('search_bctype_api', 'API\APIHandsBooksController@searchBCtype')->name('search_bctype_api');
Route::get('search_aeroport_api', 'API\APIHandsBooksController@searchAeroport')->name('search_aeroport_api');
Route::post('currency_add_api', 'API\APIHandsBooksController@postCurrencyAdd')->name('currency_add_api');
Route::post('currency_edit_api', 'API\APIHandsBooksController@postCurrencyEdit')->name('currency_edit_api');
Route::post('airline_add_api', 'API\APIHandsBooksController@postAirlineAdd')->name('airline_add_api');
Route::post('airline_edit_api', 'API\APIHandsBooksController@postAirlineEdit')->name('airline_edit_api');
Route::post('fare_family_add_api', 'API\APIHandsBooksController@postFareFamilyAdd')->name('fare_family_add_api');
Route::get('edit_provider_api/{id}', 'API\APIHandsBooksController@getEditProvider')->name('edit_provider_api');
Route::post('provider_add_api', 'API\APIHandsBooksController@postProviderAdd')->name('provider_add_api');
Route::post('add_type_fee_api', 'API\APIHandsBooksController@postTypeFeeAdd')->name('add_type_fee_api');
Route::post('edit_type_fee_api', 'API\APIHandsBooksController@postTypeFeeEdit')->name('edit_type_fee_api');
Route::post('provider_edit_api', 'API\APIHandsBooksController@postProviderEdit')->name('provider_edit_api');
Route::get('get_edit_currency_api/{$id}', 'API\APIHandsBooksController@getEditCurrency')->name('get_edit_currency_api');
Route::get('get_edit_provider_account_api/{id}', 'API\APIHandsBooksController@getEditProviderAccount')->name('get_edit_provider_account_api');
Route::post('provider_account_add_api', 'API\APIHandsBooksController@postProviderAccountAdd')->name('provider_account_add_api');
Route::post('provider_account_edit_api', 'API\APIHandsBooksController@postProviderAccountEdit')->name('provider_account_edit_api');
Route::get('get_provider_account_api/', 'API\APIHandsBooksController@getProviderAccount')->name('get_provider_account_api');
Route::get('search_provider_account', 'API\APIHandsBooksController@searchProviderAccount')->name('search_provider_account');
Route::get('get_edit_farefamily_api/{$id}', 'API\APIHandsBooksController@getEditFareFamily')->name('get_edit_farefamily_api');
Route::get('add_currency_api
', 'API\APIHandsBooksController@addCurrency')->name('add_currency_api');
Route::post('fare_family_edit_api
', 'API\APIHandsBooksController@postFareFamilyEdit')->name('fare_family_edit_api');
Route::get('add_provider_api
', 'API\APIHandsBooksController@addProvider')->name('add_provider_api');
Route::get('add_airline_api
', 'API\APIHandsBooksController@addAirline')->name('add_airline_api');
Route::get('add_provider_account_api
', 'API\APIHandsBooksController@addProviderAccount')->name('add_provider_account_api');
Route::get('add_fare_family_api
', 'API\APIHandsBooksController@addFareFamily')->name('add_fare_family_api');
Route::post('add_passenger_api
', 'API\APIHandsBooksController@postAddPassenger')->name('add_passenger_api');
Route::post('edit_passenger_api
', 'API\APIHandsBooksController@postEditPassenger')->name('edit_passenger_api');
Route::post('add_bctype_api
', 'API\APIHandsBooksController@postAddBCtype')->name('add_bctype_api');
Route::post('edit_bctype_api
', 'API\APIHandsBooksController@postEditBCtype')->name('edit_bctype_api');
Route::get('get_city_api
', 'API\APIHandsBooksController@getCity')->name('get_city_api');
Route::get('get_country_api
', 'API\APIHandsBooksController@getCountry')->name('get_country_api');
Route::get('add_city_api
', 'API\APIHandsBooksController@addCity')->name('add_city_api');
Route::get('add_country_api
', 'API\APIHandsBooksController@addCountry')->name('add_country_api');
Route::get('add_bctype_api
', 'API\APIHandsBooksController@addBCtype')->name('add_bctype_api');
Route::get('add_airoport_api
', 'API\APIHandsBooksController@addAiroport')->name('add_airoport_api');
Route::post('add_airoport_api
', 'API\APIHandsBooksController@postEditAiroport')->name('add_airoport_api');
Route::post('add_airoport_api
', 'API\APIHandsBooksController@postEditAiroport')->name('add_airoport_api');
Route::get('edit_airoport_api
', 'API\APIHandsBooksController@postAddAiroport')->name('edit_airoport_api');
Route::get('add_type_fee_api
', 'API\APIHandsBooksController@addTypeFee')->name('add_type_fee_api');
 
Route::get('search_type_fee_api
', 'API\APIHandsBooksController@searchTypeFee')->name('search_type_fee_api');

Route::get('add_passenger_api
', 'API\APIPassengersController@add')->name('add_passenger_api');
Route::get('search_passenger_api
', 'API\APIPassengersController@search')->name('search_passenger_api');

Route::prefix('users')->group(function(){
	Route::get('/', 'UserController@index');
	Route::get('/show/{id}', 'UserController@show');
	Route::post('/create', 'UserController@storeNewUser');
	Route::post('/edit', 'UserController@updateUser');
	Route::post('/search', 'UserController@searchUser');
	Route::get('/byparent', 'UserController@listbyparent');
	
});


//PassengerController search
Route::get('passengers/search', 'PassengersController@search');



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
});
