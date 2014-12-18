<script src="/js/editusers.js" ></script>


<table>
    <tr>
        <th>Email Address</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Role</th>
        <th>Delete</th>
        <th>Change Role</th>
    </tr>

    <?php
    foreach ($users as $user) :
        $roleName = 'User';
        $changeRole = 'Admin';

        if ($user->roleId == ROLE_ID_ADMIN) {
            $roleName = 'Admin';
            $changeRole = 'User';
        }
        ?>

        <tr>
            <td><?php echo $user->email; ?></td>
            <td><?php echo $user->firstName; ?></td>
            <td><?php echo $user->lastName; ?></td>
            <td><?php echo $roleName; ?></td>
            <td><button onclick="Delete User(<?php echo $user->id; ?>)">Delete</button></td>
            <td><button onclick="Change User(<?php echo $user->id; ?>, '<?php echo $changeRole; ?>');">Make <?php echo $changeRole; ?></button></td>
        </tr>

    <?php endforeach; ?>
</table>
