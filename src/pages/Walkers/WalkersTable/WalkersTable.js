import { useState } from "@wordpress/element";
import { WalkersTableAction } from "./Actions";
import { UserModal } from "../../../components/Modals/UserModal/UserModal";
import { AdditionalNotes } from "../../../components/Modals/AdditionalNotes";

export const WalkersTable = ({ data }) => {
  const [isEditModalOpen, setIsEditModalOpen] = useState(false);
  const [isNotesModalOpen, setIsNotesModalOpen] = useState(false);

  const handleEditClick = () => {
    setIsEditModalOpen(!isEditModalOpen);
  };

  const handleNotesClick = () => {
    setIsNotesModalOpen(!isNotesModalOpen);
  };

  return (
    <>
      <WalkersTableAction
        data={data}
        onEditClick={handleEditClick}
        onNotesClick={handleNotesClick}
      />
      {isEditModalOpen && (
        <UserModal data={data} setModalOpen={setIsEditModalOpen} />
      )}
      {isNotesModalOpen && (
        <AdditionalNotes data={data} setModalOpen={setIsNotesModalOpen} />
      )}
    </>
  );
};
