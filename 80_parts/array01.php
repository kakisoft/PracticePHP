<?php
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
＜コマンドライン＞

php array01.php

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */

return array_filter($domains, function ($d) use ($ignoreDomainList) {
    return !in_array($d, $ignoreDomainList);
});



