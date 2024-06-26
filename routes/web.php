<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Home\Auth\AuthController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Order\CityController;
use App\Http\Controllers\Admin\Product\BrandController;
use App\Http\Controllers\Admin\Product\ColorController;
use App\Http\Controllers\Admin\Order\DeliveryController;
use App\Http\Controllers\Admin\Order\ProvinceController;
use App\Http\Controllers\Home\Account\AccountController;
use App\Http\Controllers\Admin\Product\CommentController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Product\CategoryController;
use App\Http\Controllers\Home\SalesProcess\CartController;
use App\Http\Controllers\Admin\Appearance\BannerController;
use App\Http\Controllers\Admin\Appearance\SliderController;
use App\Http\Controllers\Admin\BecomeSeller\SellerRequestsController;
use App\Http\Controllers\Admin\Contact\ContactController as AdminContactController;
use App\Http\Controllers\Admin\Discount\DiscountCouponController;
use App\Http\Controllers\Admin\Discount\GeneralDiscountController;
use App\Http\Controllers\Admin\faq\FaqController;
use App\Http\Controllers\Admin\JobOpportunities\JobOpportunitiesController as AdminJobOpportunitiesController;
use App\Http\Controllers\Admin\JobOpportunities\JobRequestsController;
use App\Http\Controllers\Admin\Notifications\EmailController;
use App\Http\Controllers\Admin\Product\GuaranteeController;
use App\Http\Controllers\Home\SalesProcess\OrderController;
use App\Http\Controllers\Admin\Product\ImageProductController;
use App\Http\Controllers\Admin\Product\ProductColorController;
use App\Http\Controllers\Admin\Product\OptionProductController;
use App\Http\Controllers\Admin\Product\ProductGuaranteeController;
use App\Http\Controllers\Home\ProductController as HomeProductController;
use App\Http\Controllers\Admin\Order\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\Order\PaymentController;
use App\Http\Controllers\Admin\Ticket\TicketController;
use App\Http\Controllers\Admin\User\PermissionController;
use App\Http\Controllers\Admin\User\RoleController;
use App\Http\Controllers\Home\BecomeSellerController;
use App\Http\Controllers\Home\ContactController;
use App\Http\Controllers\Home\JobOpportunitiesController;

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

