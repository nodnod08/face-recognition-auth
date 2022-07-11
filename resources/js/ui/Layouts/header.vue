<template>
    <div>
        <v-app-bar color="white" flat fixed height="100">
            <v-img :src="'./images/USER1.png'" max-width="200px" contain />

            <v-spacer></v-spacer>

            <template>
                <v-app-bar-nav-icon class="appbar-toggle" @click="drawer = true"></v-app-bar-nav-icon>
                <v-menu class="account-full-ui" nudge-bottom="50" left bottom :close-on-content-click="false">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn class="account-full-ui" fab small depressed color="purple deep-purple accent-2" v-bind="attrs" v-on="on">
                            <span class="white--text account-letter">{{ user.user_initial }}</span>
                        </v-btn>
                    </template>

                    <v-list dense>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-avatar color="grey darken-1" size="30">
                                    <span class="white--text">{{ user.user_initial }}</span>
                                </v-avatar>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>{{ user.user_fullname }}</v-list-item-title>
                                <v-list-item-subtitle>{{ user.user_role }}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item link href="/auth-settings" class="tile ml-3">
                            <v-list-item-icon class="semi-icon">
                                <v-icon size="20">mdi-face-recognition</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title class="semi-nav">Authentication Settings</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item link href="/logout" class="tile ml-3">
                            <v-list-item-icon class="semi-icon">
                                <v-icon size="20">mdi-logout</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title class="semi-nav">Logout</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </template>
        </v-app-bar>
        <v-navigation-drawer v-model="drawer" fixed temporary>
            <v-list-item class="logo-main-container">
                <v-list-item-content class="logo-semi-container">
                    <v-list-item-title class="title">
                        <v-img class="ml-3" :src="'./img/logo.png'" max-width="130px" contain />
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
            <v-list dense>
                <v-list-item class="ml-3">
                    <v-list-item-content>
                        <v-list-item-title>{{ user.user_fullname }}</v-list-item-title>
                        <v-list-item-subtitle>{{ user.user_role }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link href="/auth-settings" class="tile ml-3">
                    <v-list-item-icon class="semi-icon">
                        <v-icon size="20">mdi-face-recognition</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title class="semi-nav">Authentication Settings</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link href="/logout" class="tile ml-3">
                    <v-list-item-icon class="semi-icon">
                        <v-icon size="20">mdi-logout</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title class="semi-nav">Logout</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <v-divider></v-divider>
        </v-navigation-drawer>
    </div>
</template>

<script>
import { mapState } from "vuex"
export default {
    data: () => ({
        drawer: false,
        group: null,
        items: [
            {
                title: "Home",
                icon: "mdi-home",
                url: "#"
            },
            {
                title: "Reports",
                icon: "mdi-format-list-checks",
                url: "#"
            }
        ]
    }),
    computed: {
        ...mapState("home", ["user"])
    }
}
</script>

<style lang="scss" scoped>
.account-letter {
    font-weight: bold;
    font-size: 20px;
    font-family: "Roboto";
}

.appbar-toggle {
    display: none;
}

.account-full-ui {
    display: inline;
}

@media (max-width: 650px) {
    .appbar-toggle {
        display: inline;
    }

    .account-full-ui {
        display: none;
    }
}

.semi-icon {
    margin-right: 20px !important;
}
</style>
