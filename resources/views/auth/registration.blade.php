<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    {{-- <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" /> --}}

    <title>Registration</title>
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
         .vh-100 {
            min-height: 100vh;
        }

        /* Adjust padding for small screens */
        @media (max-width: 576px) {
            .card {
                padding: 1rem;
            }
        }
    </style>

</head>

<body>
    <section class="vh-100 d-flex justify-content-center align-items-center"
        style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593)">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col col-xl-12">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp"
                                    alt="login form" class="img-fluid h-100 w-100"
                                    style="object-fit: cover; border-radius: 1rem 0 0 1rem;"  />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body  text-black">
                                    <form method="post" action="{{ route('register.post') }}">
                                        @csrf
                                        <div class="d-flex align-items-center mb-1 pb-1">
                                            <span class="h1 fw-bold mb-0">Sign Up</span>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-2">
                                            <label class="form-label" for="full_name">Full Name</label>
                                            <input type="text" id="full_name" name="full_name"
                                                class="form-control form-control-lg"
                                                placeholder="Enter your Full Name" />
                                            @error('full_name')
                                            <span class="invalid-feedback"
                                                style="display:block !important; font-size:100% !important;"
                                                role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-2">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" id="email" name="email"
                                                class="form-control form-control-lg" placeholder="Enter your Email" />
                                            @error('email')
                                            <span class="invalid-feedback"
                                                style="display:block !important; font-size:100% !important;"
                                                role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div data-mdb-input-init class="form-outline mb-2">
                                            <label class="form-label" for="phone">Phone Number</label>
                                            <input type="text" id="phone" class="form-control form-control-lg"
                                                placeholder="Enter your Phone Number" name="phone" />
                                            @error('phone')
                                            <span class="invalid-feedback"
                                                style="display:block !important; font-size:100% !important;"
                                                role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-2">
                                            <label class="form-label" for="dob">Date of birth</label>
                                            <input type="date" id="dob" class="form-control form-control-lg"
                                                placeholder="Enter your Phone Number" name="dob" />
                                            @error('dob')
                                            <span class="invalid-feedback"
                                                style="display:block !important; font-size:100% !important;"
                                                role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-2">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" id="password" class="form-control form-control-lg"
                                                name="password" placeholder="Enter your Password" />
                                            @error('password')
                                            <span class="invalid-feedback"
                                                style="display:block !important; font-size:100% !important;"
                                                role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-2">
                                            <label class="form-label" for="password">Confirm Password</label>
                                            <input type="password" id="password" class="form-control form-control-lg"
                                                name="password_confirmation"
                                                placeholder="Enter your Confirm Password" />
                                        </div>

                                        <div class="pt-1 mb-2">
                                            <button data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-dark btn-lg btn-block" type="submit">Sign Up</button>
                                        </div>
                                        <p style="color: #393f81;">Already have account?
                                            <a href="{{ route('login') }}"
                                                style="">Sign In here</a>
                                            </p>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
