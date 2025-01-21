import { WalkersTable } from "./pages/Walkers/WalkersTable";

// Renderizar el componente
const renderUserRowActions = () => {
  const userTableRows = document.querySelectorAll(".user-table-row");
  userTableRows.forEach((row) => {
    const walkerData = JSON.parse(row.getAttribute("data-walker"));

    const container = row.querySelector(".user-action-container");
    // wp.element.render(<UserRowActions userData={walkerData} />, container);
    wp.element.render(<WalkersTable data={walkerData} />, container);
  });
};

document.addEventListener("DOMContentLoaded", () => {
  renderUserRowActions();
});
