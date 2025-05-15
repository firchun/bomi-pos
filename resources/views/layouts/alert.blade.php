@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible show fade my-2 ">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            <p>{{ $message }}</p>
        </div>
    </div>
@endif
@if ($message = Session::get('danger'))
    <div class="alert alert-danger alert-dismissible show fade my-2">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            <p>{{ $message }}</p>
        </div>
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible show fade my-2">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            <p>{{ $message }}</p>
        </div>
    </div>
@endif
@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible show fade my-2">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            <p>{{ $message }}</p>
        </div>
    </div>
@endif
