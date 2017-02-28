
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Acme</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/">Home</a></li>
            <li><a href="/about-acme">About</a></li>
            @if(Acme\helpers\views\Pages::isDbPages())
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" id="topnav-dbPages-drop1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  Other Pages
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="topnav-dbPages-drop1">
                  {!! Acme\helpers\views\Pages::otherPagesListItems() !!}
                </ul>
              </li>
            @endif
          </ul>
          <ul class="nav navbar-nav navbar-right">
            @if(Acme\auth\Roles::isAdmin())
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" id="topnav-admin-drop1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  Admin
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="topnav-admin-drop1">
                  <li><a href="#" class="menu-item"
                         onclick="makePageEditable(this)"
                      >Edit Page</a>
                  </li>
                  <li role="separator" class="divider"></li>
                  <li><a href="/admin/page/add">Add a page</a></li>
                </ul>
              </li>
            @endif
            @if(Acme\auth\LoggedIn::user())
              <li>
                <a href="/logout">
                  <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                  &nbsp;Logout ({{ Acme\auth\LoggedIn::user()->first_name }}: {{ Acme\auth\LoggedIn::user()->email }})
                </a>
              </li>
            @else
              <li><a href="/register">Register</a></li>
              <li>
                  <a href="/login">
                    <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                    &nbsp;Login
                  </a>
              </li>
            @endif
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
