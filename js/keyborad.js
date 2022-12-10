document.addEventListener('keydown', (e) => {
	if (!e.repeat) {
		console.log(e.key);
	} else {
		console.log(e.key);
	}
	switch(e.key) {
		case "ArrowUp": 
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