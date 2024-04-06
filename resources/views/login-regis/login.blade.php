<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

	{{-- Bootstrap Icons --}}
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="col-lg-4 mx-auto mt-4">

		@if (session()->has('loginError'))
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				{{ session('loginError') }}
				<button type="button" class="btn-close" data-bs-dismiss='alert' aria-label="Close"></button>
			</div>
		@endif

		<form action="{{ route('admin.login.proses') }}" class="login-form" method="post" enctype="multipart/form-data">
			@csrf
			<h1>Login</h1>
			<div class="form-content">
				<div class="form-item @error('username') is-invalid @enderror"> 
					<label for="username">Masukan username Address</label>
					<input type="text" name="username" id="username" placeholder="username" required value="{{ old('username') }}">
				</div>
			</div>
			@error ('username')
			<div class="is-invalid">
				{{ $message }}
			</div>
			@enderror
			<div class="form-content mb-3">
				<div class="form-item">
					<label for="password">Masukan Password</label>
					<input type="password" name="password" id="password" placeholder="Password" required>
				</div>
			</div>
			<div class="d-md-flex justify-content-md-end">
				<a class="link-danger link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover my-auto me-2"  href="{{ route('welcome') }}"><i class="bi bi-arrow-bar-left text-danger"></i>Too Home</a>
				<button class="btn btn-outline-primary" type="submit" name="login">Login</button>
			</div>
		</form>
	</div>	
</body>
</html>