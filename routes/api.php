<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Auth route
Route::get('User',[App\Http\Controllers\AuthController::class,'index'])->name('Auth.index');
Route::get('UserByEmail/{email}',[App\Http\Controllers\AuthController::class,'getbyEmail'])->name('Auth.getbyEmail');
Route::get('UserById/{id}',[App\Http\Controllers\AuthController::class,'getbyId'])->name('Auth.getbyId');
Route::post('register',[App\Http\Controllers\AuthController::class,'register'])->name('Auth.register');
Route::post('registerstaff',[App\Http\Controllers\AuthController::class,'registerstaff'])->name('Auth.registerstaff');
Route::post('login',[App\Http\Controllers\AuthController::class,'login'])->name('Auth.login');
Route::post('verify',[App\Http\Controllers\AuthController::class,'verify'])->name('Auth.verify');

// Seller route
Route::get('Seller',[App\Http\Controllers\SellerController::class,'index'])->name('Seller.index');
Route::get('SellerSlug/{slug}',[App\Http\Controllers\SellerController::class,'show'])->name('Seller.show');
Route::get('SellerID/{id}',[App\Http\Controllers\SellerController::class,'showById'])->name('Seller.showById');
Route::post('Seller',[App\Http\Controllers\SellerController::class,'store'])->name('Seller.store');
Route::put('Seller/{id}',[App\Http\Controllers\SellerController::class,'update'])->name('Seller.update');
Route::delete('Seller/{id}',[App\Http\Controllers\SellerController::class,'destroy'])->name('Seller.destroy');

// BlogCategory route
Route::get('BlogCategory',[App\Http\Controllers\BlogCategoryController::class,'index'])->name('BlogCategory.index');
Route::get('BlogCategory/{id}',[App\Http\Controllers\BlogCategoryController::class,'show'])->name('BlogCategory.show');
Route::post('BlogCategory',[App\Http\Controllers\BlogCategoryController::class,'store'])->name('BlogCategory.store');
Route::put('BlogCategory/{id}',[App\Http\Controllers\BlogCategoryController::class,'update'])->name('BlogCategory.update');
Route::delete('BlogCategory/{id}',[App\Http\Controllers\BlogCategoryController::class,'destroy'])->name('BlogCategory.destroy');

// Blog route
Route::get('Blog',[App\Http\Controllers\BlogController::class,'index'])->name('Blog.index');
Route::get('NewBlog',[App\Http\Controllers\BlogController::class,'newBlog'])->name('Product.newBlog');
Route::post('filterBlog', [App\Http\Controllers\BlogController::class, 'getBlogsByCategories'])->name('Product.getBlogsByCategories');
Route::get('BlogSlug/{slug}',[App\Http\Controllers\BlogController::class,'show'])->name('Blog.show');
Route::get('BlogID/{id}',[App\Http\Controllers\BlogController::class,'showById'])->name('Blog.showById');
Route::post('Blog',[App\Http\Controllers\BlogController::class,'store'])->name('Blog.store');
Route::put('Blog/{id}',[App\Http\Controllers\BlogController::class,'update'])->name('Blog.update');
Route::delete('Blog/{id}',[App\Http\Controllers\BlogController::class,'destroy'])->name('Blog.destroy');
Route::post('/upload', [App\Http\Controllers\BlogController::class,'upload'])->name('Blog.upload');

// Brand route
Route::get('Brand',[App\Http\Controllers\BrandController::class,'index'])->name('Brand.index');
Route::get('BrandSlug/{slug}',[App\Http\Controllers\BrandController::class,'show'])->name('Brand.show');
Route::get('BrandID/{id}',[App\Http\Controllers\BrandController::class,'showById'])->name('Brand.showById');
Route::post('Brand',[App\Http\Controllers\BrandController::class,'store'])->name('Brand.store');
Route::put('Brand/{id}',[App\Http\Controllers\BrandController::class,'update'])->name('Brand.update');
Route::delete('Brand/{id}',[App\Http\Controllers\BrandController::class,'destroy'])->name('Brand.destroy');

