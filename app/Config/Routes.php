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
$routes->get('/audits/get', 'AuditController::getAudits');
$routes->post('/settings/update', 'AuditController::settingsUpdate');

// ? SALES MODULE
$routes->group('sales', static function ($routes) {
    $routes->post('create', 'SaleController::createSale');
    $routes->get('get', 'SaleController::getSales');
    $routes->get('getById/(:any)', 'SaleController::getSaleById/$1');
    $routes->get('getProducts', 'SaleController::getProducts');
    $routes->get('getRate/(:any)', 'SaleController::getRate/$1');
    $routes->post('delete', 'SaleController::deleteSale');
});

// ? ORDERS MODULE
$routes->group('orders', static function ($routes) {
    $routes->post('create', 'OrderController::createOrder');
    $routes->get('verifyProviderOrder/(:any)', 'OrderController::verifyProviderOrder/$1');
    $routes->get('get', 'OrderController::getOrders');
    $routes->get('getById/(:any)', 'OrderController::getOrderById/$1');
    $routes->get('getProviders', 'OrderController::getProviders');
    $routes->get('getProducts', 'OrderController::getProducts');
    $routes->post('acceptOrder', 'OrderController::acceptOrder');
    $routes->post('update', 'OrderController::updateOrder');
    $routes->post('delete', 'OrderController::deleteOrder');
    $routes->post('deleteProductOrder', 'OrderController::deleteProductOrder');
});

// ? PURCHASES MODULE
$routes->group('purchases', static function ($routes) {
    $routes->get('get', 'PurchaseController::getPurchases');
});

// ? USERS MODULE
$routes->group('users', static function ($routes) {
    $routes->post('signin', 'UserController::signin');
    $routes->post('create', 'UserController::createUser');
    $routes->get('get', 'UserController::getUsers');
    $routes->get('getById/(:any)', 'UserController::getUserById/$1');
    $routes->post('update', 'UserController::updateUser');
    $routes->post('updateCurrentUser', 'UserController::updateCurrentUser');
    $routes->post('delete', 'UserController::deleteUser');
    $routes->post('recover', 'UserController::recoverUser');
});

// ? CATEGORIES MODULE
$routes->group('categories', static function ($routes) {
    $routes->post('create', 'CategoryController::createCategory');
    $routes->get('get', 'CategoryController::getCategories');
    $routes->get('getById/(:any)', 'CategoryController::getCategoryById/$1');
    $routes->post('update', 'CategoryController::updateCategory');
    $routes->post('delete', 'CategoryController::deleteCategory');
    $routes->post('recover', 'CategoryController::recoverCategory');
});

// ? BRANDS MODULE
$routes->group('brands', static function ($routes) {
    $routes->post('create', 'BrandController::createBrand');
    $routes->get('get', 'BrandController::getBrands');
    $routes->get('getById/(:any)', 'BrandController::getBrandById/$1');
    $routes->post('update', 'BrandController::updateBrand');
    $routes->post('delete', 'BrandController::deleteBrand');
    $routes->post('recover', 'BrandController::recoverBrand');
});

// ? HIGH RUBBER MODULE
$routes->group('highRubber', static function ($routes) {
    $routes->post('create', 'HighRubberController::createHighRubber');
    $routes->get('get', 'HighRubberController::getHighRubbers');
    $routes->get('getById/(:any)', 'HighRubberController::getHighRubberById/$1');
    $routes->post('update', 'HighRubberController::updateHighRubber');
    $routes->post('delete', 'HighRubberController::deleteHighRubber');
    $routes->post('recover', 'HighRubberController::recoverHighRubber');
});


// ? WIDE RUBBER MODULE
$routes->group('wideRubber', static function ($routes) {
    $routes->post('create', 'WideRubberController::createWideRubber');
    $routes->get('get', 'WideRubberController::getWideRubbers');
    $routes->get('getById/(:any)', 'WideRubberController::getWideRubberById/$1');
    $routes->post('update', 'WideRubberController::updateWideRubber');
    $routes->post('delete', 'WideRubberController::deleteWideRubber');
    $routes->post('recover', 'WideRubberController::recoverWideRubber');
});


