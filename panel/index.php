<?php 	require_once '../functions.php';
require_once '../qa-db-connect.php';
$status = file_get_contents('../status.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex, nofollow" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Koło Naukowe Studentów Anglistyki KUL">
	<title>Panel</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,300;0,600;1,300;1,600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../qa-data/styles.css">
	<link rel="stylesheet" href="../qa-data/panel.css">
</head>
<body>
		<aside>
			<div class="modal-container" id="modal-con">
				<div class="modal-window">
					<div class="modal-header">knsa.pl</div>
					<div class="modal-text" id="modal-text"></div>
							<div class="modal-button-container">
								<button class="action-button modal-button-accept" id="modal-accept">Akceptuj</button>
								<button class="action-button modal-button-decline" id="modal-decline">Anuluj</button>
							</div>
				<img src="../qa-data/x_icon.png" class="modal-close-icon" id="modal-close" alt="" width="16" height="16">
				<img src="../qa-data/kotek.png" alt="" class="modal-cat" width="64" height="64">
				</div>
			</div>
		</aside>

		<main>
			
			<header class="container-small knsa-kul">
				<img src="../knsa-logo.png" alt="" class="img-knsa">
				<img src="../kul.jpg" alt="" class="img-kul">
				<div>Panel - knsa.pl</div>
			</header>
			
				<div class="flag"></div>
			
			<section class="container-small result-form">
					<table class="table-questions">
					
					<tr>
						<td colspan="3">
							<form method="get" style="display:inline;">
								<input type="hidden" name="session_status" value="<?php echo $status ? '0':'1'; ?>">
								<input type="submit" class="action-button" value="<?php echo $status ? 'Zakończ sesję':'Rozpocznij sesję'; ?>">
							</form>
						</td>
					</tr>
				
					<tr>
						<td colspan="3">
							<p>Status: <?php echo date("d-m-Y H:i:s"); ?></p>
							<p class="<?php echo $status ? 'green':'red'; ?>">Sesja <?php echo $status ? 'otwarta':'zamknięta'; ?></p>
							<p><?php echo $status ? 'Formularz jest dostępny.' : 'Formularz jest niedostępny.'?></p>

							<?php

							$questions = db_do_query_return_obj("SELECT question_text FROM questions");$questions_total = $questions->num_rows;

							if ($questions_total > 0) {

								echo '<p style="margin:3px auto">Wysłano ' . $questions_total . ' ';

								if ($questions_total === 1) {
									echo 'pytanie:';
								}
								else if ($questions_total % 10 >=2 && $questions_total % 10 <=4 && ($questions_total <= 5 || $questions_total >= 21)) {
									echo 'pytania:';
								}
								else {
									echo 'pytań:';
								}
								
								echo '</p>';

							}
							else {
								echo '<p style="margin:3px auto">Brak pytań</p>';
							}

							?>
						</td>
					</tr>
					
					<?php

						$questions = db_do_query_return_obj("SELECT * FROM questions");

						$questions_total = $questions->num_rows;
					
						if (!$questions_total) {
							echo 	'<tr>
										<td colspan="3">
											<p>Lista pytań jest pusta!</p>
										</td>
									</tr>'; 
						}
						else {
					
							foreach ($questions as $questionnumber => $question) {
								$questionnumber++;
								echo '<tr>
										<td>
											<span>' . $questionnumber . '</span>
										</td>
										<td style="word-wrap:break-word">
											<span>';
											
												foreach ($question as $key => $value) {
													if ($key === 'question_text') {
														echo $value;
													}
													if ($key === 'question_id') {
														$this_question_id = $value;
													}
												}
											
											echo '</span>
										</td>
										<td>
											<input type="submit" class="action-button" onclick="DeleteQuestionConfirmation(' . $questionnumber . ',' . $this_question_id . ')" value="Usuń pytanie ' . $questionnumber . ' (ID ' . $this_question_id . ')">
										</td>
									</tr>';
								
							}
						}
						//END - TABLE QUESTIONS
					?>
				
					</table>
			</section>

			</main>

			<main style="margin-top:65px;box-shadow:none">
			
			<header class="container-small knsa-kul">
				<div>Pozostałe</div>
			</header>
			
			<section class="container-small result-form remaining-tables">
					
				<table style="margin-top:10px;">
					<tr>
						<td><p>Nazwa instytucji</p></td>
						<td><p><?php Value('../institution-name.php');?></p></td>
						<td>
							<button class="action-button" onclick="ChangeInstitutionName()">Change Institution Name</button>
						</td>
					</tr>
					<tr>
						<td><p>Nazwa wydarzenia</p></td>
						<td><p><?php Value('../event-name.php');?></p></td>
						<td>
							<button class="action-button" onclick="ChangeEventName()">Change Event Name</button>
						</td>
					</tr>
					<tr>
						<td><p>Data wydarzenia</p></td>
						<td><p><?php Value('../event-date.php');?></p></td>
						<td>
							<button class="action-button" onclick="ChangeEventDate()">Change Event Date</button>
						</td>
					</tr>
				</table>
			
				<table style="margin-top:20px;">
					<tr>
						<?php $board_auto_refresh_state = file_get_contents('../board-auto-refresh.php'); ?>
						<td><p>Board: Auto Refresh</p></td>
						<td><p><?php echo $board_auto_refresh_state ? 'Activated':'Deactivated'; ?></p></td>
						<td><button class="action-button" onclick="ChangeBoardAutoRefresh(<?php echo $board_auto_refresh_state ? '0':'1';?>)"><?php echo $board_auto_refresh_state ? 'Deactivate':'Activate';?></button></td>
					</tr>
				
				<?php 
					if ($board_auto_refresh_state) {
						
				
				echo '<tr>
					<td><p>Board: Auto Refresh</p><p>(time interval - ms)</p></td>
					<td><p>'; echo file_get_contents('../board-auto-refresh-time.php'); echo '</p></td>
					<td><button class="action-button" onclick="ChangeBoardAutoRefreshTime()">Change Time Interval</button></td>
				</tr>';
					}
				?>
		
			
			</table>
			
			<table style="margin-top:20px;">
				<tr>
				<?php $qr_code_visibility = file_get_contents('../board-qr-visible.php'); ?>
				
				<td><p>Board: QR Code visibility</p></td>
				<td><p><?php echo $qr_code_visibility ? 'Visible':'Hidden'; ?></p></td>
				<td><button class="action-button" onclick="ChangeQrVisibility(<?php echo $qr_code_visibility ? '0':'1';?>)"><?php echo $qr_code_visibility ? 'Hide QR Code':'Show QR code';?></button></td>		
				</tr>
			</table>

			</section>

			</main>

			<script src="../qa-data/panel.js"></script>


<?php
			
				if (isset ($_GET['iname'])) {
					file_put_contents('../institution-name.php', htmlspecialchars($_GET['iname']));
					echo '<script>
					let response = confirm("Institution name changed to: ' . $_GET['iname'] . '");
					if (response || !response) {
							window.location.replace("?");
						  }
					</script>';
					}
					
				if (isset ($_GET['eventname'])) {
					file_put_contents('../event-name.php', htmlspecialchars($_GET['eventname']));
					echo '<script>
					let response = confirm("Event name changed to: ' . $_GET['eventname'] . '");
					if (response || !response) {
							window.location.replace("?");
						  }
					</script>';
					
					}
					
				if (isset ($_GET['eventdate'])) {
					file_put_contents('../event-date.php', htmlspecialchars($_GET['eventdate']));
					echo '<script>
					let response = confirm("Event date changed to: ' . $_GET['eventdate'] . '");
					if (response || !response) {
							window.location.replace("?");
						  }
					</script>';
					}
					
				if (isset($_GET['session_status'])) {
					if ($_GET['session_status']) {
						file_put_contents('../status.php', 1);
						echo '<script>
						let response = confirm("Session is now open! New questions are welcome!");
						if (response || !response) {
								window.location.replace("?");
							  }
						</script>';
					}
					else {
						file_put_contents('../status.php', 0);
						echo '<script>
						let response = confirm("Session is now closed! New questions will not be added to the list!");
						if (response || !response) {
								window.location.replace("?");
							  }
						</script>';
					}
				}

				if (isset($_GET['delete_question']) && $_GET['delete_question'] && isset($_GET['question_id']) && filter_var($_GET['question_id'], FILTER_VALIDATE_INT) && $_GET['question_id'] >=1) {

						db_do_query_return_obj("DELETE FROM questions WHERE question_id=" . $_GET['question_id'] . ";");

						echo '<script>
						showModalLocate("Pytanie ID ' . $_GET['question_id'] . ' zostało usunięte!","?");
						</script>';
						
					}
				
					if (isset($_GET['board_auto_refresh'])) {
						
						if ($_GET['board_auto_refresh'] === '0' || $_GET['board_auto_refresh'] === '1') {
						
							file_put_contents('../board-auto-refresh.php', $_GET['board_auto_refresh']);
							echo '<script>
							let response = confirm("Auto refresh was'; echo $_GET['board_auto_refresh'] ? ' activated.':' deactivated.'; echo '");
							if (response || !response) {
									window.location.replace("?");
								  }
							</script>';
						}
					}
					
					if (isset($_GET['board_auto_refresh_time']) && filter_var($_GET['board_auto_refresh_time'], FILTER_VALIDATE_INT)) {
						
						if ($_GET['board_auto_refresh_time'] >= 1000 || $_GET['board_auto_refresh'] <= 10000) {
						
							file_put_contents('../board-auto-refresh-time.php', $_GET['board_auto_refresh_time']);
							echo '<script>
							let response = confirm("Auto refresh time interval was set to ' . $_GET['board_auto_refresh_time'] . '");
							if (response || !response) {
									window.location.replace("?");
								  }
							</script>';
						}
					}
					
					if (isset($_GET['qr_code_visibility'])) {
						
						if ($_GET['qr_code_visibility'] === '0' || $_GET['qr_code_visibility'] === '1') {
						
							file_put_contents('../board-qr-visible.php', $_GET['qr_code_visibility']);
							echo '<script>
							let response = confirm("QR Code is now'; echo $_GET['qr_code_visibility'] ? ' visible.':' hidden.'; echo '");
							if (response || !response) {
									window.location.replace("?");
								  }
							</script>';
						}
					}
				
?>
				</body>
				</html>