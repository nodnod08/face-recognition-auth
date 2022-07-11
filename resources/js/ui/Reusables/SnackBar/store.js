export const namespaced = true

export const state = {
    snackbar: {
        timeout: 4500,
        isVisible: false,
        text: "",
        type: "success",
        color: "success"
    }
}
export const mutations = {
    SET_SNACKBAR(state, payload) {
        state.snackbar = {
            ...state.snackbar,
            ...payload
        }
    }
}
export const getters = {
    getSnackbar: (state) => {
        return state.snackbar
    },
    getVisibility: (state) => state.snackbar.isVisible
}

export const actions = {
    add({ commit }, payload) {
        commit("SET_SNACKBAR", payload)
    }
}
