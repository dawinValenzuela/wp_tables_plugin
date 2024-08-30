import { useState } from "@wordpress/element";
import { Modal, Button, TextControl } from "@wordpress/components";
import { TableActions } from "./components/Table";

const UserRowActions = ({ userData }) => {
  const [isModalOpen, setModalOpen] = useState(false);
  const [name, setName] = useState(userData.first_name);
  const [email, setEmail] = useState(userData.email);

  const handleSave = () => {
    // Aquí deberías manejar la lógica para guardar los cambios
    console.log("Saving user data...", { name, email });
    setModalOpen(false);
  };

  return (
    <>
      <Button variant="primary" onClick={() => setModalOpen(true)}>
        Editar
      </Button>
      {isModalOpen && (
        <Modal
          title="Editar Información del Usuario"
          onRequestClose={() => setModalOpen(false)}
        >
          <TextControl
            label="Nombre"
            value={name}
            onChange={(value) => setName(value)}
          />
          <TextControl
            label="Email"
            value={email}
            onChange={(value) => setEmail(value)}
          />
          {/* Agrega más campos según sea necesario */}
          <Button variant="secondary" onClick={handleSave}>
            Guardar
          </Button>
        </Modal>
      )}
    </>
  );
};

const UserTableBase = () => {
  return (
    <>
      <TableActions />
    </>
  );
};

// Renderizar el componente
const renderUserRowActions = () => {
  const userTableRows = document.querySelectorAll(".user-table-row");
  userTableRows.forEach((row) => {
    const walkerData = JSON.parse(row.getAttribute("data-walker"));
    // console.log(walkerData);

    const container = row.querySelector(".user-action-container");
    // wp.element.render(<UserRowActions userData={walkerData} />, container);
    wp.element.render(<UserTableBase />, container);
  });
};

document.addEventListener("DOMContentLoaded", renderUserRowActions);
