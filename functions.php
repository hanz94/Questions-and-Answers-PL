<?php
			
			function Value($path) {
				echo file_get_contents($path);
			}

			function test_input($input) {
				$input = trim($input);
				$input = stripslashes($input);
				$input = htmlspecialchars($input);
				return $input;
			}

			function db_do_query_return_obj($q) {
				global $db_host, $db_user, $db_pass, $db_name;

				$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
				$conn->set_charset("utf8");
				if ($conn->connect_error) { die('Connection failed: ' . $conn->connect_error);}

				$query_result = $conn->query($q);

				$conn->close();

				return $query_result;

			}

			function db_send($question) {
				global $db_host, $db_user, $db_pass, $db_name;

				$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
				$conn->set_charset("utf8");
				if ($conn->connect_error) { die('Connection failed: ' . $conn->connect_error);}

				$stmt = $conn->prepare('INSERT INTO questions (question_text) VALUES (?)');
				$stmt->bind_param("s", $question);
				$stmt->execute();
				$stmt->close();
				$conn->close();

				$questions = db_do_query_return_obj("SELECT * FROM questions");

				$questions_total = $questions->num_rows;
				
				echo '<script>showModal("Pytanie zostało wysłane.<br>Numer w kolejce: ' . $questions_total .'");</script>';

			}
			
			function SessionClosedMessage() {
				echo '
						<p>Q&A session has been closed!</p>
						';
			}
			
			function SessionClosed() {
					echo '<main>
			
				<header class="container-small knsa-kul">
					<img src="knsa-logo.png" alt="" class="img-knsa">
					<img src="kul.jpg" alt="" class="img-kul">
					<div>'; Value('institution-name.php'); echo '</div>
				</header>
				
					<div class="flag"></div>
				
				<section class="container-small container-event-name-date">
					<div class="event-name">'; Value('event-name.php'); echo '</div>
					<div class="event-date">'; Value('event-date.php'); echo '</div>
				</section>
				
				<section class="container-small result-form">
					<div>'; SessionClosedMessage(); echo '</div>
				</section>

				</main>';				
			}
			
			function InputQuestion() {
					echo '<main>
			
				<header class="container-small knsa-kul">
					<img src="knsa-logo.png" alt="" class="img-knsa">
					<img src="kul.jpg" alt="" class="img-kul">
					<div>'; Value('institution-name.php'); echo '</div>
				</header>
				
					<div class="flag"></div>
				
				<section class="container-small container-event-name-date">
					<div class="event-name">'; Value('event-name.php'); echo '</div>
					<div class="event-date">'; Value('event-date.php'); echo '</div>
				</section>

				<section id="input-solution" class="container-small result-form">
				
				<label for="question">
					<p>Treść pytania:</p>
					<br />
				</label>
					<form method="post" class="question-form">
						<textarea id="question" name="question" maxlength="1000" autofocus required></textarea>
						<p class="remaining-chars">Pozostało znaków: <span id="counter"></span></p>
						<button class="send-question-button">Wyślij</button>
					</form>
					
				</section>

			</main>';
			
				if (isset($_POST['question']) && $_POST['question'] != null && strlen($_POST['question']) <= 1000) {

					$question = test_input($_POST['question']);
					db_send($question);
					unset($_POST);
					header("Cache-Control: no-store, no-cache, must-revalidate");
 					header("Cache-Control: post-check=0, pre-check=0", false);
 					header("Pragma: no-cache");
					header("Location: $PHP_SELF");
					exit;
				}
				else if (isset($_POST['question']) && $_POST['question'] != null && strlen($_POST['question']) > 1000) {
					echo '<script>showModal("Długość pytania przekracza 1000 znaków.<br>Pytanie nie zostało wysłane. (error)");</script>';
				}
		
				
			}
			
?>