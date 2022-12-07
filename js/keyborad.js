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
		case "1":
			window.location.href = 'panel.php';
			break;
		case "2":
			window.location.href = 'grades.php';
			break;
		case "3":
			window.location.href = 'attendance.php';
			break;
		case "4":
			window.location.href = 'timetable.php';
			break;
		case "5":
			window.location.href = 'exams.php';
			break;
		case "6":
			window.location.href = 'meetings.php';
			break;
		case "7":
			window.location.href = 'topics.php';
			break;
		case "8":
			window.location.href = 'comments.php';
			break;
		default: 
			return; 
   }
});