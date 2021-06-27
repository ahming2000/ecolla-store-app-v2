@extends('en.layouts.app')

@section('title')
    Cart | Ecolla e口乐
@endsection

@section('content')
    <main class="container">
        <div class="row">

            <div class="col-lg-8">

                <!-- Cart items -->
                <div class="card shadow mb-3">
                    <div class="card-body" id="cartItemList">

                        <div class="d-flex justify-content-between mb-3">
                            <div class="h4">
                                Cart（{{ $cart->getCartCount() }}）
                            </div>
                            @if($cart->getCartCount() != 0)
                                <div>
                                    <form action="{{ url('/en/cart') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="action" value="resetCart">
                                        <button class="btn btn-outline-danger">
                                            <i class="icofont icofont-trash"></i> Clear
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>


                        @if($cart->getCartCount() == 0)
                            <div class="text-center">
                                <img src="{{ asset('img/empty-cart.png') }}" width="150" height="150" alt="">
                                <div class="h5 p-2">Your Cart is Empty</div>
                            </div>
                        @endif

                        @foreach($cart->cartItems as $cartItem)
                            <div class="col-12 mb-3" id="{{ $cartItem->variation->barcode }}">
                                <div class="row">

                                    <!-- Image -->
                                    <div class="col-4 col-lg-3">
                                        <a href="{{ url('/en/item/' . $cartItem->variation->item->id) }}" class="no-anchor-style">
                                            <img class="img-fluid rounded-3" alt=""
                                                 src="{{ asset($cartItem->variation->image ?? $cartItem->variation->item->getCoverImage()) ?? "" }}">
                                        </a>
                                    </div>
                                    <!-- Image -->

                                    <div class="col-8 col-lg-9">

                                        <div class="d-flex justify-content-between align-content-center">

                                            <!-- Item Name -->
                                            <div class="h4 font-weight-bold text-truncate">
                                                {{ $cartItem->variation->item->name_en }}
                                            </div>
                                            <!-- Item Name -->

                                            <!-- Item Remove Button -->
                                            <div>
                                                <form action="{{ url('/en/cart') }}" method="post">
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
                                        <div class="h6 grey-text">
                                            {{ $cartItem->variation->name_en }}
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
                                                @if($cartItem->variation->getCurrentDiscountMode($cartItem->quantity) == 'normal')
                                                    <span>RM{{ number_format($cartItem->getSubPrice(), 2, '.', '') }}</span>
                                                @else
                                                    <span class="grey-text mr-1" style="font-size: 15px">
                                                    <del>RM{{ number_format($cartItem->getOriginalSubPrice(), 2, '.', '') }}</del>
                                                </span>
                                                    <span>
                                                    RM{{ number_format($cartItem->getSubPrice(), 2, '.', '') }}
                                                </span>
                                                    <span
                                                        class="badge rounded-pill {{ $cartItem->variation->getCurrentDiscountMode($cartItem->quantity) == 'variation' ? "bg-danger" : "bg-warning" }} me-1">
                                                        {{ number_format((1 - $cartItem->getDiscountRate()) * 100, 0, '.', '') }}% OFF
                                                </span>
                                                @endif
                                            </div>
                                            {{-- Price --}}

                                        </div>

                                        <!-- Quantity control -->
                                        <div class="col-12 d-flex justify-content-center">
                                            <form action="{{ url('/en/cart') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="action" value="quantityAdjust">
                                                <input type="hidden" name="barcode"
                                                       value="{{ $cartItem->variation->barcode }}">
                                                <input type="hidden" name="quantityToAdjust" value="-1">

                                                <button class="btn btn-primary btn-sm mx-3 px-3 quantity-decrease-button" {{ $cartItem->quantity == 1 ? "disabled" : "" }}>
                                                    -
                                                </button>
                                            </form>
                                            <input type="number" class="form-control form-control-sm cart-item-quantity"
                                                   value="{{ $cartItem->quantity }}" style="width: 45px" disabled>
                                            <form action="{{ url('/en/cart') }}" method="post">
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
                        <h5>Self Pick-up Service</h5>
                        <p class="text-light">
                            Please fill in the phone number for in-store verification purpose
                        </p>
                        <h5>Delivery Service</h5>
                        <p class="text-light">
                            Maximum delivery distance: Within 5KM, delivery service not available for more than 5KM distance from store<br>
                            Shipping Fee：RM3.00
                        </p>
                    </div>
                </div>
                <!-- Notification -->

            </div>

            <div class="col-lg-4">

                <!-- Order mode settings -->
                <div class="card shadow mb-3">
                    <div class="card-body">

                        <div class="h5 mb-3">Order Mode: </div>

                        <form action="{{ url('/en/cart') }}" method="post" id="order-mode-selector-form">
                            @csrf

                            <input type="hidden" name="action" value="updateOrderMode">

                            <select class="form-select mb-3" name="mode" id="order-mode-selector">
                                <option value="pickup" {{ $cart->orderMode == 'pickup' ? " selected" : "" }}>
                                    Pick-up
                                </option>
                                <option value="delivery" {{ $cart->orderMode == 'delivery' ? " selected" : "" }}>
                                    Delivery (Within 5km from store)
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

                        <form action="{{ url('/en/cart') }}" method="post">
                            @csrf
                            <input type="hidden" name="action" value="updateCustomerData">
                            <input type="hidden" name="mode" value="pickup">

                            <div class="mb-3">
                                <label for="delivery_id" class="mb-2">Phone Number</label>
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

                            <button class="btn btn-primary w-100" type="submit">Save</button>

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

                        <form action="{{ url('/en/cart') }}" method="post">
                            @csrf
                            <input type="hidden" name="action" value="updateCustomerData">
                            <input type="hidden" name="mode" value="delivery">

                            <div class="mb-3">
                                <label for="name" class="mb-2">Name</label>
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


                            <div class="mb-3">
                                <label for="phone" class="mb-2">Phone</label>
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


                            <div class="mb-3">
                                <label for="addressLine1" class="mb-2">Address</label>
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
                            {{--                                                   placeholder="州属"/>--}}
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
                            {{--                                                   placeholder="地区/城市"/>--}}
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
                            {{--                                                   placeholder="邮政编号"/>--}}

                            {{--                                            @if ($errors->has('postal_code'))--}}
                            {{--                                                <div class="invalid-feedback">--}}
                            {{--                                                    <strong>{{ $errors->first('postal_code') }}</strong>--}}
                            {{--                                                </div>--}}
                            {{--                                            @endif--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}

                            <button class="btn btn-primary w-100" type="submit">Save</button>
                        </form>

                    </div>
                </div>
                <!-- Delivery -->

                <!-- Order summary -->
                <div class="card shadow mb-3">
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

                        <button class="btn btn-primary w-100" type="submit"
                                onclick="window.location.href = '{{ url('/en/check-out') }}'"
                                id="submit_btn" {{ $cart->canCheckOut ? "" : "disabled" }}>
                            Check Out
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
