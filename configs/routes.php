<?php

return [
  'news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2',
  'news/([0-9]+)' => 'news/view/$1',
    'news/news-list' => 'news/newsList',
  'news' => 'news/index',  // NewsController actionIndex
  'products' => 'product/list',  // ProductController actionList()
];
