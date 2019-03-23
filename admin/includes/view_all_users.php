<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php
            fetch_all_users();
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
    update_users_role();
    delete_users();
?>