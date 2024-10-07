import { generateTableActions } from "../../../components/Table";

export const WalkersTableAction = ({ onEditClick, onNotesClick }) => {
  const actions = [
    {
      label: "Ver",
      onClick: onEditClick,
      variant: "primary",
      size: "small",
    },
    {
      label: "Notas",
      onClick: onNotesClick,
      variant: "secondary",
      size: "small",
    },
  ];

  return <div>{generateTableActions(actions)}</div>;
};
