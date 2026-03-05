<?php 
session_start();
include('db_connect.php'); 
if(!isset($_SESSION['login_id'])) header("location:login.php");
$user_id = $_SESSION['login_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Rental History | RentIt</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="background-color: #f4f7f6;">

    <nav class="navbar" style="background: white; padding: 15px 10%; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <div class="logo" style="font-size: 24px; font-weight: bold;">Rent<span style="color: #007bff;">It</span></div>
        <a href="index.php" style="text-decoration: none; color: #007bff; font-weight: 500;">
            <i class="fa fa-home"></i> Back to Home
        </a>
    </nav>
    
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">My Rent History</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>                        
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Start Date</th>
                            <th>Duration</th> 
                            <th>Total Paid</th> 
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT b.*, i.item_name FROM bookings b INNER JOIN items i ON i.id = b.item_id WHERE b.user_id = '$user_id' ORDER BY b.id DESC");
                        
                        if($qry->num_rows > 0):
                            while($row = $qry->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $row['item_name'] ?></td>
                            <td><?php echo date("M d, Y", strtotime($row['date_start'])) ?></td>
                            <td><?php echo $row['days'] ?> days</td> 
                            <td>₹<?php echo number_format($row['total_amount'], 2) ?></td> 
                            <td>
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Completed / Returned</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger cancel_booking" data-id="<?php echo $row['id'] ?>">
                                    <?php echo ($row['status'] == 1) ? 'Cancel Rental' : 'Delete Record'; ?>
                                </button>
                            </td>
                        </tr>
                        <?php 
                            endwhile;
                        else:
                        ?>
                        <tr>
                            <td colspan="7" class="text-center">No rental history found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $('.cancel_booking').click(function(){
            var id = $(this).attr('data-id');
            var actionText = $(this).text().trim();
            if(confirm("Are you sure you want to " + actionText + "?")){
                $.ajax({
                    url: 'ajax.php?action=cancel_booking',
                    method: 'POST',
                    data: {id: id},
                    success: function(resp){
                        if(resp == 1){
                            alert("Action successful.");
                            location.reload();
                        } else {
                            alert("An error occurred.");
                        }
                    }
                })
            }
        })
    </script>
</body>
</html>