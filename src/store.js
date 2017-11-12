import { createStore, combineReducers } from "redux";
import persistState from "redux-localstorage";
import place from "./MainPage/reducer";

const rootReducer = combineReducers({
  place: place
});

const enhancer = persistState(rootReducer.place);

const store = createStore(rootReducer, {}, enhancer);

export { store };