// check activation for users
Route::middleware("checkActivation")->group(function () {

    // Home routes
    Route::get('/', [HomeController::class, "index"])->name("home.index");
    // search
    Route::get("/search/{category:slug?}", [HomeController::class, "search"])->name("home.search");

    // login
    Route::get("/login", [AuthController::class, "loginPage"])->name("home.auth.login.page")->middleware("guest");
    Route::post("/login", [AuthController::class, "login"])->name("home.auth.login")->middleware("guest");
    Route::get("/verify-email/{token}", [AuthController::class, "verifyEmailPage"])->name("home.auth.verifyEmail.page")->middleware("guest");
    Route::post("/verify-email/{token}", [AuthController::class, "verifyEmail"])->name("home.auth.verifyEmail")->middleware("guest");
    Route::get("/logout", [AuthController::class, "logout"])->name("home.auth.logout")->middleware("auth");

    // add to bookmarks
    Route::get("/add-to-bookmark/{product:slug}", [HomeController::class, "addToBookmark"])->name("home.addToBookmark")->middleware("auth");

    // Profile
    Route::middleware("auth")->controller(AccountController::class)->prefix("profile")->group(function () {
        Route::get("/", "myProfile")->name("home.profile.myProfile.index");
        Route::put("/update-profile", "updateProfile")->name("home.profile.myProfile.updateProfile");
        Route::get("/my-bookmarks", "myBookmarks")->name("home.profile.myBookmarks.index")->middleware("CheckUserInformations");
        Route::post("/remove-bookmark/{bookmark}", "removeBookmark")->name("home.profile.myBookmarks.removeBookmark")->middleware("CheckUserInformations");
        Route::get("my-addresses", "myAddresses")->name("home.profile.myAddresses.index")->middleware("CheckUserInformations");
        Route::get('get-cities/{province?}', 'getCities')->name("home.profile.myAddresses.getCities");
        Route::post("my-addresses", "storeMyAddress")->name("home.profile.myAddresses.store")->middleware("CheckUserInformations");
        Route::get("my-addresses/edit/{address}", "editmyAddresses")->name("home.profile.myAddresses.edit")->middleware("CheckUserInformations");
        Route::put("my-addresses/update/{address}", "updateMyAddress")->name("home.profile.myAddresses.update")->middleware("CheckUserInformations");
        Route::get("my-orders/{sort?}", "myOrders")->name("home.profile.myOrders.index")->middleware("CheckUserInformations");
        Route::get("my-order/{order:tracking_id}", "showMyOrder")->name("home.profile.myOrders.show")->middleware("CheckUserInformations");
        Route::get("my-tickets", "myTickets")->name("home.profile.myTickets.index")->middleware("CheckUserInformations");
        Route::post("my-tickets", "storeTicket")->name("home.profile.myTickets.storeTicket")->middleware("CheckUserInformations");
        Route::get("my-tickets/messages/{ticket:ticket_id}", "myTicketMessages")->name("home.profile.myTickets.messages.index")->middleware("CheckUserInformations");
        Route::post("my-tickets/messages/{ticket:ticket_id}", "myTicketMessagesStore")->name("home.profile.myTickets.messages.store")->middleware("CheckUserInformations");
    });

    // Product
    Route::get("/product/{product:slug}", [HomeProductController::class, "show"])->name("home.product.show");

    // add to cart
    Route::post("/add-to-cart/{product:slug}", [HomeProductController::class, "addToCart"])->name("home.product.addToCart")->middleware("auth", "CheckUserInformations");
    Route::delete("/delete-from-cart/{cartItem}", [HomeProductController::class, "deleteFromCart"])->name("home.product.deleteFromCart")->middleware("auth", "CheckUserInformations");

    // submit comment
    Route::post("/product/comment/{product:slug}", [HomeProductController::class, "submitComment"])->name("home.product.submitComment")->middleware("auth", "CheckUserInformations");
    Route::post("/product/create-comment/{product:slug}", [HomeProductController::class, "createComment"])->name("home.product.createComment")->middleware("auth", "CheckUserInformations");

    // Sales Process
    Route::get("/my-cart", [CartController::class, "index"])->name("home.salesProcess.myCart")->middleware("auth", "CheckUserInformations");
    Route::get("/delivery", [CartController::class, "delivery"])->name("home.salesProcess.delivery")->middleware(["auth", "cartitems"]);
    Route::post("/submit-order", [OrderController::class, "submitOrder"])->name("home.salesProcess.submitOrder")->middleware(["auth", "cartitems"]);
    Route::get("/payment", [OrderController::class, "paymentPage"])->name("home.salesProcess.payment.page")->middleware(["auth", "cartitems"]);
    Route::post("/check-coupon", [OrderController::class, "checkCoupon"])->name("home.salesProcess.checkCoupon")->middleware(["auth", "cartitems"]);
    Route::post("/payment", [OrderController::class, "payment"])->name("home.salesProcess.payment")->middleware(["auth", "cartitems"]);
    Route::get("/callback", [OrderController::class, "callback"])->name("home.salesProcess.callback")->middleware(["auth", "cartitems"]);

    // Discounts and offers
    Route::get("/offers", [HomeController::class, "offers"])->name("home.offers.index");

    // contact us
    Route::middleware("auth")->controller(ContactController::class)->prefix("contact-us")->group(function () {
        Route::get("/", "create")->name("home.contactUs.index");
        Route::post("/", "store")->name("home.contactUs.store");
    });

    // contact us
    Route::get("/about-us", [HomeController::class, "showAboutUs"])->name("home.aboutUs.index");

    // Frequently Asked Questions (faq)
    Route::get("/faq", [HomeController::class, "showFaq"])->name("home.faq.index");

    // Frequently Asked Questions (faq)
    Route::middleware("auth", "CheckUserInformations")->controller(BecomeSellerController::class)->prefix("become-seller")->group(function () {
        Route::get("/", "index")->name("home.become-seller.index");
        Route::post("/", "store")->name("home.become-seller.store");
    });

    // Frequently Asked Questions (faq)
    Route::middleware("auth")->controller(JobOpportunitiesController::class)->prefix("job-opportunities")->group(function () {
        Route::get("/", "index")->name("home.job-opportunities.index");
        Route::get("/{job:slug}", "show")->name("home.job-opportunities.show");
        Route::post("/{job:slug}", "submitJobRequest")->name("home.job-opportunities.submitJobRequest");
    });

    // Admin routes
    Route::middleware("auth", "checkRoles")->prefix("admin")->group(function () {
        Route::get("/", [AdminController::class, "index"])->name("admin.index");


        Route::prefix("product")->group(function () {

            // Category
            Route::controller(CategoryController::class)->prefix("category")->group(function () {
                Route::get("/", "index")->name("admin.product.category.index");
                Route::get("/create", "create")->name("admin.product.category.create");
                Route::post("/", "store")->name("admin.product.category.store");
                Route::get("/{category}", "edit")->name("admin.product.category.edit");
                Route::put("/{category}", "update")->name("admin.product.category.update");
                Route::delete("/{category}", "destroy")->name("admin.product.category.delete");
            });

            // Brand
            Route::controller(BrandController::class)->prefix("brand")->group(function () {
                Route::get("/", "index")->name("admin.product.brand.index");
                Route::get("/create", "create")->name("admin.product.brand.create");
                Route::post("/", "store")->name("admin.product.brand.store");
                Route::get("/{brand}", "edit")->name("admin.product.brand.edit");
                Route::put("/{brand}", "update")->name("admin.product.brand.update");
                Route::delete("/{brand}", "destroy")->name("admin.product.brand.delete");
            });


            // Color
            Route::controller(ColorController::class)->prefix("color")->group(function () {
                Route::get("/", "index")->name("admin.product.color.index");
                Route::get("/create", "create")->name("admin.product.color.create");
                Route::post("/", "store")->name("admin.product.color.store");
                Route::get("/{color}", "edit")->name("admin.product.color.edit");
                Route::put("/{color}", "update")->name("admin.product.color.update");
                Route::delete("/{color}", "destroy")->name("admin.product.color.delete");
            });

            // Guarantee
            Route::controller(GuaranteeController::class)->prefix("guarantee")->group(function () {
                Route::get("/", "index")->name("admin.product.guarantee.index");
                Route::get("/create", "create")->name("admin.product.guarantee.create");
                Route::post("/", "store")->name("admin.product.guarantee.store");
                Route::get("/{guarantee}", "edit")->name("admin.product.guarantee.edit");
                Route::put("/{guarantee}", "update")->name("admin.product.guarantee.update");
                Route::delete("/{guarantee}", "destroy")->name("admin.product.guarantee.delete");
            });

            // Product
            Route::controller(ProductController::class)->group(function () {
                Route::get("/", "index")->name("admin.product.index");
                Route::get("/create", "create")->name("admin.product.create");
                Route::get("/show/{product}", "show")->name("admin.product.show");
                Route::get("/product-discount/{product}", "productDiscount")->name("admin.product.discount.index");
                Route::put("/product-discount/{product}", "productDiscountUpdate")->name("admin.product.discount.update");
                Route::post("/", "store")->name("admin.product.store");
                Route::get("/{product}", "edit")->name("admin.product.edit");
                Route::put("/{product}", "update")->name("admin.product.update");
                Route::delete("/{product}", "destroy")->name("admin.product.delete");
                Route::get("/change-status/{product}", "changeStatus")->name("admin.product.changeStatus");
                Route::get("/change-sale-status/{product}", "changeSaleStatus")->name("admin.product.changeSaleStatus");
            });

            // Product comments
            Route::controller(CommentController::class)->prefix("comment")->group(function () {
                Route::get("/{product}", "index")->name("admin.product.comment.index");
                Route::get("/show/{product}/{comment}", "show")->name("admin.product.comment.show")->scopeBindings();
                Route::get("/change-status/{product}/{comment}", "changeStatus")->name("admin.product.comment.changeStatus")->scopeBindings();
                Route::get("/change-seen-status/{product}/{comment}", "changeSeenStatus")->name("admin.product.comment.changeSeenStatus")->scopeBindings();
                Route::delete("/delete/{product}/{comment}", "destroy")->name("admin.product.comment.delete")->scopeBindings();
            });

            // Product options
            Route::controller(OptionProductController::class)->prefix("option")->group(function () {
                Route::get("/{product}", "index")->name("admin.product.option.index");
                Route::get("/create/{product}", "create")->name("admin.product.option.create");
                Route::post("/store/{product}", "store")->name("admin.product.option.store");
                Route::get("/show/{product}/{option}", "show")->name("admin.product.option.show")->scopeBindings();
                Route::get("/edit/{product}/{option}", "edit")->name("admin.product.option.edit")->scopeBindings();
                Route::put("/update/{product}/{option}", "update")->name("admin.product.option.update")->scopeBindings();
                Route::delete("/delete/{product}/{option}", "destroy")->name("admin.product.option.delete")->scopeBindings();
            });

            // Product images
            Route::controller(ImageProductController::class)->prefix("image")->group(function () {
                Route::get("/{product}", "index")->name("admin.product.image.index");
                Route::get("/create/{product}", "create")->name("admin.product.image.create");
                Route::post("/store/{product}", "store")->name("admin.product.image.store");
                Route::get("/edit/{product}/{image}", "edit")->name("admin.product.image.edit")->scopeBindings();
                Route::put("/update/{product}/{image}", "update")->name("admin.product.image.update")->scopeBindings();
                Route::delete("/delete/{product}/{image}", "destroy")->name("admin.product.image.delete")->scopeBindings();
            });

            // Product guarantees
            Route::controller(ProductGuaranteeController::class)->prefix("product-guarantees")->group(function () {
                Route::get("/{product}", "index")->name("admin.product.product-guarantees.index");
                Route::get("/create/{product}", "create")->name("admin.product.product-guarantees.create");
                Route::post("/store/{product}", "store")->name("admin.product.product-guarantees.store");
                Route::get("/edit/{product}/{guarantee}", "edit")->name("admin.product.product-guarantees.edit")->scopeBindings();
                Route::put("/update/{product}/{guarantee}", "update")->name("admin.product.product-guarantees.update")->scopeBindings();
                Route::delete("/delete/{product}/{guarantee}", "destroy")->name("admin.product.product-guarantees.delete")->scopeBindings();
            });

            // Product colors
            Route::controller(ProductColorController::class)->prefix("product-color")->group(function () {
                Route::get("/{product}", "index")->name("admin.product.product-color.index");
                Route::get("/create/{product}", "create")->name("admin.product.product-color.create");
                Route::post("/store/{product}", "store")->name("admin.product.product-color.store");
                Route::get("/edit/{product}/{color}", "edit")->name("admin.product.product-color.edit")->scopeBindings();
                Route::put("/update/{product}/{color}", "update")->name("admin.product.product-color.update")->scopeBindings();
                Route::delete("/delete/{product}/{color}", "destroy")->name("admin.product.product-color.delete")->scopeBindings();
            });
        });

        // users
        Route::prefix("user")->group(function () {
            Route::controller(UserController::class)->group(function () {
                Route::get("/", "index")->name("admin.user.index");
                Route::get("/change-status/{user}", "changeStatus")->name("admin.user.changeStatus");
                Route::get("/set-role/{user}", "setRolePage")->name("admin.user.setRolePage");
                Route::post("/set-role/{user}", "setRole")->name("admin.user.setRole");
            });
        });

        // Access management
        Route::prefix("access-management")->group(function () {
            // roles
            Route::controller(RoleController::class)->prefix("roles")->group(function () {
                Route::get("/", "index")->name("admin.accessManagement.role.index");
                Route::get("/create", "create")->name("admin.accessManagement.role.create");
                Route::post("/store", "store")->name("admin.accessManagement.role.store");
                Route::get("/edit/{role}", "edit")->name("admin.accessManagement.role.edit");
                Route::put("/update/{role}", "update")->name("admin.accessManagement.role.update");
                Route::delete("/delete/{role}", "destroy")->name("admin.accessManagement.role.delete");
                Route::get("/permissions/{role}", "permissionsPage")->name("admin.accessManagement.role.permissions.page");
                Route::post("/permissions/{role}", "permissionsStore")->name("admin.accessManagement.role.permissions.store");
            });

            // permissions
            Route::controller(PermissionController::class)->prefix("permission")->group(function () {
                Route::get("/", "index")->name("admin.accessManagement.permission.index");
            });
        });

        // appearance
        Route::prefix("appearance")->group(function () {
            // sliders
            Route::controller(SliderController::class)->prefix("slider")->group(function () {
                Route::get("/", "index")->name("admin.appearance.slider.index");
                Route::get("/create", "create")->name("admin.appearance.slider.create");
                Route::post("/store", "store")->name("admin.appearance.slider.store");
                Route::get("/edit/{slider}", "edit")->name("admin.appearance.slider.edit");
                Route::put("/update/{slider}", "update")->name("admin.appearance.slider.update");
                Route::get("/change-status/{slider}", "changeStatus")->name("admin.appearance.slider.changeStatus");
                Route::delete("/delete/{slider}", "destroy")->name("admin.appearance.slider.delete");
            });

            // banners
            Route::controller(BannerController::class)->prefix("banner")->group(function () {
                Route::get("/", "index")->name("admin.appearance.banner.index");
                Route::get("/create", "create")->name("admin.appearance.banner.create");
                Route::post("/store", "store")->name("admin.appearance.banner.store");
                Route::get("/edit/{banner}", "edit")->name("admin.appearance.banner.edit");
                Route::put("/update/{banner}", "update")->name("admin.appearance.banner.update");
                Route::get("/change-status/{banner}", "changeStatus")->name("admin.appearance.banner.changeStatus");
                Route::delete("/delete/{banner}", "destroy")->name("admin.appearance.banner.delete");
            });
        });

        // orders
        Route::prefix("order")->group(function () {

            Route::controller(AdminOrderController::class)->prefix("manage")->group(function () {
                Route::get("/", "index")->name("admin.order.all.index");
                Route::get("/filter", "filter")->name("admin.order.filter.index");
                Route::get("/{order}", "show")->name("admin.order.show");
                Route::get("/details/{order}", "details")->name("admin.order.details");
                Route::get("/change-payment-status/{order}", "changePaymentStatus")->name("admin.order.changePaymentStatus");
                Route::get("/change-delivery-status/{order}", "changeDeliveryStatus")->name("admin.order.changeDeliveryStatus");
                Route::get("/change-status/{order}", "changeStatus")->name("admin.order.changeStatus");
            });

            // payments
            Route::controller(PaymentController::class)->prefix("payment")->group(function () {
                Route::get("/", "index")->name("admin.order.payment.index");
                Route::get("/change-status/{payment}", "changeStatus")->name("admin.order.payment.changeStatus");
            });

            // Delivery
            Route::controller(DeliveryController::class)->prefix("delivery")->group(function () {
                Route::get("/", "index")->name("admin.order.delivery.index");
                Route::get("/create", "create")->name("admin.order.delivery.create");
                Route::post("/store", "store")->name("admin.order.delivery.store");
                Route::get("/edit/{delivery}", "edit")->name("admin.order.delivery.edit");
                Route::put("/update/{delivery}", "update")->name("admin.order.delivery.update");
                Route::get("/change-status/{delivery}", "changeStatus")->name("admin.order.delivery.changeStatus");
                Route::delete("/delete/{delivery}", "destroy")->name("admin.order.delivery.delete");
            });

            // Province
            Route::controller(ProvinceController::class)->prefix("province")->group(function () {
                Route::get("/", "index")->name("admin.order.province.index");
                Route::get("/create", "create")->name("admin.order.province.create");
                Route::post("/store", "store")->name("admin.order.province.store");
                Route::get("/edit/{province}", "edit")->name("admin.order.province.edit");
                Route::put("/update/{province}", "update")->name("admin.order.province.update");
                Route::get("/change-status/{province}", "changeStatus")->name("admin.order.province.changeStatus");
                Route::delete("/delete/{province}", "destroy")->name("admin.order.province.delete");
            });

            // City
            Route::controller(CityController::class)->prefix("city")->group(function () {
                Route::get("/", "index")->name("admin.order.city.index");
                Route::get("/create", "create")->name("admin.order.city.create");
                Route::post("/store", "store")->name("admin.order.city.store");
                Route::get("/edit/{city}", "edit")->name("admin.order.city.edit");
                Route::put("/update/{city}", "update")->name("admin.order.city.update");
                Route::get("/change-status/{city}", "changeStatus")->name("admin.order.city.changeStatus");
                Route::delete("/delete/{city}", "destroy")->name("admin.order.city.delete");
            });
        });

        // tickets
        Route::controller(TicketController::class)->prefix("ticket")->group(function () {
            Route::get("/", "index")->name("admin.ticket.index");
            Route::get("/messages/{ticket}", "messages")->name("admin.ticket.messages");
            Route::post("/messages/{ticket}", "storeMessages")->name("admin.ticket.messages.store");
            Route::get("/change-status/{ticket}", "changeStatus")->name("admin.ticket.changeStatus");
            Route::delete("/delete/{ticket}", "destroy")->name("admin.ticket.delete");
        });

        // notifications
        Route::prefix("notification")->group(function () {
            // email
            Route::controller(EmailController::class)->prefix("email")->group(function () {
                Route::get("/", "index")->name("admin.notification.email.index");
                Route::get("/create", "create")->name("admin.notification.email.create");
                Route::post("/store", "store")->name("admin.notification.email.store");
                Route::get("/show/{email}", "show")->name("admin.notification.email.show");
                Route::get("/send/{email}", "send")->name("admin.notification.email.send");
                Route::get("/edit/{email}", "edit")->name("admin.notification.email.edit");
                Route::put("/update/{email}", "update")->name("admin.notification.email.update");
                Route::delete("/delete/{email}", "destroy")->name("admin.notification.email.delete");
            });
        });

        // Contact Us
        Route::controller(AdminContactController::class)->prefix("contact-us")->group(function () {
            Route::get("/", "index")->name("admin.contactUs.index");
            Route::get("/show/{contactMessage}", "show")->name("admin.contactUs.show");
            Route::get("/change-status/{contactMessage}", "changeStatus")->name("admin.contactUs.changeStatus");
            Route::delete("/delete/{contactMessage}", "destroy")->name("admin.contactUs.delete");
        });

        // become seller requests
        Route::controller(SellerRequestsController::class)->prefix("seller-requests")->group(function () {
            Route::get("/", "index")->name("admin.seller-requests.index");
            Route::get("/show/{seller}", "show")->name("admin.seller-requests.show");
            Route::get("/change-seen-status/{seller}", "changeSeenStatus")->name("admin.seller-requests.changeSeenStatus");
            Route::get("/change-approval-status/{seller}", "changeApprovalStatus")->name("admin.seller-requests.changeApprovalStatus");
            Route::delete("/delete/{seller}", "destroy")->name("admin.seller-requests.delete");
        });

        // Job Opportunities and job requests
        Route::prefix("job-opportunities")->group(function () {
            // Job Opportunities
            Route::controller(AdminJobOpportunitiesController::class)->group(function () {
                Route::get("/", "index")->name("admin.job-opportunities.index");
                Route::get("/create", "create")->name("admin.job-opportunities.create");
                Route::post("/store", "store")->name("admin.job-opportunities.store");
                Route::get("/edit/{job}", "edit")->name("admin.job-opportunities.edit");
                Route::put("/update/{job}", "update")->name("admin.job-opportunities.update");
                Route::get("/change-status/{job}", "changeStatus")->name("admin.job-opportunities.change-status");
                Route::delete("/delete/{job}", "destroy")->name("admin.job-opportunities.delete");
            });

            // job requests
            Route::controller(JobRequestsController::class)->prefix("job-requests")->group(function () {
                Route::get("/{job}", "index")->name("admin.job-opportunities.job-requests.index");
                Route::get("/show/{job}/{request}", "show")->name("admin.job-opportunities.job-requests.show")->scopeBindings();
                Route::get("/change-seen-status/{job}/{request}", "changeSeenStatus")->name("admin.job-opportunities.job-requests.change-seen-status")->scopeBindings();
                Route::get("/change-approval-status/{job}/{request}", "changeApprovalStatus")->name("admin.job-opportunities.job-requests.change-approval-status")->scopeBindings();
                Route::delete("/delete/{job}/{request}", "destroy")->name("admin.job-opportunities.job-requests.delete")->scopeBindings();
            });
        });

        // Frequently Asked Questions (faq)
        Route::controller(FaqController::class)->prefix("faq")->group(function () {
            Route::get("/", "index")->name("admin.faq.index");
            Route::get("/create", "create")->name("admin.faq.create");
            Route::post("/store", "store")->name("admin.faq.store");
            Route::get("/edit/{faq}", "edit")->name("admin.faq.edit");
            Route::put("/update/{faq}", "update")->name("admin.faq.update");
            Route::get("/show/{faq}", "show")->name("admin.faq.show");
            Route::get("/change-status/{faq}", "changeStatus")->name("admin.faq.changeStatus");
            Route::delete("/delete/{faq}", "destroy")->name("admin.faq.delete");
        });

        // discounts
        Route::prefix("discount")->group(function () {
            // coupon
            Route::controller(DiscountCouponController::class)->prefix("coupon")->group(function () {
                Route::get("/", "index")->name("admin.discount.coupon.index");
                Route::get("/create", "create")->name("admin.discount.coupon.create");
                Route::post("/store", "store")->name("admin.discount.coupon.store");
                Route::get("/edit/{coupon}", "edit")->name("admin.discount.coupon.edit");
                Route::put("/update/{coupon}", "update")->name("admin.discount.coupon.update");
                Route::delete("/delete/{coupon}", "destroy")->name("admin.discount.coupon.delete");
                Route::get("/change-status/{coupon}", "changeStatus")->name("admin.discount.coupon.changeStatus");
            });
            // general discount
            Route::controller(GeneralDiscountController::class)->prefix("general")->group(function () {
                Route::get("/", "index")->name("admin.discount.general.index");
                Route::get("/create", "create")->name("admin.discount.general.create");
                Route::post("/store", "store")->name("admin.discount.general.store");
                Route::get("/edit/{discount}", "edit")->name("admin.discount.general.edit");
                Route::put("/update/{discount}", "update")->name("admin.discount.general.update");
                Route::delete("/delete/{discount}", "destroy")->name("admin.discount.general.delete");
                Route::get("/change-status/{discount}", "changeStatus")->name("admin.discount.general.changeStatus");
            });
        });
    });
});
