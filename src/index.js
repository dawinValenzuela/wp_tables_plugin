import { WalkersTable } from "./pages/walkers/WalkersTable";
import { ServersTable } from "./pages/servers/ServersTable";

// Renderizar el componente
const renderUserRowActions = () => {
  const userTableRows = document.querySelectorAll(".user-table-row");
  userTableRows.forEach((row) => {
    const walkerData = JSON.parse(row.getAttribute("data-walker"));

    const container = row.querySelector(".user-action-container");
    wp.element.render(<WalkersTable data={walkerData} />, container);
  });
};

const renderServersRowActions = () => {
  const serverTableRows = document.querySelectorAll(".servers-table-row");
  serverTableRows.forEach((row) => {
    const serverData = JSON.parse(row.getAttribute("data-servers"));

    const container = row.querySelector(".servers-action-container");
    wp.element.render(<ServersTable data={serverData} />, container);
  });
};

document.addEventListener("DOMContentLoaded", () => {
  renderUserRowActions();
  renderServersRowActions();
});
