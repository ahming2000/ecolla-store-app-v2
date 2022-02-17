@extends('ch.layouts.app')

@section('title')
    购物车 | Ecolla e口乐
@endsection

@section('content')
    <main class="container">
        <div class="row">

            @if(App\Models\SystemConfig::where('name', '=', 'clt_o_shipping_discount')->value('value') == '1')
                <div class="col-12">
                    <div class="card shadow bg-warning mb-3">
                        <div class="card-body">
                            <div class="h5 text-center">
                                限时优惠！买上RM{{ App\Models\SystemConfig::where('name', '=', 'clt_o_shipping_discount_threshold')->value('value') }}免邮！
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-8">

                <!-- Cart items -->
                <div class="card shadow mb-3">
                    <div class="card-body" id="cartItemList">

                        <div class="d-flex justify-content-between mb-3">
                            <div class="h4">
                                购物车（{{ $cart->getCartCount() }}个）
                            </div>
                            @if($cart->getCartCount() != 0)
                                <div>
                                    <form action="{{ url('/ch/cart') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="action" value="resetCart">
                                        <button class="btn btn-outline-danger">
                                            <i class="icofont icofont-trash"></i> 清空
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>


                        @if($cart->getCartCount() == 0)
                            <div class="text-center">
                                <img src="{{ asset('img/empty-cart.png') }}" width="150" height="150" alt="">
                                <div class="h5 p-2">您的购物车为空</div>
                            </div>
                        @endif

                        @foreach($cart->cartItems as $cartItem)
                            <div class="col-12 mb-3" id="{{ $cartItem->variation->barcode }}">
                                <div class="row">

                                    <!-- Image -->
                                    <div class="col-4 col-lg-3">
                                        <a href="{{ url('/ch/item/' . $cartItem->variation->item->id) }}"
                                           class="no-anchor-style">
                                            <img class="img-fluid rounded-3" alt=""
                                                 src="{{ $cartItem->variation->image ?? $cartItem->variation->item->getCoverImage() }}">
                                        </a>
                                    </div>
                                    <!-- Image -->

                                    <div class="col-8 col-lg-9">

                                        <div class="d-flex justify-content-between align-content-center">

                                            <!-- Item Name -->
                                            <div class="h4 font-weight-bold text-truncate">
                                                <a href="{{ url('/ch/item/' . $cartItem->variation->item->id) }}"
                                                   class="no-anchor-style">
                                                    {{ $cartItem->variation->item->name }}
                                                </a>
                                            </div>
                                            <!-- Item Name -->

                                            <!-- Item Remove Button -->
                                            <div>
                                                <form action="{{ url('/ch/cart') }}" method="post">
                                                    @csrf

                                                    <input type="hidden" name="action" value="deleteItem">
                                                    <input type="hidden" name="barcode"
                                                           value="{{ $cartItem->variation->barcode }}">
                                                    <button class="btn btn-danger btn-sm rounded-pill px-3">
                                                        X
                                                    </button>
                                                </form>
                                            </div>
                                            <!-- Item Remove Button -->

                                        </div>

                                        <!-- Variation Name -->
                                        <div class="h6">
                                            {{ $cartItem->variation->name }}

                                            {{-- Discount Percentage --}}
                                            @if($cartItem->variation->getCurrentDiscountMode($cartItem->quantity) == "variation")
                                                <span class="badge rounded-pill bg-danger me-1">
                                                    {{ $cartItem->variation->getDiscountPercentage() }}% OFF
                                                </span>
                                            @endif

                                            @if($cartItem->variation->getCurrentDiscountMode($cartItem->quantity) == "wholesale")
                                                {{-- TODO - Wholesale Discount Percentage --}}
                                            @endif
                                            {{-- Discount Percentage --}}
                                        </div>
                                        <!-- Variation Name -->

                                        <div class="d-flex justify-content-between mb-3">

                                            <!-- Weight -->
                                            <div class="h6 text-muted">
                                                {{ number_format($cartItem->variation->weight * $cartItem->quantity, 3) . 'kg' }}
                                            </div>
                                            <!-- Weight -->

                                            {{-- Price --}}
                                            <div class="h6">
                                                <span>RM{{ number_format($cartItem->getSubPrice(), 2, '.', '') }}</span>
                                            </div>
                                            {{-- Price --}}

                                        </div>

                                        <!-- Quantity control -->
                                        <div class="col-12 d-flex justify-content-center">
                                            <form action="{{ url('/ch/cart') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="action" value="quantityAdjust">
                                                <input type="hidden" name="barcode"
                                                       value="{{ $cartItem->variation->barcode }}">
                                                <input type="hidden" name="quantityToAdjust" value="-1">

                                                <button
                                                    class="btn btn-primary btn-sm mx-3 px-3 quantity-decrease-button" {{ $cartItem->quantity == 1 ? "disabled" : "" }}>
                                                    -
                                                </button>
                                            </form>
                                            <input type="number" class="form-control form-control-sm cart-item-quantity"
                                                   value="{{ $cartItem->quantity }}" style="width: 45px" disabled>
                                            <form action="{{ url('/ch/cart') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="action" value="quantityAdjust">
                                                <input type="hidden" name="barcode"
                                                       value="{{ $cartItem->variation->barcode }}">
                                                <input type="hidden" name="quantityToAdjust" value="1">

                                                <button type="submit"
                                                        class="btn btn-primary btn-sm mx-3 px-3 quantity-increase-button" {{ $cartItem->quantity == $cartItem->variation->stock ? "disabled" : "" }}>
                                                    +
                                                </button>
                                            </form>
                                        </div>
                                        <!-- Quantity control -->

                                    </div>

                                </div>
                            </div>

                        @endforeach


                    </div>
                </div>
                <!-- Cart items -->

                <!-- Notification -->
                <div class="card shadow mb-3">
                    <div class="card-body bg-info">
                        <!-- Delivery Description -->
                        <h5>预购取货：</h5>
                        <p class="text-light">
                            请填写电话号码以便能在店里领取您的商品
                        </p>
                        <h5>外送：</h5>
                        <p class="text-light">
                            运送距离：距离本店5公里以内，暂不开放给5公里外的外送<br>
                            外送价钱：RM{{ App\Models\SystemConfig::where('name', '=', 'clt_o_shippingFeeKampar')->value('value') }}<br>
                            <span class="text-danger">**不支持货到付款</span><br>
                            <br>
                            配送时段详情：<br>
                            3PM之前订单的配送时间 - 3PM~4PM<br>
                            3PM之后订单的配送时间 - 7PM~8PM<br>
                        </p>
                    </div>
                </div>
                <!-- Notification -->

            </div>

            <div class="col-lg-4">

                <div class="card shadow mb-3">
                    <div class="card-body">
                        <div class="h5 mb-3 fw-bold">备注</div>

                        如有任何问题，请联系我们！

                        <br>

                        <i class="icofont icofont-facebook pr-2"></i>
                        <a href="https://www.facebook.com/Ecolla-e%E5%8F%A3%E4%B9%90-2347940035424278" target="_blank">e口乐官方脸书</a>

                        <br>

                        <i class="icofont icofont-whatsapp pr-2"></i>
                        <a href="https://wa.link/fcfum1" target="_blank">WhatsApp 客服</a>

                        <br>

                        <i class="icofont icofont-phone pr-2"></i>
                        <a href="#" onclick="event.preventDefault();navigator.clipboard.writeText('+60129862365');alert('已成功复制电话号码！');">012-9862365（点击复制）</a>
                    </div>
                </div>

                <!-- Order mode settings -->
                <div class="card shadow mb-3">
                    <div class="card-body">

                        <div class="h5 mb-3">订单模式：</div>

                        <form action="{{ url('/ch/cart') }}" method="post" id="order-mode-selector-form">
                            @csrf

                            <input type="hidden" name="action" value="updateOrderMode">

                            <select class="form-select mb-3" name="mode" id="order-mode-selector">
                                <option value="pickup" {{ $cart->orderMode == 'pickup' ? " selected" : "" }}>
                                    预购取货
                                </option>
                                <option value="delivery" {{ $cart->orderMode == 'delivery' ? " selected" : "" }}>
                                    外送（距离本店5公里内）
                                </option>
                            </select>

                        </form>
                    </div>
                </div>
                <!-- Order mode settings -->

                <!-- Pick up -->
                <div class="card shadow mb-3" id="pickup-display"
                     style="{{ $cart->orderMode == 'pickup' ? "" : "display: none;" }}">
                    <div class="card-body">

                        @if(session()->has('message'))
                            <div class="alert alert-info text-center" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form action="{{ url('/ch/cart') }}" method="post">
                            @csrf
                            <input type="hidden" name="action" value="updateCustomerData">
                            <input type="hidden" name="mode" value="pickup">

                            <div class="mb-3">
                                <label for="delivery_id" class="mb-2">电话号码</label>
                                <input type="text"
                                       class="form-control{{ $errors->has('delivery_id') ? ' is-invalid' : '' }}"
                                       name="delivery_id"
                                       id="delivery_id"
                                       value="{{ $cart->deliveryId ?? old('delivery_id') ?? "" }}"
                                       placeholder="电话号码">
                                @if ($errors->has('delivery_id'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('delivery_id') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <button class="btn btn-primary w-100" type="submit">保存</button>

                        </form>

                    </div>
                </div>
                <!-- Pick up -->

                <!-- Delivery -->
                <div class="card shadow mb-3" id="delivery-display"
                     style="{{ $cart->orderMode == 'delivery' ? "" : "display: none;" }}">
                    <div class="card-body">

                        @if(session()->has('message'))
                            <div class="alert alert-info text-center" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form action="{{ url('/ch/cart') }}" method="post">
                            @csrf
                            <input type="hidden" name="action" value="updateCustomerData">
                            <input type="hidden" name="mode" value="delivery">

                            <div class="mb-3">
                                <label for="name" class="mb-2">收货人名字（英语）</label>
                                <input type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       name="name"
                                       id="name"
                                       value="{{ $cart->customer->name ?? old('name') ?? "" }}"
                                       placeholder="请输入可辨识的姓名"/>
                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>


                            <div class="mb-3">
                                <label for="phone" class="mb-2">电话号码</label>
                                <input type="text"
                                       class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                       name="phone"
                                       id="phone"
                                       value="{{ $cart->customer->phone ?? old('phone') ?? "" }}"
                                       placeholder="电话号码">
                                @if ($errors->has('phone'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </div>
                                @endif
                            </div>


                            <div class="mb-3">
                                <div class="mb-1">
                                    <label for="addressLine1" class="mb-2">地址</label>
                                    <input type="text"
                                           name="addressLine1"
                                           class="form-control{{ $errors->has('addressLine1') ? ' is-invalid' : '' }}"
                                           value="{{ $cart->customer->addressLine1 ?? old('addressLine1') ?? "" }}"
                                           placeholder="门牌/路名"/>
                                    @if ($errors->has('addressLine1'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('addressLine1') }}</strong>
                                        </div>
                                    @endif
                                </div>

{{--                                <div class="mb-1">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col pe-1">--}}
{{--                                            <input type="text" name="postal_code"--}}
{{--                                                   class="form-control{{ $errors->has('postal_code') ? ' is-invalid' : '' }}"--}}
{{--                                                   value="31900"--}}
{{--                                                   --}}{{-- value="{{ $cart->customer->postal_code ?? old('postal_code') ?? "" }}" --}}
{{--                                                   placeholder="邮政编号" disabled/>--}}

{{--                                            @if ($errors->has('postal_code'))--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    <strong>{{ $errors->first('postal_code') }}</strong>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                        <div class="col px-0">--}}
{{--                                            <input type="text" name="area"--}}
{{--                                                   class="form-control{{ $errors->has('area') ? ' is-invalid' : '' }}"--}}
{{--                                                   value="Kampar"--}}
{{--                                                   --}}{{-- value="{{ $cart->customer->area ?? old('area') ?? "" }}" --}}
{{--                                                   placeholder="地区/城市" disabled/>--}}
{{--                                            @if ($errors->has('area'))--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    <strong>{{ $errors->first('area') }}</strong>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                        <div class="col ps-1">--}}
{{--                                            <input type="text"--}}
{{--                                                   name="state"--}}
{{--                                                   class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}"--}}
{{--                                                   value="Perak"--}}
{{--                                                   --}}{{-- value="{{ $cart->customer->state ?? old('state') ?? "" }}" --}}
{{--                                                   placeholder="州属" disabled/>--}}
{{--                                            @if ($errors->has('state'))--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    <strong>{{ $errors->first('state') }}</strong>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>

                            <button class="btn btn-primary w-100" type="submit">保存</button>
                        </form>

                    </div>
                </div>
                <!-- Delivery -->

                <!-- Order summary -->
                <div class="card shadow mb-3">
                    <div class="card-body">

                        <h5 class="card-title">购物车订单摘要</h5>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                小计
                                <span>RM {{ number_format($cart->getSubTotal(), 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                邮费@if($cart->getFreeShippingNote() != null) {{ "（" . $cart->getFreeShippingNote() . "）" }} @endif
                                <span>{{ $cart->orderMode == 'delivery' ? "RM " . number_format($cart->getShippingFee(), 2) : "N/A" }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                <strong>总计</strong>
                                <span><strong>RM {{ number_format($cart->getSubTotal() + $cart->getShippingFee(), 2) }}</strong></span>
                            </li>
                        </ul>

                        <button class="btn btn-primary w-100" type="submit"
                                onclick="window.location.href = '{{ url('/ch/check-out') }}'"
                                id="submit_btn" {{ $cart->canCheckOut ? "" : "disabled" }}>
                            前往付款
                        </button>
                    </div>
                </div><!-- Order summary -->

            </div>

        </div>
    </main>

@endsection

@section('script')
    <script>
        $(document).on('change', '#order-mode-selector', function () {
            $('#order-mode-selector-form').submit();
        });
    </script>
@endsection
