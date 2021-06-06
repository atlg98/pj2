<?php
include 'includes/header.php';
include 'func/account.php';
?>

<style>
	.flip-card {
		background-color: transparent;
		width: 35vw;
		height: 70vh;
		perspective: 1000px;
	}

	.flip-card-inner {
		position: relative;
		width: 100%;
		height: 100%;
		transition: transform 0.8s;
		transform-style: preserve-3d;
	}

	.flip-card:hover .flip-card-inner {
		transform: rotateY(180deg);
	}

	.flip-card-front,
	.flip-card-back {
		padding: 20px;
		position: absolute;
		width: 100%;
		height: 100%;
		-webkit-backface-visibility: hidden;
		border: 1px solid #aaa;
		border-radius: 10px;
		/* Safari */
		backface-visibility: hidden;
	}

	.flip-card-front {
		background-color: white;
		color: black;
	}

	.flip-card-back {
		background-color: aliceblue;
		transform: rotateY(180deg);
	}
</style>

<div class="container mt-3">


	<?php if (isset($errorMsg)) : ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $errorMsg; ?>
		</div>
	<?php endif; ?>


	<div class="row">

		<div class="col-md-6">

			<div class="flip-card">
				<div class="flip-card-inner">
					<div class="flip-card-front">
						<h1 class='mb-4 text-center'>Register Aera</h1>
						<img src="data:image/jpeg;base64,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" alt="Avatar" style="width: 100%; height: 80%; object-fit: contain;">
					</div>
					<div class="flip-card-back">
						<h3>Create a new account</h3>
						<hr>


						<form class="" action="login.php" method="post">

							<label for="username">Username</label>

							<input type="text" name="username" class="form-control" placeholder="Input your username..." value="<?= isset($username) ? htmlspecialchars($username) : '' ?>">

							<p class="error">
								<?php if (isset($errors['create_username'])) {
									echo $errors['create_username'];
								} ?>
							</p>

							<label for="email">Email</label>
							<input type="email" name="email" class="form-control" placeholder="Input your email..." value="
						<?php if (isset($email)) {
							echo htmlspecialchars($email);
						} ?>">

							<p class="error">
								<?php if (isset($errors['create_email'])) {
									echo $errors['create_email'];
								} ?>
							</p>

							<label for="password1">Password</label>
							<input type="password" name="password1" class="form-control" placeholder="Input your password..." value="">

							<p class="error"></p>

							<label for="password2">Confirm Password</label>
							<input type="password" name="password2" class="form-control" placeholder="Input your confirm password..." value="">
							<p class="error">
								<?php if (isset($errors['create_password'])) {
									echo $errors['create_password'];
								} ?>
							</p>
							<button type="submit" name="create" class="btn btn-success col-12 btn-block">Create Account</button>

						</form>
					</div>
				</div>
			</div>




		</div>

		<div class="col-md-6">
			<div class="flip-card">
				<div class="flip-card-inner">
					<div class="flip-card-front">
						<h1 class='mb-4 text-center'>Login Aera</h1>
						<img class='text-center' src="https://i.pinimg.com/736x/27/f1/aa/27f1aa74f7e12e561b527a36abd7c72f.jpg" alt="Avatar" style="border-radius: 50%; width: 80%; height: 80%; object-fit: cover;
						display: block; margin-left: auto; margin-right: auto;">
					</div>
					<div class="flip-card-back">
						<h3>Login</h3>
						<hr>
						<form class="" action="login.php" method="post">
							<label for="username">Username</label>
							<input type="text" name="username" class="form-control" placeholder="Input your username..." value="<?= isset($username) ? htmlspecialchars($username) : '' ?>">
							<p class="error">
								<?php if (isset($errors['login_username'])) {
									echo $errors['login_username'];
								} ?>
							</p>

							<label for="password">Password</label>
							<input type="password" name="password" class="form-control" placeholder="Input your username..." value="">

							<p class="error">
								<?php if (isset($errors['login_password'])) {
									echo $errors['login_password'];
								} ?>
							</p>
							<button type="submit" name="login" class="btn btn-success col-4">Login</button>
						</form>
					</div>
				</div>
			</div>



		</div>

	</div>
</div>

<?php
include 'includes/footer.php';
?>