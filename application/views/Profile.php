<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/styles.css">
    <style>
        .container {
            margin-top: 20px;
            max-width: 1500px;
        }

        .card {
            margin-bottom: 25px;
            color: black;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .user-details {
            max-width: 900px;
        }

        .card-title {
            font-size: 1.5rem;
        }

        .card-text {
            font-size: 1.1rem;
        }

        .nav-tabs {
            border-bottom: none;
             max-width: 1500px;
        }

        .nav-link {
            color: white;
            font-size: 1.2rem;
        }

        .nav-link.active {
            color: #b4c0cc;
            border-bottom: 2px solid #b4c0cc;
        }

        .logout-btn {
            margin-top: 20px;
        }

        .btn-danger {
            border-radius: 5px;
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
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="mb-4">Hello, <?= $username ?></h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- User details -->
                <div class="card user-details">
                    <div class="card-body">                    
                        <p class="card-text"><b>Username:</b> <?= $username ?></p>
                        <p class="card-text"><b>Email:</b> <?= $email ?></p>
                        <p class="card-text"><b>Questions:</b> <?= $num_questions ?></p>
                        <p class="card-text"><b>Answers:</b> <?= $num_answers ?></p>
                        <p class="card-text my-3"><b>Correct answers:</b> <?= $num_correct_answers ?></p>
                    </div>

                    <?php if (isset($user_id) && $user_id && $title == 'Profile'): ?>
                        <div class="logout-btn text-center">
                            <form action="<?php echo site_url('user_controller/userLogout'); ?>" method="post">   
                            <button type="submit" class="btn btn-danger btn-lg float-right">Logout</button>
                            </form>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Answers and Questions the user has provided -->
                <ul class="nav nav-tabs" id="tab-section" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="questions-tab" data-toggle="tab" href="#questions" role="tab">Questions user has Asked</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="answers-tab" data-toggle="tab" href="#answers" role="tab">Answers the user has Given</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="questions" role="tabpanel">
                        <?php if (empty($questions)): ?>
                            <div class="alert alert-info" role="alert">
                                No questions found.
                            </div>
                        <?php endif; ?>
                        <?php foreach ($questions as $question): ?>
                            <a href="<?php echo site_url('question/view/' . $question['id']); ?>" class="text-decoration-none"
					        style="color:black; ">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $question['title'] ?></h5>
                                    <p class="card-text"><?= $question['description'] ?></p>
                                    <p class="card-text">Answers: <?= $this->questionModel->get_answer_count($question['id']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="tab-pane fade" id="answers" role="tabpanel">
                        <?php if (empty($answers)): ?>
                            <div class="alert alert-info" role="alert">
                                No Answers found.
                            </div>
                        <?php endif; ?>

                        <?php foreach ($answers as $answer): ?>
                            <a href="<?php echo site_url('question/view/' . $answer['question_id']); ?>" class="text-decoration-none text-black">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $answer['question_title'] ?></h5>
                                    <p class="card-text"><?= $answer['answer'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="<?php echo site_url('view_and_ask_questions_controller'); ?>" class="btn btn-primary">View and Ask Questions</a> 
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(function () {
            $('.nav-tabs a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>
</body>

</html>