<template>
    <div>
        <v-content>
            <v-card class="site-bg d-flex align-center justify-center" min-height="calc(100vh - 130px)" elevation="0">
                <v-card class="login-form" elevation="0">
                    <v-card class="d-flex justify-center" elevation="0">
                        <v-img class="mx-0 mb-5" :src="'./images/USER1.png'" max-width="230px" contain />
                    </v-card>

                    <v-form method="POST" ref="loginForm" @submit.prevent="handleSubmit">
                        <v-container class="py-0">
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field color="deep-purple accent-2" label="Username" prepend-inner-icon="mdi-account-outline" :no-filter="true" outlined return-object clearable :dense="true" hide-details="auto" name="username" autofocus v-model="username" :rules="rules.username" />
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field color="deep-purple accent-2" label="Password" prepend-inner-icon="mdi-lock" :append-icon="isPasswordVisible ? 'mdi-eye' : 'mdi-eye-off'" @click:append="isPasswordVisible = !isPasswordVisible" :no-filter="true" outlined return-object :dense="true" hide-details="auto" :type="isPasswordVisible ? 'text' : 'password'" name="password" v-model="password" :rules="rules.password" />
                                </v-col>

                                <input type="hidden" name="_token" :value="csrf" />

                                <v-col cols="6" class="py-0">
                                    <v-card-text class="text-right primary--text form-g">
                                        <v-checkbox v-model="checkbox" hide-details="auto" name="remember" :value="checkbox">
                                            <template v-slot:label>
                                                <div class="login-txt">KEEP ME SIGNED IN</div>
                                            </template>
                                        </v-checkbox>
                                    </v-card-text>
                                </v-col>

                                <v-col cols="12">
                                    <v-btn color="deep-purple accent-2 white--text" block large type="submit" :disabled="isLoading">LOG IN</v-btn>

                                    <v-alert type="error" outlined class="mt-3" v-if="isError"> {{ errorMessage }} </v-alert>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                </v-card>
            </v-card>
        </v-content>
        <Footer />
    </div>
</template>

<script>
import Footer from "./footer"
import axios from "axios"

export default {
    name: "SiteLayout",
    components: {
        Footer
    },
    data: () => ({
        isPasswordVisible: false,
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        username: "",
        checkbox: false,
        password: "",
        rules: {
            username: [(v) => !!v || "Username is required"],
            password: [(v) => v.length >= 3 || "Password must contain atleast 3 characters"]
        },
        isError: false,
        isLoading: false,
        errorMessage: ""
    }),
    methods: {
        async handleSubmit() {
            const isLoginValid = this.$refs.loginForm.validate()
            if (isLoginValid) {
                //This is to validate user exists
                const result = await this.verifyUser()

                //Traditional way to submit a form.
                if (result.success) {
                    window.location.replace("/")
                }
            }
        },
        async verifyUser() {
            this.isError = false
            this.isLoading = true
            this.errorMessage = ""

            const data = {
                username: this.username,
                password: this.password,
                remember: this.checkbox
            }

            const response = await axios.post("/api/user/attempt", data)
            const result = response.data

            this.isLoading = false
            this.isError = !response.data.success
            this.errorMessage = response.data.message

            if (this.isError) {
                setTimeout(() => {
                    this.isError = false
                    this.errorMessage = ""
                }, 3000)
            }

            return result
        }
    }
}
</script>

<style lang="scss" scoped>
.login-card-title {
    margin-bottom: 3%;
    font-weight: 400;
    font-size: 25px;
}

.login-form {
    width: 500px;
    min-width: 500px;
    background: transparent;

    @media (max-width: 499px) {
        width: 100%;
        min-width: 100%;
    }
}
.registration-text {
    cursor: pointer;
}

.v-input--selection-controls {
    margin-top: 0;
    margin-bottom: 0;
    padding: 0;
}

.form-g {
    padding: 10px 0;
    @media (max-width: 499px) {
        padding: 0;
    }
}

.login-txt {
    font-weight: bold;
    font-size: 11px;
}

.link-txt {
    text-decoration: none;
}

.site-bg {
    background-size: 100%;
    background-repeat: no-repeat;
    background-position: center 93%;
}
</style>
