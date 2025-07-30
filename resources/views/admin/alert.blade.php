@if(session()->has('dangnhaperror'))
    <div style="color: red; text-align: center">
        <a>
            {{session()->get('dangnhaperror') }}
        </a>
    </div>
@endif

@if(session()->has('testnull'))
    <div style="color: red; text-align: center">
        <a>
            {{session()->get('dangnhaperror') }}
        </a>
    </div>
@endif
