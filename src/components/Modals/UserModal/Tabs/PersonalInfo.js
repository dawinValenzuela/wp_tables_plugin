import { TextControl, __experimentalGrid as Grid } from "@wordpress/components";

export const PersonalInfo = ({ register }) => {
  return (
    <Grid gap={2} style={{ marginTop: "15px" }}>
      <TextControl
        label="Nombre"
        {...register("first_name", { required: true })}
      />
      <TextControl
        label="Nombre"
        {...register("last_name", { required: true })}
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
    </Grid>
  );
};
