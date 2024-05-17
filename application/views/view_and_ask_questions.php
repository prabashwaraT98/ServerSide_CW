<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>View and Ask Questions</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
	<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>/assets/css/styles.css">
	<style>
		.container {
            max-width: 1500px;
            margin: 0 auto;
        }

        .question-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
			color: black;
        }

        .card-title {
            font-size: 1.25rem;
            color: black;
        }

        .card-text {
            color: black;
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-success {
            border-radius: 20px;
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
        <div class="row mt-3 mb-3">
			<div class="col">
				<form class="form-inline" action="<?php echo site_url('view_and_ask_questions_controller/search'); ?>" method="get">
					<div class="input-group w-100">
						<input class="form-control mr-sm-2" type="search" placeholder="Search Questions..."
							aria-label="Search" name="search"
							value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
						<div class="input-group-append">
							<button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
						</div>
					</div>
				</form>
			</div>
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


	<!-- Home Page Content -->
	<div class="container">
		<!-- Ask Question button -->
		<div class="mb-3">
			<form action="<?php echo site_url('view_and_ask_questions_controller/displayQuestionSubmitForm'); ?>" method="post">
				<button type="submit" name="askButton" class="btn btn-success">Ask Your Question</button>
			</form>
		</div>

		<?php if ($showForm): ?>
			<div id="askForm">
				<?php echo validation_errors(); ?>
				<form class="form-inline" action="<?php echo site_url('view_and_ask_questions_controller/submitQuestion'); ?>" method="post">
					<div class="form-group mb-2">
						<input type="text" class="form-control" name="title" placeholder="Question Title">
					</div>
					<div class="form-group mx-sm-3 mb-2">
						<input type="text" class="form-control" name="description" placeholder="Question Description">
					</div>
					<button type="submit" class="btn btn-primary mb-2">Submit Question</button>
					<button type="button" class="btn btn-secondary mb-2 ml-2" onclick="closeForm()">Close</button>
				</form>
			</div>
		<?php endif; ?>
		
		<script>
    		function closeForm() {
        	document.getElementById('askForm').style.display = 'none';
    		}
		</script>


		<!-- List of questions -->
        <?php if (empty($questions)): ?>
				<div class="alert alert-info" role="alert">
					No questions found.
				</div>
			<?php endif; ?>

			<?php foreach ($questions as $question): ?>


				<a href="<?php echo site_url('question/view/' . $question['id']); ?>" class="text-decoration-none"
					style="color:black; ">
					<div class="card mb-3 question-card">
						<div class="card-body">
							<div class="d-flex justify-content-between align-items-center">
								<h5 class="card-title"><?= $question['title'] ?></h5>
								<p class="card-text text-right" style="font-size:small">by <span
										class="font-weight-bold"><?= ucfirst(strtolower($question['username'])) ?></span>
									<?= strtolower(timespan(strtotime($question['date_asked']), time(), 2)); ?> ago
								</p>
							</div>

							<p class="card-text"><?= $question['description'] ?></p>
							<p class="card-text">Answers: <?= $this->questionModel->get_answer_count($question['id']) ?>
							</p>

							<?php if ($question['user_id'] == $user_id): ?>
        						<form action="<?php echo site_url('question_controller/deleteQuestion'); ?>" method="post">
									<input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
									<input type="hidden" name="question_id" value="<?= $question['id']; ?>"> <!-- to pass question_id -->
									<button type="submit" class="btn btn-danger float-right">Delete</button>
								</form>
    						<?php endif; ?>

						</div>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
    </div>


</body>

</html>
