let active_assignment_id = -1;

$(document).ready(function () {
	console.log("Initializing");
	let unread_candidates = "";

	if( $( ".card-assignment" ).first() != undefined ){
		active_assignment_id 	= $( ".card-assignment" ).first().attr('data-qid');
		console.log("active_assignment_id: " + active_assignment_id);
		if(active_assignment_id=="-1" || active_assignment_id === undefined){
			return false;
		}		
		
		unread_candidates = setInterval( load_unread_candidates , 8000);		
	}	

	$(".card-assignment").click(function () {
		if($(this).attr('data-qid')=="-1" || $(this).attr('data-qid') === undefined){
			return false;
		}

		active_assignment_id = $(this).attr('data-qid');

		load_assignment_detail(  active_assignment_id );
		load_assignment_candidates( active_assignment_id );

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

function load_assignment_detail( assignment_id ){

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	   document.getElementById("assignment_detail").innerHTML = this.responseText;
	  }
	};
	xhttp.open("GET", "/yourassignments/get.php?assignment_id=" + assignment_id, true);
	xhttp.send();

	return false;
}

function load_assignment_candidates( assignment_id ){

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	   document.getElementById("assignment_candidates").innerHTML =  this.responseText;
	   // +
	  }
	};
	xhttp.open("GET", "/yourassignments/get_candidates.php?assignment_id=" + assignment_id, true);
	xhttp.send();

	return false;
}

function load_unread_candidates(){
	console.log("load_unread_candidates()");
	load_assignment_candidates( active_assignment_id );
}

function decline_bid( assignment_id , bid_id ){

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	   // call load_candidates
	   load_assignment_candidates( assignment_id );
	  }
	};
	xhttp.open("GET", "/yourassignments/decline_bid.php?assignment_id=" + assignment_id + "&bid_id=" + bid_id, true);
	xhttp.send();

	return false;
}

function accept_bid( assignment_id , bid_id ){

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	   // call load_candidates
	   load_assignment_candidates( assignment_id );
	  }
	};
	xhttp.open("GET", "/yourassignments/accept_bid.php?assignment_id=" + assignment_id + "&bid_id=" + bid_id, true);
	xhttp.send();

	return false;
}