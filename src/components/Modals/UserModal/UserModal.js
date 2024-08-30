import { Modal, Button, TextControl } from "@wordpress/components";

export const UserModal = () => {
  return (
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
  );
};
