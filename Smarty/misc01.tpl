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
【 foreach（キーを含む２） 】
https://www.smarty.net/docsv2/ja/language.function.foreach.tpl

    {{foreach from=$category_list key=k item=v}}
        <td class="row_head center color3" style="width:50px;">
            {{$k}}<br>
            {{$v}}
        </td>
    {{/foreach}}
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
【 foreach 最初のレコード 】

{{foreach from=$category_list item=category key=id name=main_loop}}
	{{$category.category_name}}
	{{if $smarty.foreach.main_loop.first}}
		1st
	{{/if}}
{{/foreach}}


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 foreach インデックス番号 】

{{foreach from=$category_list item=category key=id name=main_loop}}
    『{{ $smarty.foreach.main_loop.index}}}』
    {{$category.category_name}}
{{/foreach}}


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 for 】

<ul>
{for $foo=1 to 3}
    <li>{$foo}</li>
{/for}
</ul>


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 for(エイリアスっぽいもの？) 】

{section}関数


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 文字列の結合 】
| cat : 'charaaa'


<li>acc{$i|cat:' and lemon'}</li>   


【{'a'|cat:'bb'|cat:'ccc'}】 #=> 【abbccc】


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 特定の文字を含むかチェック 】

{{if strpos($category_name, "image_group_") }}
    ある
{{else}}
    ない
{{/if}}


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
【 配列の中身を展開。（中身を見る） 】

{{$array_01|@debug_print_var}}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 配列の要素数 】
{{$category.detail_array|@count}}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 特定の値が配列に含まれているか 】

{{if (in_array("42", $SP_INPUT_ITM_ID_LIST, true)) }}
    ある
{{else}}
    ない
{{/if}}


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 キャスト 】
{{$detail.report_id|intval}}


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 計算 】
間にスペースを空けてるとダメみたい。

{$foo+1}

{$foo*$bar}


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 math 】

{math equation="x + y" x=$height y=$width}

{{math equation=a+b a=$judgment_category_list|@count b=$smarty.foreach.loop.index+1}}


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 定数（他に方法あるかも・・・） 】

//php
const DISP_SP_PATTERN_1 = "211";

$this->view->assign('DISP_SP_PATTERN_1' , MyModel01::DISP_SP_PATTERN_1);


//smarty
{{if $detail.sp_input_id == $DISP_SP_PATTERN_1}}


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【 assign 】
{{assign var="assigned_value" value="何か出ろ"}}
【{{$assigned_value}}】


{{assign var='detail1' value=$direc_detail.1}}
{{$detail1.name}}

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
セキュリティがTRUEだとダメみたい。


{$var|@var_dump}

{$var|@print_r}

{$var|@debug_print_var}
```






