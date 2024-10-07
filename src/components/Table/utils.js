import { Button, ButtonGroup } from "@wordpress/components";

export const generateTableActions = (actions) => {
  // if actions is empty return null
  if (!actions?.length) {
    return null;
  }

  return (
    <ButtonGroup>
      {actions.map((action, index) => {
        const { onClick, label, ...rest } = action;
        return (
          <Button key={index} onClick={onClick} {...rest}>
            {label}
          </Button>
        );
      })}
    </ButtonGroup>
  );
};
