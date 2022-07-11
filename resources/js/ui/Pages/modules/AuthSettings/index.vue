<template>
    <div>
        <v-container>
            <Header />
        </v-container>
        <div class="main">
            <div class="row">
                <div class="col-md-6">
                    <v-card min-height="50vh">
                        <v-toolbar flat color="deep-purple accent-2" dark>
                            <v-toolbar-title>SET AUTHENTICATION METHODS</v-toolbar-title>
                        </v-toolbar>
                        <v-tabs color="deep-purple accent-2">
                            <v-tab>
                                <v-icon left>mdi-lock</v-icon>
                                PASSWORD
                            </v-tab>
                            <v-tab>
                                <v-icon left>mdi-face-recognition</v-icon>
                                FACE RECOGNITION
                            </v-tab>
                            <v-tab>
                                <v-icon left>mdi-fingerprint</v-icon>
                                FINGER PRINT
                            </v-tab>
                            <v-tab-item>
                                <v-card flat>
                                    <v-card-text class="mt-10">
                                        <v-row>
                                            <v-col cols="12" lg="12" md="12" sm="12">
                                                <v-text-field color="deep-purple accent-2" label="Old Password" prepend-inner-icon="mdi-lock" :append-icon="isPasswordVisible ? 'mdi-eye' : 'mdi-eye-off'" @click:append="isPasswordVisible = !isPasswordVisible" :no-filter="true" outlined return-object :dense="true" hide-details="auto" :type="isPasswordVisible ? 'text' : 'password'" name="password" v-model="password" :rules="rules.password" />
                                            </v-col>
                                            <v-col cols="12" lg="12" md="12" sm="12">
                                                <v-text-field color="deep-purple accent-2" label="New Password" prepend-inner-icon="mdi-lock" :append-icon="isNewPasswordVisible ? 'mdi-eye' : 'mdi-eye-off'" @click:append="isNewPasswordVisible = !isNewPasswordVisible" :no-filter="true" outlined return-object :dense="true" hide-details="auto" :type="isNewPasswordVisible ? 'text' : 'password'" name="new_password" v-model="new_password" :rules="rules.password" />
                                            </v-col>
                                            <v-col cols="12" lg="12" md="12" sm="12">
                                                <v-text-field color="deep-purple accent-2" label="Confirm New Password" prepend-inner-icon="mdi-lock" :append-icon="isRePasswordVisible ? 'mdi-eye' : 'mdi-eye-off'" @click:append="isRePasswordVisible = !isRePasswordVisible" :no-filter="true" outlined return-object :dense="true" hide-details="auto" :type="isRePasswordVisible ? 'text' : 'password'" name="confirm_password" v-model="confirm_password" :rules="rules.password" />
                                            </v-col>
                                            <v-col cols="12" lg="12" md="12" sm="12">
                                                <v-btn color="deep-purple accent-2 white--text" block large type="button">UPDATE</v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                            <v-tab-item>
                                <v-card flat>
                                    <v-card-text class="d-flex justify-center flex-column align-center">
                                        <v-progress-linear color="deep-purple accent-1 white--text" height="20" v-if="base64s.length < 3" :value="base64s.length * 33">CAPTURE YOUR FACE 3 TIMES</v-progress-linear>
                                        <Camera @onShot="getShot" ref="capture" />

                                        <v-btn :loading="isLoading" v-if="base64s.length == 3" @click="saveFaceRecognition" color="success"><v-icon>mdi-check-circle</v-icon> SAVE IMAGE FOR FACE RECOGNITION METHOD</v-btn>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                            <v-tab-item>
                                <v-card flat>
                                    <v-card-text> </v-card-text>
                                </v-card>
                            </v-tab-item>
                        </v-tabs>
                    </v-card>
                </div>
                <div class="col-md-6">
                    <v-row>
                        <v-col v-for="(base64, i) in base64s" :key="i" cols="12" lg="4" md="6" sm="6" xs="12">
                            <v-card>
                                <v-img :src="base64" height="200" class="grey darken-4"></v-img>
                                <v-card-title>
                                    <v-spacer></v-spacer>
                                    <v-btn @click="remove(i)" icon color="red">
                                        <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                </v-card-title>
                            </v-card>
                        </v-col>
                    </v-row>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapMutations, mapActions } from "vuex"

import Header from "./../../../Layouts/header.vue"
import Camera from "./components/Camera"

export default {
    props: {
        user: {
            type: Object,
            required: true
        }
    },
    components: {
        Header,
        Camera
    },
    methods: {
        ...mapMutations("home", ["SET_USER_DETAILS"]),
        ...mapActions("authSettings", ["storeSaveFaceRecognition"]),
        getShot({ base64, file }) {
            this.faces.push(file)
            this.base64s.push(base64)
        },
        remove(i) {
            this.faces.splice(i, 1)
            this.base64s.splice(i, 1)
        },
        validateCount(data) {
            if (data.length >= 3) {
                this.$refs.capture.hideButton(true)
            } else {
                this.$refs.capture.hideButton(false)
            }
        },
        async saveFaceRecognition() {
            this.isLoading = true

            const data = {
                faces: this.base64s
            }

            const result = await this.storeSaveFaceRecognition(data)

            this.isLoading = false
        }
    },
    data: () => ({
        //passwords
        isPasswordVisible: false,
        isNewPasswordVisible: false,
        isRePasswordVisible: false,
        password: "",
        new_password: "",
        confirm_password: "",
        //faces
        faces: [],
        base64s: [],
        //static
        rules: {
            password: [(v) => v.length >= 3 || "Password must contain atleast 3 characters"]
        },
        isLoading: false
    }),
    created() {
        this.SET_USER_DETAILS({
            user_fullname: `${this.user.first_name} ${this.user.last_name}`,
            user_initial: this.user.first_name[0],
            user_role: this.user.role.name
        })
    },
    watch: {
        base64s(v) {
            this.validateCount(v)
        }
    }
}
</script>

<style></style>
