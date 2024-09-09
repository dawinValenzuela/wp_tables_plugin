import { useState } from "@wordpress/element";
import { WalkersTableAction } from "./Actions";
import { UserModal } from "../../../components/Modals/UserModal/UserModal";

export const WalkersTable = ({ data }) => {
  const [isEditModalOpen, setIsEditModalOpen] = useState(false);
  return (
    <>
      <WalkersTableAction data={data} onEditClick={setIsEditModalOpen} />
      {isEditModalOpen && (
        <UserModal data={data} setModalOpen={setIsEditModalOpen} />
      )}
    </>
  );
};
