<template>
    <v-footer fixed bottom color="white">
        <v-row>
            <v-col class="pa-4 text-left black--text footer-txt" cols="12" sm="4">
                POWERED BY
                <span class="blue--text font-weight-medium">COMPANY</span>
            </v-col>

            <v-col class="pa-4 text-center black--text footer-txt" cols="12" sm="4"> ALL RIGHTS RESERVED {{ new Date().getFullYear() }} </v-col>

            <v-col class="pa-4 text-right black--text footer-txt" cols="12" sm="4"> PRIVACY & POLICY </v-col>
        </v-row>
    </v-footer>
</template>

<script>
export default {
    name: "Footer"
}
</script>

<style lang="scss" scoped>
.footer-txt {
    font-size: 14px;
}
.footer-txt {
    @media (max-width: 599px) {
        font-size: 12px;
        text-align: center !important;
        color: #000;
    }
}
</style>
