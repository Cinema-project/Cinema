import axios from "axios";

const apiClient = axios.create({
  baseURL: "http://localhost:80/Cinema/", //http://localhost:80/Cinema/
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json"
  }
});

export default apiClient;
