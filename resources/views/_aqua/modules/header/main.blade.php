<div class="header_main">
    <div class="container">
        <div class="row">

            <!-- Logo -->
            <div class="col-6 col-sm-3 col-lg-3 order-1 order-lg-2">
                @include( $template_name .'.modules.logo.default')
            </div>

            <!-- ShopName  -->
            <div class="col-6 col-lg-12 order-2 order-lg-1 text-center pt-2 d-none d-sm-block">
                Фирменный магазин насосов ООО "ПТФ Акватехника"
            </div>

            <!-- Search -->
            <div class="col-12 col-lg-6 order-lg-2 order-3 text-lg-left text-right">
                @include( $template_name .'.modules.search.default')
            </div>

            <!-- Cart -->
            <div class="col-6 col-sm-3 col-lg-3 order-lg-3 order-2 text-lg-left text-right">
                @include( $template_name .'.modules.shop_basket.default')
            </div>

        </div>
    </div>
</div>