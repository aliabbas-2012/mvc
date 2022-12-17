<?php
if (isset($headingForm)) {
    
    // prix 
?>

    <div class="shadow bg-white  flex-column rounded w-50 d-flex justify-content-center align-items-center p-4">
        <h2 class="text-secondary fw-bold mb-5"><?php echo $headingForm ?></h2>
        <form class="w-100" method="post" action="<?php  echo $url; ?>">
            <?php
            
            if ($headingForm != 'Login') {
            ?>
                <div class="mb-3 w-100">
                    <label for="name" class="form-label fw-bold text-secondary">NAME</label>
                    <input type="text" hidden name="method" value="put" />
                    <input type="text" hidden value="<?php echo (isset($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : ""; ?>" name="id">
                    <input type="text" class="form-control" value="<?php echo (isset($_SESSION['user']['name'])) ? $_SESSION['user']['name'] : ""; ?>" name="name" id="name" placeholder="Name">
                    <span class="text-danger">
                        <?php
                        echo (isset($_SESSION['error']['name'])) ? $_SESSION['error']['name'] : "";
                        ?>
                    </span>
                </div>
                <div class="mb-3 w-100">
                    <label for="f_name" class="form-label fw-bold text-secondary">FATHER NAME</label>
                    <input type="text" class="form-control" name="f_name" id="f_name" value="<?php echo (isset($_SESSION['user']['father_name'])) ? $_SESSION['user']['father_name'] : ""; ?>" placeholder="Father name">
                    <span class="text-danger">
                        <?php
                        echo (isset($_SESSION['error']['father_name'])) ? $_SESSION['error']['father_name'] : "";
                        ?>
                    </span>
                </div>
            <?php
            }
            ?>
            <div class="mb-3 w-100">
                <label for="email" class="form-label fw-bold text-secondary">Email address</label>
                <input type="email" class="form-control" value="<?php echo (isset($_SESSION['user']['email'])) ? $_SESSION['user']['email'] : ""; ?>" name="email" id="email" placeholder="name@example.com">
                <span class="text-danger">
                    <?php
                    echo (isset($_SESSION['error']['email'])) ? $_SESSION['error']['email'] : "";
                    ?>
                </span>
            </div>
            <div class="mb-3 w-100">
                <label for="pass" class="form-label fw-bold text-secondary">PASSWORD</label>
                <input type="text" value="<?php echo (isset($_SESSION['user']['password'])) ? $_SESSION['user']['password'] : ""; ?>" class="form-control" name="pass" id="pass" placeholder="password">
                <span class="text-danger">
                    <?php
                    echo (isset($_SESSION['error']['password'])) ? $_SESSION['error']['password'] : "";
                     ?>
                    
                </span>
            </div>
            <div class="mb-3 w-100">
                <input name="submit" value="<?php  if (isset($btn)) {echo $btn;}  ?>" type="submit" class="btn btn-primary fw-bold form-control">
            </div>

            <span class="text-danger">
                <?php
                echo (isset($_SESSION['error']['loginError'])) ? $_SESSION['error']['loginError'] : "";
                ?>
            </span>
        </form>
    </div>
<?php
    
}


?>