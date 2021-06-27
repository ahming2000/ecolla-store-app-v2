@extends('ch.layouts.app')

@section('title')
    付款 | Ecolla e口乐
@endsection

@section('style')
    <style>
        div.payment-method.active {
            border: 2px solid #00BFFF;
        }

        .scrollable {
            white-space: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .scrollable div{
            display: inline-block;
        }
    </style>
@endsection

@section('content')
    <main class="container">

        <div class="row">

            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12">
                <div class="h1">付款</div>

                <div class="row">
                    {{--  TODO Create cart item preview --}}
                </div>

                <form action="{{ url('/ch/check-out') }}" method="post" enctype="multipart/form-data">

                    @csrf

                    <div class="row mb-3 px-3">
                        <div class="col-12 mb-2">
                            <input type="text" name="payment_method" id="selected-payment-method" value="tng" hidden/>
                            <label>请点击付款方式进行付款</label>
                        </div>

                        <div class="col-12 scrollable mb-3">

                            @foreach($payments as $payment)
                                <div class="rounded-3 bg-white me-2 payment-method {{ $payment['code'] == 'tng' ? "active" : "" }}">
                                    <input type="text" value="{{ $payment['code'] }}" hidden/>
                                    <img class="img-fluid" style="width: 100px"
                                         src="{{ asset('img/payment/icon/' . $payment['code'] . '.png') }}"
                                         alt="{{ $payment['name'] }}">
                                </div>
                            @endforeach

                        </div>

                        <div class="col-12 text-center">
                            <div class="h4" style="color: orange">
                                <strong>请在付款之后载图您的收据并上传！</strong>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <input type="file"
                               class="form-control {{ $errors->has('receipt_image') ? ' is-invalid' : '' }}"
                               name="receipt_image" id="receipt" aria-describedby="receiptHelp"
                               value="{{ old('receipt_image') ?? "" }}">
                        <label for="receipt" class="input-group-text">上传</label>
                        @if ($errors->has('receipt_image'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('receipt_image') }}</strong>
                            </div>
                        @endif
                    </div>

                    <small id="receiptHelp" class="form-text text-muted">
                        文件格式支持 ".jpg", ".jpeg", ".gif", ".png", ".bpm"<br>
                        文件大小支持少于5MB
                    </small>


                    <div class="text-center">
                        <button class="btn btn-primary px-5" type="submit">
                            提交
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </main>

@endsection

@section('script')
    <script>
        $(document).ready(function () {

            // For payment method select
            $(".payment-method").on("click", function () {
                $(".payment-method").removeClass('active');
                $(this).addClass('active');

                var method = $(this).children('input').val();
                $('#selected-payment-method').val(method);
                url = "{{ asset('img/payment')}}/qr/" + method.toLowerCase() + ".jpeg";
                window.open(url, 'Image', 'width=400px, height=400px, resizable=1');
            });

        });

        // Image file validater
        // Reference: https://stackoverflow.com/questions/4234589/validation-of-file-extension-before-uploading-file
        var validFileExtensions = [".jpg", ".jpeg", ".gif", ".png", "bpm"];
        var maxUploadSize = 5000000; // Unit in Bytes // 5MB
        function validateImage(fileInput) {

            if (fileInput.type == "file") {
                var fileName = fileInput.value;
                var fileSize = fileInput.files[0].size;

                if (fileName.length > 0) {

                    var extensionValid = false;
                    var sizeValid = false;

                    for (var j = 0; j < validFileExtensions.length; j++) {
                        var cur = validFileExtensions[j];
                        if (fileName.substr(fileName.length - cur.length, cur.length).toLowerCase() == cur.toLowerCase()) {
                            extensionValid = true;
                            break;
                        }
                    }

                    if (fileSize < maxUploadSize) {
                        sizeValid = true;
                    }

                    if (!extensionValid) {
                        alert("请上传格式正确的图像");
                        return false;
                    }

                    if (!sizeValid) {
                        alert("请上传少于5MB的图像文件");
                        return false;
                    }
                }
            }

            return true;
        }

        // Validate image extension before submit
        $("#receipt").on("change", function () {
            if (!validateImage(document.getElementById("receipt"))) {
                document.getElementById("receipt").value = ''; // Empty the file upload input if wrong extension
            }
        });

    </script>
@endsection
