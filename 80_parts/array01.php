<?php
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
＜コマンドライン＞

php array01.php

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */

return array_filter($domains, function ($d) use ($ignoreDomainList) {
    return !in_array($d, $ignoreDomainList);
});



// ## use
// https://www.php.net/manual/ja/functions.anonymous.php

// 無名関数

// ## array_filter
// コールバック関数を使用して、配列の要素をフィルタリングする

