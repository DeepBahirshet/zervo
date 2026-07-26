import api from "./api"


export default {

    store(id, data)
    {
        return api.post(`/requirements/${id}/review`, data);
    }
}