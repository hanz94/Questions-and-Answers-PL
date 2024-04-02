<?php require_once '../functions.php';
require_once '../qa-db-connect.php'; ?>

<!DOCTYPE html>

<html lang="pl-PL">
    <head>
        <title><?php Value('../event-name.php');?> - <?php Value('../institution-name.php');?></title>
        <meta charset="UTF-8">
        <meta name="robots" content="noindex, nofollow" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,300;0,600;1,300;1,600&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="../qa-data/styles.css">
		<script src="../qa-data/board.js" async></script>
		
		<style>
			.qr-code {
				display: flex;
				justify-content: center;
				margin-top: 25px;
				margin-bottom: 25px;
			}

			@media only screen and (min-width: 700px) {
			
				main {
					max-width: 700px;
				}
		
			}
			
		</style>
		
    </head>

    <body>
		<?php 
			$session = file_get_contents('../status.php');
			
			$questions = db_do_query_return_obj("SELECT question_text FROM questions");

			$questions_total = $questions->num_rows;

			if (isset($_GET['question']) && $_GET['question'] >= 1 && filter_var($_GET['question'], FILTER_VALIDATE_INT)) {
						
				echo '
					<main>
				
					<header class="container-small knsa-kul">
						<img src="../knsa-logo.png" alt="" class="img-knsa">
						<img src="../kul.jpg" alt="" class="img-kul">
						<div>'; Value('../institution-name.php'); echo '</div>
					</header>
					
						<div class="flag"></div>
					
					<section class="container-small container-event-name-date">
						<div class="event-name">'; Value('../event-name.php'); echo '</div>
						<div class="event-date">'; Value('../event-date.php'); echo '</div>
					</section>
					
					<section class="container-small result-form">
						<div>
							<p>Pytanie ' . $_GET['question'] . ':</p>
							<br />
							<p>' . $questions->fetch_all(MYSQLI_NUM)[$_GET['question']-1][0] . '</p>
							<br />
							<div class="previous-next-question-button-container">';
								
								if ($_GET['question'] === '1' && $questions_total === 1) {
									
									echo '<button class="previous-next-question-button" id="back-to-start">Powrót</button>';
									
								}
								else if ($_GET['question'] === '1' && $_GET['question'] < $questions_total) {
									
									echo '<button class="previous-next-question-button" id="back-to-start">Powrót</button>';
									echo '<button class="previous-next-question-button" id="next-question">Następne pytanie</button>';
									
								}
							
								else if ($_GET['question'] > 1 && $_GET['question'] < $questions_total) {
									
								echo 	'<button class="previous-next-question-button" id="previous-question">Poprzednie pytanie</button>
										<button class="previous-next-question-button" id="next-question">Następne pytanie</button>';
								}
								
								else if ($_GET['question'] != '1' && $_GET['question'] = $questions_total) {
									echo '<button class="previous-next-question-button" id="previous-question">Poprzednie pytanie</button>';
								}

								
							echo '</div>
							
							
						</div>
					</section>

					</main>';
			}
			
			else {
				echo '<main>
				
					<header class="container-small knsa-kul">
						<img src="../knsa-logo.png" alt="" class="img-knsa">
						<img src="../kul.jpg" alt="" class="img-kul">
						<div>'; Value('../institution-name.php'); echo '</div>
					</header>
					
						<div class="flag"></div>
					
					<section class="container-small container-event-name-date">
						<div class="event-name">'; Value('../event-name.php'); echo '</div>
						<div class="event-date">'; Value('../event-date.php'); echo '</div>
					</section>
					
					<section class="container-small result-form">
						<div>
						<p>Liczba pytań: ' . $questions_total . '</p>
						<br />';
						
						if (!$questions_total) {
							echo '<button class="start-button" id="back-to-start">START</button>';
						}
						else {
							echo '<button class="start-button" id="first-question">START</button>';
						}
						
						echo '</div>
					</section>

					</main>';
					
					if (file_get_contents('../board-auto-refresh.php')) {
					
						echo '<script>
						setTimeout(function(){
							   window.location.reload();
							},'; echo file_get_contents('../board-auto-refresh-time.php'); echo ');
						
						</script>';
					}
			}
			
		if (file_get_contents('../board-qr-visible.php')) {
			
			echo '<div class="qr-code"><img src="../qr.gif" alt="" /></div>';
			
		}
		
		
		
		?>
    </body>
</html>