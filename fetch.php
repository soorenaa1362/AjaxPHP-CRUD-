<?php
    include 'db.php';

    $num = 1;
    $result = $conn->prepare("SELECT * FROM users");
    $result->execute();
    $users = $result->fetchAll(PDO::FETCH_ASSOC);
?> 

<?php foreach($users as $user){?>
    <tr>
        <th scope="row">
            <?php echo $num++ ?>
        </th>
        <td>
            <?= $user['username']; ?>
        </td>
        <td>
            <?= $user['password']; ?>
        </td>
        <td>
            <button class="btn btn-warning" id="edit-user" value=<?= $user['id']; ?> >
                Edit
            </button>
            <button class="btn btn-danger" id="delete-user" value=<?php echo $user['id']; ?> >
                Delete
            </button>
        </td>
    </tr>
<?php }?>