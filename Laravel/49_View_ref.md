## Bladeで使用できるメソッド一覧
https://leben.mobi/blog/laravel_blade_method/php/

* {{ $var }} – エスケープした$var(変数)をecho(Laravel4ではエスケープされない)
* {{ $var or ‘default’ }} – デフォルトを指定してechoする。この場合、$varに値があった場合、$varを表示、そうでなければdefalutを出力
* {{{ $var }}} – Laravel4で、エスケープした$var(変数)をecho
* {!! $var !!} – エスケープしない$var(変数)をecho
* {{– Comment –}} – Bladeへコメントを記述する
* @extends(‘layout’) – layoutテンプレートを継承する
* @if(condition) – if文の始まり
* @else – else文の始まり
* @elseif(condition) – elseif文を始まり
* @endif – if文を終了
* @foreach($list as $key => $val) – foreach文の始まり
* @endforeach – foreach文の終了
* @for($i = 0; $i < 10; $i++) - for文の始まり
* @endfor – for文を終了
* @while(condition) – while文の始まり
* @endwhile – while文の終了
* @unless(condition) – unless文の始まり
* @endunless – unlessの終了
* @include(file) – 他のテンプレートをincludeする
* @include(file, [‘var’ => $val,…]) – 他のテンプレートをincludeする際に変数を渡す
* @each(‘file’,$list,’item’) – コレクションをレンダリング
* @each(‘file’,$list,’item’,’empty’) – コレクションを指定し、空の場合は別のテンプレートを割り当ててレンダリング
* @yield(‘section’) – ‘section’の内容を生成
* @show – セクションを終了させて、内容を生成
* @lang(‘message’) – 言語環境に沿った文字列を生成
* @choice(‘message’, $count) – 言語に沿った文字列を複数形で出力
* @section(‘name’) – セクションの始まり
* @stop – セクションの終了
* @endsection – セクションの終わり
* @append – セクションを終了させて、、既存のセクションに追加する
* @overwrite – セクションの上書き


