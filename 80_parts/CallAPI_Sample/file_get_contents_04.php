
<?php
$data = [
    'title' => '送信テスト',
    'body' => 'テスト',
];

$opts = [
    'http' => [
        'method' => 'POST',
        'header' => implode("\r\n", [
            "User-Agent: hogehoge",
            "Accept-Language: ja",
            "Cookie: test=hoge",
        ]),
    ],
    'data' => http_build_query($data)
];

$ctx = stream_context_create($opts);

$response = file_get_contents('http://example.com/inquiry', false, $ctx);
