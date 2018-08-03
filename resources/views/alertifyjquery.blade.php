<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="{{ asset('backend/assets/css/totancss/style.css') }}"></script>

    <script src="{{ asset('backend/assets/js/totanjs/alertify.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/totanjs/jquery-1.9.1.js') }}"></script>

	<style>
body{
    background-color: #FFC0CB;
    padding-top: 30px;
}
.main-section{
	text-align: center;
	padding:80px;
	background-color:#fff;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}
.button-primary {
    background: #d16879;
    color: #FFF;
    padding: 10px 20px;
    font-weight: bold;
    border:1px solid #FFC0CB;
}
</style>
</head>
<body>
<div class="main-section">
	<nav class="button-group">
		<button class="button-primary" id="alert">Alert Dialog</button>
		<button class="button-primary" id="confirm">Confirm Dialog</button>
		<button class="button-primary" id="prompt">Prompt Dialog</button>
	</nav>	
</div>

<script type="text/javascript">
$("#alert").on( 'click', function () {
	alertify.alert("This is an alert dialog");
	return false;
});

$("#confirm").on( 'click', function () { 
	alertify.confirm("This is a confirm dialog", function (e) {
		if (e) {
			alertify.success("You've clicked OK");
		} else {
			alertify.error("You've clicked Cancel");
		}
	});
	return false;
});

$("#prompt").on( 'click', function () {
	alertify.prompt("This is a prompt dialog", function (e, str) {
		if (e) {
			alertify.success("You've clicked OK and typed: " + str);
		} else {
			alertify.error("You've clicked Cancel");
		}
	}, "Default Value");
	return false;
});

</script>
</body>
</html>