
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
        Exchange Demo
  </title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" /> 
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
</head>

<body class="bg-gray-200">
  <main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Log in</h4>
                </div>
              </div>
              <div class="card-body">
                <form id="loginForm" role="form" class="text-start" method="post" action="{{route('login.post')}}">
                  @csrf
                  <div class="input-group input-group-outline my-3">
                    <select class="form-control" name="userRole" id="userRole" onchange="toggleExchangeDropdown()">
                      <option value="" disabled selected>Select your Role</option>
                      <option value="admin">Admin</option>
                      <option value="exchange">Exchange</option>
                      <option value="carecenter">Care Center</option>
                    </select>
                  </div>
                  <div id="userFields">
                    <div class="input-group input-group-outline my-3">
                      <input type="text" class="form-control" id="name" name="name" placeholder="Enter User Name" required>
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <input type="password" class="form-control" id="password"  name="password" placeholder="Enter Password" required>
                    </div>
                  </div>
                  <div id="ExchangeDropdown" style="width: 100%;" class="input-group input-group-outline mb-3">
                      <select class="form-control" id="exchange" name="exchange">
                          <option value="" disabled selected>Select Your Exchange</option>
                          <option value="Exchange1">Exchange 1</option>
                          <option value="Exchange2">Exchange 2</option>
                          <option value="Exchange3">Exchange 3</option>
                      </select>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign in</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>

  <script>
    function toggleExchangeDropdown() {
      const userRole = document.getElementById('userRole').value;
      const ExchangeDropdown = document.getElementById('ExchangeDropdown');
      if (userRole == 'exchange') {
        ExchangeDropdown.style.display = 'block';
      } else {
        ExchangeDropdown.style.display = 'none';
      }
    }    
  </script>
</body>
</html>