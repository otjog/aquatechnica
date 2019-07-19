@if(isset($shipment) && count($shipment) > 0 && $shipment !== null)
    @include( $global_data['template']['name'] . '.modules.elements.progress',
                       ['msg' => 'Рассчитываем доставку..'])
    <div class="shipment-offers">
        <div class="my-4">
            <h3 class="text-center">Самовывоз с пункта выдачи</h3>

            @foreach($shipment as $service)
                <div class="reload"
                     data-alias="{{$service['alias']}}"
                     data-view="offer-show"
                     data-parcel_data="{{$parcelData}}"
                     data-type="toTerminal"
                >
                    @include( $global_data['template']['name'] .'.modules.shop.shipment._reload.offer-show')
                </div>
            @endforeach
        </div>
        <div class="my-4">
            <h3 class="text-center">Курьерская доставка до дверей</h3>

            @foreach($shipment as $service)
                <div class="reload"
                     data-alias="{{$service['alias']}}"
                     data-view="offer-show"
                     data-parcel_data="{{$parcelData}}"
                     data-type="toDoor"
                >
                    @include( $global_data['template']['name'] .'.modules.shop.shipment._reload.offer-show')
                </div>
            @endforeach
        </div>
    </div>

@endif