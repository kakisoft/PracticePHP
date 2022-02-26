Error response from daemon: pull access denied for 581151730552.dkr.ecr.ap-northeast-1.amazonaws.com/php-fpm/dev, repository does not exist or may require 'docker login': denied: Your authorization token has expired. Reauthenticate and try again.

________________________________________________________________________________

## Config Check
```
aws configure list --profile kakinohana
```

## mfa ツール起動
PS C:\kaki\BBP\ASIMS3\hapi_docker\application\tools> .\aws_mfa.ps1

Example MFA ARN: arn:aws:iam::12345678908123:mfa/bloggsj
Example Profile: as3_config
Example code: 123456
```
入力内容
```
arn:aws:iam::581151730552:mfa/hl_kakinohana-stg
kakinohana
123456 （スマホにインストールされた認証システムを確認）
```

成功した時のメッセージ
```
Your authentication credentials have now been updated
Your new access-key-id is: ASIAYOT2XVN4EQ24OHDV
Your new session token will expire: 2021-06-21T18:16:05+00:00
Please continue and use the AWS CLI as normal.
```


## Login
```
aws ecr get-login-password --region ap-northeast-1 | docker login --username AWS --password-stdin 581151730552.dkr.ecr.ap-northeast-1.amazonaws.com
```

