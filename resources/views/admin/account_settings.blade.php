@extends('admin.layouts.master')
@section('title', 'Account Settings')

@section('page_css')
        <!-- telephone plugin -->
<link rel="stylesheet" href="{{ url('css/telephonePlugin/intlTelInput.css') }}">
<link rel="stylesheet" href="{{ url('admin/vendors/cropper/cropper.css') }}">

<style>
        .password-progress {
            margin-top: 10px;
            margin-bottom: 0;
        }
        #valid-msg{
            color: green;
        }
        #error-msg{
            color: red;
        }
        .intl-tel-input{
            width: 100%;
        }
    </style>
@stop
@section('content')


        <!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Account Settings</h3>
            </div>
        </div>
        @if(isset($errors))
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @endif
        @if(\Session::has('msg'))

        @endif
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <form id="update_profile_form" action="{{ route('user-profile-update') }}" class="form-horizontal form-label-left"  novalidate method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                            <span class="section">Edit Profile</span>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="3" data-validate-words="2" name="name" placeholder="both name(s) e.g Jon Doe" required="required" type="text" value="{{ $user_credentials->name }}">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" value="{{ $user_credentials->email }}">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Phone <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="number" id="phone_number" name="phone_number" required="required" class="form-control col-md-7 col-xs-12" value="{{ $user_credentials->phone }}">
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="save_pd_btn" type="submit" class="btn btn-success">Change Profile</button>
                                </div>
                            </div>
                        </form>


                        <form action="{{ route('password-change') }}" class="form-horizontal form-label-left" novalidate method="post" >
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                            <span class="section">Change Password</span>
                            <div class="item form-group">
                                <label for="password" class="control-label col-md-3">Old Password</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="password_old" type="password" name="password_old" data-validate-length="6,8" class="form-control col-md-7 col-xs-12" required="required">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="password" class="control-label col-md-3">Password</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="password" type="password" name="password" data-validate-length="6,8" class="form-control col-md-7 col-xs-12" required="required">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Repeat Password</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="password_confirmation" type="password" name="password_confirmation" data-validate-linked="password" class="form-control col-md-7 col-xs-12" required="required">
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="save_pw_btn" type="submit" class="btn btn-success">Change Password</button>
                                </div>
                            </div>
                        </form>
                        @if(Auth::user()->user_type == \App\Libraries\Enumerations\UserTypes::$TEACHER)
                        <form action="{{ route('signature_change') }}" class="form-horizontal form-label-left" novalidate method="post"  enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                            <span class="section">Signature Attach</span>
                            @if($user_signature)
                                <div class="form-group" id="signatureExists">
                                    <label class="col-md-3 col-sm-4 col-xs-4 f_label">Current Signature</label>
                                    <div class="col-md-5 col-sm-6 col-xs-8">
                                        <img src="{{ url($user_signature->file_path) }}" alt="current signature image" /> <br/>
                                        <a href="javascript:void(0)" id="resetSig"><i class="fa fa-refresh"></i> Reset Signature</a>
                                    </div>
                                </div>
                            @endif
                            <div class="item form-group">
                                <label id="sigLabel" class="col-md-3 col-sm-4 col-xs-4 f_label" @if($user_signature)style="display: none"@endif>Signature</label>
                                <div class="col-md-6 col-sm-6 col-xs-8" id="signatureField">
                                    @if(!$user_signature)
                                        <div class="sigPad">
                                            <ul class="sigNav">
                                                <li>Draw your signature</li>
                                                <li class="clearButton"><a href="#clear">Clear</a></li>
                                            </ul>
                                            <div class="sig sigWrapper">
                                                <canvas class="pad" width="439" height="90"></canvas>
                                                <input type="hidden" name="signature" class="output">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="save_pw_btn" type="submit" class="btn btn-success">Change Signature</button>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
            </div>
        </div>
    </div>
</div>

<!-- /page content -->
    <!-- crop image -->
    <div class="modal fade" id="modalChangePicture" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button id="modal_close" type="button" class="close" data-dismiss="modal">x</button>
                    <h4 class="modal-title">Upload image</h4>
                </div>
                <form action="">
                    <div class="modal-body">
                        <div class="col-md-12" id="upImage" style="text-align: center;">
                            <div id="image-div1">
                                <img id="image_upload" src="" style="width: 100%;" alt="..." style='display: none;'>
                            </div>
                            <img id="imageCropped" src="" style="display: none; width:100%;">
                            <br>
                            <br>
                            <a href="javascript:void(0)" id="change_picture" class="btn btn-primary" style="display: none;">Change</a>
                            <div class="btn-group-horizontal">
                                <a href="javascript:void(0)" id="back" class="btn btn-primary" style="display: none;">Back</a>
                                <a href="javascript:void(0)" id="save" class="btn btn-primary" style="display: none;">Save</a>
                                <a href="javascript:void(0)" id="discard" class="btn btn-primary" style="display: none;">Cancel</a>
                                <input type='button' id='getCroppedImage' class="btn btn-primary" value='Get cropped area' >
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="file" id="imageFile" name="photo" style="display: none;">
                            <br>
                            <div class="progress" style="display: none;">
                                <div id="progressBar" class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
        <!-- telephone plugin -->
<script src="{{ asset('js/telephonePlugin/intlTelInput.min.js') }} "></script>
<script>
    
