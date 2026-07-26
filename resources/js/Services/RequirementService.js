import api from "./api";

export default {
    index(status = 'pending')
    {
        return api.get(`/admin/requirements`, {
            params: {
                status,
            }
        });
    },

    approve(id)
    {
        return api.patch(`/admin/requirements/${id}/approve`);
    },

    reject(id)
    {
        return api.patch(`/admin/requirements/${id}/reject`);
    },

    complete(id)
    {
        return api.post(`/requirements/${id}/complete`);
    }
}