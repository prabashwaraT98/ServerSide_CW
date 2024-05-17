<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $question['title'] ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>/assets/css/styles.css">
    <style>

        .container {
            max-width: 1500px;
            margin: 0 auto;
        }

        .bg-dark {
            background-color: #343a40 !important;
        }

        .btn-primary {
            background-color: #007bff !important;
            border-color: #007bff !important;
        }

        .btn-secondary {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
        }

        .btn-success {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }

        .btn-danger {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
        }

        .btn {
            color: #fff;
        }

        .btn-rounded {
            border-radius: 20px !important;
        }

        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: black;
        }

    </style>
</head>

<body>
    <!-- Header -->
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center py-3">
            <div>
                <h1><a href="<?php echo site_url('home_page_controller'); ?>" class="text-light text-decoration-none">faqOverflow</a></h1>
                <h4><span class="text-muted" style="font-size: smaller;">All Your Q&As in One Place!</span></h4>
            </div>
            <div class="text-center">
                <h5 class="text-light">Answer Question</h5>
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
        <h1 class="display-4"><?= $question['title'] ?></h1>
        <?php if ($question['is_solved']) : ?>
			<i class="fas fa-check text-success fa-2x"> Solved </i>
		<?php endif; ?>
        <p class="lead"><?= $question['description'] ?></p>
        <p class="card-text text-right" style="font-size:small">Asked by <span class="font-weight-bold"><?= ucfirst(strtolower($question['username'])) ?></span> <?= strtolower(timespan(strtotime($question['date_asked']), time(), 2)); ?> ago</p>

        <hr>

		<div class="mb-3 text-center">
            <form action="<?php echo site_url('question/view/' . $question['id'] . '/displayAnsweringForm') ?>" method="post">
                <button type="submit" name="answerButton" class="btn btn-success btn-rounded">Add Answer</button>
            </form>
        </div>

        <h5>Answers</h5>
        

        <?php if ($showForm): ?>
            <div id="askForm">
                <?php echo validation_errors(); ?>
                <div class="form-group">
                    <form action="<?php echo site_url('question/view/' . $question['id'] . '/answer/submit'); ?>" method="post">
                        <div class="form-group">
                            <textarea type="text" class="form-control" name="answer" placeholder="Enter Answer"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-rounded">Submit</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <?php if (empty($question['answers'])): ?>
            <p>No answers yet.</p>
        <?php else: ?>
            <?php foreach ($question['answers'] as $answer): ?>
                <div class="card">
                    <div class="card-body d-flex align-items-start">
                        <div class="w-100">
                            <p class="card-text"><?= $answer['answer'] ?></p>
                            <p class="card-text text-right" style="font-size:small">Answered by <span class="font-weight-bold"><?= ucfirst(strtolower($answer['username'])) ?></span>
                            <span class=" text-secondary"> <?= strtolower(timespan(strtotime($answer['date_answered']), time(), 3)); ?> ago</span></p>
                            <?php if ($answer['is_correct']) : ?>
                                <i class="fas fa-check text-success fa-2x"> Answer is Correct </i>
                            <?php endif; ?>
                            <?php if ($this->session->userdata('user_id') == $question['user_id'] && !($answer['is_correct'])) : ?>
								<form action="<?php echo site_url('question_controller/questionSolved') ?>" method="post">
									<input type="hidden" name="answer_id" value="<?= $answer['id'] ?>">
									<input type="hidden" name="question_id" value="<?= $question['id'] ?>">
									<button class="btn-success float-left" type="submit">Mark as Correct</button>
								</form>
							<?php endif; ?>
                            <?php if ($user_id && $user_id == $answer['user_id']): ?>
                                <form action="<?= site_url('answer_controller/deleteAnswer'); ?>" method="post">
                                    <input type="hidden" name="answer_id" value="<?= $answer['id']; ?>">
                                    <input type="hidden" name="question_id" value="<?= $question['id']; ?>">
                                    <button type="submit" class="btn btn-danger float-right">Delete</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
		<a href="<?php echo site_url('view_and_ask_questions_controller'); ?>" class="btn btn-primary btn-rounded">Back to Questions</a>
    </div>
</body>

</html>
