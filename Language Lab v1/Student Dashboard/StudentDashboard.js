function setContent() {
	/* Get name from DB. */
	var name = "Test";

	//TO-do
	//name = getFromDB();

	setStudentName(name);

	/* Get a course list from DB. */
	//setCourseList();
}

function setStudentName(inName) {
	var welcomeMsg = "Welcome, " + inName;
	document.getElementById("welcome").innerHTML = welcomeMsg;
}

