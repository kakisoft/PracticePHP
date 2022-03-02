```php
        Schema::create('customer_branch_details', function (Blueprint $table) {
            $table->foreignId('customer_branch_id')->references('id')->on('customer_branches')->comment('得意先支社ID');

```

