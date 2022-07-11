<template>
    <v-dialog v-model="dialog" width="800" transition="dialog-bottom-transition" content-class="dialog-content-class">
        <template v-slot:activator="{ on, attrs }">
            <span v-if="link">
                <a :href="url" target="_blank" style="text-decoration: none">
                    {{ transformedContent }}
                </a>
            </span>

            <span v-else>{{ transformedContent | emptyFormatter }}</span>

            <small v-if="contentLocal.length > 20" class="see-more" :class="{ 'purple--text text--darken-3': link }" v-bind="attrs" v-on="on"> See More </small>
        </template>
        <v-card class="modal">
            <slot name="header">
                <v-card-title class="mb-4 title">{{ title }}</v-card-title>
            </slot>

            <v-card-text>
                <span v-html="contentLocal"></span>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn text @click="dialog = false">Close</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "SeeMore",

    props: {
        content: {
            required: true
        },
        title: {
            default: "Full Texts"
        },
        visible: {
            default: false
        },
        link: {
            type: Boolean,
            default: false
        },
        url: {
            type: String,
            default: "#"
        }
    },

    data: () => ({
        dialog: false,
        contentLocal: ""
    }),

    computed: {
        transformedContent() {
            return this.seeMoreTexts(this.contentLocal.replace(/<\/?[^>]+(>|$)/g, ""))
        }
    },

    methods: {
        seeMoreTexts(text) {
            return text.length > 20 ? text.substring(0, 40) + "..." : text
        }
    },

    created() {
        this.contentLocal = this.content ? this.content : ""
    },

    watch: {
        content(newVal) {
            this.contentLocal = newVal ? newVal : ""
        }
    }
}
</script>

<style lang="scss" scoped>
.see-more {
    cursor: pointer;
    color: #007aff;
    &:hover {
        color: #405f83;
    }
}
</style>
