import axios from "axios";
import { URL_BASE } from "./constants";

export default axios.create({
    baseURL: URL_BASE,
});
