```php

{debug}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
{* これはコメントです *}


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 ワンライナーで書く方法 】

{if $userParameters["email"]  == "1"}checked{/if}

<input type='checkbox' name='email'  id='email'  value='1' {if $userParameters["email"]  == "1"}checked{/if}>一般";


<input type="radio" name="lang_cd" id="lang_cd" value="0" {if $userParameters["lang_cd"] != "1"}checked{/if}>日本語
<input type="radio" name="lang_cd" id="lang_cd" value="1" {if $userParameters["lang_cd"] == "1"}checked{/if}>英語

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

{if $preBodyDivideId == 1}
    {* 入力内容にエラーがある *}
{/if}


{if $userParameters['is_admin'] == true}

{else}}

{/if}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 標準出力 】

{php}
echo "<pre>";
echo "This will be sent to browserrrrrrrrr<br>";
echo {$name};
var_dump({$name});
echo "</pre>";
{/php}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 if 分岐 】

{if $name eq 'Fred'}
    Welcome Sir.
{elseif $name eq 'Wilma'}
    Welcome Ma'am.
{else}
    Welcome, whatever you are.
{/if}

=============================================================================

{if count($_POST) > 0}
    count_POST_OVER 0
{/if}

=============================================================================

{if ($divideId == "2" && $is_admin == true)}
{else}
{/if}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 foreach 】

<ul>
{foreach from=$myArray item=foo}
    <li>{$foo}</li>
{/foreach}
</ul>

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 foreach（キーを含む） 】

{foreach $userParameters as $value}
   <li>{$value@key}: {$value}</li>
{/foreach}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 for 】

<ul>
{for $foo=1 to 3}
    <li>{$foo}</li>
{/for}
</ul>

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
＜smartyで渡された内容は、{php}内では参照できない？＞

        functionKey：{$functionKey}<br>

{php}
echo "ファンクション：";
echo $functionKey;
echo "<br>";

if($functionKey == "update"){
    echo "あっぷでーと";
}else{
    echo "あっぷでーと以外";
}
{/php}


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 日付を整形して出力 】
https://www.smarty.net/docs/ja/language.modifier.date.format.tpl

{strtotime($userParameters.update_date)|date_format:"%G/%m/%d %H:%M:%S"}


```
