$(document).ready(function () {
  var h = $("#codepad").css("height");
  var num = Math.ceil(h.substring(0, 3) / 25);
  // console.log(num)
  var temp = "";
  let flag = "";
  for (let i = 1; i <= num; i++) {
    if (i % 2 != 0) flag = "odd";
    else flag = "even";
    temp += `<div class="number ` + flag + `">` + i + `</div>`;
  }
  $(".codepad-bg").html(temp);
});
