import api from "./api";

export default {
    uploadImage(file) {
        const formData = new FormData();

        formData.append("profile_image", file);

        return api.post("/profile/photo", formData, {
            headers: {
                'Content-Type': "multipart/form-data"
            }
        });
    },
};