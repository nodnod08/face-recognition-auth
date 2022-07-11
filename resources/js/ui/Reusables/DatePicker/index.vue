<template>
    <v-dialog v-model="menu" max-width="300px">
        <template v-slot:activator="{ on }">
            <v-text-field v-model="formatDisplayDate" outlined readonly v-on="on" hide-details="auto" dense v-bind="$attrs">
                <template #append-outer>
                    <slot name="append-outer" />
                </template>
            </v-text-field>
        </template>

        <v-date-picker v-model="date" :range="range" @input="handleDatepickerClose" :max="maxDate" />
    </v-dialog>
</template>

<script>
import moment from "moment"

export default {
    name: "datepicker-field",

    inheritAttrs: false,

    props: {
        value: {
            type: [String, Array],
            required: true
        },
        displayFormat: {
            type: String,
            default: "MMM DD, YYYY"
        },
        range: {
            type: Boolean,
            default: false
        },
        maxDate: {
            type: String,
            default: undefined
        }
    },

    data: () => ({
        menu: false
    }),

    computed: {
        date: {
            get() {
                return this.value
            },
            set(date) {
                if (this.range) {
                    date.sort((a, b) => new Date(a) - new Date(b))
                }

                this.$emit("input", date)
            }
        },

        formatDisplayDate: {
            get() {
                if (this.value) {
                    if (typeof this.value === "object") {
                        const range = this.value.map((value) => this.transformToReadableDate(value))

                        return range.join("-")
                    }

                    return this.transformToReadableDate(this.value)
                }

                return ""
            },
            set(date) {
                if (this.range) {
                    this.$emit("input", date || [])
                } else {
                    this.$emit("input", date || "")
                }
            }
        }
    },
    methods: {
        transformToReadableDate(rawDate) {
            const initial = new Date(rawDate)

            return moment(initial).format(this.displayFormat)
        },
        handleDatepickerClose() {
            if (this.range) {
                this.$nextTick(() => {
                    const len = this.value.length
                    if (len > 1) {
                        this.menu = false
                    }
                })
            } else {
                this.menu = false
            }
        }
    }
}
</script>
