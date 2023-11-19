<?php

function route($method, $path)
{
    $routes = [
        'GET' => [
            '/api/books' => 'BooksController@index',
            '/api/books/byid' => 'BooksController@listOneById',
            '/api/books/byname' => 'BooksController@listByName',
            '/api/publishers' => 'PublishersController@index',
            '/api/publishers/byid' => 'PublishersController@listOneById',
            '/api/publishers/byname' => 'PublishersController@listByName',
            '/api/query' => 'CommonController@listByCustomQuery',
        ],
        'POST' => [
            '/api/books' => 'BooksController@store',
            '/api/publishers' => 'PublishersController@store',
            '/api/books/update' => 'BooksController@update',
            '/api/publishers/update' => 'PublishersController@update'
        ],
        'DELETE' => [
            '/api/books' => 'BooksController@delete',
            '/api/publishers' => 'PublishersController@delete'
        ]
    ];

    if (isset($routes[$method][$path])) {
        return $routes[$method][$path];
    } else {
        return null;
    }
}
