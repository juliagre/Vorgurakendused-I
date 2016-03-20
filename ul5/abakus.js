window.onload = function() {
	var massiiv = document.querySelectorAll("div.bead");
	function changePosition() {
    if(this.style.cssFloat == "left") {
        this.style.cssFloat = "right";
    } else {
        this.style.cssFloat = "left";
    }
}

	for (i = 0, len = massiiv.length; i < len; i++){
		massiiv[i].onclick = changePosition;
	}



};