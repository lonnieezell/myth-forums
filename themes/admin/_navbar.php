<div class="main-navbar sticky-top bg-white">
    <!-- Main Navbar -->
    <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
        <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex" _lpchecked="1">
            <div class="input-group input-group-seamless ml-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
                <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search">
            </div>
        </form>
        <ul class="navbar-nav border-left flex-row ">
            <li class="nav-item border-right dropdown notifications">
                <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="nav-link-icon__wrapper">
                        <i class="material-icons"></i>
                        <span class="badge badge-pill badge-danger">2</span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">
                        <div class="notification__icon-wrapper">
                            <div class="notification__icon">
                                <i class="material-icons"></i>
                            </div>
                        </div>
                        <div class="notification__content">
                            <span class="notification__category">Analytics</span>
                            <p>Your website’s active users count increased by <span class="text-success text-semibold">28%</span> in the last week. Great job!</p>
                        </div>
                    </a>
                    <a class="dropdown-item" href="#">
                        <div class="notification__icon-wrapper">
                            <div class="notification__icon">
                                <i class="material-icons"></i>
                            </div>
                        </div>
                        <div class="notification__content">
                            <span class="notification__category">Sales</span>
                            <p>Last week your store’s sales count decreased by <span class="text-danger text-semibold">5.52%</span>. It could have been worse!</p>
                        </div>
                    </a>
                    <a class="dropdown-item notification__all text-center" href="#"> View all Notifications </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle mr-2" src="<?= $currentUser->avatar(40) ?>>" alt="User Avatar"> <span class="d-none d-md-inline-block"><?= $currentUser->username ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-small" style="display: none;">
                    <a class="dropdown-item" href="user-profile-lite.html"><i class="material-icons"></i> Profile</a>
                    <a class="dropdown-item" href="components-blog-posts.html"><i class="material-icons">vertical_split</i> Blog Posts</a>
                    <a class="dropdown-item" href="add-new-post.html"><i class="material-icons">note_add</i> Add New Post</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="#">
                        <i class="material-icons text-danger"></i> Logout </a>
                </div>
            </li>
        </ul>
        <nav class="nav">
            <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                <i class="material-icons"></i>
            </a>
        </nav>
    </nav>
</div>



