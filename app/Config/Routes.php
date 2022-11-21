<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('App');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'App::index');
$routes->get('/recover', 'App::recover');
$routes->get('/audits/get', 'AuditController::getAudits');

//SALES MODULE
$routes->group('sales', static function ($routes) {
    $routes->post('create', 'SaleController::createSale');
    $routes->get('get', 'SaleController::getSales');
    $routes->get('getById/(:num)', 'SaleController::getSaleById/$1');
    $routes->get('getProducts', 'SaleController::getProducts');
    $routes->get('getRate/(:num)', 'SaleController::getRate/$1');
    $routes->post('delete', 'SaleController::deleteSale');
});


//PURCHASES MODULE
$routes->group('purchases', static function ($routes) {
    $routes->post('create', 'PurchaseController::createPurchase');
    $routes->get('get', 'PurchaseController::getPurchases');
    $routes->get('getById/(:num)', 'PurchaseController::getPurchaseById/$1');
    $routes->get('getProviders', 'PurchaseController::getProviders');
    $routes->get('getProducts', 'PurchaseController::getProducts');
    $routes->post('delete', 'PurchaseController::deletePurchase');
});

//USERS MODULE
$routes->group('users', static function ($routes) {
    $routes->post('signin', 'UserController::signin');
    $routes->post('create', 'UserController::createUser');
    $routes->get('get', 'UserController::getUsers');
    $routes->get('getById/(:num)', 'UserController::getUserById/$1');
    $routes->post('update', 'UserController::updateUser');
    $routes->post('updateCurrentUser', 'UserController::updateCurrentUser');
    $routes->post('delete', 'UserController::deleteUser');
    $routes->post('recover', 'UserController::recoverUser');
});

//CATEGORIES MODULE
$routes->group('categories', static function ($routes) {
    $routes->post('create', 'CategoryController::createCategory');
    $routes->get('get', 'CategoryController::getCategories');
    $routes->get('getById/(:num)', 'CategoryController::getCategoryById/$1');
    $routes->post('update', 'CategoryController::updateCategory');
    $routes->post('delete', 'CategoryController::deleteCategory');
    $routes->post('recover', 'CategoryController::recoverCategory');
});

//BRANDS MODULE
$routes->group('brands', static function ($routes) {
    $routes->post('create', 'BrandController::createBrand');
    $routes->get('get', 'BrandController::getBrands');
    $routes->get('getById/(:num)', 'BrandController::getBrandById/$1');
    $routes->post('update', 'BrandController::updateBrand');
    $routes->post('delete', 'BrandController::deleteBrand');
    $routes->post('recover', 'BrandController::recoverBrand');
});

//COINS MODULE
$routes->group('coins', static function ($routes) {
    $routes->post('create', 'CoinController::createCoin');
    $routes->get('get', 'CoinController::getCoins');
    $routes->get('getById/(:num)', 'CoinController::getCoinById/$1');
    $routes->post('update', 'CoinController::updateCoin');
    $routes->post('delete', 'CoinController::deleteCoin');
    $routes->post('recover', 'CoinController::recoverCoin');
});

//TAXES MODULE
$routes->group('taxes', static function ($routes) {
    $routes->post('create', 'TaxController::createTax');
    $routes->get('get', 'TaxController::getTaxes');
    $routes->get('getById/(:num)', 'TaxController::getTaxById/$1');
    $routes->post('update', 'TaxController::updateTax');
    $routes->post('delete', 'TaxController::deleteTax');
    $routes->post('recover', 'TaxController::recoverTax');
});

//DOCUMENT TYPE MODULE
$routes->group('document_type', static function ($routes) {
    $routes->post('create', 'DocumentTypeController::createDocumentType');
    $routes->get('get', 'DocumentTypeController::getDocumentsType');
    $routes->get('getById/(:num)', 'DocumentTypeController::getDocumentTypeById/$1');
    $routes->post('update', 'DocumentTypeController::updateDocumentType');
    $routes->post('delete', 'DocumentTypeController::deleteDocumentType');
    $routes->post('recover', 'DocumentTypeController::recoverDocumentType');
});

//PAYMENT METHOD MODULE
$routes->group('payment_method', static function ($routes) {
    $routes->post('create', 'PaymentMethodController::createPaymentMethod');
    $routes->get('get', 'PaymentMethodController::getPaymentMethods');
    $routes->get('getById/(:num)', 'PaymentMethodController::getPaymentMethodById/$1');
    $routes->post('update', 'PaymentMethodController::updatePaymentMethod');
    $routes->post('delete', 'PaymentMethodController::deletePaymentMethod');
    $routes->post('recover', 'PaymentMethodController::recoverPaymentMethod');
});

//PRODUCTS MODULE
$routes->group('products', static function ($routes) {
    $routes->post('create', 'ProductController::createProduct');
    $routes->get('get', 'ProductController::getProducts');
    $routes->get('getById/(:any)', 'ProductController::getProductById/$1');
    $routes->post('update', 'ProductController::updateProduct');
    $routes->post('delete', 'ProductController::deleteProduct');
    $routes->post('recover', 'ProductController::recoverProduct');
});

//PROVIDERS MODULE
$routes->group('providers', static function ($routes) {
    $routes->post('create', 'ProviderController::createProvider');
    $routes->get('get', 'ProviderController::getProviders');
    $routes->get('getById/(:any)', 'ProviderController::getProviderById/$1');
    $routes->post('update', 'ProviderController::updateProvider');
    $routes->post('delete', 'ProviderController::deleteProvider');
    $routes->post('recover', 'ProviderController::recoverProvider');
});

//CUSTOMERS MODULE
$routes->group('customers', static function ($routes) {
    $routes->post('create', 'CustomerController::createCustomer');
    $routes->get('get', 'CustomerController::getCustomers');
    $routes->get('getById/(:any)', 'CustomerController::getCustomerById/$1');
    $routes->post('update', 'CustomerController::updateCustomer');
    $routes->post('delete', 'CustomerController::deleteCustomer');
    $routes->post('recover', 'CustomerController::recoverCustomer');
});

//COIN PRICES MODULE
$routes->group('coinPrices', static function ($routes) {
    $routes->post('createCoinPrice', 'ControlCenterController::createCoinPrice');
    $routes->get('getCoinPrices', 'ControlCenterController::getCoinPrices');
    $routes->get('getById/(:num)', 'ControlCenterController::getCoinPriceById/$1');
    $routes->post('update', 'ControlCenterController::updateCoinPrice');
    $routes->post('delete', 'ControlCenterController::deleteCoinPrice');
    $routes->post('recover', 'ControlCenterController::recoverCoinPrice');
});

// INVENTORY MODULE
$routes->get('inventory', 'ReportController::getInventory');

//INVOICES
$routes->group('invoice', static function ($routes) {
    $routes->get('sale/(:num).pdf', 'InvoiceController::saleInvoice/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
