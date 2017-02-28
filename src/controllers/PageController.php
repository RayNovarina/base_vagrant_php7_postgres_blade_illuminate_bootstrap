<?php

namespace Acme\controllers;

use duncan3dc\Laravel\BladeInstance;
use Acme\models\Page;

class PageController extends BaseController
{
    public function getShowHomePage()
    {
        echo $this->blade->render('home'); # /views/home.blade.php
    }

    // Given generic url, find matching page in the db.
    public function getShowDbPage()
    {
        $browser_title = '';
        $page_content = '';
        $page_db_id = '';

        // extract page name from Url
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        $target = $uri[1];

        // find matching page in the db.
        $page = Page::where('slug', '=', $target)->get(); // getters for attributes field?

        // look up page content
        foreach ($page as $attribs) {
          $browser_title = $attribs->browser_title;
          $page_content = $attribs->page_content;
          $page_db_id = $attribs->id;
        }

        if (strlen($browser_title) == 0) {
          // page not found.
          header('Location: /page-not-found?info=' . $target);
        }

        // pass the content to some blade template and render it.
        echo $this->blade->render('db-page', [
          'browser_title' => $browser_title,
          'page_content' => $page_content,
          'page_db_id' => $page_db_id
        ]);

    }

    public function getShow404()
    {
      header('HTTP/1.0 404 Not Found');
      echo $this->blade->render('page-not-found');
    }
}
