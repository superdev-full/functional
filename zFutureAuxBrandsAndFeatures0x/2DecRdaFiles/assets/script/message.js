let active_chat_id = -1;
let active_member_id = -1;
let last_top_chat_id = -1;

const chat_scan_interval = 8000;


let unread_messages = null;
let chat_list = null;

$(document).ready(function () {
  // Find the first element and set
  if ($(window).width() <= 767) {
    $(".user-container").addClass("mobile");
    $(".chatting-container").addClass("mobile");
    $(".user-container.mobile")
      .find(".user-box")
      .click(function () {
        if ($(window).width() <= 767)
          $(".user-container").removeClass("active");
      });
    $(".back-btn").click(function () {
      $(".user-container").addClass("active");
    });
  } else {
    $(".user-container").removeClass("mobile");
    $(".chatting-container").removeClass("mobile");
  }
  $(window).resize(function () {
    if ($(window).width() <= 767) {
      $(".user-container").addClass("mobile");
      $(".chatting-container").addClass("mobile");
      $(".user-container.mobile")
        .find(".user-box")
        .click(function () {
          if ($(window).width() <= 767)
            $(".user-container").removeClass("active");
        });
      $(".back-btn").click(function () {
        $(".user-container").addClass("active");
      });
    } else {
      $(".user-container").removeClass("mobile");
      $(".chatting-container").removeClass("mobile");
      $(".user-container").addClass("active");
    }
  });

  if ($(".card-chat").first() != undefined) {
    active_chat_id = $(".card-chat").first().attr("data-chatid");
    active_member_id = $(".card-chat").first().attr("data-memberid");
    console.log("Initializing");
    console.log("active_chat_id: " + active_chat_id);
    console.log("active_member_id: " + active_member_id);
  }

  unread_messages = setInterval(load_chat_unread_messages, chat_scan_interval);
  chat_list = setInterval(load_chat_list, chat_scan_interval);
  //let all_messages = setInterval(load_all_messages, chat_scan_interval);
  load_all_messages();

  // scroll it to bottom
  $(".chatting-box-body").scrollTop($(".chatting-box-body")[0].scrollHeight);

  $(".card-chat").click(on_card_chat_click);

  $("#send_msg").click(function () {
    console.log("#send_msg.click");
    console.log("active_chat_id: " + active_chat_id);
    console.log("active_member_id: " + active_member_id);

    if (active_chat_id != -1 && active_member_id != -1) {
      send_message();
    } else {
      return false;
    }
  });
});


function on_card_chat_click() {
  if (
    $(this).attr("data-chatid") == "-1" ||
    $(this).attr("data-chatid") === undefined ||
    $(this).attr("data-memberid") == "-1" ||
    $(this).attr("data-memberid") === undefined
  ) {
    return false;
  }

  $(this).find(".unread-mark").css("background-color", "white");
  active_chat_id = $(this).attr("data-chatid");
  active_member_id = $(this).attr("data-memberid");

  clearInterval(unread_messages);
  clearInterval(chat_list);
  // clearInterval(all_messages);
  unread_messages = setInterval(load_chat_unread_messages, chat_scan_interval);
  chat_list = setInterval(load_chat_list, chat_scan_interval);
  // all_messages = setInterval(load_all_messages, chat_scan_interval);

  load_chat_messages_header(active_chat_id);
  load_chat_messages(active_chat_id);
}



function send_message() {
  let msg = $("#msg_box").val().trim();

  if (msg.length == 0) {
    console.log("empty message");
    return false;
  }

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let response = this.responseText;
      if (response == "[OK]") {
        ui_reset_message();
        ui_add_new_message(msg);
        load_chat_list();
      }
    }
  };

  xhttp.open("POST", "/messages/send_message.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(
    "chat_id=" +
    active_chat_id +
    "&member_id=" +
    active_member_id +
    "&msg=" +
    msg
  );

  return false;
}

