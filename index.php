<?php 
require_once 'functions.php';
require_once 'qa-db-connect.php';
?>

<!DOCTYPE html>

<html lang="pl-PL">
    <head>
        <meta charset="UTF-8">
        <meta name="robots" content="noindex, nofollow" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Koło Naukowe Studentów Anglistyki KUL">
		<title><?php Value('event-name.php');?> - <?php Value('institution-name.php');?></title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,300;0,600;1,300;1,600&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="/qa-data/styles.css">
		<script src="/qa-data/script.js"></script>
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
				<img src="/qa-data/x_icon.png" class="modal-close-icon" id="modal-close" alt="" width="16" height="16">
				<img src="/qa-data/kotek.png" alt="" class="modal-cat" width="64" height="64">
				</div>
			</div>
		</aside>
		<?php 
			$session = file_get_contents('status.php');
		
				if ($session) {
					InputQuestion();
				}
				else {
					SessionClosed();
				}

		?>
    </body>
</html>