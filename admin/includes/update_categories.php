<form action="" method="post">
    <div class="form-gourp">
        <label for="cat-title">Update Category</label>
        <?php //Loop fetching desired update categories data
            if(isset($_GET['edit'])){
                $cat_id = $_GET['edit'];
                $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
                $select_categories_id = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($select_categories_id)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    ?>

        <input value="<?php if(isset($cat_title)){echo $cat_title;} ?>" type="text" name="cat_title" class="form-control">

                <?php //Closing php for Loop    
                }
            }
        ?>
        <!-- update categories data operation to db -->
        <?php
            update_categories();
        ?>
        <!-- /.update categories data operation to db -->
    </div>
    <div class="form-gourp">
        <input type="submit" name="update_category" value="Update Category" class="btn btn-primary">
    </div>
</form>