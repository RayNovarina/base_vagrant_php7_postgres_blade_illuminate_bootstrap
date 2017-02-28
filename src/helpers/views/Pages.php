<?php

namespace Acme\helpers\Views;

use Acme\models\Page;

class Pages
{
  public static function isDbPages()
  {
    return Page::all()->count() > 0;
  }

  public static function otherPagesListItems()
  {
    $html = null;
    $other_pages = Page::where('slug', '<>', 'about-acme')->get();
    foreach ($other_pages as $db_page) {
      $html .= Pages::addListItem($db_page);
    }
    return $html ?? Pages::addListItem(null);
  }

  private function addListItem($db_page) {
    $href  = $db_page ? $db_page->slug          : '#';
    $label = $db_page ? $db_page->browser_title : 'Empty';
    return "<li><a href=\"/$href\">$label</a></li>";
  }
}

?>
