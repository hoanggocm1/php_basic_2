<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!------ Include the above in your HEAD tag ---------->
    <div class="container">
        <div class="m-5">
            <?php session_start();
            if (isset($_SESSION['success'])) : ?>
                <p style="color: green;"><?php echo $_SESSION['success'];  ?></p>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            <form action="services/services.php?action=register" method="post">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="inputPassword3" class="col-sm-2 ">Name</label>
                        <input type="text" name="name" required class="form-control" placeholder="Name">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="inputPassword4" class="col-sm-2 col-form-label">Email</label>
                        <input type="email" required class="form-control" name="email" placeholder="email">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="inputPassword4" class="col-sm-2 col-form-label">Password</label>
                        <input type="password" required name="password" class="form-control" placeholder="Password">
                    </div>
                </div>
                <div class="form-group row">

                    <div class="col-sm-6">
                        <label for="inputPassword3" class="col-sm-4 ">Confirm password</label>
                        <input type="password" required class="form-control" name="confirm_password" placeholder="Confirm password">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary">Đăng ký</button>
                    </div>
                    <div class="col-sm-6">
                        <a href="index.php" class="btn btn-primary">Login here</a>
                    </div>
                </div>

            </form>



        </div>

    </div>



</html>