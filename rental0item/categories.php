<?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Categories</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="background-color: #f4f7f6;">
    <nav class="navbar" style="background: white; padding: 15px 10%; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <div class="logo">Rent<span>It</span> Admin</div>
        <a href="index.php" style="text-decoration: none; color: #007bff;">Back to Home</a>
    </nav>

    <div class="container mt-5">
        
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">Manage "All Items" Default Icon</div>
            <div class="card-body">
                <form id="manage-all-items-icon" class="d-flex align-items-center gap-3">
                    <div style="flex-grow: 1;">
                        <input type="file" name="icon" class="form-control" accept="image/*" required>
                    </div>
                    <button class="btn btn-success">Update "All Items" Icon</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">Category Form</div>
                    <div class="card-body">
                        <form id="manage-category">
                            <input type="hidden" name="id">
                            <div class="form-group mb-3">
                                <label>Category Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Category Icon</label>
                                <input type="file" name="icon" class="form-control" accept="image/*">
                                <small class="text-muted">Leave blank to keep existing icon</small>
                            </div>
                            <button class="btn btn-primary w-100">Save Category</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">Category List</div>
                    <div class="card-body">
                        <table class="table table-bordered bg-white">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Icon</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $cats = $conn->query("SELECT * FROM categories ORDER BY name ASC");
                                while($row=$cats->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td>
                                        <img src="assets/uploads/<?php echo $row['category_icon'] ?>" width="50px" height="50px" style="object-fit:cover; border-radius:5px">
                                    </td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info text-white edit_category" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>">Edit</button>
                                        <button class="btn btn-sm btn-danger delete_category" data-id="<?php echo $row['id'] ?>">Delete</button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update All Items Icon
        $('#manage-all-items-icon').submit(function(e){
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url:'ajax.php?action=save_all_items_icon',
                method:'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(resp){
                    if(resp == 1){
                        alert("'All Items' icon updated successfully.");
                        location.reload();
                    } else {
                        alert("Error updating icon.");
                    }
                }
            })
        });

        // Edit Existing Category
        $('.edit_category').click(function(){
            var form = $('#manage-category');
            form.find("[name='id']").val($(this).attr('data-id'));
            form.find("[name='name']").val($(this).attr('data-name'));
        });

        // Save Category
        $('#manage-category').submit(function(e){
            e.preventDefault();
            var formData = new FormData($(this)[0]); 
            $.ajax({
                url:'ajax.php?action=save_category',
                method:'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(resp){
                    if(resp == 1){
                        alert("Category saved successfully.");
                        location.reload();
                    } else {
                        alert("Error saving category.");
                    }
                }
            })
        });

        // Delete Category
        $('.delete_category').click(function(){
            if(confirm("Are you sure? Items in this category might break.")){
                $.ajax({
                    url:'ajax.php?action=delete_category',
                    method:'POST',
                    data:{id:$(this).attr('data-id')},
                    success:function(resp){
                        if(resp == 1) location.reload();
                    }
                })
            }
        });
    </script>
</body>
</html>