## VSCode スニペット
File -> Preference -> User Snipets  


##### ファイル ： php.json
```json
	    "error_log_output_01": {
	        "prefix": "alog",
	        "body": [
	          "error_log('aaa_01'.PHP_EOL,'3','C:\\logs\\php\\tmp_log_02.log');"
	        ],
	        "description": "error log output 01"
	    },

    "error_log_output_02": {
        "prefix": "blog",
        "body": [
            "$$log_output_vaalluuee = array( 1=>'a' );",
            "error_log(  print_r($$log_output_vaalluuee, true)  ,'3','C:\\logs\\php\\tmp_log_02.log');",
        ],
        "description": "error log output 02"
    },

	"error_log_output_03": {
		"prefix": "clog",
		"body": [
			"error_log(PHP_EOL.'-------------------------------------'.PHP_EOL,'3','C:\\logs\\php\\tmp_log_02.log');",
			"error_log(  print_r($$log_output_vaalluuee, true)  ,'3','C:\\logs\\php\\tmp_log_02.log');",
			"error_log(PHP_EOL.'-------------------------------------'.PHP_EOL,'3','C:\\logs\\php\\tmp_log_02.log');",
		],
		"description": "error log output 02"
	},

    "var_dump_exit": {
        "prefix": "de",
        "body": [
            "echo '<pre>';",
            "print_r($$value);",
            "echo '</pre>';",
            "exit;",
        ],
        "description": "var dump exit"
    },


    "dump_query_contents": {
	        "prefix": "dq",
	        "body": [
			  //"$$s1 = \\App\\Facades\\DebugUtil::dq($$q1);",
			  "$$s1 = \\App\\Utils\\DebugUtil::dq($$q1);",
			  "\\Log::info($$s1);"
	        ],
	        "description": "Dump Query"
	},
```

「 $ 」を表現する場合、「 $$ 」  
「 \ 」 → 「 \\ 」  



