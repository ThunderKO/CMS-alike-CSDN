<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
            fetch_all_comments();
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
    update_comments_status();
    delete_comments();
?>