// Slider route
Route::get('Slider',[App\Http\Controllers\SliderController::class,'index'])->name('Slider.index');
Route::get('SliderID/{id}',[App\Http\Controllers\SliderController::class,'show'])->name('Slider.show');
Route::post('Slider',[App\Http\Controllers\SliderController::class,'store'])->name('Slider.store');
Route::put('Slider/{id}',[App\Http\Controllers\SliderController::class,'update'])->name('Slider.update');
Route::delete('Slider/{id}',[App\Http\Controllers\SliderController::class,'destroy'])->name('Slider.destroy');

// HomeSlider route
Route::get('HomeSlider',[App\Http\Controllers\HomeSliderController::class,'index'])->name('HomeSlider.index');
Route::get('HomeSliderID/{id}',[App\Http\Controllers\HomeSliderController::class,'show'])->name('HomeSlider.show');
Route::post('HomeSlider',[App\Http\Controllers\HomeSliderController::class,'store'])->name('HomeSlider.store');
Route::put('HomeSlider/{id}',[App\Http\Controllers\HomeSliderController::class,'update'])->name('HomeSlider.update');
Route::delete('HomeSlider/{id}',[App\Http\Controllers\HomeSliderController::class,'destroy'])->name('HomeSlider.destroy');

// Color route
Route::get('Color',[App\Http\Controllers\ColorController::class,'index'])->name('Color.index');
Route::get('Color/{id}',[App\Http\Controllers\ColorController::class,'show'])->name('Color.show');
Route::post('Color',[App\Http\Controllers\ColorController::class,'store'])->name('Color.store');
Route::put('Color/{id}',[App\Http\Controllers\ColorController::class,'update'])->name('Color.update');
Route::delete('Color/{id}',[App\Http\Controllers\ColorController::class,'destroy'])->name('Color.destroy');

// Attribute route
Route::get('Attribute',[App\Http\Controllers\AttributeController::class,'index'])->name('Attribute.index');
Route::get('Attribute/{id}',[App\Http\Controllers\AttributeController::class,'show'])->name('Attribute.show');
Route::post('Attribute',[App\Http\Controllers\AttributeController::class,'store'])->name('Attribute.store');
Route::put('Attribute/{id}',[App\Http\Controllers\AttributeController::class,'update'])->name('Attribute.update');
Route::delete('Attribute/{id}',[App\Http\Controllers\AttributeController::class,'destroy'])->name('Attribute.destroy');

// AttributeValue route
Route::get('AttributeValue',[App\Http\Controllers\AttributeValueController::class,'index'])->name('AttributeValue.index');
Route::get('AttributeValue/{id}',[App\Http\Controllers\AttributeValueController::class,'show'])->name('AttributeValue.show');
Route::post('AttributeValue',[App\Http\Controllers\AttributeValueController::class,'store'])->name('AttributeValue.store');
Route::put('AttributeValue/{id}',[App\Http\Controllers\AttributeValueController::class,'update'])->name('AttributeValue.update');
Route::delete('AttributeValue/{id}',[App\Http\Controllers\AttributeValueController::class,'destroy'])->name('AttributeValue.destroy');

// ProductCategory route
Route::get('ProductCategory',[App\Http\Controllers\ProductCategoryController::class,'index'])->name('ProductCategory.index');
Route::get('ProductCategoryID/{id}',[App\Http\Controllers\ProductCategoryController::class,'showByID'])->name('ProductCategory.showByID');
Route::get('ProductCategorySlug/{id}',[App\Http\Controllers\ProductCategoryController::class,'showBySlug'])->name('ProductCategory.showBySlug');
Route::post('ProductCategory',[App\Http\Controllers\ProductCategoryController::class,'store'])->name('ProductCategory.store');
Route::put('ProductCategory/{id}',[App\Http\Controllers\ProductCategoryController::class,'update'])->name('ProductCategory.update');
Route::delete('ProductCategory/{id}',[App\Http\Controllers\ProductCategoryController::class,'destroy'])->name('ProductCategory.destroy');

