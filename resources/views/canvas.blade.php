@extends('layouts.app')

@section('styles')

@endsection
@section('navbar')
    @if (auth()->user()->hasRole('customer'))
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
    <div class="two-thirds column">
        <div id="sketchpad"></div>
        <em>Try resizing the window!</em>
    </div>
    <div class="one-third column">
    <label for="line-color-input">Set Line Color</label>
    <input class="u-full-width" type="text" value="#000000" id="line-color-input">
    <label for="line-size-input">Set Line Size</label>
    <input class="u-full-width" type="number" value="5" id="line-size-input">
    <div class="row">
    <div class="one-half column">
    <button class="u-full-width" id="undo">Undo</button>
    </div>
    <div class="one-half column">
    <button class="u-full-width" id="redo">Redo</button>
    </div>
    <button class="u-full-width" id="clear">Clear</button>
    </div>
    <div>
        <input type="button" onclick="uploadEx()" value="Upload" />
        <input type="button" onclick="drawagain()" value="Draw More" />
        
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
        base_image = new Image();
        base_image.src = 'ARG.jpg';
        
        base_image.onload = function() {
            var size = calculateAspectRatioFit(this.width, this.height, 1000,1000);
            pad = new Sketchpad(el, {
                aspectRatio: size.width/size.height,
                width: size.width, 
                height: size.height,
                image: 'ARG.jpg'});
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
        if (srcWidth > maxWidth || srcHeight > maxHeight ) {
            return { width: srcWidth*ratio, height: srcHeight*ratio };
        }
        else {
            return { width: srcWidth, height: srcHeight };
        }
    }

//     context = canvas.getContext('2d');

//     make_base();

// function make_base()
// {
//   base_image = new Image();
//   base_image.src = 'test.png';
//   base_image.onload = function(){
//     context.drawImage(base_image, 0, 0);
//   }
// }
</script>
@endsection