<!-- BEGIN: base.html -->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>
        @yield('browsertitle')
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- BEGIN: Blade include file for base page css -->
    @include('base.base-css')
    <!-- END: Blade include file for base page css -->

    @if(Acme\auth\Roles::isAdmin())
      <!-- BEGIN: Blade insert block for admin css -->
      @include('admin.admin-base-css')
      <!-- END: Blade insert block for admin css -->
    @endif

    @yield('pagecss')

  </head>
  <body>

    <!-- BEGIN: Blade include file for topnav.html -->
    @include('topnav')
    <!-- END: Blade include file for topnav.html -->

    <div class="container pagecontainer">
      <div class="row">
        <br><br>
        @include('errormessages')
      </div>

      <div class="row">
        <div class="col-md-12 page-content">
          <!-- BEGIN: Blade insert block for content -->
          @yield('content')
          <!-- END: Blade insert block for content -->
        </div>
      </div>

    </div>

    <!-- BEGIN: Blade include file for footer.html -->
    @include('footer')
    <!-- END: Blade include file for footer.html -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.migrate/jquery-migrate-3.0.0.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    @if(Acme\auth\Roles::isAdmin())
    <!-- BEGIN: Blade insert block for admin CKEditor utility js -->
      <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
    <!-- END: Blade insert block for admin CKEditor utility js -->
    @endif

    <!-- BEGIN: Blade insert block for bottomjs -->
    @yield('bottomjs')
    <!-- END: Blade insert block for bottomjs -->

    @if(Acme\auth\Roles::isAdmin())
      <!-- BEGIN: Blade insert block for admin js -->
      @include('admin.admin-edit-form-js')
      <!-- END: Blade insert block for admin js -->
    @endif

  </body>
</html>
<!-- END: base.html -->
