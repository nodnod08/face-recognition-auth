export const namespaced = true

export const state = {
    user: {
        user_initial: "",
        user_fullname: "",
        user_role: ""
    }
}

export const getters = {}

export const actions = {}

export const mutations = {
    SET_USER_DETAILS(state, payload) {
        const { user_initial, user_fullname, user_role } = payload

        state.user.user_initial = user_initial
        state.user.user_fullname = user_fullname
        state.user.user_role = user_role
    }
}
