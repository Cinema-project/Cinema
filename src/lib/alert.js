import { toast } from "react-toastify";
import style from "./styleToast.css";

const callToast = message => {
  toast.dismiss();
  toast(message, options);
};

const options = {
  autoClose: 3000,
  hideProgressBar: true,
  position: toast.POSITION.TOP_CENTER
};

export { callToast };
