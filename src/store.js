import { createStore, combineReducers } from "redux";
import persistState from "redux-localstorage";
import place from "./MainPage/reducer";
import session from "./session/reducer";

const rootReducer = combineReducers({
  place: place,
  session: session
});

const enhancer = persistState(rootReducer.place);

const store = createStore(rootReducer, {}, enhancer);

export { store };
