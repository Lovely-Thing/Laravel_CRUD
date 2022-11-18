
@extends('address.layout')
 
 @section('content')
 <h2 class="subtitle has-text-centered mt-4">住所管理</h2>
  
 @if ($message = Session::get('success'))
 <article class="message is-success">
     <div class="message-header">
         <p>Success</p>
     </div>
     <div class="message-body">
         <p>{{ $message }}</p>
     </div>
 </article>
 @endif
 @if ($message = Session::get('error'))
 <article class="message is-danger">
     <div class="message-header">
         <p>Error</p>
     </div>
     <div class="message-body">
         <p>{{ $message }}</p>
     </div>
 </article>
 @endif
 <div class="column is-8 is-offset-2">
     <a class="button is-primary my-4 is-fullwidth" href="{{ route('address.create') }}"> 新規作成</a> 
     <table class="table is-bordered is-striped has-text-centered is-fullwidth">
         <tr>
             <th>ID</th>
             <th>郵便番号</th>
             <th>住所</th>
             <td></td>
         </tr>
         @foreach ($addressList as $address)
         <tr>
             <td>{{ $address->id }}</td>
             <td>{{ $address->post_code }}</td>
             <td>{{ $address->address }}</td>             
             <td>
                 <form action="{{ route('address.destroy',$address->id) }}" method="POST">
                     <a class="button is-info" href="{{ route('address.show',$address->id) }}">詳細を表示</a>
                     <a class="button is-success" href="{{ route('address.edit',$address->id) }}">編集</a>
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="button is-danger">削除</button>
                 </form>
             </td>
         </tr>         
         @endforeach 
     </table> 
     <?php 
        $link_limit = 8; 
     ?>
     @if ($addressList->lastPage() > 1)
     <nav class="pagination is-rounded" role="navigation" aria-label="pagination">
        <a class="pagination-previous {{ ($addressList->currentPage() == 1) ? ' disabled' : '' }}" href='{!! $addressList->previousPageUrl() !!}'>前のページ</a>
        <a class="pagination-next {{ ($addressList->currentPage() == $addressList->lastPage()) ? ' disabled' : '' }}" href='{!! $addressList->nextPageUrl() !!}'>次のページ</a>
        <ul class="pagination-list"> 
            @for ($i = 1; $i <= $addressList->lastPage(); $i++)
                <?php
                    $half_total_links = floor($link_limit / 2);
                    $from = $addressList->currentPage() - $half_total_links;
                    $to = $addressList->currentPage() + $half_total_links;
                    if ($addressList->currentPage() < $half_total_links) {
                    $to += $half_total_links - $addressList->currentPage();
                    }
                    if ($addressList->lastPage() - $addressList->currentPage() < $half_total_links) {
                        $from -= $half_total_links - ($addressList->lastPage() - $addressList->currentPage()) - 1;
                    }
                ?>
                @if ($from < $i && $i < $to)
                    <li>
                        <a class="pagination-link {{ ($addressList->currentPage() == $i) ? ' is-current' : '' }}" href="{{ $addressList->url($i) }}">{{ $i }}</a>
                    </li>
                @endif
            @endfor 
        </ul>
    </nav>
    @endif
 </div>
  
 @endsection 

            