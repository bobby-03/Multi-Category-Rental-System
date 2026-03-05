<?php 
session_start();
include('db_connect.php'); 

$category_filter = isset($_GET['category_id']) ? " AND i.category_id = '{$_GET['category_id']}' " : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentIt - Multi-Category Rental System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .category-nav {
            background: #fff;
            padding: 20px 0;
            display: flex;
            justify-content: center;
            gap: 30px;
            overflow-x: auto;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border-bottom: 1px solid #eee;
        }
        .cat-item {
            text-decoration: none;
            text-align: center;
            min-width: 90px;
            transition: transform 0.2s;
            color: inherit;
        }
        .cat-item:hover { transform: translateY(-5px); }
        .cat-icon-wrapper {
            width: 70px;
            height: 70px;
            margin: 0 auto 10px;
            background: #f0f8ff;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }
        .cat-icon-wrapper img {
            width: 80%;
            height: 80%;
            object-fit: contain;
        }
        .cat-item p {
            font-size: 14px;
            font-weight: 600;
            color: #444;
            margin: 0;
        }
        .cat-item.active p { color: #007bff; }
        .cat-item.active .cat-icon-wrapper { border-color: #007bff; background: #e7f1ff; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; color: white; display: inline-block; }
        .bg-success { background: #28a745; }
        .bg-danger { background: #dc3545; }
    </style>
</head>
<body>

    <nav class="navbar">
    <div class="logo">Rent<span>It</span></div>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <?php if(isset($_SESSION['login_id'])): ?>
            <?php if($_SESSION['login_type'] == 1): ?>
                <li><a href="add_item.php">Add Item</a></li>
                <li><a href="my_bookings.php">All Bookings</a></li> 
                <li><a href="categories.php">Categories</a></li>
            <?php else: ?>
                <li><a href="user_history.php">My Rent History</a></li>
            <?php endif; ?>
            <li><a href="ajax.php?action=logout">Logout (<?php echo $_SESSION['login_name'] ?>)</a></li>
        <?php else: ?>
            <li><a href="login.php" class="login-btn">Login</a></li>
            <li><a href="signup.php" style="color: #28a745; font-weight: bold;">Sign Up</a></li>
        <?php endif; ?>
    </ul>
</nav>

    <div class="category-nav">
        <a href="index.php" class="cat-item <?php echo !isset($_GET['category_id']) ? 'active' : '' ?>">
            <div class="cat-icon-wrapper">
                <?php 
                $all_items_icon = 'assets/uploads/all_items_icon.png';
                if(file_exists($all_items_icon)){
                    echo '<img src="'.$all_items_icon.'?v='.time().'" alt="All Items">';
                } else {
                    echo '<img src="https://cdn-icons-png.flaticon.com/512/1160/1160358.png" alt="All Items">';
                }
                ?>
            </div>
            <p>All Items</p>
        </a>
        <?php 
        $cats = $conn->query("SELECT * FROM categories ORDER BY name ASC");
        while($row = $cats->fetch_assoc()):
        ?>
            <a href="index.php?category_id=<?php echo $row['id'] ?>" class="cat-item <?php echo (isset($_GET['category_id']) && $_GET['category_id'] == $row['id']) ? 'active' : '' ?>">
                <div class="cat-icon-wrapper">
                    <img src="assets/uploads/<?php echo $row['category_icon'] ?>" alt="<?php echo $row['name'] ?>">
                </div>
                <p><?php echo $row['name'] ?></p>
            </a>
        <?php endwhile; ?>
    </div>

    <header class="hero">
        <div class="hero-content">
            <h1>Rent Everything You Need</h1>
            <p>From houses to tools, all in one place.</p>
        </div>
    </header>

    <section class="container">
        <h2 class="section-title">
            <?php 
                if(isset($_GET['category_id'])){
                    $cat_id = $conn->real_escape_string($_GET['category_id']);
                    $category_res = $conn->query("SELECT name FROM categories WHERE id = '$cat_id'");
                    if($category_res && $category_res->num_rows > 0){
                        $cname = $category_res->fetch_assoc();
                        echo $cname['name'] . " for Rent";
                    } else {
                        echo "Available Items";
                    }
                } else {
                    echo "Available Items";
                }
            ?>
        </h2>
        
        <div class="item-grid">
            <?php 
            $sql = "SELECT i.*, c.name as category_name, 
                    (SELECT COUNT(id) FROM bookings b WHERE b.item_id = i.id AND b.status = 1) as is_rented 
                    FROM items i 
                    INNER JOIN categories c ON c.id = i.category_id 
                    WHERE 1=1 $category_filter 
                    ORDER BY i.id DESC";
            $result = $conn->query($sql);

            if($result && $result->num_rows > 0):
                while($row = $result->fetch_assoc()):
            ?>
                <div class="item-card">
                    <img src="assets/uploads/<?php echo $row['image_path']; ?>" alt="Item Image">
                    <div class="item-info">
                        <h3><?php echo ucwords($row['item_name']); ?></h3>
                        <div style="margin-bottom: 10px;">
                            <?php if($row['is_rented'] > 0): ?>
                                <span class="badge bg-danger">Already Booked</span>
                            <?php else: ?>
                                <span class="badge bg-success">Available</span>
                            <?php endif; ?>
                        </div>
                        <p><?php echo $row['description']; ?></p>
                        <div class="price">
                            ₹<?php echo number_format($row['price'], 2); ?><span>/day</span>
                        </div>

                        <?php if(isset($_SESSION['login_id'])): ?>
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <?php if($row['is_rented'] > 0): ?>
                                    <button class="rent-now" disabled style="background: #6c757d; cursor: not-allowed;">Currently Unavailable</button>
                                <?php else: ?>
                                    <button class="rent-now" onclick="openBooking(<?php echo $row['id']; ?>, <?php echo $row['price']; ?>)">Rent Now</button>
                                <?php endif; ?>
                                
                                <?php if($_SESSION['login_type'] == 1): ?>
                                    <div style="display: flex; flex-direction: column; gap: 5px;">
                                        <a href="add_item.php?id=<?php echo $row['id'] ?>" style="display:block; text-align:center; padding:10px; background:#ffc107; color:black; text-decoration:none; border-radius:5px; font-weight:bold;">Edit Item</a>
                                        <button onclick="deleteItem(<?php echo $row['id']; ?>)" style="width: 100%; padding: 10px; background: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight:bold;">Delete Item</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <a href="login.php" class="rent-now" style="display: block; text-align: center; text-decoration: none; background: #6c757d;">Login to Rent</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; else: echo "<p style='grid-column: 1/-1; text-align:center;'>No items found in this category.</p>"; endif; ?>
        </div>
    </section>

    <div id="bookingModal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
        <div style="background:white; width:400px; margin:100px auto; padding:20px; border-radius:10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
            <h3>Book This Item</h3>
            <hr>
            <form id="manage-booking">
                <input type="hidden" name="item_id" id="item_id">
                <input type="hidden" name="price_per_day" id="price_per_day"> 
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px;">Your Name</label>
                    <input type="text" name="customer_name" value="<?php echo $_SESSION['login_name'] ?? '' ?>" required style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                </div>
                <div style="margin-bottom:15px; display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label style="display:block; margin-bottom:5px;">Start Date</label>
                        <input type="date" name="date_start" id="date_start" required style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display:block; margin-bottom:5px;">Days to Rent</label>
                        <input type="number" name="days" id="days" min="1" value="1" required style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                    </div>
                </div>
                <div style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                    <h4 style="margin: 0; color: #28a745;">Total: ₹<span id="total_price">0.00</span></h4>
                </div>
                <div style="text-align:right; gap:10px; display:flex; justify-content: flex-end;">
                    <button type="button" onclick="closeBooking()" style="padding:8px 15px; background:#6c757d; color:white; border:none; border-radius:5px; cursor:pointer;">Cancel</button>
                    <button type="submit" style="padding:8px 15px; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">Confirm Booking</button>
                </div>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>