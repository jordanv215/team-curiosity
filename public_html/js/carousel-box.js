function slideBox(id) {

	// create array of image paths
	var images = [
		"img/above-shot.jpg",
		"img/mars-landscape.jpg",
		"img/sunset.gif",
		"img/selfie-optimized.jpg"
		
	];

	// grab appropriate image path based on slide id
	var path;
	switch (id) {
		case "slide-1":
			path = images[0];
			break;
		case "slide-2":
			path = images[1];
			break;
		case "slide-3":
			path = images[2];
			break;
		case "slide-4":
			path = images[3];
			break;
		default:
			path = images[0];
			break;
	}

	document.getElementById("imgModalImage").innerHTML = "<img src=\'" + path + "\' alt=\'mars image\' class=\'img-responsive\' >";

	// call modal
	$("#imgModal").modal();
}