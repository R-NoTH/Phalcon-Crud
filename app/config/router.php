<?php

$router = $di->getRouter();

// Define your routes here\

// Article Routes
$router->add('/article/create/article',['controller' => 'article','action' => 'createArticle',]);
$router->add('/article/edit',['controller' => 'article','action' => 'edit',]);
$router->add('/article/edit/submit',['controller' => 'article','action' => 'editSubmit',]);

$router->handle();
