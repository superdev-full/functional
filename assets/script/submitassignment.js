$(document).ready(function () {
  $("#atitle").val(getCookie("submitassignment"));
  //====================== stepper form script start============================
  var current_fs, next_fs, previous_fs; //fieldsets
  var opacity;
  var current = 1;
  var steps = $("fieldset").length;

  setProgressBar(current);

  $(".next").click(function () {
    if ($("#topic")) $("#topic").focus();
    current_fs = $(this).parent().parent();
    next_fs = $(this).parent().parent().next();

    // Check if title and description are filled
    if( $('#atitle').val().trim() == "" ){
      alert('Please provide a title for your assignment.');
      return false;
    }else if( $('#description').val().trim() == "" ){
      alert('Please provide a description for your assignment.');
      return false;
    }else if( $('#atitle').val().trim().length > A_TITLE_LIMIT ){
      alert('Your title is too long, maximum length allow is ' + A_TITLE_LIMIT + ' characters.');
      return false;
    }else if( $('#description').val().trim().length > A_DESCRIPTION_LIMIT ){
      alert('Your description is too long, maximum length allow is ' + A_DESCRIPTION_LIMIT + ' characters.');
      return false;
    }

    // Update the cookie
    setCookie("submitassignment", $('#atitle').val(), 30);

    //Add Class Active
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    //show the next fieldset
    next_fs.show();
    //hide the current fieldset with style
    current_fs.animate(
      { opacity: 0 },
      {
        step: function (now) {
          // for making fielset appear animation
          opacity = 1 - now;

          current_fs.css({
            display: "none",
            position: "relative",
          });
          next_fs.css({ opacity: opacity });
        },
        duration: 500,
      }
    );
    setProgressBar(++current);
  });

  $(".previous").click(function () {
    if ($("#topic")) $("#topic").focus();
    current_fs = $(this).parent().parent();
    previous_fs = $(this).parent().parent().prev();

    //Remove class active
    $("#progressbar li")
      .eq($("fieldset").index(current_fs))
      .removeClass("active");

    //show the previous fieldset
    previous_fs.show();

    //hide the current fieldset with style
    current_fs.animate(
      { opacity: 0 },
      {
        step: function (now) {
          // for making fielset appear animation
          opacity = 1 - now;

          current_fs.css({
            display: "none",
            position: "relative",
          });
          previous_fs.css({ opacity: opacity });
        },
        duration: 500,
      }
    );
    setProgressBar(--current);
  });

  function setProgressBar(curStep) {
    var percent = parseFloat(100 / steps) * curStep;
    percent = percent.toFixed();
    $(".progress-bar").css("width", percent + "%");
  }

  $(".submit").click(function () {
    return false;
  });

  $("#topic").on("keypress", function (e) {
    if (e.which == 13) {
      if ($(this).val()) {
        $(".topic-box").prepend(
          `<div class="topic-item mr-2">
            <div class="close-btn">
              <svg xmlns="http://www.w3.org/2000/svg"\
               width="1em" height="1em" preserveAspect\
               Ratio="xMidYMid meet" viewBox="0 0 32 32"\
               ><path fill="currentColor" d="M24 9.4L22.6\
                8L16 14.6L9.4 8L8 9.4l6.6 6.6L8 22.6L9.4\
                 24l6.6-6.6l6.6 6.6l1.4-1.4l-6.6-6.6L24 9.4z"/></svg>
            </div><div>` +
            $(this).val() +
            `</div></div>`
        );
        $(this).val("");
        $("#topic").focus();
      }
    }
    $(".close-btn").click(function () {
      $(this).closest(".topic-item").remove();
      $("#topic").focus();
    });
  });

  $(".selectBox").on("click", function (e) {
    $(this).toggleClass("show");
    var dropdownItem = e.target;
    var container = $(this).find(".selectBox__value");
    container.text(dropdownItem.text);
    $(dropdownItem).addClass("active").siblings().removeClass("active");
  });
  //==================================== stepper form script end======================
  $(".dropdown-item").click(function () {
    console.log(this.innerHTML);
    $("#aemergency").val(this.innerHTML);
    
  });

});

// Write the file name of the selected file in the preview 
function preview_file(input){
    let file = $("input[type=file]").get(0).files[0];
    let filename = file.name;
    if(filename.length>30){
      filename = filename.substring(1,20) + "...";
    }
    $("#filename_preview").html(filename);

}  
