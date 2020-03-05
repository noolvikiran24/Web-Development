   <nav class="navbar navbar-expand-lg navbar-light bg-secondary navbar-fixed-top" style="position: fixed; z-index: 99;">
  <a class="navbar-brand" href="index.php?maincategory=fashion" >ABAX</a>
 

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  
  <div style="margin-left: 930px;">
  <form class="form-inline my-2 my-lg-0" >
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
   </div>
  
  <?php 
    if(!$_SESSION["borrusername"]){
  ?>
  <div class="navbar-right" style="padding-left: 5px;">
     <button id ="loginbutton" class="btn btn-outline-dark my-2 my-sm-0" type="submit" onclick="loginfunction()">Log in</button>
  </div>
<?php } 
 
   else{
  ?>
  <div class="navbar-right" style="padding-left: 5px;">
     <button id ="logout" class="btn btn-outline-dark my-2 my-sm-0" type="submit" onclick="logoutfunction()">Log Out</button>
  </div>

<?php } ?>


    
  </div>
</nav>
