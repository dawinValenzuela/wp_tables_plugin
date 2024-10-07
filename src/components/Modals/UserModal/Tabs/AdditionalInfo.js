import {
  TextareaControl,
  __experimentalGrid as Grid,
} from "@wordpress/components";

export const AdditionalInfo = ({ register }) => {
  return (
    <Grid gap={2} style={{ marginTop: "15px" }}>
      <TextareaControl
        label="¿Tiene alguna condición médica?"
        {...register("medical_condition")}
      />
      <TextareaControl
        label="¿Tiene alguna dieta especial?"
        {...register("special_diet")}
      />
      <TextareaControl
        label="Notas adicionales"
        {...register("additional_notes")}
      />
    </Grid>
  );
};
