let active_question_id = -1;

$(document).ready(function () {
	console.log("Initializing");
	let unread_candidates = "";

	if( $( ".card-question" ).first() != undefined ){
		active_question_id 	= $( ".card-question" ).first().attr('data-qid');
		console.log("active_question_id: " + active_question_id);
		if(active_question_id=="-1" || active_question_id === undefined){
			return false;
		}		
		
		unread_candidates = setInterval( load_unread_candidates , 8000);		
	}	

	$(".card-question").click(function () {
		if($(this).attr('data-qid')=="-1" || $(this).attr('data-qid') === undefined){
			return false;
		}

		active_question_id = $(this).attr('data-qid');

		load_question_detail(  active_question_id );
		load_question_candidates( active_question_id );

		clearInterval(unread_candidates);
		unread_candidates = setInterval( load_unread_candidates , 8000);

	});

});

function decline_btn_click(obj){
	console.log("decline_btn_click");
	if($(obj).attr('data-bidid')=="-1" || $(obj).attr('data-bidid') === undefined || $(obj).attr('data-qid')=="-1" || $(obj).attr('data-qid') === undefined){
		return false;
	}

	if( confirm('Are you sure you want to decline this candidate?') ){
		decline_bid( $(obj).attr('data-qid'), $(obj).attr('data-bidid') );
	}
}

function hire_btn_click(obj){
	console.log("hire_btn_click");
	if($(obj).attr('data-bidid')=="-1" || $(obj).attr('data-bidid') === undefined || $(obj).attr('data-qid')=="-1" || $(obj).attr('data-qid') === undefined){
		console.log("empty or wrong btn");
		return false;
	}

	if( confirm('Are you sure you want to accept this candidate?') ){
		accept_bid( $(obj).attr('data-qid'), $(obj).attr('data-bidid') );
	}
}

function load_question_detail( question_id ){

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	   document.getElementById("question_detail").innerHTML = this.responseText;
	  }
	};
	xhttp.open("GET", "/yourquestions/get.php?question_id=" + question_id, true);
	xhttp.send();

	return false;
}

function load_question_candidates( question_id ){

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	   document.getElementById("question_candidates").innerHTML =  this.responseText;
	   // +
	  }
	};
	xhttp.open("GET", "/yourquestions/get_candidates.php?question_id=" + question_id, true);
	xhttp.send();

	return false;
}

function load_unread_candidates(){
	console.log("load_unread_candidates()");
	load_question_candidates( active_question_id );
}

function decline_bid( question_id , bid_id ){

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	   // call load_candidates
	   load_question_candidates( question_id );
	  }
	};
	xhttp.open("GET", "/yourquestions/decline_bid.php?question_id=" + question_id + "&bid_id=" + bid_id, true);
	xhttp.send();

	return false;
}

function accept_bid( question_id , bid_id ){

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	   // call load_candidates
	   load_question_candidates( question_id );
	  }
	};
	xhttp.open("GET", "/yourquestions/accept_bid.php?question_id=" + question_id + "&bid_id=" + bid_id, true);
	xhttp.send();

	return false;
}