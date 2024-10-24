<!DOCTYPE html>
<html lang="en">
  @include("layout.header")
<body class="g-sidenav-show  bg-gray-200">
    @include("layout.sideNavBar")
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include("layout.topNavBar")        
        <div class="container-fluid py-4 d-flex flex-column justify-content-between" style="min-height:95vh">
            @yield("content")
            @include("layout.footer")
        </div>
    </main>

  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>
</body>
</html>
