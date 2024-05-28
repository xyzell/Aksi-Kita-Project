<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-warning sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <i class="fas fa-toolbox"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ADMIN</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Campaign
    </div>

    <!-- Nav Item - Orders -->
    <li class="nav-item">
        <a class="nav-link" href="admin.php">
            <i class="fas fa-toolbox"></i>
            <span>Admin</span></a>
    </li>

    <!-- Nav Item - Orders -->
    <li class="nav-item">
        <a class="nav-link" href="user.php">
            <i class="fa fa-users"></i>
            <span>User</span></a>
    </li>

    <!-- Nav Item - Orders -->
    <li class="nav-item">
        <a class="nav-link" href="organizer.php">
            <i class="fa fa-user-plus"></i>
            <span>Organizer</span></a>
    </li>

    <!-- Nav Item - Products -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-luggage-cart"></i>
            <span>Campaign Management</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Campaign Management</h6>
                <a class="collapse-item" href="campaign.php">Campaign List</a>
                <a class="collapse-item" href="products.php">Certificate List</a>
                <a class="collapse-item" href="products.php">Task List</a>
                <a class="collapse-item" href="products.php">Feedback List</a>
                <a class="collapse-item" href="products.php">Comment</a>
                <!-- <a class="collapse-item" href="create_product.php">User Product</a>
                <a class="collapse-item" href="create_product.php">Campaign List</a> -->
            </div>
        </div>
    </li>

    <!-- Nav Item - Customers -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="customers.php">
            <i class="fas fa-users"></i>
            <span>Customers</span></a>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Account
    </div>

    <!-- Nav Item - Customers -->
    <li class="nav-item">
        <a class="nav-link" href="#displayAccount" data-toggle="modal">
            <i class="fas fa-user"></i>
            <span>Account</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
<!-- Modal -->
<div class="modal fade" id="displayAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Info Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-sm-10 col-md-8">
                        <div class="card text-center border-0 shadow-sm">
                            <div class="card-body">
                                <h4 class="card-title text-primary">
                                    <?php if (isset($_SESSION['admin_name'])) {
                                        echo $_SESSION['admin_name'];
                                    } ?>
                                </h4>
                                <p class="card-text">
                                    <i class="fas fa-envelope text-secondary"></i>
                                    <?php if (isset($_SESSION['admin_email'])) {
                                        echo $_SESSION['admin_email'];
                                    } ?>
                                </p>
                                <p class="card-text">
                                    <i class="fas fa-phone text-secondary"></i>
                                    <?php if (isset($_SESSION['admin_phone'])) {
                                        echo $_SESSION['admin_phone'];
                                    } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>