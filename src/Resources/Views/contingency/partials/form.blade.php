@extends('posinvoicingfel::general.partials.card', ['action_link' => $setup['action_link'], 'action_name' => $setup['action_name'] ])
@section('card_content')
    <form action="{{ $setup['action'] }}" method="POST" enctype="multipart/form-data">
            @csrf
            @isset($setup['isupdate'])
                @method('PUT')
            @endisset
            <div class="row">
                @foreach($fields_row as $field)
                    @include('posinvoicingfel::general.partials.fields',$field)
                @endforeach
            </div>
            @if (isset($setup['isupdate']))
                <button type="submit" class="btn btn-primary">{{ __('Update')}}</button>  
            @else
                <button type="submit" class="btn btn-primary">{{ __('Save')}}</button>  
            @endif
    </form>
@endsection