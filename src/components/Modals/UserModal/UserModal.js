import {
  Modal,
  Button,
  TextControl,
  TextareaControl,
  TabPanel,
} from "@wordpress/components";
import { useForm } from "react-hook-form";

const PersonalInfo = ({ register }) => {
  return (
    <div>
      <TextControl
        label="Nombre"
        {...register("first_name", { required: true })}
      />
      <TextControl label="Email" {...register("email", { required: true })} />
      <TextControl
        label="Teléfono"
        {...register("phone_number", { required: true })}
      />
      <TextControl
        label="Nombre de la EPS"
        {...register("eps", { required: true })}
      />
      <TextControl
        label="Talla de camiseta"
        {...register("shirt_size", { required: true })}
      />
      <TextControl
        label="Estado civil"
        {...register("marital_status", { required: true })}
      />
      <TextControl
        label="Fecha de nacimiento"
        {...register("birthdate", { required: true })}
      />
    </div>
  );
};

const ContactInfo = ({ register }) => {
  return (
    <div>
      <TextControl
        label="Nombre de contacto de emergencia 1"
        {...register("emergency_contact_name_1", { required: true })}
      />
      <TextControl
        label="Teléfono de contacto de emergencia 1"
        {...register("emergency_contact_phone_1", { required: true })}
      />
      <TextControl
        label="Parentesco de contacto de emergencia 1"
        {...register("emergency_contact_relationship_1", { required: true })}
      />
      <TextControl
        label="Nombre de contacto de emergencia 2"
        {...register("emergency_contact_name_2", { required: true })}
      />
      <TextControl
        label="Teléfono de contacto de emergencia 2"
        {...register("emergency_contact_phone_2", { required: true })}
      />
      <TextControl
        label="Parentesco de contacto de emergencia 2"
        {...register("emergency_contact_relationship_2", { required: true })}
      />
      <TextControl
        label="Nombre de la persona que paga"
        {...register("payment_by_name", { required: true })}
      />
      <TextControl
        label="Teléfono de la persona que paga"
        {...register("payment_by_phone", { required: true })}
      />
      <TextControl
        label="Nombre de la persona que invita"
        {...register("invited_by_name", { required: true })}
      />
      <TextControl
        label="Teléfono de la persona que invita"
        {...register("invited_by_phone", { required: true })}
      />
      <TextControl
        label="Parentesco de la persona que invita"
        {...register("invited_by_relationship", { required: true })}
      />
      <TextControl
        label="¿La persona que invita es servidor?"
        {...register("invited_contact_is_servant", { required: true })}
      />
    </div>
  );
};

const AdditionalInfo = ({ register }) => {
  return (
    <div>
      <TextareaControl
        label="¿Tiene alguna condición médica?"
        {...register("medical_condition", { required: true })}
      />
      <TextareaControl
        label="¿Tiene alguna dieta especial?"
        {...register("special_diet", { required: true })}
      />
      <TextareaControl
        label="Notas adicionales"
        {...register("additional_notes", { required: true })}
      />

      <TextControl
        label="Nombre de la EPS"
        {...register("eps", { required: true })}
      />
      <TextControl
        label="Nombre de la persona que paga"
        {...register("payment_by_name", { required: true })}
      />
      <TextControl
        label="Teléfono de la persona que paga"
        {...register("payment_by_phone", { required: true })}
      />
      <TextControl
        label="Nombre de la persona que invita"
        {...register("invited_by_name", { required: true })}
      />
      <TextControl
        label="Teléfono de la persona que invita"
        {...register("invited_by_phone", { required: true })}
      />
      <TextControl
        label="Parentesco de la persona que invita"
        {...register("invited_by_relationship", { required: true })}
      />
      <TextControl
        label="Nombre de contacto de emergencia 1"
        {...register("emergency_contact_name_1", { required: true })}
      />
      <TextControl
        label="Teléfono de contacto de emergencia 1"
        {...register("emergency_contact_phone_1", { required: true })}
      />
      <TextControl
        label="Parentesco de contacto de emergencia 1"
        {...register("emergency_contact_relationship_1", { required: true })}
      />
      <TextControl
        label="Nombre de contacto de emergencia 2"
        {...register("emergency_contact_name_2", { required: true })}
      />
      <TextControl
        label="Teléfono de contacto de emergencia 2"
        {...register("emergency_contact_phone_2", { required: true })}
      />
      <TextControl
        label="Parentesco de contacto de emergencia 2"
        {...register("emergency_contact_relationship_2", { required: true })}
      />
      <TextControl
        label="Nombre del retiro"
        {...register("retreat_name", { required: true })}
      />
      <TextControl
        label="Talla de camiseta"
        {...register("shirt_size", { required: true })}
      />
      <TextControl
        label="Estado civil"
        {...register("marital_status", { required: true })}
      />
      <TextControl
        label="Fecha de nacimiento"
        {...register("birthdate", { required: true })}
      />
      <TextareaControl
        label="¿Tiene alguna condición médica?"
        {...register("medical_condition", { required: true })}
      />
      <TextareaControl
        label="¿Tiene alguna dieta especial?"
        {...register("special_diet", { required: true })}
      />
      <TextControl
        label="¿La persona que invita es servidor?"
        {...register("invited_contact_is_servant", { required: true })}
      />
      <TextareaControl
        label="Notas adicionales"
        {...register("additional_notes", { required: true })}
      />
    </div>
  );
};

export const UserModal = ({ setModalOpen, data }) => {
  const {
    register,
    handleSubmit,
    watch,
    formState: { errors },
  } = useForm({
    defaultValues: data,
  });

  console.log({ data });

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
          className="my-tab-panel"
          activeClass="active-tab"
          tabs={[
            {
              name: "tab1",
              title: "Información Personal",
              className: "tab-one",
              content: <PersonalInfo register={register} />,
            },
            {
              name: "tab2",
              title: "Información de Contacto",
              className: "tab-two",
              content: <ContactInfo register={register} />,
            },
            {
              name: "tab3",
              title: "Información Adicional",
              className: "tab-three",
              content: <AdditionalInfo register={register} />,
            },
          ]}
        >
          {(tab) => <div className={tab.className}>{tab.content}</div>}
        </TabPanel>

        {/* <TextControl
          label="Nombre del retiro"
          {...register("retreat_name", { required: true })}
        /> */}

        <Button type="submit" variant="secondary">
          Guardar
        </Button>
      </form>
    </Modal>
  );
};