// Product route
Route::get('Product',[App\Http\Controllers\ProductController::class,'index'])->name('Product.index');
Route::get('ProductColor',[App\Http\Controllers\ProductController::class,'productColor'])->name('Product.productColor');
Route::get('Product/category/{categoryId}',[App\Http\Controllers\ProductController::class,'getProductsByCategory'])->name('Product.getProductsByCategory');
Route::get('Product/brand/{brandId}',[App\Http\Controllers\ProductController::class,'getProductsBybrand'])->name('Product.getProductsBybrand');
Route::get('NewProduct',[App\Http\Controllers\ProductController::class,'newProduct'])->name('Product.newProduct');
Route::post('/products/filter/{categoryId}',[App\Http\Controllers\ProductController::class,'filter'])->name('Product.filter');
Route::post('/searchproducts/filter',[App\Http\Controllers\ProductController::class,'searchfilter'])->name('Product.searchfilter');
Route::post('/products/filterbrand/{brandId}',[App\Http\Controllers\ProductController::class,'filterofBrand'])->name('Product.filterofBrand');
Route::get('/searchProduct', [App\Http\Controllers\ProductController::class, 'search'])->name('product.search');
Route::get('ProductSlug/{slug}',[App\Http\Controllers\ProductController::class,'show'])->name('Product.show');
Route::get('ProductID/{id}',[App\Http\Controllers\ProductController::class,'showByID'])->name('Product.showByID');
Route::get('Productcolor/{id}',[App\Http\Controllers\ProductController::class,'showProductcolor'])->name('Product.showProductcolor');
Route::get('Productattribute/{id}',[App\Http\Controllers\ProductController::class,'showProductattribute'])->name('Product.showProductattribute');
Route::get('Productdiscount/{id}',[App\Http\Controllers\ProductController::class,'showProductdiscount'])->name('Product.showProductdiscount');
Route::post('Product',[App\Http\Controllers\ProductController::class,'store'])->name('Product.store');
Route::put('Product/{id}',[App\Http\Controllers\ProductController::class,'update'])->name('Product.update');
Route::put('Productcolor/{id}',[App\Http\Controllers\ProductController::class,'updatecolor'])->name('Product.updatecolor');
Route::put('Productattribute/{id}',[App\Http\Controllers\ProductController::class,'updateattribute'])->name('Product.updateattribute');
Route::put('Productdiscount/{id}',[App\Http\Controllers\ProductController::class,'updatediscount'])->name('Product.updatediscount');
Route::delete('Product/{id}',[App\Http\Controllers\ProductController::class,'destroy'])->name('Product.destroy');
Route::post('products/decrease-quantity', [App\Http\Controllers\ProductController::class, 'decreaseProductQuantity'])->name('Product.decreaseProductQuantity');
Route::post('/uploadMultipleImage', [App\Http\Controllers\ProductController::class,'upload'])->name('Product.upload');

// Cart route
Route::get('Cart',[App\Http\Controllers\CartController::class,'index'])->name('Cart.index');
Route::get('Cart/{id}',[App\Http\Controllers\CartController::class,'show'])->name('Cart.show');
Route::get('CartByUserId/{id}',[App\Http\Controllers\CartController::class,'showuserId'])->name('Cart.showuserId');
Route::post('Cart',[App\Http\Controllers\CartController::class,'store'])->name('Cart.store');
Route::put('Cart/{id}',[App\Http\Controllers\CartController::class,'update'])->name('Cart.update');
Route::delete('Cart/{id}',[App\Http\Controllers\CartController::class,'destroy'])->name('Cart.destroy');

// Feedback route
Route::get('Feedback',[App\Http\Controllers\FeedbackController::class,'index'])->name('Feedback.index');
Route::get('Feedback/{id}',[App\Http\Controllers\FeedbackController::class,'show'])->name('Feedback.show');
Route::get('FeedbackByProduct/{id}',[App\Http\Controllers\FeedbackController::class,'showproductId'])->name('Feedback.showproductId');
Route::post('Feedback',[App\Http\Controllers\FeedbackController::class,'store'])->name('Feedback.store');
Route::put('Feedback/{id}',[App\Http\Controllers\FeedbackController::class,'update'])->name('Feedback.update');
Route::delete('Feedback/{id}',[App\Http\Controllers\FeedbackController::class,'destroy'])->name('Feedback.destroy');

