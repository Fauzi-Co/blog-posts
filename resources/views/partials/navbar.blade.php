<nav class="navbar navbar-expand-lg navbar-dark bg-info shadow-sm ">
  <div class="container">
    <a class="navbar-brand" href="#">WPU</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto">
        <a class="nav-link {{ ($active == "home") ? 'active' : '' }}" aria-current="page" href="/">Home</a>
        <a class="nav-link {{ ($active == "about") ? 'active' : '' }}" href="/about">About</a>
        <a class="nav-link {{ ($active == "posts") ? 'active' : '' }}" href="/posts">Blog</a>
        <a class="nav-link {{ ($active == "categories") ? 'active' : '' }}" href="/categories">Categories</a>
        
      </div>
      
      @auth
        <li class="nav-item dropdown text-white" style="list-style: none">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Welcome Back, {{ auth()->user()->name }}
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-layout-text-sidebar-reverse"></i> Dashboard</a></li>
            <li>
              <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="dropdown-item">
                  <i class="bi bi-box-arrow-right"></i> Log Out
                </button>
              </form>
              <a class="dropdown-item" href="/logout">
              </a>
            </li>
          </ul>
        </li>
          @else
          <div class="navbar-nav">
            <a href="/login" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Login</a>
          </div>
      @endauth

    </div>
  </div>
</nav>