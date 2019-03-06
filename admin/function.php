<?php
    // 0 - Utiliy Function Operation

    // Code Migration - fetching error messages whenever there is a query fail to db
    function query_fail_response($result) {
        //Change the scope of connection across application
        global $connection;
        if(!$result) {
            die("QUERY FAILED" . mysqli_error($connection));
        }
    }

    // 1 - Categories CRUD Opertion

    // Code Migration - insert categories data operation to db 
    function insert_categories() {
        //Change the scope of connection across application
        global $connection;
        if(isset($_POST['submit'])) {
            $cat_title = $_POST['cat_title'];
            if($cat_title == "" || empty($cat_title)) {
                echo "This field should not be empty";
            } else {
                $query = "INSERT INTO categories(cat_title) ";
                $query .= "VALUE('{$cat_title}') ";
                $create_category_query = mysqli_query($connection, $query);
                if(!$create_category_query) {
                    die("QUERY FAILED" . mysqli_error($connection));
                }
            }
        }
    }

    // Code Migration - fetching categories table data in db
    function fetch_all_categories() {
        //Change the scope of connection across application
        global $connection;
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_categories)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
            echo "<tr>";
            echo "<td>{$cat_id}</td>";
            echo "<td>{$cat_title}</td>";
            echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
            echo "<td><a href='categories.php?edit={$cat_id}'>Update</a></td>";
            echo "</tr>";
        }
    }

    // Code Migration - update categories data operation to db
    function update_categories() {
        //Change the scope of connection across application
        global $connection;
        $cat_id = $_GET['edit'];
        if(isset($_POST['update_category'])) {
            $cat_title_for_update = $_POST['cat_title'];
            $query = "UPDATE categories SET cat_title = '{$cat_title_for_update}' WHERE cat_id = {$cat_id}";
            $update_query = mysqli_query($connection, $query);
            if(!$update_query) {
                die("QUERY FAILED" . mysqli_error($connection));
            }
        }
    }

    // Code Migration - delete categories data operation to db
    function delete_categories() {
        //Change the scope of connection across application
        global $connection;
        if(isset($_GET['delete'])) {
            $cat_id_for_delete = $_GET['delete'];
            $query = "DELETE FROM categories WHERE cat_id = {$cat_id_for_delete}";
            $delete_query = mysqli_query($connection, $query);
            //Refresh the page for instant changes
            header("Location: categories.php");
        }
    }

    // 2 - Posts CRUD Opertion

    // Code Migration - insert posts data operation to db
    function insert_posts() {
        //Change the scope of connection across application
        global $connection;
        if(isset($_POST['create_post'])) {
            $post_title = $_POST['title'];
            $post_author = $_POST['author'];
            $post_category_id = $_POST['post_category'];
            $post_status = $_POST['post_status'];
    
            $post_image = $_FILES['image']['name'];
            $post_image_temp = $_FILES['image']['tmp_name'];
    
            $post_tags = $_POST['post_tags'];
            $post_content = $_POST['post_content'];
            $post_date = date('d-m-y');
            $post_comment_count = 4;
    
            move_uploaded_file($post_image_temp, "../images/$post_image");
    
            $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
            $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_comment_count}', '{$post_status}') ";
            $create_post_query = mysqli_query($connection, $query);
            query_fail_response($create_post_query);
        }
    }

    // Code Migration - fetching posts data table in db
    function fetch_all_posts() {
        //Change the scope of connection across application
        global $connection;
        $query = "SELECT * FROM posts";
        $select_posts = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_posts)) {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];

            echo "<tr>";
            echo "<td>$post_id </td>";
            echo "<td>$post_author </td>";
            echo "<td>$post_title </td>";

            $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
            $select_categories_id = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<td>{$cat_title} </td>";
            }
            echo "<td>$post_status </td>";
            echo "<td><img width='100' src='../images/$post_image'></td>";
            echo "<td>$post_tags </td>";
            echo "<td>$post_comment_count </td>";
            echo "<td>$post_date </td>";
            echo "<td><a href='posts.php?source=update_post&update_post_id={$post_id}'>Update</a></td>";
            echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
            echo "</tr>";
        }
    }

    // Code Migration - update posts data operation to db
    function update_posts() {
        //Change the scope of connection across application
        global $connection;
        if(isset($_GET['update_post_id'])) {
            $post_id_for_update = $_GET['update_post_id'];
        }
        if(isset($_POST['update_post'])) {
            $post_author = $_POST['author'];
            $post_title = $_POST['title'];
            $post_category_id = $_POST['post_category_id'];
            $post_status = $_POST['post_status'];
            $post_image = $_FILES['image']['name'];
            $post_image_temp = $_FILES['image']['tmp_name'];
            $post_tags = $_POST['post_tags'];
            $post_content = $_POST['post_content'];
    
            move_uploaded_file($post_image_temp, "../images/$post_image");
    
            //fixing the image upload situation: when the image is empty, it will have null value.
            if(empty($post_image)) {
                $query = "SELECT * FROM posts WHERE post_id = $post_id_for_update ";
                $select_image = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($select_image)) {
                    $post_image = $row['post_image'];
                }
            }

            $query = "UPDATE posts SET ";
            $query .= "post_title = '{$post_title}', ";
            $query .= "post_category_id = '{$post_category_id}', ";
            $query .= "post_date = now(), ";
            $query .= "post_author = '{$post_author}', ";
            $query .= "post_status = '{$post_status}', ";
            $query .= "post_tags = '{$post_tags}', ";
            $query .= "post_content = '{$post_content}', ";
            $query .= "post_image = '{$post_image}' ";
            $query .= "WHERE post_id = {$post_id_for_update} ";
    
            $update_post = mysqli_query($connection, $query);
            query_fail_response($update_post);
        }
    }

    // Code Migration - delete posts data operation to db
    function delete_posts() {
        //Change the scope of connection across application
        global $connection;
        if(isset($_GET['delete'])) {
            $post_id_for_delete = $_GET['delete'];
            $query = "DELETE FROM posts WHERE post_id = {$post_id_for_delete} ";
            $delete_query = mysqli_query($connection, $query);
            //Refresh the page for instant changes
            header("Location: posts.php");
        }
    }
?>