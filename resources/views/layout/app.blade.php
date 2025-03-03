<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') | {{ config('app.name') }}</title>

    <link rel="icon" href="{{asset('assets/foto/logo.png')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://bootswatch.com/5/united/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('assets/logo.png')}}"> -->
</head>
<style>
         body {
            font-family: 'Lato', sans-serif;
            color: white;
            background-color: #151521;
        }
.guide{
    position:fixed; top:5%; right:3% ;
}
        .sidebar {
            background-color: #29293d;
            width: 250px;
            position: fixed;
            overflow-y: auto;
            padding-top: 20px;
            height: 95vh;
            border-radius: 20px ;
        }
        .nav-link.active {
    background-color: #435ebe;
    color: black;
    border-radius: 8px;
}

        .sidebar h3 {
            color: #435ebe;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            font-size: 20px;
        }

        .sidebar .nav-link {
            color: white;
            font-size: 16px;
            padding: 10px 15px;
        }

        .sidebar .nav-links {
            color: #435ebe;
            font-size: 17px;
        }
        .sidebar .nav-item:hover .nav-link {
            color: blue;
        }

        .main-content {
            margin-left: 250px; /* Offset the width of the sidebar */
            max-height: 100vh;
            position: fixed;
            overflow-y: auto;
        }

        .card {
            color: black;
        }

        .card-body {
            display: flex;
            align-items: center;
            padding: 20px;
            color: white;
            background-color: #1e1e2d;
            border-radius:8px;
        }
        .card-bodys{
            align-items: center;
            padding: 20px;
            color: white;
            background-color: #1e1e2d;
            border-radius: 8px;
        }

        .card-body i {
            font-size: 30px;
            margin-right: 110px;
        }
        
        .card-body .card-text {
            justify-content: center;
            align-items: center;
            display: flex;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .card-text {
            font-size: 16px;
            margin: 0;
        }
        .nav-link {
          font-size: 29px;
          color: #435ebe;
        }
        .btn-toggle {
            background-color: #2e2e48;
            color: #fff;
        }
        
    /* Change icon color to gray on hover */
    .nav-item:hover i {
        color:  black; /* Gray color on hover */
    }

    /* Change the whole list item color to gray on hover */
    .nav-item:hover .nav-link:hover {
        background-color: #435ebe; /* Light gray background on hover */
        color: black; /* Change text color to gray on hover */
        border-radius: 8px; /* Optional: Add rounded corners */
    }

    /* Change the text color of the "Kas" menu item to blue on hover */
     .nav-link .active {
        color: black; /* Text color changes to blue */
    }

    /* Change background color of "Kas" menu item on hover */
    .row h2{
        color: #435ebe;
        font-weight: bold;
        font-size: 30px;
    }
    .row h2 {
        color: #657bc1;
        font-weight: bold;
        font-size: 30px;
    }
    .back{
        background-color: #151521;
        padding: 20px;
        position: relative;
    }
    .container-fluid{
        background-color: #151521;
        border-radius: 25px;
    }
    @media (max-width: 596px) {
  
    }
    @media (max-width: 868px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                height: 100%;
                overflow-y: auto;
                transition: all 0.3s;
                z-index: 1050;
            }
.guide{
    top:10%;
}
            .sidebar.show {
                left: 0;
            }

            .sidebar-backdrop {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1040;
            }

            .sidebar-backdrop.show {
                display: block;
            }

            .navbar-toggler {
                border: none;
                color: white;
                font-size: 1.5rem;
            }
        }
        .bg-dark{
            background-color:#161622 !important;
        }
        .pp{
            background-color:#0d0d17 !important;
        }
        #driver-page-overlay {
        backdrop-filter: blur(1000px) saturate(500%)!important;
-webkit-backdrop-filter: blur(1000px) saturate(500%)!important;
background-color: rgba(0, 0, 0, 0.78)!important;
border-radius: 12px !important;
border: 1px solid rgba(255, 255, 255, 0.125)!important;

  }

  /* Gaya highlight yang diinginkan untuk elemen yang di-highlight */
  #driver-highlighted-element-stage {
    backdrop-filter: blur(0px) saturate(200%)!important;
    -webkit-backdrop-filter: blur(0px) saturate(200%)!important;
    background-color: rgba(255, 255, 255, 0.125)   !important;
    border-radius: 12px !important;
    border: 2px solid rgba(255, 255, 255, 0.125)!important;
  }
