<?php 
include('db_connect.php'); 
$id = isset($_GET['id']) ? $_GET['id'] : '';
if($id){
    $qry = $conn->query("SELECT * FROM items WHERE id = $id")->fetch_assoc();
    if($qry){
        foreach($qry as $k => $v){
            $$k = $v;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title><?php echo isset($id) ? "Edit" : "Add New" ?> Rental Item</title>
</head>
<body>
    <div class="container mt-5" style="max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2><?php echo isset($id) ? "Edit Item" : "Add New Rental Item" ?></h2>
        <hr>
        <form id="manage-item">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            
            <div class="form-group mb-3">
                <label>Item Name</label>
                <input type="text" name="item_name" value="<?php echo isset($item_name) ? $item_name : '' ?>" class="form-control" style="width: 100%; padding: 8px;" required>
            </div>

            <div class="form-group mb-3">
                <label>Category</label>
                <select name="category_id" class="form-control" style="width: 100%; padding: 8px;" required>
                    <option value="" disabled <?php echo !isset($category_id) ? 'selected' : '' ?>>Select Category</option>
                    <?php 
                    $categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");
                    while($row = $categories->fetch_assoc()):
                    ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($category_id) && $category_id == $row['id'] ? 'selected' : '' ?>>
                            <?php echo $row['name'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Price per Day (₹)</label>
                <input type="number" name="price" value="<?php echo isset($price) ? $price : '' ?>" class="form-control" style="width: 100%; padding: 8px;" required>
            </div>

            <div class="form-group mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" style="width: 100%; padding: 8px;" rows="3" required><?php echo isset($description) ? $description : '' ?></textarea>
            </div>

            <div class="form-group mb-3">
                <label>Item Image (Leave blank to keep current image)</label>
                <input type="file" name="img" class="form-control" style="width: 100%; padding: 8px;" <?php echo !isset($id) ? 'required' : '' ?>>
            </div>

            <button type="submit" class="btn btn-primary" style="background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                <?php echo isset($id) ? "Update Item" : "Save Item" ?>
            </button>
            <a href="index.php" style="margin-left: 10px; color: #666; text-decoration: none;">Cancel</a>
        </form>
    </div>

    <script>
        document.getElementById('manage-item').onsubmit = function(e){
            e.preventDefault();
            let formData = new FormData(this);
            fetch('ajax.php?action=save_item', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if(data.trim() == 1){
                    alert("Item successfully saved!");
                    location.href = "index.php";
                } else {
                    alert("An error occurred.");
                }
            });
        }
    </script>
</body>
</html>