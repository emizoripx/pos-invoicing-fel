<div id="group-{{ $id }}" class="form-group {{ $errors->has($id) ? ' has-danger' : '' }}  ">

    <select style="width: 100% !important;"  class="form-control form-control-alternative" data-dropdown-parent="#modal-new-item"  name="{{ $id }}" id="{{ $id }}">
        <option disabled selected value> {{ __('Select')." ".__($placeholder)}} </option>
        @foreach ($data as $key => $item)

            @if (is_array(__($item)))
                <option value="{{ $key }}">{{ $item }}</option>
            @else
                @if (old($id)&&old($id).""==$key."")
                    <option  selected value="{{ $key }}">{{ __($item) }}</option>
                @elseif (isset($value)&&trim(strtoupper($value.""))==trim(strtoupper($key."")))
                    <option  selected value="{{ $key }}">{{ __($item) }}</option>
                @elseif (app('request')->input($id)&&strtoupper(app('request')->input($id)."")==strtoupper($key.""))
                    <option  selected value="{{ $key }}">{{ __($item) }}</option>
                @else
                    <option value="{{ $key }}">{{ __($item) }}</option>
                @endif
            @endif
            
        @endforeach
    </select>

    @if ($errors->has($id))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($id) }}</strong>
        </span>
    @endif
</div>
