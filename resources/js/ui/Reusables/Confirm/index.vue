<template>
    <v-dialog v-model="isVisible" width="400" transition="dialog-bottom-transition" persistent>
        <v-card class="modal">
            <slot name="header">
                <v-card-title class="mb-4">{{ title }}</v-card-title>
            </slot>

            <v-card-text>
                <slot name="content">
                    <span v-html="content"></span>
                </slot>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn text color="info" @click="handleResult(true)">Confirm</v-btn>
                <v-btn text @click="handleResult(false)">Cancel</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "confirm-box",
    props: {
        title: {
            type: String,
            default: "Confirm"
        },

        content: String,

        visible: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        isVisible: {
            get() {
                return this.visible
            },
            set(value) {
                if (!value) {
                    this.$emit("update:visible", false)
                }
            }
        }
    },
    methods: {
        handleResult(result) {
            this.$emit("result", result)
            this.isVisible = false
        }
    }
}
</script>

<style></style>