</style>

<body>
<div class="back">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="navbar navbar-dark bg-dark d-md-none">
        <div class="container-fluid pp">
            <button class="navbar-toggler" type="button" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
            <span class="navbar-brand">CashZone</span>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar d-md-block" id="sidebar">
        <div class="position-sticky pt-1">
            <div class="d-flex align-items-center px-3 py-2 mt-2">
                <img src="{{asset('assets/foto/logo_6.png')}}" alt="Logo" style="width: 50px; height: 50px; margin-right: 10px;">
                <h2>Cash<span>Zone</span></h2>
            </div>
            <ul class="nav flex-column px-3">
                <li class="nav-item mb-3">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
           href="{{ route('admin.dashboard') }}">
            <span><i class="fa-solid fa-tachometer-alt"></i></span> 
            <span class="ms-2">Dashboard</span>
        </a>
    </li>
    <p class="nav-links text-white" style="font-size: 1rem;">
        <i class="fa-solid fa-list"></i>
    </p>
    <li class="nav-item mb-3">
        <a class="nav-link {{ request()->routeIs('admin.users.list') ? 'active' : '' }}" 
           style="font-size: 1rem;" 
           href="{{ route('admin.users.list', ['status' => 'admin']) }}">
            <span><i class="fa-solid fa-user"></i></span> 
            <span class="ms-2">Akun</span>
        </a>
    </li>
    
    <li class="nav-item mb-3">
        <a class="nav-link {{ request()->routeIs('tabungan.index') ? 'active' : '' }}" 
           href="{{ route('tabungan.index') }}">
            <span><i class="fa-solid fa-piggy-bank"></i></span> 
            <span class="ms-2">Tabungan</span>
        </a>
    </li>
    
    <li class="nav-item mb-3">
        <a class="nav-link {{ request()->routeIs('tabungan.riwayat') ? 'active' : '' }}" 
           href="{{ route('tabungan.riwayat') }}">
            <span><i class="fa-solid fa-history"></i></span> 
            <span class="ms-2">Riwayat</span>
        </a>
    </li>
    
    <li class="nav-item mb-3">
        <a class="nav-link {{ request()->routeIs('approved.index') ? 'active' : '' }}" 
           href="{{ route('approved.index') }}">
            <span><i class="fa-solid fa-check-circle"></i></span> 
            <span class="ms-2">Approved</span>
            @php
                $approvedCount = \App\Models\Approved::count();
            @endphp
            @if($approvedCount > 0)
                <span style="background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; margin-left: 5px;">
                    {{ $approvedCount }}
                </span>
            @endif
        </a>
    </li>
    
    <li class="nav-item mb-3">
        <a class="nav-link {{ request()->routeIs('acara.acara') ? 'active' : '' }}" 
           href="{{ route('acara.acara') }}">
            <span><i class="fa-solid fa-calendar-alt"></i></span> 
            <span class="ms-2">Acara</span>
        </a>
    </li>
                <li class="nav-item mb-3">
    <a class="nav-link justify-content-between" href="{{ url('/logout') }}">
        <span><i class="fa-solid fa-right-from-bracket"></i></span> <span class="ms-2">Keluar</span>
    </a>
</li>


            </ul>
        </div>
    </div>

    <!-- Backdrop for sidebar -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 ">
                

             
    <div class="background-flexbox">
        @yield('content')    
    <button class="guide btn btn-primary btn-sm mb-3" ><i class="fa-solid fa-question"></i> how to use</button>

    </div>
    <script>
        // JavaScript to toggle sidebar
        const sidebar = document.getElementById('sidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const toggleSidebar = document.getElementById('toggleSidebar');

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            sidebarBackdrop.classList.toggle('show');
        });

        sidebarBackdrop.addEventListener('click', () => {
            sidebar.classList.remove('show');
            sidebarBackdrop.classList.remove('show');
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>
    <!-- <script src="script.js"></script> -->
</body>

</html>