@extends('ch.layouts.customer')

@section('title')
    结账 | Ecolla e口乐
@endsection

@section('extraStyle')
    <style>
        .receipt-image {
            height: 40px;
            width: 100%;
        }

        .item_txt1 {
            font-size: 12px;
        }


        .item_txt2 {
            font-size: 12px;
        }

        /* for xiao ji, total amount */
        .item_txt3 {
            font-size: 15px;
        }

        .cl1 {
            width: 10%;
        }

        .cl2 {
            width: 20%;
        }

        .cl3 {
            width: 5%;
        }

        .cl4 {
            width: 15%;
        }

        .cl11 {
            width: 25%;
        }

        .cl12 {
            width: 20%;
        }

        .img-payment {
            width: 30%;
        }

        @media only screen and (min-width: 600px) {
            .receipt-image {
                height: 80px;
                width: 100%;
            }

            .item_txt1 {
                font-size: 20px;
            }


            .item_txt2 {
                font-size: 20px;
            }

            /* for xiao ji, total amount */
            .item_txt3 {
                font-size: 24px;
            }

            .img-fluid {
                height: 180px;
                width: 180px;
            }
        }
    </style>
@endsection

@section('content')
    <main class="container">

        <div class="row">

            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12">
                <div class="h1">结账界面</div>

                <!-- Order preview -->

                <form action="/check-out" method="post" enctype="multipart/form-data">

                    @csrf

                    <div class="form-row mb-3 p-3">
                        <div class="col-12">
                            <div class="row mb-3">
                                <input type="text" name="payment_method" id="selected-payment-method" value="TnG"
                                       hidden/>
                                <div class="col-12"><label><strong>请点击付款方式进行付款</strong></label></div>
                                <div
                                    class="d-flex justify-content-center align-items-center img-payment view zoom payment-method active">
                                    <input type="text" value="TnG" hidden/>
                                    <img class="img-fluid" src="{{ asset('img/payment/tng.png') }}" alt="image">
                                </div>
                                <div
                                    class="d-flex justify-content-center align-items-center img-payment view zoom payment-method">
                                    <input type="text" value="Boost" hidden/>
                                    <img class="img-fluid" src="{{ asset('img/payment/boost.png') }}" alt="image">
                                </div>
                                <div
                                    class="d-flex justify-content-center align-items-center img-payment view zoom payment-method">
                                    <input type="text" value="Bank Transfer" hidden/>
                                    <img class="img-fluid" src="{{ asset('img/payment/bank-transfer.png') }}"
                                         alt="image">
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-12"><span class="orange-text" style="font-size: 25px;"><strong>请在付款之后载图您的收据并上传！</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="first_name">收货人名字（英语）</label>
                        <input type="text"
                               class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                               name="first_name"
                               id="first_name"
                               value="{{ old('first_name') ?? "" }}"
                               placeholder="请输入可辨识的姓名"/>
                        @if ($errors->has('first_name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </div>
                        @endif
                    </div>


                    <div class="form-group">
                        <label for="phone">电话号码</label>
                        <input type="text"
                               class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                               name="phone"
                               id="phone"
                               value="{{ old('phone') ?? "" }}"
                               placeholder="电话号码">
                        @if ($errors->has('phone'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </div>
                        @endif
                    </div>


                    <div class="form-group">
                        <label for="addressLine1">地址</label>
                        <input type="text"
                               name="addressLine1"
                               class="form-control{{ $errors->has('addressLine1') ? ' is-invalid' : '' }}"
                               value="{{ old('addressLine1') ?? "" }}"
                               placeholder="门牌/路名"/>
                        @if ($errors->has('addressLine1'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('addressLine1') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <input type="text"
                                       name="state"
                                       class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}"
                                       value="{{ old('state') ?? "" }}"
                                       placeholder="州属"/>
                                @if ($errors->has('state'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <input type="text" name="area"
                                       class="form-control{{ $errors->has('area') ? ' is-invalid' : '' }}"
                                       value="{{ old('area') ?? "" }}"
                                       placeholder="地区/城市"/>
                                @if ($errors->has('area'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('area') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <input type="text" name="postal_code"
                                       class="form-control{{ $errors->has('postal_code') ? ' is-invalid' : '' }}"
                                       value="{{ old('postal_code') ?? "" }}"
                                       placeholder="邮政编号"/>

                                @if ($errors->has('postal_code'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('postal_code') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label>上传收据</label>
                        <div class="custom-file">
                            <input type="file"
                                   class="custom-file-input{{ $errors->has('receipt_image') ? ' is-invalid' : '' }}"
                                   name="receipt_image" id="receipt" aria-describedby="receiptHelp"
                                   value="{{ old('receipt_image') ?? "" }}">
                            <label class="custom-file-label" for="receipt" data-browse="上传">请上传您的收据</label>
                            @if ($errors->has('receipt_image'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('receipt_image') }}</strong>
                                </div>
                            @endif
                            <small id="receiptHelp" class="form-text text-muted">文件格式支持 ".jpg", ".jpeg", ".gif",
                                ".png"<br>文件大小支持少于5MB</small>

                        </div>
                    </div>


                    <div class="text-center">
                        <input class="btn btn-primary"
                               type="submit" value="提交" name="submit"
                               style="width: 200px;"/>
                    </div>

                </form>
            </div>

        </div>


    </main>

    <script>
        $(document).ready(function () {
            bsCustomFileInput.init(); //For uploaded file name to show

            // For payment method select
            $(".payment-method").on("click", function () {
                $(".payment-method").removeClass('active');
                $(this).addClass('active');

                var method = $(this).children('input').val();
                $('#selected-payment-method').val(method);
                url = "assets/images/payment/pay_" + method.toLowerCase() + ".png";
                window.open(url, 'Image', 'width=400px, height=400px, resizable=1');
            });

            //add phone number mmc
            addPhoneMCC("+60");
            addPhoneMCC("+65");

        });

        function addPhoneMCC(option) {
            let str =
                `
                <option value="${option}">
                    ${option}
                </option>
            `;
            $("#c-phone-mcc").append(str);
        }

        // Image file validater
        // Reference: https://stackoverflow.com/questions/4234589/validation-of-file-extension-before-uploading-file
        var validFileExtensions = [".jpg", ".jpeg", ".gif", ".png"];
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
