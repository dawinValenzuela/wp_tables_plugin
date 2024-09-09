import { generateTableActions } from "../../../components/Table";

export const WalkersTableAction = ({ onEditClick, onDeleteClick }) => {
  const actions = [
    {
      label: "Editar",
      onClick: onEditClick,
      variant: "primary",
      size: "small",
    },
    {
      label: "Eliminar",
      onClick: onDeleteClick,
      variant: "secondary",
      size: "small",
    },
  ];

  return <div>{generateTableActions(actions)}</div>;
};
