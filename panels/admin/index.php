<?php 
session_start();
if(!empty($_SESSION['role'])){
    $title="home";
    require_once('header.php');
    require_once('./logics.class.php');
    
    $logic = new logics();
    $stats = $logic->getDashboardStats();
?>

<style>
.order-card {
    color: #fff;
    padding: 20px;
    margin-bottom: 25px;
    border-radius: 8px;
    min-height: 135px;
    transition: all 0.3s ease;
}

.order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.bg-products { background: linear-gradient(45deg, #4099ff, #73b4ff); }
.bg-orders { background: linear-gradient(45deg, #2ed8b6, #59e0c5); }
.bg-users { background: linear-gradient(45deg, #FFB64D, #ffcb80); }
.bg-categories { background: linear-gradient(45deg, #FF5370, #ff869a); }
.bg-reviews { background: linear-gradient(45deg, #7367F0, #9b94f3); }
.bg-payments { background: linear-gradient(45deg, #55CE63, #7fe48c); }
.bg-contacts { background: linear-gradient(45deg, #7A4EFF, #a485ff); }
.bg-subscribers { background: linear-gradient(45deg, #FF4E89, #ff7aa7); }

.card-icon {
    font-size: 30px;
    margin-bottom: 10px;
}

.stat-title {
    font-size: 16px;
    margin-bottom: 15px;
    opacity: 0.9;
}

.stat-number {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 5px;
}

.stat-info {
    font-size: 13px;
    opacity: 0.8;
}

.stats-card {
    background: #fff;
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
    transition: all 0.2s ease-in-out;
    border: 1px solid rgba(67, 89, 113, 0.08);
}

.stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px 0 rgba(67, 89, 113, 0.16);
}

.stats-icon {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.375rem;
    margin-bottom: 1rem;
    font-size: 1.25rem;
}

.stats-title {
    font-size: 0.875rem;
    font-weight: 500;
    color: #566a7f;
    margin-bottom: 0.5rem;
}

.stats-number {
    font-size: 1.5rem;
    font-weight: 600;
    color: #566a7f;
    margin-bottom: 0.5rem;
}

.stats-info {
    font-size: 0.813rem;
    color: #697a8d;
}

/* Icon background colors */
.bg-icon-primary { background-color: #e7e7ff; color: #696cff; }
.bg-icon-success { background-color: #e8fadf; color: #71dd37; }
.bg-icon-warning { background-color: #fff5e0; color: #ffab00; }
.bg-icon-danger { background-color: #ffe0db; color: #ff3e1d; }
.bg-icon-info { background-color: #d7f5fc; color: #03c3ec; }
.bg-icon-dark { background-color: #dcdfe1; color: #233446; }

.badge-stat {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    border-radius: 0.25rem;
}

.badge-primary { background-color: #e7e7ff; color: #696cff; }
.badge-success { background-color: #e8fadf; color: #71dd37; }
.badge-warning { background-color: #fff5e0; color: #ffab00; }

.bg-gradient-primary { background: linear-gradient(45deg, #4099ff, #73b4ff); }
.bg-gradient-success { background: linear-gradient(45deg, #2ed8b6, #59e0c5); }
.bg-gradient-warning { background: linear-gradient(45deg, #FFB64D, #ffcb80); }
.bg-gradient-danger { background: linear-gradient(45deg, #FF5370, #ff869a); }
.bg-gradient-info { background: linear-gradient(45deg, #7367F0, #9b94f3); }
.bg-gradient-dark { background: linear-gradient(45deg, #444444, #777777); }

.text-white { color: white !important; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Welcome Card -->
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Welcome <?php echo $_SESSION['role']; ?> 🎉</h5>
                            <p class="mb-4">Here's what's happening with your store today.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Orders Stats -->
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-icon-primary">
                    <i class="bi bi-cart"></i>
                </div>
                <div class="stats-title">Orders</div>
                <div class="stats-number"><?php echo number_format($stats['orders']['total_orders']); ?></div>
                <div class="stats-info">
                    <span class="badge-stat badge-warning"><?php echo $stats['orders']['pending_orders']; ?> pending</span>
                    <span class="badge-stat badge-success"><?php echo $stats['orders']['delivered_orders']; ?> delivered</span>
                </div>
            </div>
        </div>

        <!-- Revenue Stats -->
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-icon-success">
                    <i class="bi bi-currency-rupee"></i>
                </div>
                <div class="stats-title">Revenue</div>
                <div class="stats-number">₹<?php echo number_format($stats['orders']['total_revenue']); ?></div>
                <div class="stats-info">
                    <span class="badge-stat badge-success"><?php echo $stats['orders']['paid_orders']; ?> paid orders</span>
                </div>
            </div>
        </div>

        <!-- Products Stats -->
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-icon-warning">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stats-title">Products</div>
                <div class="stats-number"><?php echo number_format($stats['products']['total_products']); ?></div>
                <div class="stats-info">
                    <span class="badge-stat badge-primary"><?php echo $stats['products']['popular_products']; ?> popular</span>
                    • <?php echo $stats['products']['recommended_products']; ?> recommended
                </div>
            </div>
        </div>

        <!-- Categories Stats -->
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-icon-danger">
                    <i class="bi bi-grid"></i>
                </div>
                <div class="stats-title">Categories</div>
                <div class="stats-number"><?php echo number_format($stats['categories']['total_categories']); ?></div>
                <div class="stats-info">
                    <span class="badge-stat badge-primary"><?php echo $stats['categories']['total_subcategories']; ?> subcategories</span>
                </div>
            </div>
        </div>

        <!-- Users Stats -->
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-icon-info">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stats-title">Users</div>
                <div class="stats-number"><?php echo $stats['users']['total_users']; ?></div>
                <div class="stats-info">
                    Active registered users
                </div>
            </div>
        </div>

        <!-- Reviews Stats -->
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-icon-dark">
                    <i class="bi bi-star"></i>
                </div>
                <div class="stats-title">Reviews</div>
                <div class="stats-number"><?php echo $stats['users']['total_reviews']; ?></div>
                <div class="stats-info">
                    Product reviews & ratings
                </div>
            </div>
        </div>

        <!-- Cart Stats -->
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-icon-primary">
                    <i class="bi bi-basket"></i>
                </div>
                <div class="stats-title">Active Carts</div>
                <div class="stats-number"><?php echo $stats['cart']['users_with_cart']; ?></div>
                <div class="stats-info">
                    <?php echo $stats['cart']['total_cart_items']; ?> items in carts
                </div>
            </div>
        </div>

        <!-- Inquiries Stats -->
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon bg-icon-success">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <div class="stats-title">Inquiries</div>
                <div class="stats-number"><?php echo $stats['users']['total_inquiries']; ?></div>
                <div class="stats-info">
                    Contact form submissions
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
require_once('footer.php');
} else {
    header('location:login.php');
}
?>

