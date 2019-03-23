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
    
            move_uploaded_file($post_image_temp, "../images/$post_image");
    
            $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
            $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";
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

    // 3 - Comments CRUD Opertion

    // Code Migration - insert comments data operation to db
    function insert_comments() {
        //Change the scope of connection across application
        global $connection;
        if(isset($_POST['create_comment'])){
            $post_id_for_detail = $_GET['post_id_for_detail'];

            $comment_author = $_POST['comment_author'];
            $comment_email = $_POST['comment_email'];
            $comment_content = $_POST['comment_content'];
            
            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
            $query .= "VALUE ($post_id_for_detail, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'pending', now())";
            $create_comment_query = mysqli_query($connection, $query);
            query_fail_response($create_comment_query);

            //update posts_comment_data everytime we insert comments
            $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
            $query .= "WHERE post_id = $post_id_for_detail ";
            $update_post_comment_count = mysqli_query($connection, $query);
        }
    }

    // Code Migration - fetching comments data table in db
    function fetch_all_comments() {
        //Change the scope of connection across application
        global $connection;
        $query = "SELECT * FROM comments";
        $select_comments = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_comments)) {
            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_content = $row['comment_content'];
            $comment_email = $row['comment_email'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];

            echo "<tr>";
            echo "<td>$comment_id </td>";
            echo "<td>$comment_author </td>";
            echo "<td>$comment_content </td>";

            // $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
            // $select_categories_id = mysqli_query($connection, $query);
            // while($row = mysqli_fetch_assoc($select_categories_id)) {
            //     $cat_id = $row['cat_id'];
            //     $cat_title = $row['cat_title'];
            //     echo "<td>{$cat_title} </td>";
            // }
            echo "<td>$comment_email </td>";
            echo "<td>$comment_status </td>";
            $query = "SELECT * FROM posts where post_id = $comment_post_id ";
            $select_post_id_query = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_post_id_query)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                echo "<td><a href='../post.php?post_id_for_detail=$post_id'>$post_title</a></td>";
            }
            echo "<td>$comment_date </td>";
            echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
            echo "<td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
            echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";
            echo "</tr>";
        }
    }

    // Code Migration - (update) approve/unapprove comment data operation to db
    function update_comments_status() {
        //Change the scope of connection across application
        global $connection;
        if(isset($_GET['approve'])) {
            $comment_id = $_GET['approve'];
            $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $comment_id ";
            $approve_comment_query = mysqli_query($connection, $query);
            //Refresh the page for instant changes
            header("Location: comments.php");
        }

        if(isset($_GET['unapprove'])) {
            $comment_id = $_GET['unapprove'];
            $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $comment_id ";
            $unapprove_comment_query = mysqli_query($connection, $query);
            //Refresh the page for instant changes
            header("Location: comments.php");
        }
    }

    // Code Migration - delete comment data operation to db
    function delete_comments() {
        //Change the scope of connection across application
        global $connection;
        if(isset($_GET['delete'])) {
            $comment_id_for_delete = $_GET['delete'];
            $query = "DELETE FROM comments WHERE comment_id = {$comment_id_for_delete} ";
            $delete_query = mysqli_query($connection, $query);
            //Refresh the page for instant changes
            header("Location: comments.php");
        }
    }

    // 4 - Users CRUD Opertion

    // Code Migration - insert user data operation to db
    function insert_users() {
        //Change the scope of connection across application
        global $connection;
        if(isset($_POST['create_user'])) {
            $user_firstname = $_POST['user_firstname'];
            $user_lastname = $_POST['user_lastname'];
            $user_role = $_POST['user_role'];
    
            // $post_image = $_FILES['image']['name'];
            // $post_image_temp = $_FILES['image']['tmp_name'];
    
            $username = $_POST['username'];
            $user_email = $_POST['user_email'];
            $user_password = $_POST['user_password'];
            // $post_date = date('d-m-y');
    
            // move_uploaded_file($post_image_temp, "../images/$post_image");
    
            $query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) ";
            $query .= "VALUES('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}', '{$user_password}') ";
            $create_user_query = mysqli_query($connection, $query);
            query_fail_response($create_user_query);
        }
    }

    // Code Migration - fetching users data table in db
    function fetch_all_users() {
        //Change the scope of connection across application
        global $connection;
        $query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_users)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];

            echo "<tr>";
            echo "<td>$user_id </td>";
            echo "<td>$username </td>";
            echo "<td>$user_firstname </td>";

            // $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
            // $select_categories_id = mysqli_query($connection, $query);
            // while($row = mysqli_fetch_assoc($select_categories_id)) {
            //     $cat_id = $row['cat_id'];
            //     $cat_title = $row['cat_title'];
            //     echo "<td>{$cat_title} </td>";
            // }
            echo "<td>$user_lastname </td>";
            echo "<td>$user_email </td>";
            echo "<td>$user_role </td>";
            // $query = "SELECT * FROM posts where post_id = $comment_post_id ";
            // $select_post_id_query = mysqli_query($connection, $query);
            // while($row = mysqli_fetch_assoc($select_post_id_query)) {
            //     $post_id = $row['post_id'];
            //     $post_title = $row['post_title'];
            //     echo "<td><a href='../post.php?post_id_for_detail=$post_id'>$post_title</a></td>";
            // }
            echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
            echo "<td><a href='users.php?change_to_subscriber={$user_id}'>Subscriber</a></td>";
            echo "<td><a href='users.php?source=update_user&update_user={$user_id}'>Update</a></td>";
            echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
            echo "</tr>";
        }
    }

    // Code Migration - (update) approve/unapprove comment data operation to db
    function update_users_role() {
        //Change the scope of connection across application
        global $connection;
        if(isset($_GET['change_to_admin'])) {
            $user_id = $_GET['change_to_admin'];
            $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $user_id ";
            $change_to_admin_query = mysqli_query($connection, $query);
            //Refresh the page for instant changes
            header("Location: users.php");
        }

        if(isset($_GET['change_to_subscriber'])) {
            $user_id = $_GET['change_to_subscriber'];
            $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $user_id ";
            $change_to_subscriber_query = mysqli_query($connection, $query);
            //Refresh the page for instant changes
            header("Location: users.php");
        }
    }

    // Code Migration - delete comment data operation to db
    function delete_users() {
        //Change the scope of connection across application
        global $connection;
        if(isset($_GET['delete'])) {
            $user_id_for_delete = $_GET['delete'];
            $query = "DELETE FROM users WHERE user_id = {$user_id_for_delete} ";
            $delete_query = mysqli_query($connection, $query);
            //Refresh the page for instant changes
            header("Location: users.php");
        }
    }
?>