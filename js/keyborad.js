document.addEventListener('keydown', (e) => {
	if (!e.repeat) {
		console.log(e.key);
	} else {
		console.log(e.key);
	}
	switch(e.key) {
		case "ArrowUp": 
			switch (window.location.href) {
				case "InfProject/panel.php":
					break;
				case "InfProject/grades.php":
					break;
				case "InfProject/attendance.php":
					break;
				case "InfProject/timetable.php":
					break;
				case "InfProject/exams.php":
					break;
			}
			break;		
		case "ArrowRight": 
			switch (window.location.href) {

			}
			break;		
		case "ArrowLeft":
			switch (window.location.href) {
				
			}
			break;		
		case "ArrowDown":
			switch (window.location.href) {
				
			}
			break;
		default: 
			return; 
   }
});