const words = [
  "How do you fix DNS Server errors?",
  "How do you transfer data from SQL to AWS?",
  "How do you detect error 404 in JSON request?",
  "How do you detect a user gesture in ReactJS?",
  "How do you use UIGestureRecognizer in swift 5.5?",
  "How do you fix OAuth login error 18?",
  "How do you start coding?",
  "How to get selected UICollectionViewCell?",
  "How to generate Regular Expression?",
  "How do I avoid error while pushing to Github?",
  "How do you make Swift UI’s Picker borderless/transparent on macOS?",
  "How do I build a 2D game board with a player using Swift?",
  "How to get a specific video area in Swift AWPlayer?",
  "Responsive Column Layout with CSS/HTML?",
  "How can I write Code to create a tree using fork()?",
];

const containerEl = document.querySelector(".container");
const formEl = document.querySelector("#search");
const dropEl = document.querySelector(".drop");

const formHandler = (e) => {
  const userInput = e.target.value.toLowerCase();

  if (userInput.length === 0) {
    dropEl.style.height = 0;
    dropEl.style.minHeight = 0;
    return (dropEl.innerHTML = "");
  }

  const filteredWords = words
    .filter((word) => word.toLowerCase().includes(userInput))
    .sort()
    .splice(0, 5);

  dropEl.innerHTML = "";
  const link = document.createElement("a");
  link.textContent = "Ask anything and everything.";
  //Question not found? Ask your question now!

  filteredWords.forEach((item) => {
    const listEl = document.createElement("li");
    listEl.textContent = item;
    listEl.setAttribute("onclick", "sugSearchFunc('" + item + "')");
    if (item === userInput) {
      listEl.classList.add("match");
    }
    dropEl.appendChild(listEl);
    listEl.addEventListener("click", function () {
      formEl.value = listEl.textContent;
      dropEl.style.height = 0;
      dropEl.style.minHeight = 0;
    });
  });
  dropEl.appendChild(link);

  if (dropEl.children[0] === undefined) {
    return (dropEl.style.height = 0);
  }

  let totalChildrenHeight =
    dropEl.children[0].offsetHeight * filteredWords.length;
  dropEl.style.height = "fit-content";
  dropEl.style.minHeight = "70px";
};

formEl.addEventListener("input", formHandler);

function sugSearchFunc(e) {
  setCookie("askquestion", e, 30);
  location.href = "askquestion";
}
$(document).ready(function () {
  $("#search").focus();
  $("#search").on("keypress", function (e) {
    if (e.which == 13) {
      if ($("#search").val()) {
        setCookie("askquestion", $("#search").val(), 30);
        location.href = "askquestion";
      }
    }
  });
});
