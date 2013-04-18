var halfInt, TCInt, bonusInt;
function startHalf() {
	halfInt = clearInterval(halfInt);
	document.getElementById('times').getElementsByTagName('td')[0].style.color = '#000';
	halfInt = setInterval('reduce(document.getElementById(\'times\').getElementsByTagName(\'td\')[0])', 1000);
}
function startTC() {
	TCInt = clearInterval(TCInt);
	document.getElementById('times').getElementsByTagName('td')[1].style.color = '#000';
	TCInt = setInterval('reduce(document.getElementById(\'times\').getElementsByTagName(\'td\')[1])', 1000);
}
function startBonus() {
	bonusInt = clearInterval(bonusInt);
	document.getElementById('times').getElementsByTagName('td')[2].style.color = '#000';
	bonusInt = setInterval('reduce(document.getElementById(\'times\').getElementsByTagName(\'td\')[2])', 1000);
}
function reduce(time) {
	var str = time.innerHTML;
	var sec = (str.charAt(3) == '0') ? parseInt(str.charAt(4)) : parseInt(str.split(':')[1]);
	var min = (str.charAt(0) == '0') ? parseInt(str.charAt(1)) : parseInt(str.split(':')[0]);
	if (sec == 0) {
		if (min <= 0) {
			time.innerHTML = '00:00';
			return;
		}
		(min > 10) ? time.innerHTML = (min - 1) + ':59' : time.innerHTML = '0' + (min-1) + ':59';
	}
	else {
		if (min == 0 && sec < 7) time.style.color = 'red';
		else time.style.color = '#000';
		(sec > 10) ? time.innerHTML = str.split(':')[0] + ':' + (sec-1) : time.innerHTML = str.split(':')[0] + ':0' + (sec-1);
	}
}