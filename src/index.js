import { useState } from "@wordpress/element";
import { Modal, Button, TextControl } from "@wordpress/components";

const UserRowActions = ({ userData }) => {
  const [isModalOpen, setModalOpen] = useState(false);
  const [name, setName] = useState(userData.name);
  const [email, setEmail] = useState(userData.email);

  const handleSave = () => {
    // Aquí deberías manejar la lógica para guardar los cambios
    console.log("Saving user data...", { name, email });
    setModalOpen(false);
  };

  return (
    <>
      <Button isPrimary onClick={() => setModalOpen(true)}>
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
          <Button isPrimary onClick={handleSave}>
            Guardar
          </Button>
        </Modal>
      )}
    </>
  );
};

// Renderizar el componente
const renderUserRowActions = () => {
  const userTableRows = document.querySelectorAll(".user-table-row");
  userTableRows.forEach((row) => {
    const userData = {
      name: row.dataset.name,
      email: row.dataset.email,
      // Añade más datos del usuario si es necesario
    };
    const container = row.querySelector(".user-action-container");
    wp.element.render(<UserRowActions userData={userData} />, container);
  });
};

document.addEventListener("DOMContentLoaded", renderUserRowActions);
