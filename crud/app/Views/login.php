<!-- navbar section -->
<body style="height: 100vh;background-image: url('https://codetheweb.blog/assets/img/posts/css-advanced-background-images/mountains.jpg');
    background-size: 2000px;
    background-position-x: center; 
    background-position-y: center; ">
  
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="/login">Login </a>
      </li>
    
      <li class="nav-item active">
        <a class="nav-link" href="/register">Register </a>
      </li>
    </ul>
  </div>
</nav>






<!-- login form -->

<div class="container my-5" style="width: 700px; height:600px">
<form action="/login" method="post">
  <div class="form-group">
    <h2>User Login</h2>
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
    
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
  <a href="/register" class="btn btn-link mx-5 my-5">Don't Have An Account</a>
</form>
</div>


</body>