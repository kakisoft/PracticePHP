## Requestクラス
ブラウザを通してユーザーから送られる情報をすべて含んでいるオブジェクト。  

```php
class UserController extends Controller
{
    /**
     * 新しいユーザーを保存
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');

        //
    }
}
```



## Validate
https://readouble.com/laravel/5.8/ja/validation.html  
```php
    public function store(Request $request) {
      $this->validate($request, [
        'title' => 'required|min:3',
        'body' => 'required'
      ]);
      $post = new Post();
      $post->title = $request->title;
      $post->body = $request->body;
      $post->save();
      return redirect('/');
    }
```







