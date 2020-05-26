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
                            <div id="sketchpad" style="border: 1px solid black; display:inline-block;"></div>

                            <a href=#>or click here to upload your signature</a>

                            
                            <div class="mt-2 float-right">
                                <form method="POST" accept-charset="utf-8" name="form1">
                                    <input name="hidden_data" id='hidden_data' type="hidden" />
                                    <input type="button" class="btn btn-primary status_picture" id="approve" value="Save" />
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
            aspectRatio: this.width / this.height,
            width: 300,
            height: 300,
            enable_draw: true
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
</script>
@endsection