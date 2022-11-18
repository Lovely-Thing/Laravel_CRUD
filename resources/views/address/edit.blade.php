
@extends('address.layout')
 
 @section('content')
 <h2 class="subtitle has-text-centered mt-4">編集</h2>
  
 @if ($errors->any()) 
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
  
 <form class="column is-8 is-offset-2" action="{{ route('address.update',$address->id) }}" method="POST">
     @csrf
     @method('PUT')
     <h3 class="has-text-weight-bold">郵便番号:</h3>
     <input class="input" type="text" name="post_code" value="{{ old('post_code', $address->post_code) }}" placeholder="7830060">      
     <div class="columns">
         <div class="column">
             <button type="submit" class="button is-success my-4">送信</button>
         </div>
         <div class="has-text-right column">
             <a class="button is-info my-4" href="{{ route('address.index') }}"> 戻る</a>
         </div>
     </div>
 </form>
 @endsection