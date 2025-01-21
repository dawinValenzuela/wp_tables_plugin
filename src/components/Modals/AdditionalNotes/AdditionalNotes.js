import { Modal, Button } from "@wordpress/components";
import { TextareaControl } from "@wordpress/components";
import { set, useForm } from "react-hook-form";
import apiFetch from "@wordpress/api-fetch";

export const AdditionalNotes = ({ setModalOpen, data }) => {
  const {
    register,
    handleSubmit,
    watch,
    formState: { errors },
  } = useForm({
    defaultValues: {
      additional_info: data.additional_info,
    },
  });

  const onSubmit = (formData) => {
    const payload = {
      walker_id: data.id,
      additional_info: formData.additional_info,
    };

    let urlPath = "";

    if (data.table === "walkers") {
      urlPath = "/wp-json/wp-easy-tables/v1/update-walker-additional-info";
    } else if (data.table === "servers") {
      urlPath = "/wp-json/wp-easy-tables/v1/update-server-additional-info";
    }

    apiFetch({
      path: urlPath,
      method: "POST",
      headers: {
        "X-WP-Nonce": window.wpApiSettings.nonce,
      },
      data: payload,
    })
      .then((response) => {
        setModalOpen(false);
        alert("Notas adicionales guardadas correctamente.");
        window.location.reload();
      })
      .catch((error) => {
        alert("Ocurrió un error al guardar las notas adicionales.");
      });
  };

  return (
    <Modal
      title="Nota Adicional"
      onRequestClose={() => setModalOpen(false)}
      size="large"
    >
      <form onSubmit={handleSubmit(onSubmit)}>
        <TextareaControl
          label="Notas adicionales"
          {...register("additional_info")}
        />
        <Button type="submit" variant="secondary">
          Guardar
        </Button>
      </form>
    </Modal>
  );
};
