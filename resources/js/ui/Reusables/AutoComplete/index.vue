<template>
    <v-autocomplete v-bind="$attrs" validate-on-blur :multiple="multiple" v-model="select" :items="items" :loading="loading || isLoading" :hide-no-data="loading" hide-details="auto" :search-input.sync="search" :item-text="itemText" :item-value="itemValue" :messages="this.message" :clearable="!readonly" :label="label" :rules="rules" :dense="dense" outlined :readonly="readonly" @keypress="handleKeypress">
        <template v-slot:item="data">
            <v-list-item-content v-if="isNotObject(data.item)" v-text="data.item"></v-list-item-content>

            <template v-else>
                <v-list-item-content>
                    <v-list-item-title v-html="data.item[mainText]"></v-list-item-title>
                    <v-list-item-subtitle class="sub" v-html="data.item[subText]"></v-list-item-subtitle>
                </v-list-item-content>
            </template>
        </template>
        <template v-if="multiple" v-slot:selection="data">
            <v-chip class="mt-2 mb-2" outlined v-bind="data.attrs" :input-value="data.selected" close @click="data.select" @click:close="remove(data.item)">
                {{ data.item.name }}
            </v-chip>
        </template>
    </v-autocomplete>
</template>
<script>
import axios from "axios"

export default {
    name: "autocomplete-field",
    inheritAttrs: false,
    props: {
        value: {
            type: [Array, Object, Number, String]
        },
        message: String,
        label: {
            type: String,
            default: ""
        },
        dense: {
            type: Boolean,
            default: true
        },
        readonly: {
            type: Boolean,
            default: false
        },
        rules: {
            type: Array,
            default: () => []
        },
        suggestedData: {
            type: Array,
            default: () => []
        },
        urlSearch: {
            required: false,
            type: String,
            default: null
        },
        hasBackEnd: {
            required: false,
            type: Boolean,
            default: false
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
        },
        mainText: {
            required: false,
            type: String,
            default: "name"
        },
        subText: {
            required: false,
            type: String,
            default: "id"
        },
        isLoading: {
            required: false,
            type: Boolean,
            default: false
        },
        multiple: {
            required: false,
            type: Boolean,
            default: false
        },
        keyUniqueForMultiple: {
            required: false,
            type: String,
            default: "id"
        }
    },
    data() {
        return {
            // select: null,
            search: null,
            items: [],
            loading: false
        }
    },
    created() {
        this.preloading()
    },
    computed: {
        select: {
            set(value) {
                this.$emit("input", (this.multiple ? value.length : value) ? value : this.multiple ? [] : null)
            },
            get() {
                return this.value
            }
        }
    },
    watch: {
        search(query) {
            if (query == "" || (query && !this.select)) {
                this.querySearch()
            }
        },
        suggestedData(v) {
            this.items = v
        }
    },
    methods: {
        remove(data) {
            this.select = this.select.filter((ct) => ct[this.keyUniqueForMultiple] != data[this.keyUniqueForMultiple])
        },
        isNotObject(obj) {
            return typeof obj !== "object"
        },
        handleKeypress(e) {
            const code = e.key
            const REGEX_ALLOWED_CHARS = /^([a-zA-Z0-9\s]+)$/

            if (!REGEX_ALLOWED_CHARS.test(code) || e.altKey) {
                e.preventDefault()
            }
        },
        setValue(value) {
            if (!(this.multiple ? value.length : value)) {
                this.select = null
            } else {
                this.preloading()
            }
        },
        getItemByValue(value) {
            if (value) {
                let ref = this.items.find((item) => item[this.itemValue] == value[this.itemValue])
                if (ref) {
                    return ref
                }
            }

            return this.multiple ? [] : null
        },
        async querySearch() {
            this.loading = true

            try {
                const params = {
                    limit: "all",
                    q: this.search
                }
                if (this.hasBackEnd) {
                    const response = await this.apiQuery(params)
                    let data = response.data
                    for (let row of data) {
                        if (!this.items.some((item) => item[this.itemValue] === row[this.itemValue])) {
                            this.items.push(row)
                        }
                    }
                }
            } catch (error) {
                console.log(error)
            }

            this.loading = false
        },
        async preloading() {
            this.loading = true

            try {
                let type = typeof this.value

                if (this.value) {
                    const params = {
                        limit: "all",
                        q: type == "object" ? this.value[this.itemText] : this.value
                    }

                    this.items = this.suggestedData

                    this.select = this.getItemByValue(this.value)
                } else {
                    this.items = this.suggestedData
                }
            } catch (error) {
                console.log(error)
            }

            this.loading = false
        }
    }
}
</script>

<style lang="scss" scoped>
.sub {
    font-size: 12px !important;
    color: #1976d2 !important;
}
</style>
