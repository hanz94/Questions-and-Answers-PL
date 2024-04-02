<?php require_once '../functions.php';
require_once '../qa-db-connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Clear</title>
</head>
<body>
	
<button onclick="Clear()">Clear Questions</button>

<script>
	function Clear() {
		
		let response = confirm("Delete all questions?\nOK to confirm.");
		
		if (response) {
			window.location.replace("?clear=1");
		}
		
	}

</script>

<?php
	if (isset($_GET['clear']) && $_GET['clear']) {

		db_do_query_return_obj("DELETE FROM questions");
		db_do_query_return_obj("ALTER TABLE questions AUTO_INCREMENT = 1");
		
		echo 	'<script>
					alert("Cleared all questions.");
					window.location.replace("?");
				</script>';
		
	}




?>
</body>
</html>