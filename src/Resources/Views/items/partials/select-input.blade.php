<div id="group-unidadMedida" class="form-group {{ $errors->has('unidadMedida') ? ' has-danger' : '' }}  ">

    <select style="width: 100% !important;"  class="form-control form-control-alternative" data-dropdown-parent="#modal-new-item"  name="unidadMedida" id="unidadMedida">
        <option disabled selected value> {{ __('Select')." ".__('Unidad Medida')}} </option>
        @foreach ($units as $key => $item)

            @if (is_array(__($item)))
                <option value="{{ $key }}">{{ $item }}</option>
            @else
                @if (old('unidadMedida')&&old('unidadMedida').""==$key."")
                    <option  selected value="{{ $key }}">{{ __($item) }}</option>
                @elseif (isset($value)&&trim(strtoupper($value.""))==trim(strtoupper($key."")))
                    <option  selected value="{{ $key }}">{{ __($item) }}</option>
                @elseif (app('request')->input('unidadMedida')&&strtoupper(app('request')->input('unidadMedida')."")==strtoupper($key.""))
                    <option  selected value="{{ $key }}">{{ __($item) }}</option>
                @else
                    <option value="{{ $key }}">{{ __($item) }}</option>
                @endif
            @endif
            
        @endforeach
    </select>

    @if ($errors->has('unidadMedida'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('unidadMedida') }}</strong>
        </span>
    @endif
</div>