// Order route
Route::get('Order',[App\Http\Controllers\OrderController::class,'index'])->name('Order.index');
Route::get('orderDate-analysis',[App\Http\Controllers\OrderController::class,'getOrderDateAnalysis'])->name('Order.getOrderDateAnalysis');
Route::get('order-analysis',[App\Http\Controllers\OrderController::class,'getOrderAnalysis'])->name('Order.getOrderAnalysis');
Route::get('product-analysis',[App\Http\Controllers\OrderController::class,'getProductCounts'])->name('Order.getProductCounts');
Route::get('user-analysis',[App\Http\Controllers\OrderController::class,'getUserCounts'])->name('Order.getUserCounts');
Route::get('seller-analysis',[App\Http\Controllers\OrderController::class,'getSellerCounts'])->name('Order.getSellerCounts');
Route::get('Order/{id}',[App\Http\Controllers\OrderController::class,'show'])->name('Order.show');
Route::get('OrderById/{id}',[App\Http\Controllers\OrderController::class,'showorderId'])->name('Order.showorderId');
Route::post('Order',[App\Http\Controllers\OrderController::class,'store'])->name('Order.store');
Route::put('Order/{id}',[App\Http\Controllers\OrderController::class,'update'])->name('Order.update');
Route::get('OrderByUserId/{id}',[App\Http\Controllers\OrderController::class,'showuserId'])->name('Cart.showuserId');
Route::put('Order/cancel/{id}',[App\Http\Controllers\OrderController::class,'cancel'])->name('Order.cancel');
Route::put('Order/accept/{id}',[App\Http\Controllers\OrderController::class,'accept'])->name('Order.accept');
Route::put('Order/paid/{id}',[App\Http\Controllers\OrderController::class,'paid'])->name('Order.paid');
Route::put('Order/comment/{id}',[App\Http\Controllers\OrderController::class,'comment'])->name('Order.comment');
Route::put('Order/user_required/{id}',[App\Http\Controllers\OrderController::class,'user_required'])->name('Order.user_required');
Route::delete('Order/{id}',[App\Http\Controllers\OrderController::class,'destroy'])->name('Order.destroy');
Route::put('Order/update-total-price/{id}', [App\Http\Controllers\OrderController::class, 'updateOrderTotalPrice'])->name('Order.updateOrderTotalPrice');
Route::get('orderseller-analysis/{seller_id}',[App\Http\Controllers\OrderController::class,'getOrderSellerAnalysis'])->name('Order.getOrderSellerAnalysis');
Route::get('productseller-analysis/{seller_id}',[App\Http\Controllers\OrderController::class,'getProductSellerCounts'])->name('Order.getProductSellerCounts');
Route::get('userseller-analysis/{seller_id}',[App\Http\Controllers\OrderController::class,'getUserSellerCounts'])->name('Order.getUserSellerCounts');
Route::get('orderDateSeller-analysis/{seller_id}',[App\Http\Controllers\OrderController::class,'getOrderSellerDateAnalysis'])->name('Order.getOrderSellerDateAnalysis');

// Inquiry route
Route::get('Inquiry',[App\Http\Controllers\InquiryController::class,'index'])->name('Inquiry.index');
Route::post('Inquiry',[App\Http\Controllers\InquiryController::class,'store'])->name('Inquiry.store');

// Refund route
Route::get('Refund',[App\Http\Controllers\RefundController::class,'index'])->name('Refund.index');
Route::get('Refund/{id}',[App\Http\Controllers\RefundController::class,'show'])->name('Refund.show');
Route::get('RefundByorderId/{id}',[App\Http\Controllers\RefundController::class,'showRefundorderId'])->name('Refund.showRefundorderId');
Route::post('Refund',[App\Http\Controllers\RefundController::class,'store'])->name('Refund.store');
Route::put('Refund/{id}',[App\Http\Controllers\RefundController::class,'update'])->name('Refund.update');
Route::get('RefundByUserId/{id}',[App\Http\Controllers\RefundController::class,'showuserId'])->name('Cart.showuserId');
Route::put('Refund/cancel/{id}',[App\Http\Controllers\RefundController::class,'cancel'])->name('Refund.cancel');
Route::put('Refund/accept/{id}',[App\Http\Controllers\RefundController::class,'accept'])->name('Refund.accept');
Route::delete('Refund/{id}',[App\Http\Controllers\RefundController::class,'destroy'])->name('Refund.destroy');

