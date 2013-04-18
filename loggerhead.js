var httpRequest1 = false;
var lastFunction;

function request(fileName,callback) {
	if (window.XMLHttpRequest) {
		httpRequest1 = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		try {
			httpRequest1 = new ActiveXObject('Msxml2.XMLHTTP');
		} catch (e) {
			try {
				httpRequest1 = new ActiveXObject('Microsoft.XMLHTTP');
			} catch (e) {}
		}
	}
	if (!httpRequest1) {
		alert('Please update to a more modern browser.');
		return false;
	}
	httpRequest1.onreadystatechange = function(){
		if (httpRequest1.readyState == 4) {
			if(httpRequest1.status==200){
				callback();
				window.status = "Done";
			}else{	// automatically resend call if it doesnt work the first time
				httpRequest1.open('GET', fileName, true);
				httpRequest1.send(null);
				window.status = "Retrying";
			}
		}
	};
	window.status = "Loading";
	httpRequest1.open('GET', fileName, true);
	httpRequest1.send(null);
	window.status = "Loading";
}

function loadPlayers() {
	request("sidebar.php", function() {
		document.getElementById('sidebar').innerHTML = httpRequest1.responseText;
	});
}

function addPlayer(name, nickname) {
	if (nickname.indexOf(' ') != -1) {
		alert('Nicknames may not have spaces.');
		return;
	}
	if (nickname.length > 15) {
		alert('Nicknames may not be longer than 15 characters (' + nickname.length + ')');
		return;
	}
	request('newplayer.php?name=' + name + '&nick=' + nickname, loadPlayers);
	var inputs = document.getElementById('add').getElementsByTagName('input');
	inputs[0].value = '';
	inputs[1].value = '';
}
function removePlayer(nickname) {
	var sure = confirm('Are you sure that you wish to remove ' + nickname + '? This action cannot be undone.');
	if(sure) {
		request('remove.php?nick=' + nickname, function(){
			loadPlayers();
			playerComparison();
		});
		alert (nickname + " was removed.");
	}
	else alert('Your action was canceled.');
}

function updateLog(nickname, questionCategory, result) { // result can have string values: p,i,m,n
	request('update.php?nick=' + nickname + "&qtype=" + questionCategory + "&btype=" + result,
			lastFunction);
}

function displayPlayerStats(nickname) {
	request('playerstats.php?nick=' + nickname, function() {
		document.getElementById('display').innerHTML = httpRequest1.responseText;
	});
	lastFunction = function(){displayPlayerStats(nickname);}
}
function playerComparison(url) {
	if(url == null) url='sql.php';
	if(!document.getElementById('frame'))
		document.getElementById('display').innerHTML = 
			'<iframe id="frame" src="'+url+'" width="800" height="500" frameborder="0">';
	else
		document.getElementById('frame').contentWindow.location.href = url;
	lastFunction = function(){
		playerComparison(document.getElementById('frame').contentWindow.location.href);
	}
}
window.onload = loadPlayers;