// ? COINS MODULE
$routes->group('coins', static function ($routes) {
    $routes->post('create', 'CoinController::createCoin');
    $routes->get('get', 'CoinController::getCoins');
    $routes->get('getById/(:any)', 'CoinController::getCoinById/$1');
    $routes->post('update', 'CoinController::updateCoin');
    $routes->post('delete', 'CoinController::deleteCoin');
    $routes->post('recover', 'CoinController::recoverCoin');
});

// ? TAXES MODULE
$routes->group('taxes', static function ($routes) {
    $routes->post('create', 'TaxController::createTax');
    $routes->get('get', 'TaxController::getTaxes');
    $routes->get('getById/(:any)', 'TaxController::getTaxById/$1');
    $routes->post('update', 'TaxController::updateTax');
    $routes->post('delete', 'TaxController::deleteTax');
    $routes->post('recover', 'TaxController::recoverTax');
});

// ? DOCUMENT TYPE MODULE
$routes->group('document_type', static function ($routes) {
    $routes->post('create', 'DocumentTypeController::createDocumentType');
    $routes->get('get', 'DocumentTypeController::getDocumentsType');
    $routes->get('getById/(:any)', 'DocumentTypeController::getDocumentTypeById/$1');
    $routes->post('update', 'DocumentTypeController::updateDocumentType');
    $routes->post('delete', 'DocumentTypeController::deleteDocumentType');
    $routes->post('recover', 'DocumentTypeController::recoverDocumentType');
});

// ? PAYMENT METHOD MODULE
$routes->group('payment_method', static function ($routes) {
    $routes->post('create', 'PaymentMethodController::createPaymentMethod');
    $routes->get('get', 'PaymentMethodController::getPaymentMethods');
    $routes->get('getById/(:any)', 'PaymentMethodController::getPaymentMethodById/$1');
    $routes->post('update', 'PaymentMethodController::updatePaymentMethod');
    $routes->post('delete', 'PaymentMethodController::deletePaymentMethod');
    $routes->post('recover', 'PaymentMethodController::recoverPaymentMethod');
});

// ? PRODUCTS MODULE
$routes->group('products', static function ($routes) {
    $routes->post('create', 'ProductController::createProduct');
    $routes->get('get', 'ProductController::getProducts');
    $routes->get('getProductsToAssign', 'ProductController::getProductsToAssign');
    $routes->get('getProvidersToAssign', 'ProductController::getProvidersToAssign');
    $routes->get('getProviderAssignInfo/(:any)', 'ProductController::getProviderAssignInfo/$1');
    $routes->post('setProviderAssignInfo', 'ProductController::setProviderAssignInfo');
    $routes->post('deleteProviderAssignInfo', 'ProductController::deleteProviderAssignInfo');
    $routes->get('getById/(:any)', 'ProductController::getProductById/$1');
    $routes->post('update', 'ProductController::updateProduct');
    $routes->post('delete', 'ProductController::deleteProduct');
    $routes->post('recover', 'ProductController::recoverProduct');
});

// ? PROVIDERS MODULE
$routes->group('providers', static function ($routes) {
    $routes->post('create', 'ProviderController::createProvider');
    $routes->get('get', 'ProviderController::getProviders');
    $routes->get('getById/(:any)', 'ProviderController::getProviderById/$1');
    $routes->post('update', 'ProviderController::updateProvider');
    $routes->post('delete', 'ProviderController::deleteProvider');
    $routes->post('recover', 'ProviderController::recoverProvider');
});

// ? CUSTOMERS MODULE
$routes->group('customers', static function ($routes) {
    $routes->post('create', 'CustomerController::createCustomer');
    $routes->get('get', 'CustomerController::getCustomers');
    $routes->get('getById/(:any)', 'CustomerController::getCustomerById/$1');
    $routes->post('update', 'CustomerController::updateCustomer');
    $routes->post('delete', 'CustomerController::deleteCustomer');
    $routes->post('recover', 'CustomerController::recoverCustomer');
});

