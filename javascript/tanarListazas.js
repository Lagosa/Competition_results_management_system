function clearTable(){
	document.getElementById('results').innerHTML = "";
}
function tableCreate(tanar) {

  clearTable();
  var container = document.getElementById('pdfContainer');
  container.style.visibility = 'visible';
}

function populateTeachers(){
	var select = document.getElementById('selectTeacher');
	var teachers = ['Albert Hajnalka','András Ákos','Apáczai Csilla','Baczó Emese','Balon-Ruff Andrea','Bartha Bea','Bárdos Réka','Bicăzan Silvana Luminița','Boda Attila','Boér Ágota'];
	for(var i=0;i<teachers.length;i++){
		var el = document.createElement('option');
		el.textContent = teachers[i];
		el.value = teachers[i];
		select.appendChild(el);
	}
}
