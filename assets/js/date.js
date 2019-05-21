function getdatem() {
	var datebuy = document.getElementById('datebuy').value;
	var addyearm = +document.getElementById('addyearm').value;

	var date = new Date(datebuy);
	var newdatem = new Date(date);

	newdatem.setFullYear(newdatem.getFullYear() + addyearm);
	
	var dd = newdatem.getDate();
	var mm = newdatem.getMonth() + 1;
	var y = newdatem.getFullYear();

	if (mm < 10) { mm = '0' + mm; };
	if (dd < 10) { dd = '0' + dd; };

	var someFormattedDatem = y + '-' + mm + '-' + dd;
	document.getElementById('datem').value = someFormattedDatem;
}

function getdatee() {
	var datem = document.getElementById('datem').value;
	var addyeare = +document.getElementById('addyeare').value;

	var date = new Date(datem);
	var newdatee = new Date(date);

	newdatee.setFullYear(newdatee.getFullYear() + addyeare);
	
	var dd = newdatee.getDate();
	var mm = newdatee.getMonth() + 1;
	var y = newdatee.getFullYear();

	if (mm < 10) { mm = '0' + mm; };
	if (dd < 10) { dd = '0' + dd; };

	var someFormattedDatee = y + '-' + mm + '-' + dd;
	document.getElementById('datee').value = someFormattedDatee;
}