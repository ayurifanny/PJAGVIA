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
    <li class="nav-item mb-3">
        <a class="nav-link" href="/home"><i class="fas fa-list-ul mr-2"></i>List of Inspection Request</a>
    </li>
    <li class="nav-item mb-3">
        <a class="nav-link" href="/history_meeting"><i class="fas fa-history mr-2"></i>History</a>
    </li>
@endif
@endsection


@section('styles')
<link href="{{ asset('css/canvas.css') }}" rel="stylesheet">
@endsection

@if (auth()->user()->hasRole('inspector'))
@section('scripts')
<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: 'ap1'
    });
    var channel = pusher.subscribe('channel-' + '{{request()->route("id")}}');
    channel.bind('my-event', function (data) {
        // alert(JSON.stringify(data));
        if (data.stroke !== null) {
            var canvas = document.getElementById("canvas");
            pad.newRedraw(data.stroke);
        }
        if (data.option !== null) {
            if (data.option == "undo"){
                pad.undo();
            }
            else if (data.option == "redo") {
                pad.redo();
            }
            else if(data.option == "clear") {
                pad.clear();
            }
            else {
                var remarks = document.getElementById("par-remarks");
                remarks.innerHTML = data.option;
            }
        }
    });

</script>

@endsection
@endif


@section('content')
<div class="container">
    @if(auth()->user()->hasRole('customer'))
    <div class="row menu-canvas mx-1 my-2 py-3">
        <div class="pr-3 border-right">
            <button type="button" class="btn btn-light" id="undo" data-toggle="tooltip" data-placement="bottom" title="Undo">
                <i class='fas fa-undo-alt'></i>
            </button>
        
            <button class="btn btn-light" id="redo" data-toggle="tooltip" data-placement="bottom" title="Redo">
                <i class='fas fa-redo-alt'></i>
            </button>
        </div>

        <div class="px-3 border-right">
            <button type="button" class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="Zoom In" id="zoom-button">
                <i class='fas fa-search-plus' id="activeLine"></i>
                <i class='fas fa-pencil-alt' id="activeZoom"></i>
            </button>
        </div>

        <div class="px-3 border-right">
            <select id="line-color-input" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Line Color">
                <option value="#000000">Black</option>
                <option value="#FF0000">Red</option>
                <option value="#00FF00">Green</option>
                <option value="#0000FF">Blue</option>
            </select>
        </div>

        <div class="pl-3">
            <input class="form-control col-md-4" type="number" value="5" id="line-size-input" data-toggle="tooltip" data-placement="bottom" title="Line Size">
        </div>

        <div class="ml-auto float-right">
            <button class="btn btn-secondary mr-3" id="clear">Clear</button>
        
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
           Done
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="exampleModalLongTitle">Confirm photo status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-dark">Approve this photo for inspection?</p>
                        <div class="mt-2 float-right">
                            <form method="POST" accept-charset="utf-8" name="form1">
                                <input name="hidden_data" id='hidden_data' type="hidden" />
                                <input type="button" class="btn btn-secondary mr-2 status_picture" id="decline" value="Decline" />
                                <input type="button" class="btn btn-primary status_picture" id="approve" value="Approve" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row justify-content-center my-4">
        <div class="col-md-11">
            <div class="row border border-custom p-1">
                <h5 class="pr-2">Customer Remarks : </h5>
                <span id="par-remarks">{{$pic->remarks}}</span>
            </div>
        </div>
    </div>
    @endif

    <div>
        <div id="sketchpad" class="text-center pt-2" style="position: relative;">
            <canvas id="canvas2" class="img-fluid" style="position: absolute; top: 1; z-index: -1;"></canvas>
        </div>

        <div class="py-3">
            @if (auth()->user()->hasRole('customer'))
            <form method="POST" accept-charset="utf-8" name="form_remarks">
                <div class="row justify-content-center">    
                    <div class="col-md-9">
                        <div class="form-group row">
                            <label for="remarks" class="col-form-label text-md-right">
                                Remarks:
                            </label>

                            <div class="col">
                                <input type="text" class="form-control mr-5" row="2" name="remarks" id="remarks" value="{{$pic->remarks}}">
                            </div>

                            <div class="float-right">
                                <input type="button" class="btn btn-primary status" id="save-remarks" onClick="send_option(1)" value="Send" />
                                <span id="alertSuccess" class="valid-feedback ml-3" role="alert">
                                    <strong>Sent!! </strong>
                                </span>
                                <span id="alertFailed" class="invalid-feedback ml-3" role="alert">
                                    <strong>Failed!!</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
    
</div>
@endsection

