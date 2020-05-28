@extends('layouts.app')

@section('navbar')
    @if (auth()->user()->hasRole('customer'))
      <li class="nav-item mb-3">
        <a class="nav-link d-inline-block" href="/home"><i class="fas fa-calendar mr-2"></i>Request Inspection</a>
      </li>
      <li class="nav-item mb-3">
        <a class="nav-link d-inline-block" href="/history_meeting"><i class="fas fa-history mr-2"></i>History</a>
      </li>
    @elseif (auth()->user()->hasRole('inspector'))
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
            ha hao
            @include('pdf')
            <div class="ml-auto float-right">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
               Signature
                </button>
            </div>
    
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                            <div id="sketchpad" style="border: 1px solid black; width:466px; height:300px;"></div>
                            <div class="mt-2 float-right">
                                <form method="POST" accept-charset="utf-8" name="form1">
                                    <input name="hidden_data" id='hidden_data' type="hidden" />
                                    <input type="button" class="btn btn-primary save_signature" id="approve" value="Save" />
                                </form>
                            </div>
                            <div><h6>Or</h6></div>
                            <div>
                                <form method="POST" action="/upload_sign" id="upload" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="border border-custom mx-1 mb-3 p-1">
                                    <div class="input-group my-3">
                                        <input type="hidden" name="id" value={{ request()->route('id') }}>
                                        <input type="hidden" name="role" value={{ auth()->user()->getRoleNames()[0] }}>
                                        
                                        <label class="col-form-label text-md-right ml-3">
                                            Add Picture (.png):
                                        </label>
                                        
                                        <div class="col">
                                            <span class="btn btn-default btn-file">
                                                <input id="file" name="file" type="file" class="file m5-5" accept="image/*" data-show-upload="true" data-show-caption="true">
                                            </span>
                                        </div>
                                        
                                        <div class="float-right mr-3">
                                            <button class="btn btn-success" type="submit">Upload</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            </div>
                            
                            
                            
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
    
    function setLineColor(e) {
        var color = e.target.value;
        if (!color.startsWith('#')) {
            color = '#' + color;
        }
        pad.setLineColor(color);
    }
    // document.getElementById('line-color-input').oninput = setLineColor;

    // setLineSize
    function setLineSize(e) {
        var size = e.target.value;
        pad.setLineSize(size);
    }
    // document.getElementById('line-size-input').oninput = setLineSize;

    // undo
    function undo() {
        send_option(2)
        pad.undo();
    }
    // $('#undo').off('click').on('click', undo);
    // document.getElementById('undo').onclick = undo;

    // redo
    function redo() {
        send_option(3)
        pad.redo();
    }
    // $('#redo').off('click').on('click', redo);
    // document.getElementById('redo').onclick = redo;

    // clear
    function clear() {
        send_option(4)
        pad.clear();
    }
    // $('#clear').off('click').on('click', clear);
    // document.getElementById('clear').onclick = clear;
    
    function toJSON() {
    }

    $(document).ready(function () {
        var canvas = document.getElementById('canvas');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(".save_signature").click(function () {
            var canvas = document.getElementById("canvas");
            context = canvas.getContext('2d');
            var dataURL = canvas.toDataURL("image/png");
            var status = $(this).val();
            $.ajax({
                /* the route pointing to the post function */
                url: '/save_sign',
                type: 'POST',
                async: false,
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    hidden_data: dataURL,
                    role: '{{ auth()->user()->getRoleNames()[0] }}',
                    id: '{{ request()->route('id') }}',
                },
                dataType: 'JSON',
                success: function (data) {
                    window.location.href = '/report/'+'{{request()->route('id')}}'
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