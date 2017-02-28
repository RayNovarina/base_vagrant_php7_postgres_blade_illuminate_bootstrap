<?php
namespace Acme\controllers;

use duncan3dc\Laravel\BladeInstance;
use Acme\validation\Validator;
use Acme\models\Page;
use Cocur\Slugify\Slugify;

class AdminController extends BaseController
{
  /**
   * Save an editted or new page.
   * @return string
   */
  public function postSavePage()
  {
    $page = null;
    if (($page_db_id = $_REQUEST['page_db_id']) == 0) {
      # new page. Verify that it is not already in the db.
      $browser_title = $_REQUEST['browser_title'];
      $slugify = new Slugify;
      $page_slug = $slugify->slugify($browser_title);

      if ($browser_title == '') {
        echo 'Please enter a browser title.';
        exit();
      }
      if ((Page::where('slug', $page_slug))->first() != null) {
        echo 'Browser is already in use!';
        exit();
      }
      # New, unique page being added.
      $page = new Page;
      $page->browser_title = $browser_title;
      $page->slug = $page_slug;
    } else {
      # Saving existing page, i.e. Edit
      $page = Page::find($page_db_id);
    }

    # Update or create new content.
    $page->page_content = $_REQUEST['thedata'];
    $page->save();
    echo 'OK';
  }

  /**
   * Retrieve page from database
   * @return blade.html string
   */
  public function getAddPage()
  {
    $page_db_id = '0'; # '0' has special meaning, i.e. add new page.
    $browser_title = 'Add Page';
    $page_content = 'Enter your content here.';

    echo $this->blade->render('db-page', [
      'browser_title' => $browser_title,
      'page_content' => $page_content,
      'page_db_id' => $page_db_id
    ]);
  }
}
?>
