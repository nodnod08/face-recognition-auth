<template>
    <v-combobox
        v-bind:style="{
            position: 'static'
        }"
        v-bind="$attrs"
        v-model="val"
        v-on="inputListeners"
        hide-details="auto"
        dense
        outlined
        clearable
        @keydown="setValue"
        @change="setValue1"
        @keyup="setValue2"
        :items="items"
        :item-text="itemText"
        :item-value="itemValue"
        @click:clear="items = suggestedData"
    ></v-combobox>
</template>

<script>
export default {
    inheritAttrs: false,
    name: "combo-box",
    props: {
        value: {
            required: true
        },
        suggestedData: {
            required: true,
            type: [Array]
        },
        itemText: {
            required: false,
            type: String,
            default: "name"
        },
        itemValue: {
            required: false,
            type: String,
            default: "id"
        }
    },
    computed: {
        inputListeners: function () {
            return Object.assign({}, this.$listeners)
        },
        val: {
            get() {
                return this.value
            },
            set(value) {
                this.$emit("input", value)
            }
        }
    },
    data: () => ({
        items: []
    }),
    watch: {
        suggestedData(v) {
            this.items = v
        }
    },
    methods: {
        setValue(event) {
            this.val = event.target.value
        },
        setValue1(event) {
            this.val = event
        },
        setValue2(event) {
            let input = event.target.value
            this.onSearch(input)
            this.val = input
        },
        onSearch(input) {
            this.items = this.suggestedData.filter((obj) => obj[this.itemText].toLowerCase().includes(input))
        }
    },
    created() {
        this.items = this.suggestedData
    }
}
</script>

<style></style>
