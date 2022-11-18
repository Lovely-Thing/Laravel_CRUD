 @extends('address.layout') @section('content')
<h2 class="subtitle has-text-centered mt-4">郵便番号新規登録ページ</h2>

@if ($errors->any() || session()->has('error'))
<article class="message is-danger">
    <div class="message-header">
        <p>エラー！！ 入力内容に問題がありました。
        </p>
    </div>
    <div class="message-body">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @if(session()->has('error')) 
            <ul class="alert alert-danger">
                <li>{{ session()->get('error') }}</li>
            </ul>
        @endif
    </div>
</article>
@endif

<div class="column is-8 is-offset-2">
    <form action="{{ route('address.store') }}" method="POST" id="register_form">
        @csrf
        <h3 class="has-text-weight-bold">郵便番号:</h3>
        <input class="input" type="text" name="post_code" value="{{ old('post_code') }}" placeholder="7830060"> 
        <div class="columns">
            <div class="column">
                <button type="submit" class="button is-success my-4" >登録</button>
            </div>
            <div class="has-text-right column">
                <a class="button is-info my-4" href="{{ route('address.index') }}"> 戻る</a>
            </div>
        </div>
    </form>
</div> 