// Information route
Route::get('Information',[App\Http\Controllers\InformationController::class,'index'])->name('Information.index');
Route::post('Information',[App\Http\Controllers\InformationController::class,'store'])->name('Information.store');
Route::put('Information/{id}',[App\Http\Controllers\InformationController::class,'update'])->name('Information.update');
Route::get('InformationID/{id}',[App\Http\Controllers\InformationController::class,'showById'])->name('Information.showById');

// Social Link route
Route::get('SocialLink',[App\Http\Controllers\SocialLinksController::class,'index'])->name('SocialLink.index');
Route::post('SocialLink',[App\Http\Controllers\SocialLinksController::class,'store'])->name('SocialLink.store');
Route::put('SocialLink/{id}',[App\Http\Controllers\SocialLinksController::class,'update'])->name('SocialLink.update');
Route::get('SocialLinkID/{id}',[App\Http\Controllers\SocialLinksController::class,'showById'])->name('SocialLink.showById');

// Pages route
Route::get('ReturnPolicy',[App\Http\Controllers\PagesController::class,'ReturnPolicyindex'])->name('ReturnPolicy.index');
Route::get('ReturnPolicyID/{id}',[App\Http\Controllers\PagesController::class,'ReturnPolicyshow'])->name('ReturnPolicy.showById');
Route::put('ReturnPolicy/{id}',[App\Http\Controllers\PagesController::class,'ReturnPolicyupdate'])->name('ReturnPolicy.update');
Route::get('Shippingpolicy',[App\Http\Controllers\PagesController::class,'Shippingpolicyindex'])->name('Shippingpolicy.index');
Route::get('ShippingpolicyID/{id}',[App\Http\Controllers\PagesController::class,'Shippingpolicyshow'])->name('Shippingpolicy.showById');
Route::put('Shippingpolicy/{id}',[App\Http\Controllers\PagesController::class,'Shippingpolicyupdate'])->name('Shippingpolicy.update');
Route::get('PrivacyPolicy',[App\Http\Controllers\PagesController::class,'PrivacyPolicyindex'])->name('PrivacyPolicy.index');
Route::get('PrivacyPolicyID/{id}',[App\Http\Controllers\PagesController::class,'PrivacyPolicyshow'])->name('PrivacyPolicy.showById');
Route::put('PrivacyPolicy/{id}',[App\Http\Controllers\PagesController::class,'PrivacyPolicyupdate'])->name('PrivacyPolicy.update');
Route::get('TermsService',[App\Http\Controllers\PagesController::class,'TermsServiceindex'])->name('TermsService.index');
Route::get('TermsServiceID/{id}',[App\Http\Controllers\PagesController::class,'TermsServiceshow'])->name('TermsService.showById');
Route::put('TermsService/{id}',[App\Http\Controllers\PagesController::class,'TermsServiceupdate'])->name('TermsService.update');

// Chat route
Route::post('chat',[App\Http\Controllers\ChatController::class,'getOrCreateChat'])->name('chat.getOrCreateChat');
Route::get('chats',[App\Http\Controllers\ChatController::class,'getAllChats'])->name('chat.getAllChats');
Route::get('chat/{chat_id}/messages',[App\Http\Controllers\ChatController::class,'getMessages'])->name('chat.getMessages');
Route::post('message',[App\Http\Controllers\ChatController::class,'sendMessage'])->name('chat.sendMessage');
Route::get('/chat/user/{userId}',[App\Http\Controllers\ChatController::class, 'getUserChats']);

//private route
Route::group(['middleware'=>["auth:sanctum"]],function(){
    Route::post('logout',[App\Http\Controllers\AuthController::class,'logOut'])->name('Auth.logout');
});
