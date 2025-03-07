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

const renderServersRowActions = () => {
  const serverTableRows = document.querySelectorAll(".server-table-row");
  serverTableRows.forEach((row) => {
    const serverData = JSON.parse(row.getAttribute("data-server"));

    const container = row.querySelector(".server-action-container");
    // wp.element.render(<UserRowActions userData={serverData} />, container);
    wp.element.render(<WalkersTable data={serverData} />, container);
  });
};

document.addEventListener("DOMContentLoaded", () => {
  renderUserRowActions();
});
