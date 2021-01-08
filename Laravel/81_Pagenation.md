## Pagination
https://laravel.com/docs/7.x/pagination

#### コントローラ側
get() は不要みたいだ。
```php
$cleared_users = Question01RegistrationInformation::where('is_cleared', Question01RegistrationInformation::IS_CLEARED___TRUE)
                                                            ->orderBy('created_at', 'desc')->paginate(5);
```

#### View側
```php
{{$cleared_users->links()}}

{{$cleared_users->currentPage()}}

@foreach ($cleared_users as $cleared_user)
    <tr>
    <td>{{ $cleared_user->id }}</td>
    <td>{{ $cleared_user->created_at }}</td>
    <td>{{ $cleared_user->name }}</td>
    <td>{{ $cleared_user->comment }}</td>
    </tr>
@endforeach
```

## Paginator Instance Methods
https://laravel.com/docs/7.x/pagination#paginator-instance-methods

|  Method                               |  Description                                                                                                 |
|:--------------------------------------|:-------------------------------------------------------------------------------------------------------------|
|  $results->count()                    |  Get the number of items for the current page.                                                               |
|  $results->currentPage()              |  Get the current page number.                                                                                |
|  $results->firstItem()                |  Get the result number of the first item in the results.                                                     |
|  $results->getOptions()               |  Get the paginator options.                                                                                  |
|  $results->getUrlRange($start, $end)  |  Create a range of pagination URLs.                                                                          |
|  $results->hasPages()                 |  Determine if there are enough items to split into multiple pages.                                           |
|  $results->hasMorePages()             |  Determine if there is more items in the data store.                                                         |
|  $results->items()                    |  Get the items for the current page.                                                                         |
|  $results->lastItem()                 |  Get the result number of the last item in the results.                                                      |
|  $results->lastPage()                 |  Get the page number of the last available page. (Not available when using simplePaginate).                  |
|  $results->nextPageUrl()              |  Get the URL for the next page.                                                                              |
|  $results->onFirstPage()              |  Determine if the paginator is on the first page.                                                            |
|  $results->perPage()                  |  The number of items to be shown per page.                                                                   |
|  $results->previousPageUrl()          |  Get the URL for the previous page.                                                                          |
|  $results->total()                    |  Determine the total number of matching items in the data store. (Not available when using simplePaginate).  |
|  $results->url($page)                 |  Get the URL for a given page number.                                                                        |
|  $results->getPageName()              |  Get the query string variable used to store the page.                                                       |
|  $results->setPageName($name)         |  Set the query string variable used to store the page.                                                       |


