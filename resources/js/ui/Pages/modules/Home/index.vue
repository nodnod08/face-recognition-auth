<template>
    <div>
        <v-container>
            <Header />
        </v-container>
    </div>
</template>

<script>
import { mapMutations } from "vuex"
import Header from "./../../../Layouts/header.vue"

export default {
    props: {
        user: {
            type: Object,
            required: true
        }
    },
    components: {
        Header
    },
    methods: {
        ...mapMutations("home", ["SET_USER_DETAILS"])
    },
    created() {
        this.SET_USER_DETAILS({
            user_fullname: `${this.user.first_name} ${this.user.last_name}`,
            user_initial: this.user.first_name[0],
            user_role: this.user.role.name
        })
    }
}
</script>

<style></style>
