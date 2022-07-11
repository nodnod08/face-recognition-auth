import axios from "axios"

export const saveFaceRecognition = (data) => {
    return axios.post("/api/user/save-face-recognition", data)
}
