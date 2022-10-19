<!DOCTYPE html>
<html lang="en">
<head>
	<title>অর্ঘ্য প্রস্ব্যস্তি</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('storage/login/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('storage/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('storage/login/vendor/animate/animate.css')}}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{asset('storage/login/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('storage/login/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('storage/login/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('storage/login/css/main.css')}}">
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-login100">

			<div class="wrap-login100">
				<div class="ml-auto mr-auto">
					<div class="text-center">অর্ঘ্য-প্রস্বস্তি</div>
					<img style="width: 105px;height:120px;margin:0 auto" class="img-fluid circle d-block" src="{{asset('storage/adminlte/dist/img/logo.jpg')}}" alt="Logo">
					<div class="text-center">প্রিয়পরম শ্রীশ্রীঠাকুর অনুকূলচন্দ্র সৎসঙ্গ ফাউন্ডেশন, বাংলাদেশ<br/>Email: satsangfoundationbd@gmail.com<br/>মোবাইলঃ-০১৭৫৯১০৭৩০৫
					</div>
				</div>
				<marquee class="mb-4 mt-2 text-primary" behavior="scroll" direction="left">{{App\Models\Scrolling::first()->description}}</marquee>
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{asset('storage/adminlte/dist/img/onukul.jpg')}}" alt="IMG">
				</div>

				<form method="POST" action="{{route('login')}}" class="login100-form validate-form">
					@csrf
					@error('email')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror
					@error('password')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror
					@error('status')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror
					<div class="wrap-input100 validate-input" data-validate = "Valid mobile is required: ex@abc.xyz">
						<input class="input100  @error('mobile') is-invalid @enderror" type="text" name="mobile" placeholder="01XXXXXXXXX">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-phone" aria-hidden="true"></i>
						</span>
                        @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100 @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i  class="fa fa-lock" aria-hidden="true"></i>
						</span>
						<span class="symbol-input1234">
							<i id="password-show"  class="fa fa-eye" aria-hidden="true"></i>
						</span>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							প্রবেশ করুন
						</button>
					</div>

					<div class="text-center p-t-12">
						
						<a class="txt2" href="{{ route('password.send.code') }}">
							পাসওয়ার্ড ভূলে গিয়েছেন ?
						</a>
					</div>
{{-- 
					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div> --}}
				</form>
			</div>
		</div>
	</div>
<!--===============================================================================================-->	
	<script src="{{asset('storage/login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('storage/login/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('storage/login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('storage/login/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('storage/login/vendor/tilt/tilt.jquery.min.js')}}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
	<script>
		$('#password-show').click(function(){
			type=$('#password').attr('type');
			console.log(type);
			if(type=="password"){
				$('#password').attr('type','text');
				$('#password-show').removeClass('fa-eye')
				$('#password-show').addClass('fa-eye-slash')
			}else{
				$('#password').attr('type','password');
				$('#password-show').removeClass('fa-eye-slash')
				$('#password-show').addClass('fa-eye')
			}
		})
	</script>
</body>
</html>