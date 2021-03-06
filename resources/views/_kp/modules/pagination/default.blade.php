<div class="shop_page_nav d-flex flex-row">
@if($products->lastPage() > 1)
    {{-- Указываем сколько показывать кнопок по умолчанию ( от 1 до 5 ) --}}
    <?php $startPage = 1; $endPage = 5;?>
    {{-- Не показываем стрелки движения влево, если мы на первой странице --}}
        <ul class="page_nav d-flex flex-row">
            @if($products->currentPage() != 1)
                <li>
                    <a
                            class="w-100 h-100 pt-3 text-center text-primary"
                            href="{{$products->appends($parameters)->url(1)}}"
                            data-ajax
                            data-ajax-push-state="1"
                            data-ajax-view="{{$global_data['template']['name']. '.components.shop.product.list._reload'}}"
                            data-ajax-event-name="click"
                            data-ajax-method="get"
                            data-ajax-name="shop-filter-product"
                            data-ajax-reload-class="product-list"
                            data-ajax-effects="scrolltop|spinner"
                    >
                        <i class="fa fa-angle-double-left"></i>
                    </a>
                </li>
                <li>
                    <a
                            class="w-100 h-100 pt-3 text-center text-primary"
                            href="{{$products->appends($parameters)->previousPageUrl()}}"
                            data-ajax
                            data-ajax-push-state="1"
                            data-ajax-view="{{$global_data['template']['name']. '.components.shop.product.list._reload'}}"
                            data-ajax-event-name="click"
                            data-ajax-method="get"
                            data-ajax-name="shop-filter-product"
                            data-ajax-reload-class="product-list"
                            data-ajax-effects="scrolltop|spinner"
                    >
                        <i class="fa fa-angle-left"></i>
                    </a>
                </li>
            @else
                <li><span class="w-100 h-100 pt-3 text-center text-muted"><i class="fa fa-angle-double-left"></i></span></li>
                <li><span class="w-100 h-100 pt-3 text-center text-muted"><i class="fa fa-angle-left"></i></span></li>
            @endif
        {{-- Когда мы показываем лишь часть кнопок, при нажатии на последнюю видимую, кнопки смещаются на одну позицию
                т.е были показаны страницы от 1 до 5, принажатии на 5 будут показаны от 2 до 6, и т.д до последней --}}
            @if($products->currentPage() <= $products->lastPage() && $products->currentPage() >= $endPage)
                <?php
                    $shift = $products->currentPage() - $endPage + 1;
                    $startPage  = $startPage + $shift;
                    $endPage    = $endPage + $shift;
                ?>
            @endif
        {{-- Выводим в цикле кнопки, текущая страница не имеет ссылки на саму себя --}}
            @for($i = $startPage; $i <= $endPage && $i <= $products->lastPage(); $i++)
                @if($products->currentPage() != $i)
                    <li>
                        <a
                                class="w-100 h-100 pt-3 text-center text-primary"
                                href="{{$products->appends($parameters)->url($i)}}"
                                data-ajax
                                data-ajax-push-state="1"
                                data-ajax-view="{{$global_data['template']['name']. '.components.shop.product.list._reload'}}"
                                data-ajax-event-name="click"
                                data-ajax-method="get"
                                data-ajax-name="shop-filter-product"
                                data-ajax-reload-class="product-list"
                                data-ajax-effects="scrolltop|spinner"
                        >
                            {{$i}}
                        </a>
                    </li>
                @else
                    <li><span class="w-100 h-100 pt-3 text-center text-muted">{{$i}}</span></li>
                @endif
            @endfor
        {{-- Не показываем стрелки движения вправо, если мы на последеней странице --}}
            @if($products->currentPage() != $products->lastPage())
                <li>
                    <a
                            class="w-100 h-100 pt-3 text-center text-primary"
                            href="{{$products->appends($parameters)->nextPageUrl()}}"
                            data-ajax
                            data-ajax-push-state="1"
                            data-ajax-view="{{$global_data['template']['name']. '.components.shop.product.list._reload'}}"
                            data-ajax-event-name="click"
                            data-ajax-method="get"
                            data-ajax-name="shop-filter-product"
                            data-ajax-reload-class="product-list"
                            data-ajax-effects="scrolltop|spinner"
                    >
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
                <li>
                    <a
                            class="w-100 h-100 pt-3 text-center text-primary"
                            href="{{$products->appends($parameters)->url($products->lastPage())}}"
                            data-ajax
                            data-ajax-push-state="1"
                            data-ajax-view="{{$global_data['template']['name']. '.components.shop.product.list._reload'}}"
                            data-ajax-event-name="click"
                            data-ajax-method="get"
                            data-ajax-name="shop-filter-product"
                            data-ajax-reload-class="product-list"
                            data-ajax-effects="scrolltop|spinner"
                    >
                        <i class="fa fa-angle-double-right"></i>
                    </a>
                </li>
            @else
                    <li><span class="w-100 h-100 pt-3 text-center text-muted"><i class="fa fa-angle-right"></i></span></li>
                    <li><span class="w-100 h-100 pt-3 text-center text-muted"><i class="fa fa-angle-double-right"></i></span></li>
            @endif
        </ul>
    @endif
</div>