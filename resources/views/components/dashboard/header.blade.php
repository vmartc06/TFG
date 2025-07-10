<div class="main-header">
    <div class="logo-header">
        <span class="logo">
            Androidade
        </span>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
    </div>
    <nav class="navbar navbar-header navbar-expand-lg">
        <div class="container-fluid">

            <form class="navbar-left navbar-form nav-search mr-md-3" action="">
                <div class="input-group">
                    <input type="text" placeholder="Buscar..." class="form-control">
                    <div class="input-group-append">
								<span class="input-group-text">
									<i class="la la-search search-icon"></i>
								</span>
                    </div>
                </div>
            </form>
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="la la-bell"></i>
                        <span class="notification" style="display: none">0</span>
                    </a>
                    <ul class="dropdown-menu notif-box" aria-labelledby="navbarDropdown">
                        <li>
                            <div class="dropdown-title">No tienes notificaciones</div>
                        </li>
                        <li>
                            <div class="notif-center">
                                <!-- TODO Ejemplo de notificación
                                <a href="#">
                                    <div class="notif-icon notif-primary"> <i class="la la-user-plus"></i> </div>
                                    <div class="notif-content">
												<span class="block">
													New user registered
												</span>
                                        <span class="time">5 minutes ago</span>
                                    </div>
                                </a>
                                -->
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false"> <img src="data:image/png;base64, {{ $profilePictureEnc }}" alt="user-img" width="36" class="img-circle"><span>{{ $user->name }}</span> </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <div class="user-box">
                                <div class="u-img"><img src="data:image/png;base64, {{ $profilePictureEnc }}" alt="user"></div>
                                <div class="u-text">
                                    <h4>{{ $user->name }}</h4>
                                    <p class="text-muted">{{ $user->email }}</p><a href="profile.html" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                            </div>
                        </li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="ti-user"></i> My Profile</a>
                        <a class="dropdown-item" href="#"> My Balance</a>
                        <a class="dropdown-item" href="#"><i class="ti-email"></i> Inbox</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="ti-settings"></i> Account Setting</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="fa fa-power-off"></i> Logout</a>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
            </ul>
        </div>
    </nav>
</div>