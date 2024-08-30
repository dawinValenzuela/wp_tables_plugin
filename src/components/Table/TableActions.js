import { generateTableActions } from "./utils";

export const TableActions = () => {
  const actions = [
    {
      label: "Editar",
      onClick: () => console.log("Edit user"),
      variant: "primary",
      size: "small",
    },
    {
      label: "Eliminar",
      onClick: () => console.log("Delete user"),
      variant: "secondary",
      size: "small",
    },
  ];

  return generateTableActions(actions);
};
