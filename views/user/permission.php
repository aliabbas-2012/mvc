<div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true " style="display: block;" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="text-danger">Are you sure you delete this field</h3>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" href="http://mvc.local/userList">cancel</a>
                <form method="post" action="/user/delete" class="d-inline">
                    <?php
                    $id = $_GET['id']
                    ?>
                    <input hidden type="text" name="id" value="<?php echo $id; ?>">
                    <input type="text" hidden name="method" value="delete">
                    <input type="submit" value="Delete" class="btn btn-danger">
                </form>
            </div>
        </div>
    </div>
</div>