<header class="navbar navbar-inverse navbar-fixed-top" id="cms-header">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand">
        <img class="header__brand-image" src="{{ Config::get('element-cms::cms.logo') }}" alt="Honor" width="114" />
      </a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="@route('Cms', 'api.users.logout')">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</header>