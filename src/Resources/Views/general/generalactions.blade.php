<div class="col-4 text-right">
    @isset($action_link)
        <a href="{{ $action_link }}" class="btn btn-sm btn-primary">{{ __($action_name) }}</a>
    @endisset
    @isset($action_link2) 
            <a href="{{ $action_link2 }}" class="btn btn-sm btn-primary">{{ __($action_name2) }}</a>
    @endisset
    @isset($action_link3) 
            <a href="{{ $action_link3 }}" class="btn btn-sm btn-primary">{{ __($action_name3) }}</a>
    @endisset
    @isset($action_link4) 
            <a href="{{ $action_link4 }}" class="btn btn-sm btn-primary">{{ __($action_name4) }}</a>
    @endisset
    @isset($usefilter)
        <button id="show-hide-filters" class="btn btn-icon btn-1 btn-sm btn-outline-secondary" type="button">
            <span class="btn-inner--icon"><i id="button-filters" class="ni ni-bold-down"></i></span>
        </button>
    @endisset
</div>