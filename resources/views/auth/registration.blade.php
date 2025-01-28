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
        body {

            height: auto;
            margin: 0;
            position: relative;
            /* overflow: hidden; */
        }

        /* Add a blur effect using a pseudo-element */
        body::before {
            background-image: url('{{ asset('assets/img/photos/network.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            -webkit-backdrop-filter: blur(5px);
            backdrop-filter: blur(50px);
            background-color: rgba(255, 255, 255, 0.4);
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        body::after {

            -webkit-backdrop-filter: blur(5px);
            backdrop-filter: blur(4px);
            background-color: rgba(255, 255, 255, 0.4);


            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* filter: blur(4px); */
            z-index: 1;
        }

        main {
            padding-top: 20px;
            padding-bottom: 20px;
            position: relative;
            z-index: 3;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.6);
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
            margin-bottom: 0px;
        }


        input,
        select {
            border-radius: 30px !important;
        }

        p {
            font-weight: 600;
            font-size: 18px;
        }
    </style>

</head>

<body>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-12 mx-auto d-table">
                    <div class="d-table-cell align-middle">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center mt-4">
                                    <h1 class="h2">Registration</h1>
                                    <p class="lead">
                                        Sign up to your account to continue
                                    </p>
                                </div>
                                <div class="m-sm-3">
                                    <form method="post" action="{{ route('register.post') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                <label class="form-label">Full Name</label>
                                                <input class="form-control mb-2" type="text" name="full_name"
                                                    placeholder="Enter your Full Name">
                                                <p class="help text-sm">
                                                    What is your full name?
                                                </p>
                                                @error('full_name')
                                                    <span class="invalid-feedback" style="display:block !important; font-size:100% !important;" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                <label class="form-label">Email</label>
                                                <input class="form-control mb-2" type="email" name="email"
                                                    placeholder="Enter your Email">
                                                <p class="help text-sm">
                                                    Would you like to share your email address?
                                                </p>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                <label class="form-label">Country</label>
                                                <select name="country" class="form-select mb-2">
                                                    <option value="">--Select your Country--</option>
                                                    @foreach (countries() as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <p class="help text-sm">
                                                    Where are you currently living? (Country)
                                                </p>
                                                @error('country')
                                                    <span class="invalid-feedback" style="display:block !important; font-size:100% !important;" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                <label class="form-label">Originally Country</label>
                                                <select name="o_country" class="form-select mb-2">
                                                    <option value="">--Select your Originally Country--</option>
                                                    @foreach (countries() as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <p class="help text-sm">
                                                    Where are you originally from? (Country)
                                                </p>
                                                @error('o_country')
                                                    <span class="invalid-feedback" style="display:block !important; font-size:100% !important;" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                <label class="form-label">City</label>
                                                <input class="form-control mb-2" type="text" name="city"
                                                    placeholder="Enter your City">
                                                <p class="help text-sm">
                                                    What city are you in right now?
                                                </p>
                                                @error('city')
                                                    <span class="invalid-feedback" style="display:block !important; font-size:100% !important;" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                <label class="form-label">Hometown <strong>OR</strong> Native
                                                    City</label>
                                                <input class="form-control mb-2" type="text" name="home_town"
                                                    placeholder="Enter your Hometown or Native City">
                                                <p class="help text-sm">
                                                    What’s your hometown or native city?
                                                </p>
                                                @error('home_town')
                                                    <span class="invalid-feedback" style="display:block !important; font-size:100% !important;" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                <label class="form-label">University <strong>OR</strong>
                                                    Institution</label>
                                                <input class="form-control mb-2" type="text" name="university"
                                                    placeholder="Enter your University or Institution">
                                                <p class="help text-sm">
                                                    What university or institution are you currently attending?
                                                </p>
                                                @error('university')
                                                    <span class="invalid-feedback" style="display:block !important; font-size:100% !important;" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                <label class="form-label">Passing Year</label>
                                                <input class="form-control mb-2" type="text" name="passing_year"
                                                    placeholder="Enter your Passing Year">
                                                <p class="help text-sm">
                                                    What is the batch or year you are studying in?
                                                </p>
                                                @error('passing_year')
                                                    <span class="invalid-feedback" style="display:block !important; font-size:100% !important;" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                <label class="form-label">Degree Program</label>
                                                <input class="form-control mb-2" type="text" name="degree"
                                                    placeholder="Enter your Degree Program">
                                                <p class="help text-sm">
                                                    What degree program are you pursuing? (Undergraduate, Master’s, PhD,
                                                    etc.)
                                                </p>
                                                @error('degree')
                                                    <span class="invalid-feedback" style="display:block !important; font-size:100% !important;" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                <label class="form-label">Working <strong>OR</strong> Business
                                                    Owner</label>
                                                <input class="form-control mb-2" type="text"
                                                    name="working_or_business"
                                                    placeholder="Enter your Working Or Business Owner">
                                                <p class="help text-sm">
                                                    Are you currently working, or are you a business owner?
                                                </p>
                                                @error('working_or_business')
                                                    <span class="invalid-feedback" style="display:block !important; font-size:100% !important;" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                <label class="form-label">User Name</label>
                                                <input class="form-control mb-2" type="text" name="user_name"
                                                    placeholder="Enter your User Name">
                                                @error('user_name')
                                                    <span class="invalid-feedback" style="display:block !important; font-size:100% !important;" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                <label class="form-label">Password</label>
                                                <input class="form-control mb-2" type="password" name="password"
                                                    placeholder="Enter your Password">
                                                @error('password')
                                                    <span class="invalid-feedback" style="display:block !important; font-size:100% !important;" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                <label class="form-label">Confirm Password</label>
                                                <input class="form-control mb-2" type="password"
                                                    name="password_confirmation"
                                                    placeholder="Enter your Confirm Password">
                                            </div>
                                            <div class="col-xl-8 col-lg-8 col-md-6 col-12 mt-4">
                                                <button type="submit" class="btn btn-lg btn-success w-100">Sign
                                                    up</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="text-center mb-3">
                                    Already have account? <a href="{{ route('login') }}">Log In</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
