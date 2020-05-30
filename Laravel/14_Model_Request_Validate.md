# Validate 用のクラスを作成
Request クラスの代わりに使える。

#### コマンド例
```
php artisan make:request PostRequest
```

#### app/Http/Requests/PostRequest.php
```php
class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * このメソッドが無いと「This action is unauthorized」が発生する。
     * 
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'title' => 'required|min:3',
            'body' => 'required'
        ];
    }

    // Validation のエラーメッセージのカスタマイズ
    public function messages() {
      return [
        'title.required' => 'please enter title!!!',
        'body.required'  => 'please enter body!!!'
      ];
    }
}
```

#### コントローラ側
引数を PostRequest でなく、artisan コマンドで作成した、FormRequest を継承したクラスを指定する。  
（以下の例では、PostRequest）
```php
    public function store(PostRequest $request) {
      $post = new Post();
      $post->title = $request->title;
      $post->body = $request->body;
      $post->save();
      return redirect('/');
    }
```

____________________________________________________________
## FormRequest を定義せず、$this->validate を使う場合
https://readouble.com/laravel/5.8/ja/validation.html  

FormRequest を継承しない場合、以下のようなやり方がある。
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

カスタムメッセージは、第２引数に渡す。
```php
    $this->validate(
        $request,
        [
            'title' => 'required|min:3',
            'body'  => 'required'
        ],
        [
            'title.required' => 'please enter title.',
            'body.required'  => 'please enter body.'
        ]
    );
```

____________________________________________________________
## Validatorファサードを使用する場合
```php
      \Validator::make($request->all(),
          [
              'title' => 'required|min:3',
              'body' => 'required',
          ],
          [
              'title.required' => 'please enter title.',
              'body.required'  => 'please enter body.'
          ]
      )->validate();
```

____________________________________________________________
## _
https://laravel.com/docs/7.x/validation  
```php
class PostController extends Controller
{
    /**
     * Store a new blog post.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Store the blog post...
    }
}
```

