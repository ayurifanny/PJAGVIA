@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/canvas.css') }}" rel="stylesheet">
@endsection

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
        var canvas = document.getElementById("canvas");
        pad.newRedraw(data.stroke);
    });

</script>

@endsection

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



        <div class="col-sm">
            <input type="button" class="btn btn-primary" id="uploadPicture" value="Save" />
        </div>
        <form method="post" accept-charset="utf-8" name="form1">
            <input name="hidden_data" id='hidden_data' type="hidden" />
        </form>
    </div>
    <div class="two-thirds column">
        <div id="sketchpad"></div>
        <em>Try resizing the window!</em>
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

    base_image.onload = function () {
        pad = new Sketchpad(el, {
            aspectRatio: this.width / this.height,
            width: this.width,
            height: this.height,
            image: this.src
        });
    }


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
        pad.undo();
    }
    document.getElementById('undo').onclick = undo;

    // redo
    function redo() {
        pad.redo();
    }
    document.getElementById('redo').onclick = redo;

    // clear
    function clear() {
        pad.clear();
    }
    document.getElementById('clear').onclick = clear;

    // resize
    window.onresize = function (e) {
        pad.resize(el.offsetWidth);
    }

    var canvas = document.getElementById('canvas');

    function calculateAspectRatioFit(srcWidth, srcHeight, maxWidth, maxHeight) {
        var ratio = Math.min(maxWidth / srcWidth, maxHeight / srcHeight);
        if (srcWidth > maxWidth || srcHeight > maxHeight) {
            return {
                width: srcWidth * ratio,
                height: srcHeight * ratio
            };
        } else {
            return {
                width: srcWidth,
                height: srcHeight
            };
        }
    }

    $(document).ready(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("#uploadPicture").click(function () {
            var canvas = document.getElementById("canvas");
            context = canvas.getContext('2d');
            var dataURL = canvas.toDataURL("image/png");
            $.ajax({
                /* the route pointing to the post function */
                url: '/save_picture',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    hidden_data: dataURL,
                    meeting_id: '{{ $pic->meeting_id }}',
                    file_name: '{{ $pic->photo }}'
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    $(".writeinfo").append(data.msg);
                }
            });
        });
    });

</script>
@endsection
