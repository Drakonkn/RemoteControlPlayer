
function showAuthWindows () {
	var url = "https://oauth.vk.com/authorize?client_id=4223386&scope=audio,friends,offline&redirect_uri=http://localhost/index1.php&response_type=code"
	var newWin = window.open(url, "Auth");
}