function ui_add_new_message(msg) {
  var today = new Date();
  var date =
    today.getMonth() + 1 + "/" + today.getDate() + "/" + today.getFullYear();
  var time =
    today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();

  let new_msg = "";
  msg = msg.replace("\n", "<br>");
  new_msg =
    "<div class='msg-box-datetime msg-box-datetime-me'><div class='msg-box-date-me date-text' >" +
    time +
    "</div><div class='msg-box-time-me date-text'></div><div style='clear:both;'></div></div>";
  new_msg += "<div class='msg-box me'>";
  new_msg += "	<p class='body-text mb-0'>";
  new_msg += msg;
  new_msg += "	</p>";
  new_msg += "</div>";

  $("#chat_messages").append(new_msg);

  // scroll it to bottom
  $(".chatting-box-body").scrollTop($(".chatting-box-body")[0].scrollHeight);
}

function ui_reset_message() {
  // clear the no messages div
  $(".no-messages").html("");
  // Clear the text box
  $("#msg_box").val("");
  // Clear the file input
  $("#file-input").val("");
}

function ui_disable_message() {
  // Disable the text box
  $("#msg_box").prop('disabled', true);
  // Disable the button
  $("#send_msg").prop('disabled', true);
}

function ui_enable_message() {
  // enable the text box
  $("#msg_box").prop('disabled', false);
  // enable the button
  $("#send_msg").prop('disabled', false);
}

function load_chat_messages_header(chat_id) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("chat_messages_header").innerHTML =
        this.responseText;
    }
  };
  xhttp.open(
    "GET",
    "/messages/get_messages_header.php?chat_id=" + chat_id,
    true
  );
  xhttp.send();

  return false;
}

function load_chat_messages(chat_id) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("chat_messages").innerHTML = this.responseText;

      // scroll it to bottom
      $(".chatting-box-body").scrollTop(
        $(".chatting-box-body")[0].scrollHeight
      );
    }
  };
  xhttp.open(
    "GET",
    "/messages/get_messages.php?chat_id=" + chat_id + "&unread=0",
    true
  );
  xhttp.send();

  return false;
}

function load_chat_unread_messages() {
  console.log("load_chat_unread_messages[chat_id: " + active_chat_id + "]");

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let new_messages = this.responseText;
      console.log("new messages length " + new_messages.length);
      if (new_messages.length > 10) {
        // clear the no messages div
        $(".no-messages").html("");

        //add to UI
        $("#chat_messages").append(new_messages);

        // scroll it to bottom
        $(".chatting-box-body").scrollTop(
          $(".chatting-box-body")[0].scrollHeight
        );
      }
    }
  };
  xhttp.open(
    "GET",
    "/messages/get_messages.php?chat_id=" + active_chat_id + "&unread=1",
    true
  );
  xhttp.send();

  return false;
}

function load_chat_list() {
  console.log("load_chat_list");

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (document.getElementById("chats_list").innerHTML != this.responseText) {
        document.getElementById("chats_list").innerHTML = this.responseText;
        $(".card-chat").click(on_card_chat_click);
      }
    }
  };
  xhttp.open(
    "GET",
    "/messages/get_chats_list.php",
    true
  );
  xhttp.send();

  return false;
}

function load_all_messages() {
  console.log("load_all_messages");

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let top_chat_id = this.responseText;
      console.log(this);
      console.log(last_top_chat_id);
      if (top_chat_id != active_chat_id) {
        console.log("-------------------------------------------");
        // refresh the page
        // window.location.reload();
        // clearInterval(unread_messages);
        // // clearInterval(all_messages);
        // unread_messages = setInterval(load_chat_unread_messages, chat_scan_interval);
        // // all_messages = setInterval(load_all_messages, chat_scan_interval);

        load_chat_messages_header(top_chat_id);
        load_chat_messages(top_chat_id);
        // last_top_chat_id = top_chat_id;
      }
    }
  };
  xhttp.open(
    "GET",
    "/messages/get_all_messages.php",
    true
  );
  xhttp.send();

  return false;
}

function upload_file(input) {

  $("#msg_box").val("Uploading attachment...");
  ui_disable_message();

  var formData = new FormData();
  formData.append("file-input", document.getElementById("file-input").files[0]);

  formData.append("chat_id", active_chat_id);
  formData.append("member_id", active_member_id);

  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let response = this.responseText;
      console.log("response: " + response);
      if (response == "[OK]") {
        ui_reset_message();
        // ui_add_new_message(msg);
      }

      ui_enable_message();
    }
  };

  xhttp.open("POST", "/messages/send_file.php", true);
  xhttp.send(formData);
}