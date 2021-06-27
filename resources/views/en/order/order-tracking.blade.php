@extends('en.layouts.app')

@section('content')
    <main class="container"> <!--put content-->

        <div class="row">

            <div class="col-sm-12 col-md-10 col-lg-8 offset-md-1 offset-lg-2"> <!-- content -->

                @if(isset($_GET['code']))
                    <div class="col-12">
                        <div class="alert alert-info" role="alert">
                            {{ $message }}
                            @if(isset($deliveryId))
                                <a href='#'>{{ $deliveryId }}</a>
                            @endif
                        </div>
                    </div>
                @endif


                <div class="col-12 mb-3">
                    <img src="{{ asset('img/order-tracking.jpg') }}" style="width: 100%;" />
                </div>

                <div class="col-12">
                    <form action="{{ url('/en/order-tracking') }}" method="get">
                        <div class="form-group">
                            <label for="order-id-input">Please enter the order code</label>
                            <input type="text"
                                   class="form-control form-control-lg"
                                   name="code" aria-describedby="code"
                                   value="{{ $_GET['code'] ?? "" }}"
                                   placeholder="e.g. ECOLLA01234567890123" required>
                            <small id="code" class="form-text text-muted">Order code can be found from the last order success page.</small>
                        </div>
                        <div class="text-center mb-3">
                            <button class="btn btn-primary" type="submit" style="width: 100px;">Track</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </main>
@endsection
