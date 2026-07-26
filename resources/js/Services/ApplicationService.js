import api from "./api";

export default {

    index(){
        return api.get('/applications');
    },

    apply(requirementId, data){
       return api.post(`/requirements/${requirementId}/apply`, data)
    },
    
     accept(applicationId) {
        return api.patch(`/applications/${applicationId}/accept`);
    },

    reject(applicationId) {
        return api.patch(`/applications/${applicationId}/reject`);
    }
}