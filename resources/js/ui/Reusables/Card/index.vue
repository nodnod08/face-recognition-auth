<template>
    <v-card>
        <v-card-title class="dtr-card-title d-flex flex-row justify-space-between">
            <span>{{ title }}</span>
            <slot name="action"></slot>
        </v-card-title>
        <div class="dtr-card-body">
            <slot name="content"></slot>
        </div>
    </v-card>
</template>

<script>
export default {
    props: {
        title: {
            required: true,
            type: String
        }
    }
}
</script>

<style></style>
