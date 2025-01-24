<!-- navbar section -->
<body style="height: 100vh;background-image: url('https://codetheweb.blog/assets/img/posts/css-advanced-background-images/mountains.jpg');
    background-size: 2000px;
    background-position-x: center; 
    background-position-y: center; ">
    
    
    
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

<div class="container my-5" style="width:600px">
  <?php
		if (session()->getFlashdata("register")) {
      
      
      ?>
			<div class="alert w-50 align-self-center alert-success alert-dismissible fade show" role="alert">
        <?php echo session()->getFlashdata("register"); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
				</button>
			</div>
      <?php } ?>
      <form action="/register" method="post">
        
        <h2>User Register</h2>
        <div class="form-group">
          <label for="formGroupExampleInput">FirstName</label>
          <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Enter your name" name="firstname">
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">LastName</label>
    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Enter lastname" name="lastname">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
    
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
  </div>
  
  
  <label for="exampleInputPassword1">Roles:</label>
  <select class="form-select my-3" aria-label="Default select example" name= "role">
    <option selected value="1">Admin</option>
    <option value="2">Supervisor</option>
    <option value="3">Teamleader</option>
  <option value="4">Agent</option>
</select>
<?php if(isset($validation)){ ?>
  <div class="col-12">
    <div class="alert alert-danger" role="alert">
      <?php 

foreach($validation as $var){
  echo $var;
  echo "</br>";
}

?>
         
         
        </div>
      </div>
      <?php } ?>
      <button type="submit" class="btn btn-primary my-4">Register</button>
      <a href="/login" class="btn btn-link mx-5 my-5" style="background-color: white;">Have an account ?</a>
    </form>
  </div>

  
</body>