import { Modal, Button, TabPanel } from "@wordpress/components";
import { useForm } from "react-hook-form";
import { PersonalInfo, AdditionalInfo, ContactInfo } from "./Tabs";

export const UserModal = ({ setModalOpen, data }) => {
  const {
    register,
    handleSubmit,
    watch,
    formState: { errors },
  } = useForm({
    defaultValues: data,
  });

  const onSubmit = () => {
    // Aquí deberías manejar la lógica para guardar los cambios
    console.log("Saving user data...");
    setModalOpen(false);
  };

  return (
    <Modal
      title="Editar Información del Usuario"
      onRequestClose={() => setModalOpen(false)}
      size="large"
    >
      <form onSubmit={handleSubmit(onSubmit)}>
        <TabPanel
          tabs={[
            {
              name: "tab1",
              title: "Información Personal",
              content: <PersonalInfo register={register} />,
            },
            {
              name: "tab2",
              title: "Información de Contacto",
              content: <ContactInfo register={register} />,
            },
            {
              name: "tab3",
              title: "Información Adicional",
              content: <AdditionalInfo register={register} />,
            },
          ]}
        >
          {(tab) => <div className={tab.className}>{tab.content}</div>}
        </TabPanel>
        <Button type="submit" variant="secondary">
          Guardar
        </Button>
      </form>
    </Modal>
  );
};
