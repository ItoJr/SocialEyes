function chatLiveSearch(uid) {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
      //some more code
      document.getElementById("items").innerHTML = this.responseText;
      if(this.responseText.match(/[a-z]/i))
      {
        document.getElementById("chats").style.opacity = .4;
      }
      else
      {
        document.getElementById("chats").style.opacity = 1;
      }
		}
	}
  var keyword=document.getElementById("chat-live-search-box").value;
	xhttp.open("POST", root+"../src/chat/chatSearch.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var para = "uid=" + uid + "&keyword=" + keyword;
	xhttp.send(para);
}

function openChatWindow(from,to){
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("chat-live-search-box").value="";
			chatLiveSearch();
			generateChatHistory();
		}
	}
	xhttp.open("POST", root+"../src/chat/makeChatConnection.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var para = "from=" + from + "&to=" + to;
	xhttp.send(para);
}