</script>
        <!-- validator -->
{{--<script src="{{ url('admin/vendors/validator/validator.js') }} "></script>--}}
<script src="{{ url('admin/vendors/cropper/cropper.min.js') }}"></script>
<script>
        $(document).ready(function(){
            var cropper;
            var div2Width;
            var imageWidth;
            $("#change_picture").click(function()
            {
                $( "#imageFile" ).click();
            });
            $("#picture_change").click(function()
            {
                $( "#imageFile" ).click();
            });
            $( "#imageFile" ).change(function()
            {
                console.log('cropper created');
                var _URL = window.URL || window.webkitURL;
                img = new Image();
                img.onerror = function() { alert('Please chose an image file!'); };
                img.onload = function () {

                    var imageWidth = this.width;
                    $("#imageCropped").hide();
                    $('#image_upload').attr('src',this.src);
                    $("#image-div1").show();
                    $("#change_picture").hide();
                    $("#back").hide();
                    $("#save").hide();
                    $("#discard").show();
                    $("#getCroppedImage").show();
                    $('#modalChangePicture').modal('show');
                };
                img.src = _URL.createObjectURL(this.files[0]);
            });

            $("#getCroppedImage").click(function(){
                var imageSrc = cropper.getCroppedCanvas().toDataURL('image/jpeg');
                $("#image-div1").hide();
                $("#imageCropped").show();
                $("#imageCropped").attr('src', imageSrc );
                $("#save").show();
                $("#discard").show();
                $("#back").show();
                $("#change_picture").hide();
                $("#getCroppedImage").hide();
            });

            $( "#save" ).click(function()
            {
                $(".progress").show();
                var adminnId = {{ Auth::user()->id }};

                var img = document.getElementById('imageFile');

                var cropedImg = $('#imageCropped').attr('src');

                $('#base_image').attr('src',cropedImg);
                var CSRF_TOKEN = "{{ csrf_token() }}";
                var data = new FormData();
                data.append('file', img.files[0]);
                data.append('cropedImageContent', cropedImg);
                data.append('adminId', adminnId);
                data.append('_token', CSRF_TOKEN);


                var Url = "{{ route('user_image_upload') }}";

                var xhr = new XMLHttpRequest();
                xhr.upload.addEventListener('progress',function(ev){
                    var progress = parseInt(ev.loaded / ev.total * 100);
                    $('#progressBar').css('width', progress + '%');
                    $('#progressBar').html(progress + '%');
                }, false);
                xhr.onreadystatechange = function(ev)
                {
                    console.log(xhr.readyState);
                    if(xhr.readyState == 4){
                        if(xhr.status = '200')
                        {
                            $("#imageCropped").hide();
                            $(".progress").hide();
                            $("#save").hide();
                            $("#back").hide();
                            $("#discard").hide();
                            $("#getCroppedImage").hide();
                            $('#progressBar').css('width','0' + '%');
                            $('#progressBar').html('0' + '%');
                            $('#modalChangePicture').modal('hide');
                        }
                    }
                };

                xhr.open('POST', Url , true);
                xhr.send(data);
                return false;
            });

            $( "#back" ).click(function()
            {
                $("#image-div1").show();
                $("#imageCropped").hide();
                $("#discard").show();
                $("#getCroppedImage").show();
                $("#save").hide();
                $("#back").hide();
                $("#change_picture").hide();
            });

            $( "#discard" ).click(function()
            {
                $('#modalChangePicture').modal('hide');
            });

            $("#modalChangePicture").on('hidden.bs.modal', function () {
                console.log('hide modal');
                cropper.destroy();
                $("#imageFile").val("");
            });

            $('#modalChangePicture').on('shown.bs.modal', function() {
                var div2Width = $("#upImage").width();
                if (this.width<div2Width)
                {
                    document.getElementById('image-div1').style.width = this.width;
                }
                var image = document.getElementById('image_upload');

                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    crop: function(e) {
                        console.log(e.detail.x);
                        console.log(e.detail.y);
                        console.log(e.detail.width);
                        console.log(e.detail.height);
                        console.log(e.detail.rotate);
                        console.log(e.detail.scaleX);
                        console.log(e.detail.scaleY);
                    }
                });
            });
        });
    </script>
    <script src="{{ url('js/SignaturePad/jquery.signaturepad.min.js')}}"></script>
    <script src="{{ url('js/SignaturePad/json2.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.sigPad').signaturePad({
                drawOnly: true,
                lineTop: 85
            });

            $('#resetSig').click(function() {
                var markup = "<div class='sigPad'>";
                markup += "<ul class=\"sigNav\"><li class=\"drawIt\"><a href=\"#draw-it\">Draw Your Signature</a></li><li class=\"clearButton\"><a href=\"#clear\">Clear</a></li></ul>";
                markup += "<div class=\"sig sigWrapper\"><div class=\"typed\"></div><canvas class=\"pad\" width=\"439\" height=\"90\"></canvas><input type=\"hidden\" name=\"signature\" class=\"output\"></div></div>";
                $('#signatureField').html(markup);
                $('#sigLabel').css('display', 'block');
                $('.sigPad').signaturePad({
                    drawOnly: true,
                    lineTop: 85
                });
                $('#signatureExists').css('display', 'none');
            });
        });

    </script>

@stop