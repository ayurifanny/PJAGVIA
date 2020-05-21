@extends('layouts.app')

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

@section('navbar')
@if(auth()->user()->hasRole('customer'))
    <li class="nav-item">
        <a class="nav-link" href="/home">Request Meeting</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/history_meeting">History</a>
    </li>
@endif
@endsection

@section('content')
<div class="container">
    @if (auth()->user()->hasRole('customer')):
    <div class="row">
        <div class="col-sm">
            <div class="form-group">
                <label for="line-color-input">Set Line Color</label>
                <select id="line-color-input" class="form-control">
                    <option value="#000000">Black</option>
                    <option value="#FF0000">Red</option>
                    <option value="#00FF00">Green</option>
                    <option value="#0000FF">Blue</option>
                </select>
            </div>
        </div>
        <div class="col-sm">
            <div class="form-group">
                <label for="line-size-input">Set Line Size</label>
                <input class="form-control" type="number" value="5" id="line-size-input">
            </div>
        </div>

        <div class="col-sm">
            <button class="btn btn-dark" id="undo">Undo</button>
        </div>
        <div class="col-sm">

            <button class="btn btn-dark" id="redo">Redo</button>

        </div>
        <div class="col-sm">
            <button class="btn btn-dark" id="clear">Clear</button>
        </div>
    </div>
    @endif
    <div class="two-thirds column">
        <div id="sketchpad" style="position: relative;">
            <canvas id="canvas2" style="position: absolute; left: 0; top: 0; z-index: -1;"></canvas>
        </div>
        @if (auth()->user()->hasRole('customer')):
        <form method="POST" accept-charset="utf-8" name="form_remarks">
            <label for="remarks">Remarks:</label>
            <input type="text" name="remarks" id="remarks">
            <input type="button" class="btn btn-primary status" id="save-remarks" onClick="send_option(1)" value="save" />
        </form>
        
        <form method="POST" accept-charset="utf-8" name="form1">
            <input name="hidden_data" id='hidden_data' type="hidden" />
            <input type="button" class="btn btn-primary status" id="approve" value="approve" />
            <input type="button" class="btn btn-primary status" id="decline" value="decline" />
        </form>
        @else
        <h4>Customer Remarks:</h4>
        <p id="par-remarks"></p> 
        @endif
    </div>
    <button id="zoom-button">zoom</button>
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
        $.ajax({
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
                },
                error: function () {
                loading = false;
              }
            });
        return;
    }
    

    

    

    @endif
    $(document).ready(function () {
        var canvas = document.getElementById('canvas');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(".status").click(function () {
            var canvas = document.getElementById("canvas");
            context = canvas.getContext('2d');
            var dataURL = canvas.toDataURL("image/png");
            var txt = document.getElementById("remarks");
            var status = $(this).val();
            $.ajax({
                /* the route pointing to the post function */
                url: '/add_remarks',
                type: 'POST',
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
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    $(".writeinfo").append(data.msg);
                }
            });
        });

        $("#zoom-button").click(function () {
            
            if (canvas2.style.zIndex > 0) {
                canvas2.style.zIndex = -1;
                this.innerHTML="zoom";
            }
            else {
                canvas2.style.zIndex = 1;
                this.innerHTML="unzoom";
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
