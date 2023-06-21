<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>

  <!-- Header -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #337AB7;">
        <div class="container">
            <a class="navbar-brand" href="/" style="font-weight: bold;">Employee Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/" style="font-weight: bold;">Home</a>
                    </li>
                    @if(auth()->check() && auth()->user()->user_type == 'owner')
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/employee-list" style="font-weight: bold;">EmployeeList</a>
                    </li>
                    @endif

                    @auth
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#" style="font-weight: bold;">Welcome {{ auth()->user()->name }}</a>
                    </li>
                    @if(auth()->check() && auth()->user()->user_type == 'employee')
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/check-in-out-page" style="font-weight: bold;">CheckInOut</a>
                    </li>
                    @endif

                    <li class="nav-item">
                        <form class="d-inline" method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="btn btn-link text-white">
                                Logout
                            </button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/login" style="font-weight: bold;">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/registation" style="font-weight: bold;">OwnerRegister</a>
                    </li>
                    @endauth
                </ul>

            </div>
        </div>
    </nav>
</header>
<!-- Flash message -->
@if (session()->has('message'))
    <div class="position-fixed top-0 start-50 translate-middle-x mt-4" style="z-index: 1000;">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif


  <!-- Content goes here -->
  <main>
    {{$slot}}
  </main>



  <!-- Footer -->
  <footer style="background-color: #003366; color: #FFFFFF;">
    <div class="container py-5">
      <div class="row">
        <div class="col-md-4">
          <h5>About Us</h5>
          <p>Manage your employee!</p>
        </div>
        <div class="col-md-4">
          <h5>Quick Links</h5>
          <ul class="list-unstyled">
            <li><a href="/">Home</a></li>
          </ul>

        </div>
        <div class="col-md-4">
          <h5>Contact</h5>
          <ul class="list-unstyled">
            <li>Address: 123 Employee Street, Dhaka, Bangladesh</li>
            <li>Email: info@employe.emanage.com</li>
            <li>Phone: +1 123 456 7890</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="text-center py-3">
      <p>&copy; 2023 Employee Management System. All rights reserved.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>




</body>
</html>
