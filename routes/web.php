<?php

Route::get('/' , function()
{
	return redirect('/login');
});

Route::group(['middleware' => 'auth'] , function()
{
    Route::get('/home', 'HomeController@index');

    Route::group(['prefix' => 'home'] , function()
	{
		Route::get('get_data_chart' , 'HomeController@getDataChart');
	});

	Route::group(['prefix' => 'products'] , function()
	{
		Route::post('table_products_list' , 'ProductController@tableProductsList');
		Route::post('change_status/{id}' , 'ProductController@changeStatus');
		Route::post('change_image/{id}' , 'ProductController@changeImage');
		Route::get('pdf_all_products' , 'ProductController@pdfAllProducts');
		Route::get('excel_all_products' , 'ProductController@excelAllProducts');
	});

	Route::group(['prefix' => 'locations'] , function()
	{
		Route::post('table_locations_list' , 'LocationController@tableLocationsList');
		Route::post('change_status/{id}' , 'LocationController@changeStatus');
		Route::get('pdf_all_locations' , 'LocationController@pdfAllLocations');
		Route::get('excel_all_locations' , 'LocationController@excelAllLocations');
	});

	Route::group(['prefix' => 'locations_product'] , function()
	{
		Route::post('table_product_locations_list' , 'LocationProductController@tableProductLocationsList');
		Route::post('table_location_products_list' , 'LocationProductController@tableLocationProductsList');
	});

	Route::group(['prefix' => 'users'] , function()
	{
		Route::post('table_users_list' , 'UserController@tableUsersList');
		Route::post('change_status/{id}' , 'UserController@changeStatus');
		Route::post('change_image/{id}' , 'UserController@changeImage');
		Route::get('pdf_all_users' , 'UserController@pdfAllUsers');
		Route::get('excel_all_users' , 'UserController@excelAllUsers');
	});

	Route::group(['prefix' => 'customers'] , function()
	{
		Route::post('table_customers_list' , 'CustomerController@tableCustomersList');
		Route::post('change_status/{id}' , 'CustomerController@changeStatus');
		Route::get('pdf_all_customers' , 'CustomerController@pdfAllCustomers');
		Route::get('excel_all_customers' , 'CustomerController@excelAllCustomers');
	});

	Route::group(['prefix' => 'orders'] , function()
	{
		Route::get('all' , 'OrderController@listAll');
		Route::post('table_orders_list' , 'OrderController@tableOrdersList');
		Route::post('table_orders_list_all' , 'OrderController@tableOrdersListAll');
		Route::post('change_status/{id}' , 'OrderController@changeStatus');
		Route::get('new_order' , 'OrderController@newOrder');
		Route::post('table_products_list' , 'OrderController@tableProductsList');
		Route::post('order_preview' , 'OrderController@orderPreview');
		Route::post('create_order' , 'OrderController@createOrder');
		Route::get('order_create_success' , 'OrderController@orderCreateSuccess');
		Route::post('change_phase_order' , 'OrderController@changePhaseOrder');
		Route::get('pdf_all_orders/{id}' , 'OrderController@pdfAllOrders');
		Route::get('print_order_preview/{data}' , 'OrderController@printOrderPreview');
		Route::get('print_order/{id}' , 'OrderController@printOrder');
		Route::get('excel_all_orders/{id}' , 'OrderController@excelAllOrders');

		Route::post('get_cities' , 'OrderController@getCities');
	});

	Route::group(['prefix' => 'warehouses'] , function()
	{
		Route::post('table_warehouses_list' , 'WarehouseController@tableWarehousesList');
		Route::post('change_status/{id}' , 'WarehouseController@changeStatus');
		Route::get('pdf_all_warehouses' , 'WarehouseController@pdfAllWarehouses');
		Route::get('excel_all_warehouses' , 'WarehouseController@excelAllWarehouses');
	});

	Route::group(['prefix' => 'categories'] , function()
	{
		Route::post('table_categories_list' , 'CategoryController@tableCategoriesList');
		Route::get('pdf_all_categories' , 'CategoryController@pdfAllCategories');
		Route::get('excel_all_categories' , 'CategoryController@excelAllCategories');
	});

	Route::group(['prefix' => 'areas'] , function()
	{
		Route::post('table_areas_list' , 'AreaController@tableAreasList');
		Route::get('pdf_all_areas' , 'AreaController@pdfAllAreas');
		Route::get('excel_all_areas' , 'AreaController@excelAllAreas');
	});

	Route::get('storage/{file}', function ( $file )
	{
		$public_path = public_path();
		$url 		 = $public_path.'/process_files/'.$file;

		return response()->download($url);
	});

	Route::get('form_quotation' , 'QuotationController@form');
	Route::post('save_quotation' , 'QuotationController@saveQuotation');
	Route::get('print_pdf_quotation/{id}' , 'QuotationController@printPdfQuotation');

	Route::resource('users' , 'UserController');
	Route::resource('products' , 'ProductController');
	Route::resource('locations' , 'LocationController');
	Route::resource('settings' , 'SettingController');
	Route::resource('orders' , 'OrderController');
	Route::resource('customers' , 'CustomerController');
	Route::resource('quotations' , 'QuotationController');
	Route::resource('warehouses' , 'WarehouseController');
	Route::resource('integrations' , 'IntegrationController');
	Route::resource('categories' , 'CategoryController');
	Route::resource('areas' , 'AreaController');
});

Auth::routes();