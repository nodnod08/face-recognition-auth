<template>
    <v-select v-bind="$attrs" v-model="val" hide-details="auto" :item-text="itemText" :item-value="itemValue" dense outlined> </v-select>
</template>

<script>
export default {
    inheritAttrs: false,
    name: "u-select",
    props: {
        value: {
            required: true
        },
        itemText: {
            required: false,
            type: String,
            default: "text"
        },
        itemValue: {
            required: false,
            type: String,
            default: "id"
        }
    },
    computed: {
        val: {
            get() {
                return this.value
            },
            set(value) {
                this.$emit("input", value)
            }
        }
    }
}
</script>

<style></style>
