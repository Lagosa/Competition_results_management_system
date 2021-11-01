function feltoltLista(elementId){
	var lista = document.getElementById(elementId);

	var elemi = ['Elemi','E.A','E.B','1.A','1.B','2.A','2.B','3.A','3.B','4.A','4.B'];
	var gimi = ['Gimnázium','5.A','5.B','6.A','6.B','6.C','7.A','7.B','8.A','8.B'];
	var lici = ['Líceum','9.H','9.R','10.H','10.R','11.H','11.R','12.H','12.R'];

	var opt;
	for(var i=0;i<elemi.length;i++)
	{
		opt = document.createElement('option');
		opt.value = elemi[i];
		opt.textContent = elemi[i];
		lista.appendChild(opt);
	}
	for(var i=0;i<gimi.length;i++)
	{
		opt = document.createElement('option');
		opt.value = gimi[i];
		opt.textContent = gimi[i];
		lista.appendChild(opt);
	}
	for(var i=0;i<lici.length;i++)
	{
		opt = document.createElement('option');
		opt.value = lici[i];
		opt.textContent = lici[i];
		lista.appendChild(opt);
	}
	opt = document.createElement('option');
	opt.value = 'Egybe';
	opt.textContent = 'Ömlesztve';
	lista.appendChild(opt);
}
function display(idShow,idHide){
	document.getElementById(idShow).style.visibility = "visible";
	document.getElementById(idHide).style.visibility = "hidden";
}
function hideSzamitasok(){
	document.getElementById("szamitasok").style.visibility = "hidden";
	document.getElementById("szamitasOsztaly").style.visibility = "hidden";
	document.getElementById("szamitasTanar").style.visibility = "hidden";
	document.getElementById("szamitasValasztDiak").style.visibility = "hidden";
	document.getElementById("szamitasValasztTanar").style.visibility = "hidden";
}
function displayChilds(){
	document.getElementById("szamitasValasztDiak").style.visibility = "visible";
	document.getElementById("szamitasValasztTanar").style.visibility = "visible";
	document.getElementById("szamitasOsztaly").style.visibility = "hidden";
	document.getElementById("szamitasTanar").style.visibility = "hidden";
}
