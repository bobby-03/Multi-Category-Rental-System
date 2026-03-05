<?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="background-color: #f4f7f6;">

    <nav class="navbar" style="background: white; padding: 15px 10%; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <div class="logo" style="font-size: 24px; font-weight: bold;">Rent<span style="color: #007bff;">It</span> Admin</div>
        <a href="index.php" style="text-decoration: none; color: #007bff;">Back to Home</a>
    </nav>
    
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-left-primary" style="border-left: 5px solid #007bff;">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Revenue (Completed)</div>
                        <?php 
                        // Only count revenue from bookings with status = 2 (Completed)
                        $revenue = $conn->query("SELECT SUM(total_amount) as total FROM bookings WHERE status = 2");
                        $total_rev = $revenue->fetch_assoc()['total'] ?? 0;
                        ?>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">₹<?php echo number_format($total_rev, 2) ?></div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow-sm border-left-success" style="border-left: 5px solid #28a745;">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Current Active Rentals</div>
                        <?php 
                        $active = $conn->query("SELECT count(id) as count FROM bookings WHERE status = 1");
                        $total_active = $active->fetch_assoc()['count'] ?? 0;
                        ?>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_active ?> Active</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-left-info" style="border-left: 5px solid #17a2b8;">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Items in Gallery</div>
                        <?php 
                        $items_count = $conn->query("SELECT count(id) as count FROM items");
                        $total_items = $items_count->fetch_assoc()['count'] ?? 0;
                        ?>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_items ?> Items</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Current Bookings</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>                        
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Item Rented</th>
                            <th>Start Date</th>
                            <th>Days</th> 
                            <th>Total Amount</th> 
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT b.*, i.item_name FROM bookings b INNER JOIN items i ON i.id = b.item_id ORDER BY b.id DESC");
                        
                        if($qry->num_rows > 0):
                            while($row = $qry->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo ucwords($row['customer_name']) ?></td>
                            <td><?php echo $row['item_name'] ?></td>
                            <td><?php echo date("M d, Y", strtotime($row['date_start'])) ?></td>
                            <td><?php echo $row['days'] ?> days</td> 
                            <td>₹<?php echo number_format($row['total_amount'], 2) ?></td> 
                            <td>
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Completed</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($row['status'] == 1): ?>
                                    <button class="btn btn-sm btn-outline-success complete_booking" data-id="<?php echo $row['id'] ?>">Complete</button>
                                <?php endif; ?>
                                <button class="btn btn-sm btn-outline-danger delete_booking" data-id="<?php echo $row['id'] ?>">Delete</button>
                            </td>
                        </tr>
                        <?php 
                            endwhile;
                        else:
                        ?>
                        <tr>
                            <td colspan="8" class="text-center">No bookings found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $('.delete_booking').click(function(){
            var id = $(this).attr('data-id'); 
            if(confirm("Are you sure you want to delete this booking?")){
                $.ajax({
                    url: 'ajax.php?action=delete_booking', 
                    method: 'POST',
                    data: {id: id},
                    success: function(resp){
                        if(resp == 1){
                            alert("Booking deleted successfully.");
                            location.reload(); 
                        } else {
                            alert("An error occurred.");
                        }
                    }
                });
            }
        });

        $('.complete_booking').click(function(){
            var id = $(this).attr('data-id');
            if(confirm("Mark this rental as completed?")){
                $.ajax({
                    url: 'ajax.php?action=complete_booking', 
                    method: 'POST',
                    data: {id: id},
                    success: function(resp){
                        if(resp == 1){
                            alert("Booking marked as completed.");
                            location.reload();
                        } else {
                            alert("An error occurred.");
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>