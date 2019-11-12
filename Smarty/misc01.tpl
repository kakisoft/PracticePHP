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
【 foreachelse 】

{foreach from=$office_list item=item name=loop}
	<tr>
		<td class="left">
			{$item.telephone_number}
		</td>
	</tr>
{foreachelse}
	<tr>
		<td class="center" colspan="5">
			登録済の営業所はありません。
		</td>
	</tr>
{/foreach}


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 for 】

<ul>
{for $foo=1 to 3}
    <li>{$foo}</li>
{/for}
</ul>

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 文字列の結合 】
| cat : 'charaaa'


<li>acc{$i|cat:' and lemon'}</li>   


【{'a'|cat:'bb'|cat:'ccc'}】 #=> 【abbccc】

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 カンマ区切り 】

num:::{$num|number_format}

num:::{10000000|number_format}

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

{strtotime($userParameters.update_date)|date_format:"%G/%m/%d %H:%M"}

{$app.product_detail.updated_at|date_format:"%Y年 %m月 %d日"}

{date('Y年 m月 d日', strtotime($userParameters.update_date))}


＜英語形式＞
【{$el.fair_start_date|date_format:$config.date}】 => Dec 4, 2018
【{$smarty.now|date_format:"%A, %e %B %Y"} 】 => Tuesday, 13 November 2018 
【{strtotime($el.fair_start_date)|date_format:"%B %e, %Y"} 】 => December 4, 2018 

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 置換 】

{$param1|replace:"&lt;br/&gt;":"<br>"}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 デフォルト値 】

<input type="text" class="my_class01" value="{{$value.something_name|default:"初期値だぞ！"}}" />
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 include 】

<head>
{include file="include_common_head.tpl"}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 literal 】

<script type="text/javascript">
{literal}

	function answer(url) {
		if($("input[name=a_id]").filter(":checked").val()){
 			//is checked
			$.ajax({
		        url: url,
		        type: "GET",
		        data: {action_detailQuestionnaire : true, a_id : $("input[name=a_id]").filter(":checked").val(), lang : "J"},
		        beforeSend: function(){
		        	$("#questionnaire").attr("disabled", true);
		        },
		        success: function(response) {
					if(response.trim()=='success'){
						$("#question_area").hide();
						$("#thank_you_area").show();
						$("#thank_you").html("<br>&nbsp<br><span><b>Thank you for your response.</b></span><br />&nbsp");
					} else {
						//Err
						$("#questionnaire").removeAttr("disabled");
					}
		        },
		        error:function() {
					//do Nothing
					$("#questionnaire").removeAttr("disabled");
		        }
		    });
	    }
	}
{/literal}
</script>

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━


```
## debug
```

====================================
【 Smarty 】（ Smarty Debug Console  ）
------------------------
{debug}

{php}

{/php}
------------------------


```