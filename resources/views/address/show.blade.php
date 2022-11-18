@extends('address.layout')
 
@section('content')
<h2 class="subtitle has-text-centered mt-4"> 詳細</h2>
 
<div class="media-content column is-8 is-offset-2">
    <h3 class="has-text-weight-bold">郵便番号:</h3>
    <div class="box">
        <p>{{ $address->post_code }}</p>
    </div>
    <h3 class="has-text-weight-bold">住所:</h3>
    <div class="box">
        {{ $address->address }}
    </div>
    <div class="has-text-right">
        <a class="button is-info my-4 has-right" href="{{ route('address.index') }}"> 戻る</a>
    </div>
</div>
@endsection