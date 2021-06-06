<?php
include 'includes/header.php';
?>
<div class="container p-3 my-3 bg-primary text-white">
	<div class="container text-center">
		<h1 class="display-3">Welcome to my Porfolio</h1>
		
		<a href="post.php" class="btn btn-success col-4">My Post</a>
		<p class="num-posts"></p>
	</div>
</div>
	<div class="container">
	<?php if (isset($_GET['login'])) : ?>
		<div class="alert alert-success" role="alert">
			You have logged in successfully!
		</div>
	<?php elseif (isset($_GET['logout'])) : ?>
		<div class="alert alert-warning" role="alert">
			You have logged out successfully!
		</div>
	<?php endif; ?>
</div>
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="https://static.wixstatic.com/media/8d6c19ec8ece4ab493cbaeb537250606.jpg/v1/fill/w_1480,h_733,al_c,q_90,usm_0.66_1.00_0.01/8d6c19ec8ece4ab493cbaeb537250606.webp" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="http://www.azonnal.net/wp-content/uploads/2019/03/Blog-ca-nhan.jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="https://blog.webico.vn/wp-content/uploads/2019/12/what-is-a-blog_bhakti-1-scaled.jpg" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<?php
include 'includes/footer.php';
?>