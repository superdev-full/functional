const words = [
  "Develop a crisis management plan for a global company facing a reputational threat.",
  "Create a research proposal on the effectiveness of nurse-led interventions.",
  "Write an essay on the ethical considerations of using predictive policing.",
  "Conduct a meta-analysis on psychological treatments for depression.",
  "React/Next.js site doesn't load properly in Safari (blank page)?",
  "Design an experiment to study the effects of climate change on plant physiology.",
  "Develop a prototype for a sustainable energy system for a remote community.",
  "Develop a financial model to evaluate an investment in a complex derivative product. ",
  "Write an essay on cultural relativism and moral relativism.",
  "Develop a marketing strategy for a new product launch in a competitive market.",
  "Conduct a feasibility study on the implementation of a telecommuting program for a large organization.",
  "Write a white paper on the potential impact of artificial intelligence on the job market.",
  "Design a program evaluation to assess the effectiveness of a community-based health promotion initiative.",
  "Develop a social media crisis management plan for a small business.",
  "Write an essay on the ethical implications of genetic engineering.",
  "Conduct a needs assessment for a new mental health program in a rural community.",
  "Design a survey to measure customer satisfaction with a product or service.",
  "Develop a training program to improve workplace diversity and inclusion.",
  "Write a policy brief on the impact of immigration policies on the economy.",
  "Conduct a cost-benefit analysis of a renewable energy project.",
  "Develop a business plan for a new startup in a niche market.",
  "Write an essay on the ethical considerations of using drones for military purposes.",
  "Conduct a usability study to evaluate the user experience of a new mobile app.",
  "Design an experiment to test the effectiveness of a new drug therapy for a specific medical condition.",
  "Develop a disaster preparedness plan for a coastal community vulnerable to hurricanes.",
  "Write a research paper on the impact of social media on mental health.",
  "Conduct a market analysis to identify new opportunities for a mature business.",
  "Design a program evaluation to assess the effectiveness of a community policing initiative.",
  "Develop a crisis communication plan for a healthcare organization in the event of a major public health emergency."  
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
  link.textContent = "We can help you with anything.";
  //Assignment not found? Submit your assignment now!

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
  setCookie("submitassignment", e, 30);
  location.href = "submitassignment";
}
$(document).ready(function () {
  $("#search").focus();
  $("#search").on("keypress", function (e) {
    if (e.which == 13) {
      if ($("#search").val()) {
        setCookie("submitassignment", $("#search").val(), 30);
        location.href = "submitassignment";
      }
    }
  });
});
