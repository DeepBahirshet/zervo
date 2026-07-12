import api from "./api";

export default {
    apply(requirementId, data){
       return api.post(`/requirements/${requirementId}/apply`, data)
    },
}