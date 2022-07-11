<template>
    <v-text-field outlined dense hide-details="auto" v-model="val" v-bind="$attrs" @keypress="keypress" @blur="blur">
        <template #append>
            <slot name="append" />
        </template>

        <template #prepend>
            <slot name="prepend" />
        </template>
    </v-text-field>
</template>

<script>
export default {
    name: "text-field",
    inheritAttrs: false,
    props: {
        value: {
            required: true
        }
    },
    computed: {
        val: {
            get() {
                return this.value
            },
            set(newValue) {
                this.$emit("input", newValue || "")
            }
        }
    },
    methods: {
        keypress(e) {
            this.$emit("keypress", e)
        },
        blur(e) {
            this.$emit("blur", e)
        }
    }
}
</script>
