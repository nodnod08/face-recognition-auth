import moment from "moment"
import Vue from "vue"

//Plugin
import vuetify from "./ui/plugins/vuetify"

//Vuex
import store from "./ui/stores"

//Pages
import loginPage from "./ui/Pages/modules/Login"
import indexPage from "./ui/Pages/modules/Home"
import authSettingsPage from "./ui/Pages/modules/AuthSettings"

//Modules
import snackBar from "./ui/Reusables/SnackBar"

Vue.filter("emptyFormatter", (data) => {
    if (data && data != "" && data != "null" && data != null && data.length != 0 && data != 0) return data
    return "-"
})

Vue.filter("numWithCommas", (num) => num && num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))

Vue.prototype.$eventHub = new Vue()

const app = new Vue({
    el: "#app",
    vuetify,
    store,
    components: {
        loginPage,
        indexPage,
        authSettingsPage,
        //modules
        snackBar
    }
})
