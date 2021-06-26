## ElasticMQ
ローカルで使える SQS 互換のキュー  
https://github.com/softwaremill/elasticmq


## elasticmq : Docker hub
https://hub.docker.com/r/softwaremill/elasticmq


```yaml
  sqs:
    image: softwaremill/elasticmq
    restart: always
    ports:
      - 9324:9324
```


