<html>
<head>
<title>Smarty Test</title>
</head>
<body>
<p>$smarty->assign("Name"   , "kakisoft", true);    ：{$Name}</p>
<p>$smarty->assign("message", "msg01"   , true);    ：{$message}</p>

<ul>
    {for $foo=1 to 3}
        <li>{$foo}　：　{sprintf('%02d', $foo)}</li>
    {/for}
</ul>


    <select name="year" id="year">
        {for $year=2018 to 2020}
            <option value="{$year}" >{$year}</option>
        {/for}
    </select>

    <select name="month" id="month">
        {for $month=1 to 12}
            <option value="{sprintf('%02d', $month)}" >{sprintf('%02d', $month)}</option>
        {/for}
    </select>

</body>
</html>