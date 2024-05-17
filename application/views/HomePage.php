<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>faqOverflow - All Your Q&As in One Place!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>/assets/css/styles.css">
    <style>
        .container {
            max-width: 900px;
        }

        .image-container {
            text-align: center;
            margin-top: 50px;
        }

        .image-container img {
            width: 100%;
            height: auto;
            margin-top: 20px;
        }

    </style>
</head>

<body>
    <!-- header -->
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center py-3">
            <div>
                <h1><a href="<?php echo site_url('home_page_controller'); ?>" class="text-light text-decoration-none">faqOverflow</a></h1>
                <h4><span class="text-muted" style="font-size: smaller;"> All Your Q&As in One Place!</span></h4>
            </div>
            
            <div>
                <?php if (isset($user_id) && $user_id): ?>
                    <div class="d-flex align-items-center">
                        <h5 class="mr-3">Hello, <a href="<?php echo site_url('user_controller/userProfile'); ?>" class="text-light text-decoration-none"><?= $username ?></a></h5>
                    </div>
                <?php else: ?>
                    <a href="<?php echo site_url('user_controller/login'); ?>" class="btn btn-primary rounded-pill">Login</a>
                    <a href="<?php echo site_url('user_controller/register'); ?>" class="btn btn-secondary rounded-pill">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="mb-4">Welcome to faqOverflow!</h2>
                <p class="lead">All Your Q&As in One Place!</p>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-4">
                <a href="<?php echo site_url('view_and_ask_questions_controller'); ?>" class="btn btn-primary btn-lg">View and Ask Questions</a>
            </div>
        </div>

        <div class="row justify-content-center image-container">
            <div class="col-md-5">
                <img src="<?php echo base_url('assets\images\faqimage.png'); ?>" alt="faqimage">
            </div>
        </div>

    </div>

</body>

</html>