@section('additional_script')
<script src="{{ asset('js/canvas.js') }}"></script>
<script>
    var el = document.getElementById('sketchpad');
    base_image = new Image();
    base_image.src =
        '{{ "/storage/" . $pic->meeting_id . "/" . $pic->photo }}';
    var x = {!!$pic->drawings!!}
    base_image.onload = function () {
        @if (auth()->user()->hasRole('customer'))
        pad = new Sketchpad(el, {
            aspectRatio: this.width / this.height,
            width: this.width,
            height: this.height,
            image: this.src,
            enable_draw: true,
            data: x
        });
        @else
        pad = new Sketchpad(el, {
            aspectRatio: this.width / this.height,
            width: this.width,
            height: this.height,
            image: this.src,
            enable_draw: false,
            data: x
        });
        @endif

    }

    @if (auth()->user()->hasRole('customer'))
    function setLineColor(e) {
        var color = e.target.value;
        if (!color.startsWith('#')) {
            color = '#' + color;
        }
        pad.setLineColor(color);
    }
    document.getElementById('line-color-input').oninput = setLineColor;

    // setLineSize
    function setLineSize(e) {
        var size = e.target.value;
        pad.setLineSize(size);
    }
    document.getElementById('line-size-input').oninput = setLineSize;

    // undo
    function undo() {
        send_option(2)
        pad.undo();
    }
    $('#undo').off('click').on('click', undo);
    // document.getElementById('undo').onclick = undo;

    // redo
    function redo() {
        send_option(3)
        pad.redo();
    }
    $('#redo').off('click').on('click', redo);
    // document.getElementById('redo').onclick = redo;

    // clear
    function clear() {
        send_option(4)
        pad.clear();
    }
    $('#clear').off('click').on('click', clear);
    // document.getElementById('clear').onclick = clear;

    function toJSON() {
        var json_data = pad.toJSON();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
                /* the route pointing to the post function */
                url: '/add_drawing',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    drawing: json_data,
                    id: '{{ request()->route('id') }}'
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    $(".writeinfo").append(data.msg);
                }
            });
    }
    function send_option(data) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var remarks = document.getElementById("remarks");
        var opts
        if (data == 1) {
            opts = remarks.value  
        }
        else if (data == 2) {
            opts = "undo"
        }
        else if (data == 3) {
            opts = "redo"
        }
        else if (data == 4) {
            opts = "clear"
        }
        $.ajax(
            {
                /* the route pointing to the post function */
                url: '/canvas_option',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    option: opts,
                    id: '{{ request()->route('id') }}'
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    $(".writeinfo").append(data.msg);
                    loading = false;
                    $("#alertFailed").fadeTo(2000, 500).slideUp(0, function(){
                        $("#alertFailed").alert('close');
                    });
                },
                error: function () {
                    loading = false;
                    $("#alertSuccess").fadeTo(2000, 500).slideUp(0, function(){
                        $("#alertSuccess").alert('close');
                    });
                }
            });
        return;
    }
    @endif

    $(document).ready(function () {
        var canvas = document.getElementById('canvas');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(".status_picture").click(function () {
            var canvas = document.getElementById("canvas");
            context = canvas.getContext('2d');
            var dataURL = canvas.toDataURL("image/png");
            var txt = document.getElementById("remarks");
            var status = $(this).val();
            $.ajax({
                /* the route pointing to the post function */
                url: '/add_remarks',
                type: 'POST',
                async: false,
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    hidden_data: dataURL,
                    meeting_id: '{{ $pic->meeting_id }}',
                    file_name: '{{ $pic->photo }}',
                    remarks:txt.value,
                    status:status,
                },
                dataType: 'JSON',
                success: function (data) {
                    window.location.href = '/meetings/detail/'+'{{$pic->meeting_id}}'
                },
                error: function () {
                    alert('Something happened')
              }
                /* remind that 'data' is the response of the AjaxController */
                
            });
        });

        $("#zoom-button").click(function () { 
            if (canvas2.style.zIndex > 0) {
                canvas2.style.zIndex = -1;
                $("#activeLine").show();
                $("#activeZoom").hide();
                // $(this).find("i").removeClass("fas fa-pencil-alt").addClass("fas fa-search-plus");
            }
            else {
                canvas2.style.zIndex = 1;
                // this.innerHTML="unzoom";
                $("#activeLine").hide();
                $("#activeZoom").show();
            } 
        });
    });

</script>

<script>
    // variables
var canvas2, ctx;
var image;
var iMouseX, iMouseY = 1;
var bMouseDown = false;
var iZoomRadius = 100;
var iZoomPower = 2;



// drawing functions
function clear() { 
    canvas2 = document.getElementById('canvas2');
    canvas2.setAttribute('width', pad.canvas.width);
    canvas2.setAttribute('height', pad.canvas.height);
    ctx = canvas2.getContext('2d');
// clear canvas function
    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
}

function drawScene() { // main drawScene function
    clear(); // clear canvas

    if (bMouseDown) { // drawing zoom area
        ctx.drawImage(pad.canvas, 0 - iMouseX * (iZoomPower - 1), 0 - iMouseY * (iZoomPower - 1), ctx.canvas.width * iZoomPower, ctx.canvas.height * iZoomPower);
        ctx.globalCompositeOperation = 'destination-atop';

        var oGrd = ctx.createRadialGradient(iMouseX, iMouseY, 0, iMouseX, iMouseY, iZoomRadius);
        oGrd.addColorStop(0.8, "rgba(0, 0, 0, 1.0)");
        oGrd.addColorStop(1.0, "rgba(0, 0, 0, 0.1)");
        ctx.fillStyle = oGrd;
        ctx.beginPath();
        ctx.arc(iMouseX, iMouseY, iZoomRadius, 0, Math.PI*2, true); 
        ctx.closePath();
        ctx.fill();
    }
}

$(function(){
    // loading source image
    image = new Image();
    image.onload = function () {
    }
    image.src = '{{ "/storage/" . $pic->meeting_id . "/" . $pic->photo }}';;


    $('#sketchpad').mousemove(function(e) {
         // mouse move handler
        var canvasOffset = $(canvas2).offset();
        iMouseX = Math.floor(e.pageX - canvasOffset.left);
        iMouseY = Math.floor(e.pageY - canvasOffset.top);
    });

    $('#sketchpad').mousedown(function(e) { // binding mousedown event
        bMouseDown = true;
    });

    $('#sketchpad').mouseup(function(e) { // binding mouseup event
        bMouseDown = false;
    });

    setInterval(drawScene, 30); // loop drawScene
});
</script>
@endsection
