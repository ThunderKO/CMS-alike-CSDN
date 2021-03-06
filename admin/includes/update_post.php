<?php
    //fetching the desired post with id for updating
    if(isset($_GET['update_post_id'])) {
        $post_id_for_update = $_GET['update_post_id'];
    }
    $query = "SELECT * FROM posts WHERE post_id = $post_id_for_update";
    $select_posts_by_id = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
    }
    // update posts data operation to db
    update_posts();
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <select name="post_category_id" id="post_category_id">
        <?php
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);
            query_fail_response($select_categories);
            while($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<option value='{$cat_id}'>{$cat_title}</option>";
                //<NEED TO FIX> showing the 'Javascript' data in select 
            }
        ?>
        </select>
    </div>
    <div class="form-group">
        <label for="title">Post Author</label>
        <input value="<?php echo $post_author; ?>" type="text" class="form-control" name="author">
    </div>
    <div class="form-group">
        <select name="post_status" id="">
            <option value="<?php echo $post_status ?>"><?php echo $post_status; ?></option>
            <?php
                if($post_status == 'published') {
                    echo "<option value='draft'>Draft</option>";
                } else {
                    echo "<option value='published'>Published</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>
</form>