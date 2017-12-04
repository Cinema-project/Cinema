const initialStateUser = {
  user: {}
};

const session = (state = initialStateUser, action) => {
  switch (action.type) {
    case "LOGIN":
      return { user: action.data };
    default:
      return state;
  }
};

export default session;
