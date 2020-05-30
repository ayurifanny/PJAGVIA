@extends('layouts.app')

@section('navbar')
@if(auth()->user()->hasRole('customer'))
    <li class="nav-item mb-3">
        <a class="nav-link d-inline-block" href="/home"><i class="fas fa-calendar mr-2"></i>Request Inspection</a>
    </li>
    <li class="nav-item mb-3">
        <a class="nav-link d-inline-block" href="/history_meeting"><i class="fas fa-history mr-2"></i>History</a>
    </li>
@elseif(auth()->user()->hasRole('inspector'))
    <li class="nav-item mb-3">
        <a class="nav-link" href="/home"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a>
    </li>
    <li php class="nav-item mb-3">
        <a class="nav-link" href="/list_request"><i class="fas fa-list-ul mr-2"></i>List of Inspection Request</a>
    </li>
    <li class="nav-item mb-3">
        <a class="nav-link" href="/history_meeting"><i class="fas fa-history mr-2"></i>History</a>
    </li>
@endif
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 py-3">
            <button type="button" class="btn btn-primary mb-2"
                onClick="location.href='/download_pdf/{{ request()->route('id') }}'">
                Download
            </button>

            <div class="bg-white py-2 px-2 mt-2 mb-4">
                <div class="border border-secondary my-3 mx-2 px-2">
                    @include('pdf')
                </div>
            </div>

            <div class="ml-auto float-right">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Signature
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary" id="exampleModalLongTitle">Add Signature</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h4>Draw your signature</h4>
                            <div id="sketchpad" style="border: 1px solid black; width:466px; height:300px;">
                            </div>

                            <div class="row mt-3">
                                <div class="ml-auto float-right">
                                    <button class="btn btn-secondary mr-3" id="clear">Clear</button>
                                </div>
                            </div>

                                <form method="POST" accept-charset="utf-8" name="form1">
                                    <input name="hidden_data" id='hidden_data' type="hidden" />
                                        <h4 class="py-3">Change Name</h4>
                                        
                                        @if (auth()->user()->hasRole('customer'))
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-4 col-form-label">Name
                                                <span class="ml-3">:</span>
                                            </label>
                                            
                                            <div class="col-sm-8">
                                                <input type="text" name="change_name" class="form-control nameedit" placeholder="{{$report->customer_name}}">
                                            </div>
                                        </div>
        
                                        @elseif (auth()->user()->hasRole('inspector'))
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-4 col-form-label">Name 
                                                <span class="ml-3">:</span>
                                            </label>
                                            
                                            <div class="col-sm-8">
                                                <input id="change_name" name="name" type="text" class="form-control border-top-0 border-left-0 border-right-0" placeholder="{{$report->inspector_name}}">
                                            </div>
                                        </div>
                                        @endif
                                       
                                    
                                    <input type="button" class="btn btn-primary save_signature mr-3" id="approve"
                                        value="Save" />
                                </form>
                           

                            <!-- <div>
                                <h6>Or</h6>

                                <form method="POST" action="/upload_sign" id="upload" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="border border-custom mx-1 mb-3 p-1">
                                        <div class="input-group my-3">
                                            <input type="hidden" name="id"
                                                value={{ request()->route('id') }}>
                                            <input type="hidden" name="role"
                                                value={{ auth()->user()->getRoleNames()[0] }}>

                                            <label class="col-form-label text-md-right ml-3">
                                                Add Picture (.png):
                                            </label>

                                            <div class="col">
                                                <span class="btn btn-default btn-file">
                                                    <input id="file" name="file" type="file" class="file m5-5"
                                                        accept="image/*" data-show-upload="true"
                                                        data-show-caption="true">
                                                </span>
                                            </div>

                                            <div class="float-right mr-3">
                                                <button class="btn btn-success" type="submit">Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
 -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_script')
<script src="{{ asset('js/canvas.js') }}"></script>
<script>
    var el = document.getElementById('sketchpad');
    pad = new Sketchpad(el, {
        enable_draw: true,
        width: 466,
        height: 300
    });

    // clear
    function clear() {
        pad.clear();
    }
    $('#clear').off('click').on('click', clear);
    // document.getElementById('clear').onclick = clear;

    function toJSON() {}

    $(document).ready(function () {
        var canvas = document.getElementById('canvas');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(".save_signature").click(function () {
            var canvas = document.getElementById("canvas");
            context = canvas.getContext('2d');
            var dataURL = canvas.toDataURL("image/png");
            var name = document.getElementById("change_name");
            alert(name.value)
            $.ajax({
                /* the route pointing to the post function */
                url: '/save_sign',
                type: 'POST',
                async: false,
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    hidden_data: dataURL,
                    name: name.value,
                    role: '{{ auth()->user()->getRoleNames()[0] }}',
                    id: '{{ request()->route('id') }}',
                },
                dataType: 'JSON',
                success: function (data) {
                    window.location.href = '/report/' +
                        '{{ request()->route('id') }}'
                },
                error: function () {
                    alert('Something happened')
                }
                /* remind that 'data' is the response of the AjaxController */

            });
        });
    });

</script>
@endsection
