```php
        Schema::create('customer_branch_details', function (Blueprint $table) {
            $table->foreignId('customer_branch_id')->references('id')->on('customer_branches')->comment('得意先支社ID');

```



## src/routes/web.php
```php
        //Department Estimate Conditions Routes
        Route::prefix('department-conditions')->name('department-conditions.')->group(function () {
            Route::get('{id}/edit', [DepartmentConditionController::class, 'edit'])->name('edit');
            Route::put('{id}', [DepartmentConditionController::class, 'update'])->name('update');
        });
```

<form method="POST" action="{{ route('department-conditions.update', $departmentId) }}">
action="https://ryuki.test:44300/department-conditions/2"




