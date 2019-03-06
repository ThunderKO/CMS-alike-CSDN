<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
            // fetching posts data operation to db
            fetch_all_posts();
        ?>
        <!-- Sample Data -->
        <!-- <tr>
            <td>10</td>
            <td>Andy Ko</td>
            <td>CMS Project Title</td>
            <td>JAVA</td>
            <td>Status</td>
            <td>Image</td>
            <td>Tags</td>
            <td>Comments</td>
            <td>Date</td>
        </tr> -->
    </tbody>
</table>
<!-- delete posts data operation to db -->
<?php
    delete_posts();
?>