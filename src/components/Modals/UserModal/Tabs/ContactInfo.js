import { TextControl, __experimentalGrid as Grid } from "@wordpress/components";

export const ContactInfo = ({ register }) => {
  return (
    <Grid gap={2} style={{ marginTop: "15px" }}>
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
    </Grid>
  );
};