// ? COIN PRICES MODULE
$routes->group('coinPrices', static function ($routes) {
    $routes->post('createCoinPrice', 'ControlCenterController::createCoinPrice');
    $routes->get('getCoinPrices', 'ControlCenterController::getCoinPrices');
    $routes->get('getById/(:any)', 'ControlCenterController::getCoinPriceById/$1');
    $routes->post('update', 'ControlCenterController::updateCoinPrice');
    $routes->post('delete', 'ControlCenterController::deleteCoinPrice');
    $routes->post('recover', 'ControlCenterController::recoverCoinPrice');
});

// ? REPORTS MODULE
$routes->get('inventory', 'ReportController::getInventory');

$routes->post('general_purchase_reports', 'ReportController::getGeneralPurchaseReports');
$routes->get('purchases_per_provider', 'ReportController::getPurchasesPerProvider');
$routes->get('best_providers', 'ReportController::getBestProviders');

$routes->post('general_sale_reports', 'ReportController::getGeneralSaleReports');
$routes->get('sales_per_customer', 'ReportController::getSalesPerCustomer');
$routes->get('sales_per_product', 'ReportController::getSalesPerProduct');
$routes->get('sales_per_payment_method', 'ReportController::getSalesPerPaymentMethod');
$routes->get('most_selled_products', 'ReportController::getMostSelledProducts');
$routes->get('less_sold_products', 'ReportController::getLessSoldProducts');
$routes->get('best_customers', 'ReportController::getBestCustomers');

// ? SELECCIÓN
$routes->get('purchases_provider', 'ReportController::getPurchasesProvider');
$routes->get('sales_customer', 'ReportController::getSalesCustomer');
$routes->get('sales_products', 'ReportController::getSalesProducts');

// ? Excel
$routes->get('reports/purchase', 'ReportController::getPurchaseReportExcel');
$routes->get('reports/purchase/(:any)', 'ReportController::getPurchaseReportExcel/$1');
$routes->get('reports/purchases_per_provider/(:any)', 'ReportController::getPurchasePerProviderReportExcel/$1/$2');
$routes->get('reports/best_providers/(:any)', 'ReportController::getBestProvidersReportExcel/$1');
$routes->get('reports/best_providers', 'ReportController::getBestProvidersReportExcel');

$routes->get('reports/order', 'ReportController::getOrderReportExcel');
$routes->get('reports/order/(:any)', 'ReportController::getOrderReportExcel/$1');

$routes->get('reports/sale', 'ReportController::getSaleReportExcel');
$routes->get('reports/sale/(:any)', 'ReportController::getSaleReportExcel/$1');
$routes->get('reports/sales_per_customer/(:any)', 'ReportController::getSalePerCustomerReportExcel/$1/$2');
$routes->get('reports/sales_per_product/(:any)', 'ReportController::getSalePerProductReportExcel/$1/$2');
$routes->get('reports/sales_per_payment_method/(:any)', 'ReportController::getSalePerPaymentMethodReportExcel/$1/$2/$3');
// $routes->get('reports/sales_per_payment_method/(:any)', 'ReportController::getSalePerPaymentMethodReportExcel/$1/$2/$3');
$routes->get('reports/most_selled_products/(:any)', 'ReportController::getMostSelledProductsReportExcel/$1');
$routes->get('reports/most_selled_products', 'ReportController::getMostSelledProductsReportExcel');
$routes->get('reports/less_sold_products/(:any)', 'ReportController::getLessSoldProductsReportExcel/$1');
$routes->get('reports/less_sold_products', 'ReportController::getLessSoldProductsReportExcel');
$routes->get('reports/best_customers/(:any)', 'ReportController::getBestCustomersReportExcel/$1');
$routes->get('reports/best_customers', 'ReportController::getBestCustomersReportExcel');

// ? INVOICES
$routes->group('invoice', static function ($routes) {
    $routes->get('sale/(:any).pdf', 'InvoiceController::saleInvoice/$1');
    $routes->get('order/(:any).pdf', 'InvoiceController::orderInvoice/$1');
    $routes->get('purchase/(:any).pdf', 'InvoiceController::purchaseInvoice/$1');
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
