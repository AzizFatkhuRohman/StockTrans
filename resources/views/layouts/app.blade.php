<!doctype html>
<html lang="en">
@include('layouts.header')

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('layouts.sidebar')
        <!--  Header End -->
        <div class="container-fluid">
            @if (session('sukses'))
                <script>
                    Swal.fire({
                        title: "Good job!",
                        text: "{{ session('sukses') }}",
                        icon: "success"
                    });
                </script>
            @endif
            @if (session('gagal'))
            <script>
                Swal.fire({
                    title: "Opps!",
                    text: "{{ session('gagal') }}",
                    icon: "error"
                });
            </script>
        @endif
            @yield('main')
            <div class="py-6 px-6 text-center">
                <p class="mb-0 fs-4">Copyright <a href="https://adminmart.com/" target="_blank"
                        class="pe-1 text-primary text-decoration-underline">PT. CAHAYA RAHMAT NUSANTARA INDONESIA</a></p>
            </div>
        </div>
    </div>
    </div>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
