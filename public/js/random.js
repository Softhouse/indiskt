
function createStuffs() {
	
	for(var i = 0 ; i < 2; i++) {
		createObject("Elephant");
	}
	for(var i = 0 ; i < 2; i++) {
		createObject("Ganesh");
	}
	playTune();
	var dishes = new Array("Kyckling vindaloo", "Kyckling curry", "Kyckling Masala", "Butter Chicken", "Kyckling Tikka Masala", "Kyckling Karahi", "Kyckling Saag", "Palak Panear", "Shahi pannear");
	var dish = Math.floor(Math.random() * dishes.length)
	
	setTimeout(function() {
		$('#base_dish').val(dishes[dish]).attr('selected',true);
	}, 3000);
	
	
}

function createObject(type) {
	
	var start = Math.floor(Math.random()*1000)
	setTimeout(function() {
		var id = idGen(8);
		var startHeight = Math.floor(Math.random()*80)
		$(".main").append("<span class=\"" + type + "\" id=\"" + id + "\"></span>");
		$("#"+ id).css("top",startHeight + "%");
			setTimeout(function() {
			$("#"+ id).addClass("flyOff"+ type);
		}, 200);
		
		var endHeight = Math.floor(Math.random()*80)
		setTimeout(function() {
			$("#"+ id).css("top",endHeight + "%")
		}, 1000);
		
		setTimeout(function() {
			$("#"+ id).remove();
		}, 5000);
	}, start);
}

function playTune(){
    var audioElement = document.createElement('audio');
    audioElement.setAttribute('src', "/sound/tune.mp3");
    audioElement.load();
    audioElement.addEventListener("canplay", function() {
        audioElement.play();
    });
}


function idGen(length) {
  var iteration = 0;
  var id = "";
  var randomNumber;
  if(special == undefined){
      var special = false;
  }
  while(iteration < length){
    randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
    if(!special){
      if ((randomNumber >=33) && (randomNumber <=47)) { continue; }
      if ((randomNumber >=58) && (randomNumber <=64)) { continue; }
      if ((randomNumber >=91) && (randomNumber <=96)) { continue; }
      if ((randomNumber >=123) && (randomNumber <=126)) { continue; }
    }
    iteration++;
    id += String.fromCharCode(randomNumber);
  }
  return id;
}
