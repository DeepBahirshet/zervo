import api from "./api";

export default {
    apply(requirementId, data){
       return api.post(`/requirements/${requirementId}/apply`, data)
    },
    
     accept(applicationId) {
        return axios.patch(`/api/applications/${applicationId}/accept`);
    },

    reject(applicationId) {
        return axios.patch(`/api/applications/${applicationId}/reject`);
    }
}