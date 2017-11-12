const initialState = {
  placeData: {}
};

const place = (state = initialState, action) => {
  switch (action.type) {
    case "PLACE_DATA":
      return {
        ...state,
        placeData: action.placeData
      };
    default:
      return state;
  }
};

export default place;
