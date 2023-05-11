// container.addEventListener("click", (e) => {
//   if (
//     e.target.classList.contains("seat") &&
//     !e.target.classList.contains("sold")
//   ) {
//     e.target.classList.toggle("selected");

//     updateSelectedCount();
//   }
// });

// Seat click event
const container = document.querySelector(".container-demo");
container.addEventListener("click", (e) => {
  if (
    e.target.classList.contains("slot") &&
    !e.target.classList.contains("occupied")
  ) {
    e.target.classList.toggle("selected");
  }
  if (
    e.target.classList.contains("r-slot") &&
    !e.target.classList.contains("occupied")
  ) {
    e.target.classList.toggle("selected");
  }
});