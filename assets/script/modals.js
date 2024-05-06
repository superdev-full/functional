
// AJAX code
let loginForm = document.querySelectorAll(".modal fade pr-0, .modal-dialog modal-dialog-centered, .modal-content form")[0];
loginForm.onsubmit = event => {
	event.preventDefault();
	fetch(loginForm.action, { method: 'POST', body: new FormData(loginForm) }).then(response => response.text()).then(result => {
		if (result.toLowerCase().includes("success")) {
			window.location.href = "<?php echo maverEnvironment ?>" + "submitassignment";
		} else {
			document.querySelector(".msg1").innerHTML = result;
		}
	});
};


// AJAX code
let registrationForm = document.querySelectorAll(".modal fade pr-0, .modal-dialog modal-dialog-centered, .modal-content form")[1];
registrationForm.onsubmit = event => {
	event.preventDefault();
	fetch(registrationForm.action, { method: 'POST', body: new FormData(registrationForm) }).then(response => response.text()).then(result => {
		if (result.toLowerCase().includes("autologin")) {
			window.location.href =  "<?php echo maverEnvironment ?>" + "submitassignment";
		} else {
			document.querySelector(".msg2").innerHTML = result;
		}
	});
};
