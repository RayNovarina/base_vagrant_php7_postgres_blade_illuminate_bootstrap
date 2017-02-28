
<!-- /admin/edit-form -->
  <form method="post" action="/admin/page/edit" id="editpage" name="editpage">
    <center><h1 style="color: blue;">Page: {!! $browser_title !!}<h1></center>
    <article id="editablecontent" class='editablecontent' itemprop="description" style='width: 100%; line-height: 2em;'>
      {!! $page_content !!}
    </article>
    <article class="admin-hidden">
      <a class="btn btn-primary" href="#!" onclick="saveEditedPage()">Save</a>
      <a class="btn btn-info" href="#!" onclick="turnOffEditing()">Cancel</a>
      &nbsp;&nbsp;&nbsp;
      @if($page_db_id == 0)
        <br><br>
        <input type="text" name="browser_title" placeholder="Enter Browser Title">
      @endif
    </article>
    <input type="hidden" name="thedata" id="thedata">
    <input type="hidden" name="old" id="old">
    <input type="hidden" name="page_db_id" id="page_db_id" value="{!! $page_db_id !!}">
   </form>
