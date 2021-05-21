@extends('en.layouts.customer')

@section('title')
    Cart | Ecolla ε口乐
@endsection

@section('content')
    <main class="container">
        <div class="row">

            <!-- Cart item and notification -->
            <div class="col-lg-8">

                <!-- Cart items -->
                <div class="card mb-3">
                    <div class="card-body" id="cartItemList">

                        <div class="h4 pl-3 mb-3">Cart（{{ $cart->getCartCount() }}）</div>

                        @if($cart->getCartCount() == 0)
                            <div class="text-center">
                                <img src="{{ asset('img/icon/empty-cart.png') }}" width="150" height="150"/>
                                <div class="h5 p-2">Your Cart is Empty</div>
                            </div>
                        @endif

                        @foreach($cart->cartItems as $cartItem)
                            <div class="col-12 mb-3" id="{{ $cartItem->variation->barcode }}">
                                <div class="row">

                                    <!-- Cart Item Image -->
                                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                                        <div class="view zoom z-depth-1 rounded mb-3">
                                            <a href="{{ url('/en/item/' . $cartItem->variation->item->name_en) }}">
                                                <img src="{{ asset($cartItem->variation->image ?? $cartItem->variation->item->getCoverImage()) }}" class="w-100" height="250">
                                            </a>
                                        </div>
                                    </div><!-- Cart Item Image -->

                                    <!-- Cart item information -->
                                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 col-xl-7">

                                        <!-- Item name display -->
                                        <div class="h4 font-weight-bold">{{ $cartItem->variation->item->name_en }}</div>
                                        <!-- Item name display -->

                                        <!-- Variety property display -->
                                        <div class="h6 grey-text">{{ $cartItem->variation->name_en }}</div>
                                        <!-- Variety property display -->

                                        <!-- Weight display -->
                                        <div class="h6 text-muted">{{ number_format($cartItem->variation->weight * $cartItem->quantity, 3) . 'kg' }}</div>
                                        <!-- Weight display -->

                                        <!-- Quantity control -->
                                        <div class="row align-items-center">
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                Quantity：
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-9 d-flex justify-content-center">
                                                <form action="{{ url('/en/cart') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="action" value="quantityAdjust">
                                                    <input type="hidden" name="barcode" value="{{ $cartItem->variation->barcode }}">
                                                    <input type="hidden" name="quantityToAdjust" value="-1">

                                                    <button type="submit" class="btn btn-primary quantity-decrease-button" {{ $cartItem->quantity == 1 ? "disabled" : "" }}>-</button>
                                                </form>
                                                <input type="number" class="mx-3 my-3 cart-item-quantity" value="{{ $cartItem->quantity }}" style="width: 45px" disabled>
                                                <form action="{{ url('/en/cart') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="action" value="quantityAdjust">
                                                    <input type="hidden" name="barcode" value="{{ $cartItem->variation->barcode }}">
                                                    <input type="hidden" name="quantityToAdjust" value="1">

                                                    <button type="submit" class="btn btn-primary quantity-increase-button" {{ $cartItem->quantity == $cartItem->variation->stock ? "disabled" : "" }}>+</button>
                                                </form>
                                            </div>
                                        </div><!-- Quantity control -->

                                        <!-- Remove button and price display -->
                                        <div class="d-flex justify-content-between align-items-center">

                                            <div>
                                                <form action="{{ url('/en/cart') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="action" value="deleteItem">
                                                    <input type="hidden" name="barcode" value="{{ $cartItem->variation->barcode }}">
                                                    <button type="submit" class="btn btn-primary py-2 px-3 card-link-secondary small">
                                                        <i class="fas fa-trash-alt mr-1"></i>Remove
                                                    </button>
                                                </form>
                                            </div>

                                            @if($cartItem->variation->getCurrentDiscountMode($cartItem->quantity) == 'normal')
                                                <div>
                                                    <span>RM{{ number_format($cartItem->getSubPrice(), 2, '.', '') }}</span>
                                                </div>
                                            @else
                                                <div>
                                                    <span class="grey-text mr-1" style="font-size: 15px">
                                                        <del>RM{{ number_format($cartItem->getOriginalSubPrice(), 2, '.', '') }}</del>
                                                    </span>
                                                    <span>RM{{ number_format($cartItem->getSubPrice(), 2, '.', '') }}</span>
                                                    <span class="badge {{ $cartItem->variation->getCurrentDiscountMode($cartItem->quantity) == 'variation' ? "badge-danger" : "badge-warning" }} mr-1">
                                                        {{ number_format((1 - $cartItem->getDiscountRate()) * 100, 0, '.', '') }}% OFF
                                                    </span>
                                                </div>
                                            @endif
                                        </div><!-- Remove button and price -->

                                    </div><!-- Cart item information price display-->

                                </div>
                            </div>

                        @endforeach

                        @if($cart->getCartCount() != 0)
                            <div class="col-12">
                                <form action="{{ url('/en/cart') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="action" value="resetCart">
                                    <button class="btn btn-primary btn-block" type="submit">Empty Cart</button>
                                </form>
                            </div>
                        @endif

                    </div>
                </div><!-- Cart items -->

                <!-- Notification -->
                <div class="card mb-3">
                    <div class="card-body bg-info">
                        <!-- Delivery Description -->
                        <h5>Self Pick-up Service</h5>
                        <p class="text-light">
                            Please fill in the phone number for in-store verification purpose
                        </p>
                        <h5>Delivery Service</h5>
                        <p class="text-light">
                            Maximum delivery distance: Within 5KM, delivery service not available for more than 5KM distance from store
                            Shipping Fee：RM3.00
                        </p>
                    </div>
                </div><!-- Notification -->

            </div><!-- Cart item and notification -->

            <!-- Order mode settings and order summary -->
            <div class="col-lg-4">

                <!-- Order mode settings -->
                <div class="card mb-3">
                    <div class="card-body">

                        <form action="{{ url('/en/cart') }}" method="post" id="order-mode-selector-form">
                            @csrf

                            <input type="hidden" name="action" value="updateOrderMode">

                            <div class="h5 mb-3">Order Mode：</div>

                            <select class="form-control mb-3 w-100" name="mode" id="order-mode-selector">
                                <option value="pickup" {{ $cart->orderMode == 'pickup' ? " selected" : "" }}>
                                    Pick-Up
                                </option>
                                <option value="delivery" {{ $cart->orderMode == 'delivery' ? " selected" : "" }}>
                                    Delivery (Within 5KM from store)
                                </option>
                            </select>
                        </form>
                    </div>
                </div>
                <!-- Order mode settings -->

                <!-- Pick up -->
                <div class="card mb-3" id="pickup-display"
                     style="{{ $cart->orderMode == 'pickup' ? "" : "display: none;" }}">
                    <div class="card-body">

                        @if(session()->has('message'))
                            <div class="alert alert-info text-center" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form action="{{ url('/en/cart') }}" method="post">
                            @csrf
                            <input type="hidden" name="action" value="updateCustomerData">
                            <input type="hidden" name="mode" value="pickup">

                            <div class="form-group">
                                <label for="delivery_id">Phone Number</label>
                                <input type="text"
                                       class="form-control{{ $errors->has('delivery_id') ? ' is-invalid' : '' }}"
                                       name="delivery_id"
                                       id="delivery_id"
                                       value="{{ $cart->deliveryId ?? old('delivery_id') ?? "" }}"
                                       placeholder="Phone Number">
                                @if ($errors->has('delivery_id'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('delivery_id') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <button class="btn btn-primary btn-block" type="submit">保存</button>
                        </form>

                    </div>
                </div>
                <!-- Pick up -->

                <!-- Delivery -->
                <div class="card mb-3" id="delivery-display"
                     style="{{ $cart->orderMode == 'delivery' ? "" : "display: none;" }}">
                    <div class="card-body">

                        @if(session()->has('message'))
                            <div class="alert alert-info text-center" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form action="{{ url('/en/cart') }}" method="post">
                            @csrf
                            <input type="hidden" name="action" value="updateCustomerData">
                            <input type="hidden" name="mode" value="delivery">

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       name="name"
                                       id="name"
                                       value="{{ $cart->customer->name ?? old('name') ?? "" }}"
                                       placeholder="Please enter the recognizable name"/>
                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text"
                                       class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                       name="phone"
                                       id="phone"
                                       value="{{ $cart->customer->phone ?? old('phone') ?? "" }}"
                                       placeholder="Phone">
                                @if ($errors->has('phone'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </div>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="addressLine1">Address</label>
                                <input type="text"
                                       name="addressLine1"
                                       class="form-control{{ $errors->has('addressLine1') ? ' is-invalid' : '' }}"
                                       value="{{ $cart->customer->addressLine1 ?? old('addressLine1') ?? "" }}"
                                       placeholder="House/Street Number"/>
                                @if ($errors->has('addressLine1'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('addressLine1') }}</strong>
                                    </div>
                                @endif
                            </div>

                            {{--                                <div class="form-group">--}}
                            {{--                                    <div class="form-row">--}}
                            {{--                                        <div class="col">--}}
                            {{--                                            <input type="text"--}}
                            {{--                                                   name="state"--}}
                            {{--                                                   class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}"--}}
                            {{--                                                   value="{{ $cart->customer->state ?? old('state') ?? "" }}"--}}
                            {{--                                                   placeholder="State"/>--}}
                            {{--                                            @if ($errors->has('state'))--}}
                            {{--                                                <div class="invalid-feedback">--}}
                            {{--                                                    <strong>{{ $errors->first('state') }}</strong>--}}
                            {{--                                                </div>--}}
                            {{--                                            @endif--}}
                            {{--                                        </div>--}}
                            {{--                                        <div class="col">--}}
                            {{--                                            <input type="text" name="area"--}}
                            {{--                                                   class="form-control{{ $errors->has('area') ? ' is-invalid' : '' }}"--}}
                            {{--                                                   value="{{ $cart->customer->area ?? old('area') ?? "" }}"--}}
                            {{--                                                   placeholder="Area/City"/>--}}
                            {{--                                            @if ($errors->has('area'))--}}
                            {{--                                                <div class="invalid-feedback">--}}
                            {{--                                                    <strong>{{ $errors->first('area') }}</strong>--}}
                            {{--                                                </div>--}}
                            {{--                                            @endif--}}
                            {{--                                        </div>--}}
                            {{--                                        <div class="col">--}}
                            {{--                                            <input type="text" name="postal_code"--}}
                            {{--                                                   class="form-control{{ $errors->has('postal_code') ? ' is-invalid' : '' }}"--}}
                            {{--                                                   value="{{ $cart->customer->postal_code ?? old('postal_code') ?? "" }}"--}}
                            {{--                                                   placeholder="Postal Code"/>--}}

                            {{--                                            @if ($errors->has('postal_code'))--}}
                            {{--                                                <div class="invalid-feedback">--}}
                            {{--                                                    <strong>{{ $errors->first('postal_code') }}</strong>--}}
                            {{--                                                </div>--}}
                            {{--                                            @endif--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}

                            <button class="btn btn-primary btn-block" type="submit">保存</button>
                        </form>

                    </div>
                </div>
                <!-- Delivery -->

                <!-- Order summary -->
                <div class="card mb-3">
                    <div class="card-body">

                        <h5 class="card-title">Order Summary</h5>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                Subtotal
                                <span>RM {{ number_format($cart->getSubTotal(), 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                Shipping Fee
                                <span>{{ $cart->orderMode == 'delivery' ? "RM " . number_format($cart->getShippingFee(), 2) : "N/A" }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                <strong>Total</strong>
                                <span><strong>RM {{ number_format($cart->getSubTotal() + $cart->getShippingFee(), 2) }}</strong></span>
                            </li>
                        </ul>

                        <form action="/en/check-out" method="get">
                            <button class="btn btn-primary btn-block" type="submit" id="submit_btn" {{ $cart->canCheckOut ? "" : "disabled" }}>Check Out</button>
                        </form>
                    </div>
                </div><!-- Order summary -->

            </div><!-- Order mode settings and order summary -->

        </div>
    </main>

@endsection

@section('extraScriptEnd')
    <script>
        $(document).on('change', '#order-mode-selector', function () {
            $('#order-mode-selector-form').submit();
        });
    </script>
@endsection
