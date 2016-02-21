function timer(){
	var endDate = new Date("2016-02-21T23:59:59");
	var time = new Date();
	var difference = endDate-time;
	if (endDate>time){
		var päevad = parseInt(difference/(1000*60*60*24));
		var tunnid = parseInt(difference/(1000*60*60))%24;
		var minutid = parseInt(difference/(1000*60))%60;
		var sekundid = parseInt(difference/(1000))%60;
		document.getElementById('myText').innerHTML = päevad + " päeva: " + tunnid + " tundi: " + minutid + " minutit: " + sekundid +" sekundit"
	}
	else {alert("TÖÖDE ESITAMISE TAHTAEG MÖÖDUNUD!")}
	
}