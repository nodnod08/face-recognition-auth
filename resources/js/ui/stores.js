import Vue from "vue"
import Vuex from "vuex"

//Modules
import * as home from "./Pages/modules/Home/assets/store"
import * as authSettings from "./Pages/modules/AuthSettings/assets/store"
//Reusable
import * as snackBar from "./Reusables/SnackBar/store"
import * as table from "./Reusables/Table/store"

Vue.use(Vuex)

const modules = {
    //modules
    home,
    authSettings,
    //reusable
    snackBar,
    table
}

export default new Vuex.Store({
    modules
})
