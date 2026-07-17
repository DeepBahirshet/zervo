import axios from "axios";

export default {
    index()
    {
        return axios.get(`/api/admin/requirements`);
    },

    approve(id)
    {
        return axios.patch(`/api/admin/requirements/${id}/approve`);
    },

    reject(id)
    {
        return axios.patch(`/api/admin/requirements/${id}/reject`);
    }
}