<template>
    <v-dialog v-model="menu" max-width="290px">
        <template v-slot:activator="{ on }">
            <v-text-field v-model="formatted" outlined readonly v-on="on" hide-details="auto" dense v-bind="$attrs">
                <template #append-outer>
                    <slot name="append-outer" />
                </template>
            </v-text-field>
        </template>

        <v-time-picker v-model="time" ampm-in-title></v-time-picker>
    </v-dialog>
</template>

<script>
import moment from "moment"
export default {
    name: "timepicker-field",

    inheritAttrs: false,

    props: {
        value: {
            required: true
        }
    },

    data: () => ({
        menu: false
    }),
    watch: {
        menu(v) {
            if (v) {
                let now = moment().format("HH:mm:ss")

                if (!this.time) this.time = now
            }
        }
    },
    computed: {
        time: {
            get() {
                return this.value
            },
            set(time) {
                let v = time
                let temp = new Date()
                let t = moment(temp).format("YYYY-MM-DD")
                let s = moment(temp).format("ss")

                if (moment(t).isValid() && time) {
                    v = moment(`${t} ${time}:${s}`).format("HH:mm:ss")
                } else {
                    v = null
                }

                this.$emit("input", v)
            }
        },
        formatted: {
            get() {
                let temp = new Date()
                let t = moment(temp).format("YYYY-MM-DD")
                let s = moment(temp).format("ss")

                if (moment(t).isValid() && this.time) return moment(`${t} ${this.time}:${s}`).format("hh:mm A")

                return this.time
            },
            set(v) {
                let v1 = v
                let temp = new Date()
                let t = moment(temp).format("YYYY-MM-DD")
                let s = moment(temp).format("ss")

                if (moment(t).isValid() && v) {
                    v1 = moment(`${t} ${v}:${s}`).format("HH:mm:ss")
                } else {
                    v1 = null
                }

                this.$emit("input", v1)
            }
        }
    }
}
</script>
