<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/styles.css">
    <style>
        .container {
            max-width: 400px;
            margin-top: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            width: 100%;
            border-radius: 20px;
        }

        .btn-secondary {
            width: 100%;
            border-radius: 20px;
        }

        .alert-danger {
            margin-bottom: 20px;
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
            <div class="text-center">
                <h5 class="text-light">User Login</h5>
            </div>
        </div>
    </div>

    <!-- Login Form -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>
                <form id="loginForm" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>

                <!-- Register Button -->
                <div class="text-center">
                    <p>Don't have an account? <a href="<?php echo site_url('user_controller/register'); ?>" class="btn btn-secondary">Register</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>

    <script>
        var LoginFormView = Backbone.View.extend({
            el: '#loginForm',

            events: {
                'submit': 'login'
            },

            login: function(e) {
                var username = this.$('#username').val();
                var password = this.$('#password').val();
                
                console.log('Username: ', username);
                console.log('Password: ', password);
            }
        });

        var loginFormView = new LoginFormView();
    </script>
</body>

</html>
