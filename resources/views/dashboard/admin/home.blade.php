@extends('layouts.layout')
@section('title', 'KYC-XEPAYS | Admin-Home')
@section('content')


    <style>
        .layout-wrapper {
            display: flex;
        }

        .layout-container {
            flex: 1;
        }

        .layout-content {
            width: calc(100% - 250px);
            /* Adjust as needed */
        }

        .navbar-custom {
            width: calc(100% + 250px);
            /* Adjust as needed */
            max-width: none;
            /* Override max-width */
        }

        @media (max-width: 991.98px) {
            .layout-content {
                width: 100%;
            }

            .navbar-custom {
                width: 100%;
            }
        }

        .app-brand-logo {
            display: inline-block;
            vertical-align: middle;
            width: 40px;
            /* Adjust as needed */
            height: 40px;
            /* Adjust as needed */
            margin-right: 10px;
            /* Adjust as needed */
        }

        .app-brand-text {
            display: inline-block;
            vertical-align: middle;
            font-size: 1.5rem;
            /* Adjust as needed */
            font-weight: bold;
        }
    </style>

    <!-- Menu -->
    <div class="sidebar" id="btn">
        <div class="app-brand demo">
            <a href="" class="app-brand-link">
                {{-- <img src="../assets/img/avatars/logo.jpeg" alt="Company Logo" class="app-brand-logo demo">
                <span class="demo menu-text-lg fw-bolder">KYC-XEPAYS</span>
                <i class="bx bx-menu" id="btn"></i> --}}
            </a>
        </div>



        <div class="logo_details">
            {{-- <i class="bx bxl-audible icon"></i> --}}
            <img src="../assets/img/avatars/logo.jpeg" alt="Company Logo" class="app-brand-logo demo">
            <div class="logo_name">KYC-XEPAYS</div>
            <i class="bx bx-menu" id="btn"></i>
        </div>



        <ul class="nav-list">
            <li><a href="#"><i class="bx bx-grid-alt"></i><span class="link_name">Dashboard</span></a></li>
            <li><a href="#"><i class="bx bx-user"></i><span class="link_name">User</span></a></li>
            <li><a href="#"><i class="bx bx-chat"></i><span class="link_name">Message</span></a></li>
            <li><a href="#"><i class="bx bx-pie-chart-alt-2"></i><span class="link_name">Analytics</span></a></li>
            <li><a href="#"><i class="bx bx-folder"></i><span class="link_name">File Manger</span></a></li>
            <li><a href="#"><i class="bx bx-cart-alt"></i><span class="link_name">Order</span></a></li>
            <li><a href="#"><i class="bx bx-cog"></i><span class="link_name">Settings</span></a></li>
        </ul>
        <div class="profile">
            <div class="admin-info">
                <a class="dropdown-item" href="#">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                                <img src="../assets/img/avatars/1.png" alt="Admin Avatar"
                                    class="w-px-30 h-auto rounded-circle" />
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{ Auth::guard('admin')->user()->name }}</span>
                            <small class="text-muted">{{ Auth::guard('admin')->user()->email }}</small><br>
                        </div>
                    </div>
                </a>
            </div>

            <div>
                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="bx bx-log-out" id="log_out"></i>&nbsp;&nbsp;
                    <span class="align-middle">LogOut</span>

                    <form action="{{ route('admin.logout') }}" method="post" class="d-none" id="logout-form">@csrf
                    </form>
                </a>
            </div>

        </div>
    </div>
@endsection
