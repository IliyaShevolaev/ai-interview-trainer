<template>
    <svg xmlns="http://www.w3.org/2000/svg" :width="size" :height="size" fill="currentColor" :class="`bi bi-${name}`"
        viewBox="0 0 16 16" v-html="icons[name]"></svg>
</template>

<script>
import icons from "../../assets/icons.json";

export default {
    props: {
        name: {
            type: String,
            required: true,
        },
        size: {
            type: [String, Number],
            default: 16,
        },
    },
    data() {
        return {
            icons,
        };
    },
};
</script>

<style scoped>
svg {
    display: inline-block;
    vertical-align: middle;
}
</style>