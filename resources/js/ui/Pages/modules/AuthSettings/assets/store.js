import * as SERVICE from "./services"

export const namespaced = true

export const state = {
    user: {
        user_initial: "",
        user_fullname: "",
        user_role: ""
    }
}

export const getters = {}

export const actions = {
    async storeSaveFaceRecognition({ commit, rootState, dispatch, state }, data) {
        try {
            const response = await SERVICE.saveFaceRecognition(data)
            if (response.data.success) {
                let notification = {
                    type: "success",
                    text: response.data.message,
                    isVisible: true
                }
                dispatch("snackBar/add", notification, { root: true })
                return true
            }
            throw { message: response.data.message }
        } catch (error) {
            let notification = {
                type: "error",
                text: error.message,
                isVisible: true
            }
            dispatch("snackBar/add", notification, { root: true })
            return false
        }
    }
}

export const mutations = {}
